<?php

namespace App\Http\Livewire\Cuotas;

use App\Exports\PagosAplicadosExport;
use App\Imports\PagosRendidosImport;
use App\Models\Acuerdo;
use App\Models\Deudor;
use App\Models\GestionCuota;
use App\Models\Operacion;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class Aplicadas extends Component
{
    use WithPagination;
    use WithFileUploads;
    
    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;
    public $modalExportarPagosAplicados = false;
    public $modalImportarPagosRendidos = false;
    public $modalNoHayPagos = false;
    public $modalImportando = false;
    public $segmento;
    public $pagosAplicados = [];
    public $pagosADescargar = [];
    public $rendicionCG;
    public $proforma;
    public $fecha_rendicion;
    public $archivoSubido;
    //Alertas
    public $alertaDeErrorEncabezado = false;
    public $mensajeUno;

    protected $listeners = ['terminosBusquedaDeCuotasAplicadas'=> 'buscarCuotasAplicadas'];

    public function buscarCuotasAplicadas($parametros)
    {
        $this->deudor = $parametros['deudor'];
        $this->nro_doc = $parametros['nro_doc'];
        $this->responsable = $parametros['responsable'];
        $this->nro_operacion = $parametros['nro_operacion'];
        $this->mes = $parametros['mes'];
        $this->estado = $parametros['estado'];
    }

    public function exportarPagosAplicados()
    {
        $this->modalExportarPagosAplicados = true;
    }

    public function cerrarModalExportarPagos()
    {
        $this->modalExportarPagosAplicados = false;
    }

    public function descargarPagosParaRendir()
    {
        // Validación
        $this->validate([
            'segmento' => 'required'
        ]);

        // Cerramos el modal
        $this->modalExportarPagosAplicados = false;
        // Obtenemos los pagos aplicados (situacion = 3)
        $pagosAplicados = GestionCuota::where('situacion', 3)->take(20)->get();
        $pagosFiltrados = collect();
        foreach($pagosAplicados as $pagoAplicado)
        {
            $idDeLaCuota = $pagoAplicado->pago_id;
            $cuotaDelPagoAplicado = Pago::find($idDeLaCuota);
            $acuerdoId = $cuotaDelPagoAplicado->acuerdo_id;
            $pagoAplicado->acuerdo_id = $acuerdoId;
            $nroCuota = $cuotaDelPagoAplicado->nro_cuota;
            $pagoAplicado->nro_cuota = $nroCuota;
            if (!$pagosFiltrados->has($acuerdoId)) {
                $pagosFiltrados[$acuerdoId] = $pagoAplicado;
            } else {
                // Si ya existe un pago con el mismo acuerdo_id, verificamos el nro_cuota
                if ($nroCuota < $pagosFiltrados[$acuerdoId]->nro_cuota) {
                    // Reemplazamos con el pago que tiene el nro_cuota más bajo
                    $pagosFiltrados[$acuerdoId] = $pagoAplicado;
                }
            }
        }
        foreach ($pagosFiltrados as $pagoFiltrado)
        {
            // Obtenemos la operacion relacionada al pago que tiene el segemento de la misma
            $operacionId = $pagoFiltrado->pago->acuerdo->propuesta->operacionId->id;
            $operacion = Operacion::find($operacionId);
            if($operacion->segmento == $this->segmento)
            {
                $this->pagosADescargar[] = $pagoFiltrado;
            }
            else
            {
                $this->modalNoHayPagos = true;
                return;
            }
        }
        // Preparamos la descarga del archivo Excel
        $pagosADescargar = $this->pagosADescargar;
        $fechaHoraDescarga = now()->format('Ymd_His');
        $nombreArchivo  = 'pagosAplicadosParaRendir_' . $fechaHoraDescarga . '.xlsx';
        return Excel::download(new PagosAplicadosExport($pagosADescargar), $nombreArchivo);
    }

    public function cerrarModalNoHayPagos()
    {
        $this->modalNoHayPagos = false;
    }

    public function importarRendicionDePagos()
    {
        $this->modalImportarPagosRendidos = true;
    }
    
    public function cerrarModalImportarPagosRendidos()
    {
        $this->modalImportarPagosRendidos = false;
    }

    public function importarPagosRendidos()
    {
        //Validacion del formulario
        $this->validate([
            'rendicionCG'=> 'required',
            'proforma'=> 'required',
            'fecha_rendicion'=> 'required|date',
            'archivoSubido' => 'required|file|mimes:xls,xlsx|max:10240', 
        ]);
        //Se cierra el modal del formulario y se inicia el de importando
        $this->modalImportarPagosRendidos = false;
        $this->modalImportando = true;
        try
        {
            //Se obtiene el archivo excel
            $excel = $this->archivoSubido;
            //Realizo la importacion
            $importarPagosRendidos = new PagosRendidosImport;
            Excel::import($importarPagosRendidos, $excel);
            //Obtengo los resultados de la importacion e itero sobre ellos
            $pagosRendidos = $importarPagosRendidos->procesarPagosRendidos;
            foreach($pagosRendidos as $pagoRendido)
            {
                //Actualizo la situacion del pago que se esta rindiendo
                $pagoId = $pagoRendido['pago_id'];
                $pagoEnBD = GestionCuota::find($pagoId);
                $pagoEnBD->situacion = 4;//Pago Rendido
                $pagoEnBD->usuario_ultima_modificacion_id = auth()->id();
                $pagoEnBD->monto_a_rendir = $pagoRendido['monto_a_rendir'];
                $pagoEnBD->proforma = $this->proforma;
                $pagoEnBD->rendicionCG = $this->rendicionCG;
                $pagoEnBD->usuario_rendidor_id = auth()->id();
                $pagoEnBD->fecha_rendicion = $this->fecha_rendicion;
                $pagoEnBD->save();

                //Obtengo la cuota a la que se le rindio el pago
                $cuota = Pago::find($pagoEnBD->pago_id);
                //Reviso si la cuota tiene algun pago informado
                $pagosDeLaCuotaInformados = GestionCuota::where('pago_id', $cuota->id)
                                            ->where('situacion', 1)
                                            ->get();
                //Buscar la cuota siguiente a la actual
                $nroCuotaSiguiente = $cuota->nro_cuota + 1;
                $cuotaSiguienteDelAcuerdo = Pago::where('acuerdo_id', $cuota->acuerdo_id)
                                            ->where('nro_cuota', $nroCuotaSiguiente)
                                            ->first();

                //Reviso si la cuota actual tiene pagos informados
                if(!$pagosDeLaCuotaInformados->isEmpty())
                {
                    //Reviso si la cuota actual que tiene pagos informados tiene una cuota siguiente 
                    if($cuotaSiguienteDelAcuerdo)
                    {
                        if($cuota->concepto_cuota == 'Cancelación')
                        {
                            //Envio el pago a la cuota siguiente (que siempre sera aplicada) y cierro el acuerdo
                            $this->pagoInformadoCuotaSiguiente($pagosDeLaCuotaInformados, $cuotaSiguienteDelAcuerdo);
                            $this->cerrarCuotaYAcuerdo($cuota);
                        }
                        elseif($cuota->concepto_cuota == 'Anticipo' || $cuota->concepto_cuota == 'Cuota')
                        {
                            //Si el monto acordado es mayor a lo abonado se crea una nueva CSP y la cuota es R. Parcial
                            if($cuota->monto_acordado > $pagoEnBD->monto_abonado)
                            {
                                $this->crearCuotaSaldoPendiente($cuota, $pagoEnBD, $pagosDeLaCuotaInformados);
                                $cuota->estado = 4; //Rendida Parcial
                                $cuota->save();
                            }
                            else
                            {
                                //Pasar pago informado a cuota siguiente
                                $this->pagoInformadoCuotaSiguiente($pagosDeLaCuotaInformados, $cuotaSiguienteDelAcuerdo);
                                $cuota->estado = 5;//Rendida Total
                                $cuota->save();
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Pendiente')
                        {
                            //1- Obtener la cuota original en estado rendida parcial
                            $idDelAcuerdo = $cuota->acuerdo_id;
                            $nroCuota = $cuota->nro_cuota;
                            $cuotaRendidaParcialDelAcuerdo = $this->obtenerCuotaRendidaParcial($idDelAcuerdo, $nroCuota);
                            if($cuotaRendidaParcialDelAcuerdo)
                            {
                                //2- Obtener la suma de todos los pagos rendidos de la cuota rendida parcial asociada a la CSP
                                $sumaDePagosRendidosDeLaCuota = $this->obtenerSumaDePagosRendidosDeLaCuota($cuotaRendidaParcialDelAcuerdo);
                                if($sumaDePagosRendidosDeLaCuota)
                                {
                                    //3- Sumar los pagos rendidos de R. Parcial y el nuevo monto abonado de CSP
                                    $totalRendido = $sumaDePagosRendidosDeLaCuota + $pagoEnBD->monto_abonado;
                                    //Si el monto acordado de la cuota es mayor a la suma se crea nueva CSP
                                    if($cuotaRendidaParcialDelAcuerdo->monto_acordado > $totalRendido)
                                    {
                                        $this->crearCuotaSaldoPendienteDos($cuotaRendidaParcialDelAcuerdo, $cuota, $totalRendido, $pagosDeLaCuotaInformados);
                                    }
                                    //El monto acordado de la cuota es igual a la suma se actualiza la R. Parcial
                                    //Se pasan los informados a la cuota siguiente
                                    elseif($cuotaRendidaParcialDelAcuerdo->monto_acordado <= $totalRendido)
                                    {
                                        $cuotaRendidaParcialDelAcuerdo->estado = 5;
                                        $cuotaRendidaParcialDelAcuerdo->save();
                                        $this->pagoInformadoCuotaSiguiente($pagosDeLaCuotaInformados, $cuotaSiguienteDelAcuerdo);                                
                                    }
                                    //En ambos casos el pago rendido lo paso a la cuota que estaba rendida parcial
                                    $pagoEnBD->pago_id = $cuotaRendidaParcialDelAcuerdo->id;
                                    $pagoEnBD->save();
                                    //En ambos casos los pagos rechazados pasan a la cuota rendida parcial
                                    $this->pasarPagosRechazados($cuota);
                                    ////En ambos casos la CSP se elimina
                                    $cuota->delete();
                                }
                            }   
                        }
                    }
                    //Si la cuota actual que tiene pagos informados no tiene una cuota siguiente 
                    else
                    {
                        if($cuota->concepto_cuota == 'Cancelación')
                        {
                            //Se crea CSE y se le pasan los informados. el acuerdo se cierra
                            $this->crearCuotaSaldoExcedente($cuota, $pagosDeLaCuotaInformados);
                            $this->cerrarCuotaYAcuerdo($cuota);
                        }
                        elseif($cuota->concepto_cuota == 'Cuota')
                        {
                            //Si el monto acordado es mayor a lo abona: la cuota queda R. Parcial y se crea CSP
                            if($cuota->monto_acordado > $pagoEnBD->monto_abonado)
                            {
                                $this->crearCuotaSaldoPendiente($cuota, $pagoEnBD, $pagosDeLaCuotaInformados);
                                $cuota->estado = 4; //Rendida Parcial
                                $cuota->save();
                            }
                            //Ei lo acordado y lo abonado coinciden: Se crea CSE y se le pasan los informados
                            //El acuerdo se cierra
                            else
                            {
                                $this->crearCuotaSaldoExcedente($cuota, $pagosDeLaCuotaInformados);
                                $this->cerrarCuotaYAcuerdo($cuota);
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Pendiente')
                        {
                            //1- Obtener la cuota original en estado rendida parcial
                            $idDelAcuerdo = $cuota->acuerdo_id;
                            $nroCuota = $cuota->nro_cuota;
                            $cuotaRendidaParcialDelAcuerdo = $this->obtenerCuotaRendidaParcial($idDelAcuerdo, $nroCuota);
                            if($cuotaRendidaParcialDelAcuerdo)
                            {
                                //2- Obtener la suma de todos los pagos rendidos de la cuota rendida parcial asociada a la CSP
                                $sumaDePagosRendidosDeLaCuota = $this->obtenerSumaDePagosRendidosDeLaCuota($cuotaRendidaParcialDelAcuerdo);
                                if($sumaDePagosRendidosDeLaCuota)
                                {
                                    //3- Sumar los pagos rendidos y el nuevo monto abonado
                                    $totalRendido = $sumaDePagosRendidosDeLaCuota + $pagoEnBD->monto_abonado;
                                    //Si el monto acordado de la cuota es mayor a la suma se genera nueva CSP y se pasan los informados
                                    if($cuotaRendidaParcialDelAcuerdo->monto_acordado > $totalRendido)
                                    {
                                        $this->crearCuotaSaldoPendienteDos($cuotaRendidaParcialDelAcuerdo, $cuota, $totalRendido, $pagosDeLaCuotaInformados);
                                    }
                                    //Lo acordado coincide con lo abonado: se crea CSE y se le pasan los Informados
                                    //Se cierra el acuerdo
                                    else
                                    {
                                        $this->crearCuotaSaldoExcedente($cuota, $pagosDeLaCuotaInformados);
                                        //La Cuota rendida parcial pasa a rendida total
                                        $this->cerrarCuotaYAcuerdo($cuota, $cuotaRendidaParcialDelAcuerdo);
                                    }
                                    //En ambos casos el pago rendido lo paso a la cuota que estaba rendida parcial
                                    $pagoEnBD->pago_id = $cuotaRendidaParcialDelAcuerdo->id;
                                    $pagoEnBD->save();
                                    //En ambos casos los pagos rechazados pasan a la cuota rendida parcial
                                    $this->pasarPagosRechazados($cuota);
                                    //La Cuota de saldo Pendiente se elimina
                                    $cuota->delete();
                                }
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Excedente')
                        {
                            $this->crearCuotaSaldoExcedente($cuota, $pagosDeLaCuotaInformados);
                            $cuota->estado = 5;//rendido total
                            $cuota->save();
                        }
                    }
                }
                //Si la cuota no tiene pagos informados
                else
                {
                    //Reviso si la cuota actual que no tiene pagos informados tiene una cuota siguiente
                    if($cuotaSiguienteDelAcuerdo)
                    {
                        if($cuota->concepto_cuota == 'Cancelación')
                        {
                            //Se cierra el acuerdo y la cuota
                            $this->cerrarCuotaYAcuerdo($cuota);
                        }
                        elseif($cuota->concepto_cuota == 'Anticipo' || $cuota->concepto_cuota == 'Cuota')
                        {
                            //Si lo acordado es mayor a lo abonado se crea CSP y la cuota es R. Parcial
                            if($cuota->monto_acordado > $pagoEnBD->monto_abonado)
                            {
                                $this->crearCuotaSaldoPendiente($cuota, $pagoEnBD);
                                $cuota->estado = 4; //Rendida Parcial
                                $cuota->save();
                            }
                            //Si lo abonado y lo acordado coinciden la cuota pasa rendida total
                            else
                            {
                                $cuota->estado = 5;
                                $cuota->save();
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Pendiente')
                        {
                            //1- Obtener la cuota original en estado rendida parcial
                            $idDelAcuerdo = $cuota->acuerdo_id;
                            $nroCuota = $cuota->nro_cuota;
                            $cuotaRendidaParcialDelAcuerdo = $this->obtenerCuotaRendidaParcial($idDelAcuerdo, $nroCuota);
                            if($cuotaRendidaParcialDelAcuerdo)
                            {
                                //2- Obtener la suma de todos los pagos rendidos de la cuota rendida parcial asociada a la CSP
                                $sumaDePagosRendidosDeLaCuota = $this->obtenerSumaDePagosRendidosDeLaCuota($cuotaRendidaParcialDelAcuerdo);
                                if($sumaDePagosRendidosDeLaCuota)
                                {
                                    //3- Sumar los pagos rendidos y el nuevo monto abonado
                                    $totalRendido = $sumaDePagosRendidosDeLaCuota + $pagoEnBD->monto_abonado;
                                    //Si el monto acordado de la cuota es mayor a la suma se crea una nueva CS
                                    if($cuotaRendidaParcialDelAcuerdo->monto_acordado > $totalRendido)
                                    {
                                        $this->crearCuotaSaldoPendienteDos($cuotaRendidaParcialDelAcuerdo, $cuota, $totalRendido);
                                    }
                                    //Si lo acordado y lo abonado coinciden la rendida parcial pasa a total
                                    else
                                    {
                                        //La Cuota rendida parcial pasa a rendida total
                                        $cuotaRendidaParcialDelAcuerdo->estado = 5;
                                        $cuotaRendidaParcialDelAcuerdo->save();
                                    }
                                    //En ambos casos los pagos rendidos se lo pasan a la cuota original
                                    $pagoEnBD->pago_id = $cuotaRendidaParcialDelAcuerdo->id;
                                    $pagoEnBD->save();
                                    //En ambos casos los pagos rechazados se lo pasan a la cuota original
                                    $this->pasarPagosRechazados($cuota);
                                    //En ambos casos la Cuota de saldo Pendiente se elimina
                                    $cuota->delete();
                                }
                            }
                        }
                    } 
                    //Si la cuota actual que no tiene pagos informados no tiene cuota siguiente
                    else
                    {
                        if($cuota->concepto_cuota == 'Cancelación')
                        {
                            //Se rinde la cuota y el acuerdo
                            $this->cerrarCuotaYAcuerdo($cuota);
                        }
                        elseif($cuota->concepto_cuota == 'Cuota')
                        {
                            //Revisar si el monto acordado es mayor a lo abonado
                            if($cuota->monto_acordado > $pagoEnBD->monto_abonado)
                            {
                                //Se crea una CSP por el saldo pendiente y la cuota pasa rendida parcial
                                $this->crearCuotaSaldoPendiente($cuota, $pagoEnBD);
                                $cuota->estado = 4; //Rendida Parcial
                                $cuota->save();
                            }
                            //Si lo abonado y lo acordado coinciden se rinde la cuota y el acuerdo
                            else
                            {
                                $this->cerrarCuotaYAcuerdo($cuota);
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Pendiente')
                        {
                            //1- Obtener la cuota original en estado rendida parcial
                            $idDelAcuerdo = $cuota->acuerdo_id;
                            $nroCuota = $cuota->nro_cuota;
                            $cuotaRendidaParcialDelAcuerdo = $this->obtenerCuotaRendidaParcial($idDelAcuerdo, $nroCuota);
                            if($cuotaRendidaParcialDelAcuerdo)
                            {
                                //2- Obtener la suma de todos los pagos rendidos de la cuota rendida parcial asociada a la CSP
                                $sumaDePagosRendidosDeLaCuota = $this->obtenerSumaDePagosRendidosDeLaCuota($cuotaRendidaParcialDelAcuerdo);
                                if($sumaDePagosRendidosDeLaCuota)
                                {
                                    //3- Sumar los pagos rendidos y el nuevo monto abonado
                                    $totalRendido = $sumaDePagosRendidosDeLaCuota + $pagoEnBD->monto_abonado;
                                    //El monto acordado de la cuota es mayor a la suma se crea nueva CSP
                                    if($cuotaRendidaParcialDelAcuerdo->monto_acordado > $totalRendido)
                                    {
                                        $this->crearCuotaSaldoPendienteDos($cuotaRendidaParcialDelAcuerdo, $cuota, $totalRendido);
                                    }
                                    //Si lo acordado y lo abonado coinciden
                                    else
                                    {
                                        //Se cierra el acuerdo y la cuota
                                        $this->cerrarCuotaYAcuerdo($cuota, $cuotaRendidaParcialDelAcuerdo);
                                    }
                                    //En ambos casos el pago rendido se pasa a la cuota origial
                                    $pagoEnBD->pago_id = $cuotaRendidaParcialDelAcuerdo->id;
                                    $pagoEnBD->save();
                                    //En ambos casos los pagos rechazados se pasan a la cuota origial
                                    $this->pasarPagosRechazados($cuota);
                                    //La CSP se elimina
                                    $cuota->delete();
                                }
                            }
                        }
                        elseif($cuota->concepto_cuota == 'Saldo Excedente')
                        {
                            $cuota->estado = 5;
                            $cuota->monto_acordado = $pagoEnBD->monto_abonado;
                            $cuota->save();
                        }
                    }
                }
            }
            $this->modalImportando = false;
            DB::beginTransaction();
        }
        catch(\Exception $e) 
        {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado. (' . $e->getMessage() . ')';
            return back()->withErrors(['error' => $errorImportacion]);
        }
    }

    public function pagoInformadoCuotaSiguiente($pagosDeLaCuotaInformados, $cuotaSiguienteDelAcuerdo)
    {
        foreach ($pagosDeLaCuotaInformados as $pagoDeLaCuotaInformado)
        {
            $pagoDeLaCuotaInformado->pago_id = $cuotaSiguienteDelAcuerdo->id;
            $pagoDeLaCuotaInformado->save();
        }
    }

    public function crearCuotaSaldoPendiente($cuota, $pagoEnBD, $pagosDeLaCuotaInformados = null)
    {
        // Calculo el monto de la cuota de saldo pendiente (CSP)
        $montoDeCSP = $cuota->monto_acordado - $pagoEnBD->monto_abonado;

        // Creo la nueva cuota de saldo pendiente
        $cuotaSaldoPendiente = new Pago([
            'acuerdo_id' => $cuota->acuerdo_id,
            'responsable_id' => $cuota->responsable_id,
            'estado' => 1, // Vigente
            'concepto_cuota' => 'Saldo Pendiente',
            'monto_acordado' => $montoDeCSP,
            'nro_cuota' => $cuota->nro_cuota,
            'vencimiento_cuota' => $cuota->vencimiento_cuota,
            'usuario_ultima_modificacion_id' => auth()->id()
        ]);
        
        $cuotaSaldoPendiente->save(); // Guardar la nueva cuota de saldo pendiente

        // Si existen pagos informados, los asocio a la nueva cuota de saldo pendiente
        if ($pagosDeLaCuotaInformados) {
            foreach ($pagosDeLaCuotaInformados as $pagoDeLaCuotaInformado) {
                $pagoDeLaCuotaInformado->pago_id = $cuotaSaldoPendiente->id;
                $pagoDeLaCuotaInformado->save();
            }
        }
    }

    public function crearCuotaSaldoPendienteDos($cuotaRendidaParcialDelAcuerdo, $cuota, $totalRendido, $pagosDeLaCuotaInformados = null)
    {
        $montoDeCSP = $cuotaRendidaParcialDelAcuerdo->monto_acordado - $totalRendido;
        $cuotaSaldoPendiente = new Pago([
            'acuerdo_id' => $cuota->acuerdo_id,
            'responsable_id' => $cuota->responsable_id,
            'estado' => 1, //Vigente
            'concepto_cuota' => 'Saldo Pendiente',
            'monto_acordado' => $montoDeCSP,
            'nro_cuota' => $cuota->nro_cuota,
            'vencimiento_cuota' => $cuota->vencimiento_cuota,
            'usuario_ultima_modificacion_id' => auth()->id()
        ]);
        $cuotaSaldoPendiente->save();
        //Si la CSP tiene pagos informados se los paso a la CSP recien creada
        if($pagosDeLaCuotaInformados)
        {
            foreach ($pagosDeLaCuotaInformados as $pagoDeLaCuotaInformado)
            {
                $pagoDeLaCuotaInformado->pago_id = $cuotaSaldoPendiente->id;
                $pagoDeLaCuotaInformado->save();
            }
        }
    }

    public function crearCuotaSaldoExcedente($cuota, $pagosDeLaCuotaInformados)
    {
        foreach ($pagosDeLaCuotaInformados as $pagoDeLaCuotaInformado)
        {
            
            //Creo un cuota de saldo excedente por el monto del pago informado
            $cuotaSaldoExcedente = new Pago([
                'acuerdo_id' => $cuota->acuerdo_id,
                'responsable_id' => $cuota->responsable_id,
                'estado' => 1, //Vigente
                'concepto_cuota' => 'Saldo Excedente',
                'monto_acordado' => $pagoDeLaCuotaInformado->monto_abonado,
                'nro_cuota' => $cuota->nro_cuota + 1,
                'vencimiento_cuota' => $cuota->vencimiento_cuota,
                'usuario_ultima_modificacion_id' => auth()->id()
            ]);
            $cuotaSaldoExcedente->save();
            //El pago informado se lo paso a la cuota de saldo excedente recien creada
            $pagoDeLaCuotaInformado->pago_id = $cuotaSaldoExcedente->id;
            $pagoDeLaCuotaInformado->save();
        }
    }

    public function obtenerCuotaRendidaParcial($acuerdoId, $nroCuota)
    {
        return Pago::where('acuerdo_id', $acuerdoId)
                   ->where('estado', 4)
                   ->where('nro_cuota', $nroCuota)
                   ->first();
    }
    
    public function obtenerSumaDePagosRendidosDeLaCuota($cuotaRendidaParcialDelAcuerdo)
    {
        return GestionCuota::where('pago_id', $cuotaRendidaParcialDelAcuerdo->id)//Pagos de la cuota  
                            ->where('situacion', 4)//Pagos rendidos
                            ->sum('monto_abonado');
    }

    public function pasarPagosRechazados($cuota)
    {
        $pagosRechazadosDeLaCuota  = GestionCuota::where('pago_id', $cuota->id)
                                                ->where('situacion', 2)
                                                ->get();
        //Si tiene pagos rechazados se los paso a la cuota rendida parcial.
        if(!$pagosRechazadosDeLaCuota->isEmpty())
        {
            foreach($pagosRechazadosDeLaCuota as $pagoRechazadoDeLaCuota)
            {
                $cuotaRendidaParcial = Pago::where('acuerdo_id', $cuota->acuerdo_id)
                                            ->where('estado', 4)
                                            ->first();
                $pagoRechazadoDeLaCuota->pago_id = $cuotaRendidaParcial->id;
                $pagoRechazadoDeLaCuota->save();
            }
        }
    }

    public function cerrarCuotaYAcuerdo($cuota, $cuotaRendidaParcialDelAcuerdo = null)
    {
        if ($cuotaRendidaParcialDelAcuerdo) {
            // Si hay una cuota rendida parcialmente, la cerramos
            $cuotaRendidaParcialDelAcuerdo->estado = 5; // Rendida total
            $cuotaRendidaParcialDelAcuerdo->save();
        }

        // Actualizamos la cuota a rendida total
        $cuota->estado = 5; // Rendida total
        $cuota->save();

        // Obtenemos el acuerdo asociado y lo marcamos como rendido
        $acuerdoId = $cuota->acuerdo_id;
        $acuerdo = Acuerdo::find($acuerdoId);
        $acuerdo->estado = 2; // Rendido
        $acuerdo->save();
    }

    public function render()
    {
        $cuotasAplicadas = Pago::query();
        //Busqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                                ->pluck('id')
                                ->first();
            if ($deudorId) {
                $cuotasAplicadas->whereHas('acuerdo.propuesta', function($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $cuotasAplicadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        //busqueda por responsable
        if ($this->responsable) {
            $cuotasAplicadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $cuotasAplicadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Busqueda por mes
        if ($this->mes) {
            $cuotasAplicadas->whereMonth('vencimiento_cuota', $this->mes);
        }
        //Busqueda por vencimiento
        if ($this->estado) {
            $hoy = Carbon::today();
            if ($this->estado == 'activo') {
                $cuotasAplicadas->where('vencimiento_cuota', '>=', $hoy);
            } else if ($this->estado == 'vencido') {
                $cuotasAplicadas->where('vencimiento_cuota', '<', $hoy);
            }
        }
        //Vista sin busqueda
        $cuotasAplicadas = $cuotasAplicadas->where('pagos.estado', 3)  
                                         ->join('acuerdos', 'pagos.acuerdo_id', '=', 'acuerdos.id')
                                         ->join('propuestas', 'acuerdos.propuesta_id', '=', 'propuestas.id')
                                         ->orderBy('propuestas.deudor_id', 'asc')  // Agrupar por deudor_id
                                         ->orderBy('pagos.created_at', 'desc')     // Ordenar por fecha de creación
                                         ->select('pagos.*')                       // Seleccionar solo las columnas de pagos
                                         ->paginate(30);
        $cuotasAplicadasTotales = $cuotasAplicadas->total();

        return view('livewire.cuotas.aplicadas',[
            'cuotasAplicadas'=>$cuotasAplicadas,
            'cuotasAplicadasTotales'=>$cuotasAplicadasTotales,
        ]);
    }
}
