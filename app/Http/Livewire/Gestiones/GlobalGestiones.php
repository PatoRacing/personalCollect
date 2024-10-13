<?php

namespace App\Http\Livewire\Gestiones;

use App\Http\Livewire\GestionesDeudor;
use App\Models\Acuerdo;
use App\Models\GestionCuota;
use App\Models\Pago;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GlobalGestiones extends Component
{
    //Cuota Actual
    public $cuota;
    //Alertas
    public $imprimirAlertaExito = false;
    public $imprimirAlertaEliminacion = false;
    //Auxiliares
    public $mostrarFormulario = true;
    public $actualizarPagoInformado = [];
    public $aplicarPagoInformado = [];
    public $aplicarPagoInformadoConIncompletos = [];
    public $eliminarPagoInformado = [];
    public $reversarPagoRechazado = [];
    public $reversarPagoIncompleto = [];
    public $reversarPagoAplicado = [];
    public $cuotasSiguientesAplicadas = [];
    public $modalReversarPagoRendido = [];
    public $modalReversarPagoParaRendir = [];
    public $modalReversarPagoRendidoACuenta = [];
    public $modalProcesarPagosIncompletos;
    public $modalDevolverPagoAplicadoEnCuotaSaldoExcedente;
    public $modalReversarPagoDevuelto;
    public $contexto;
    public $pagosRendidosAnteriores;
    public $pagosCompletos;
    public $botonProcesarPagosIncompletos = false;
    public $botonDevolverPagoAplicadoEnCuotaSaldoExcedente = false;
    public $ultimaCuota;
    public $mensajeModalUno;
    public $mensajeModalDos;
    public $mensajeModalTres;
    //Variables para actualizar gestiones
    public $pagoSeleccionado;
    public $fecha_de_pago_formulario;
    public $monto_abonado_formulario;
    public $situacion_formulario;
    public $pagosDeLaCuotaQueNoSonVigentes;
    public $pagosRechazadosOIncompletosDeCancelacionSeleccionada;
    public $sumaDeIncompletos;
    public $pagoInformado;
    public $pagosIncompletos;
    public $pagoAplicadoEnCuotaSaldoExcedente;
    public $pagoAplicado;
    public $pagosDeLaCuotaObservados;

    protected $listeners = ['nuevaGestionDeFormulario'=>'procesarGestionFormulario',
                            'eventoDeBoton'=> 'procesarGestionBoton'];

    public function mount()
    {
        // Llama al método que verifica si hay pagos incompletos
        $this->botonesExtra();
    }

    //Funciones que reciben informacion de otros componentes
    public function procesarGestionFormulario($informacionIngresada, $cuota)
    {
        // Obtener datos comunes que a pesar de la gestion no van a cambiar
        $datosComunes = $this->obtenerDatosComunes($informacionIngresada);
        // Si el usuario es agente
        if(auth()->user()->rol === 'Agente')
        {
            //Funcion para procesar informacion ingresada por agente en un formulario. Se pasan los datos comunes
            $this->procesarInformacionAgente($datosComunes);
        }
        // Si el usuario es administrador
        else
        {
            $this->procesarInformacionAdministrador($datosComunes, $cuota);
        }
    }
    public function procesarGestionBoton($accion, $pagoDeCuotaId)
    {
        //Para boton actualizar de pago informado
        if ($accion === 'admActualizarPagoInformado' || $accion === 'agtActualizarPagoInformado')
        {
            $this->botonActualizarPagoInformado($pagoDeCuotaId);
        }
        //Para boton aplicar de pago informado
        elseif ($accion === 'admAplicarPagoInformado')
        {
            $this->botonAplicarPagoInformado($pagoDeCuotaId);
        }
        //Para boton eliminar de pago informado
        elseif ($accion === 'admEliminarPagoInformado' || $accion === 'agtEliminarPagoInformado')
        {
            $this->botonEliminarPagoInformado($pagoDeCuotaId);
        }
        //Para boton reversar de pago rechazado
        elseif ($accion === 'admReversarPagoRechazado')
        {
            $this->botonReversarPagoRechazado($pagoDeCuotaId);
        }
        //Para boton reversar de pago incompleto
        elseif ($accion === 'admReversarPagoIncompleto')
        {
            $this->admReversarPagoIncompleto($pagoDeCuotaId);
        }
        //Para boton reversar de pago aplicado
        elseif ($accion === 'admReversarPagoAplicado')
        {
            $this->admReversarPagoAplicado($pagoDeCuotaId);
        }
        //Para boton reversar de pago rendido
        elseif ($accion === 'admReversarPagoRendido')
        {
            $this->admReversarPagoRendido($pagoDeCuotaId);
        }
        //Para boton reversar de pago Para rendir
        elseif ($accion === 'admReversarPagoParaRendir')
        {
            $this->admReversarPagoParaRendir($pagoDeCuotaId);
        }
        //Para boton reversar de pago Rendido a Cuenta
        elseif ($accion === 'admReversarPagoRendidoACuenta')
        {
            $this->admReversarPagoRendidoACuenta($pagoDeCuotaId);
        }
        //Para boton reversar de pago Devuelto
        elseif ($accion === 'admReversarPagoDevuelto')
        {
            $this->admReversarPagoDevuelto($pagoDeCuotaId);
        }
    }

    //Funciones de modales
    //Boton actualizar en pago informado
    public function botonActualizarPagoInformado($pagoDeCuotaId)
    {
        $this->pagoSeleccionado = GestionCuota::find($pagoDeCuotaId);
        $this->fecha_de_pago_formulario = $this->pagoSeleccionado['fecha_de_pago']; 
        $this->monto_abonado_formulario = $this->pagoSeleccionado['monto_abonado']; 
        $this->situacion_formulario = $this->pagoSeleccionado['situacion'];
        $this->actualizarPagoInformado[$pagoDeCuotaId] = true;
    }
    public function cerrarModalPagoInformadoActualizar($pagoDeCuotaId)
    {
        $this->actualizarPagoInformado[$pagoDeCuotaId] = false;
    }
    public function actualizarPagoInformado()
    {
        $this->validate([
            'fecha_de_pago_formulario'=> 'required|date',
            'monto_abonado_formulario'=> 'required',
            'situacion_formulario'=> 'required',
        ]);
        $this->pagoSeleccionado->update([
            'fecha_de_pago' => $this->fecha_de_pago_formulario,
            'monto_abonado' => $this->monto_abonado_formulario,
            'situacion' => $this->situacion_formulario, 
            'usuario_ultima_modificacion_id' => auth()->id()
        ]);
        if(auth()->user()->rol == 'Administrador')
        {
            if($this->cuota->estado == 1)
            {
                if($this->situacion_formulario == 2) 
                {
                    $this->cuota->estado = 2;
                    $this->cuota->save();
                }
            }
            
        }
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                            ->with('imprimirAlertaExito', true);   
    }
    //Boton aplicar en pago informado
    public function botonAplicarPagoInformado($pagoDeCuotaId)
    {
        $this->pagosIncompletos = GestionCuota::where('pago_id', $this->cuota->id)
                                                ->where('situacion', 5) // Pago incompleto
                                                ->get();
        //Si la cuota tiene pagos incompletos ademas de informados
        if(!$this->pagosIncompletos->isEmpty())
        {
            $this->sumaDeIncompletos = $this->pagosIncompletos->sum('monto_abonado');
            $this->pagoInformado = GestionCuota::find($pagoDeCuotaId);

            //La suma del nuevo pago y los anteriores incompletos es mayor a lo acordado
            if($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado >  $this->cuota->monto_acordado)
            {
                $this->mensajeModalUno =
                    'Los incompletos y lo informado supera lo acordado en $'
                    . number_format($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado - $this->cuota->monto_acordado, 2, ',', '.');
                    $this->mensajeModalDos =
                    'La Cancelación se aplicará y se generará una Cta. Excente por el saldo.';
            }
            //La suma del nuevo pago y los anteriores incompletos es igual a lo acordado
            elseif($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado ==  $this->cuota->monto_acordado)
            {
                $this->mensajeModalUno =
                    'La suma de Pagos Incompletos es igual a lo acordado.';
                $this->mensajeModalDos =
                    'Los mismos pasaran a Completos y se aplicará un pago de $'
                    . number_format($this->cuota->monto_acordado, 2, ',', '.');
            }
            //La suma del nuevo pago y los anteriores incompletos es menor a lo acordado
            elseif($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado <  $this->cuota->monto_acordado)
            {
                $this->mensajeModalUno =
                    'El monto es inferior a lo acordado en $'
                    . number_format($this->cuota->monto_acordado -
                        $this->pagoInformado->monto_abonado - $this->sumaDeIncompletos, 2, ',', '.'); 
                    $this->mensajeModalDos =
                    'La Cancelación será Observada y el Pago Incompleto'; 
            }
            $this->aplicarPagoInformadoConIncompletos[$pagoDeCuotaId] = true;
        }
        //Si la cuota no tiene pagos incompletos
        else
        {
            //Obtengo el pago y la cuota para comparar sus montos
            $this->pagoSeleccionado = GestionCuota::find($pagoDeCuotaId);
            $cuota = $this->cuota;
            //Si el monto abonado es mayor al acordado
            if($this->pagoSeleccionado->monto_abonado > $cuota->monto_acordado)
            {
                if($cuota->concepto_cuota === "Cancelación")
                {
                    $this->mensajeModalUno =
                    'El monto supera lo acordado en $'
                    . number_format($this->pagoSeleccionado->monto_abonado - $cuota->monto_acordado, 2, ',', '.');
                    $this->mensajeModalDos =
                    'La Cancelación se aplicará y se generará una Cta. Excente por el saldo.';
                }
                else
                {
                    $this->mensajeModalUno =
                    'El monto supera lo acordado en $'
                    . number_format($this->pagoSeleccionado->monto_abonado - $cuota->monto_acordado, 2, ',', '.');
                    $this->mensajeModalDos =
                    'La Cuota se aplicará y se imputará el saldo a las ctas siguientes.';
                }
                
            }
            //Si el monto abonado es igual  al acordado
            elseif($this->pagoSeleccionado->monto_abonado == $cuota->monto_acordado)
            {
                $this->mensajeModalUno =
                    'Se aplicará un pago de $' . number_format($this->pagoSeleccionado->monto_abonado, 2, ',', '.');
            }
            //Si el monto abonado es inferior al acordado
            elseif($this->pagoSeleccionado->monto_abonado < $cuota->monto_acordado)
            {
                if($cuota->concepto_cuota === 'Cancelación')
                {
                    $this->mensajeModalUno =
                    'El monto es inferior a lo acordado en $'
                    . number_format($cuota->monto_acordado - $this->pagoSeleccionado->monto_abonado, 2, ',', '.'); 
                    $this->mensajeModalDos =
                    'La Cancelación será Observada y el Pago Incompleto'; 
                }
                else
                {
                    $this->mensajeModalUno =
                    'El monto es inferior a lo acordado en $'
                    . number_format($cuota->monto_acordado - $this->pagoSeleccionado->monto_abonado, 2, ',', '.'); 
                    $this->mensajeModalUno =
                    'La Cuota se aplicará parcialmente'; 
                }
            }
            $this->aplicarPagoInformado[$pagoDeCuotaId] = true;
        }
        
    }
    public function cerrarModalPagoInformadoAplicar($pagoDeCuotaId)
    {
        $this->aplicarPagoInformado[$pagoDeCuotaId] = false;
    }
    public function aplicarPagoInformado()
    {
        //Si el monto abonado es mayor al acordado
        if($this->pagoSeleccionado->monto_abonado > $this->cuota->monto_acordado)
        {
            $sobrante = $this->pagoSeleccionado->monto_abonado - $this->cuota->monto_acordado;
            $informacionIngresada = $this->pagoSeleccionado;
            $cuota = $this->cuota;
            $this->gestionarSobrante($sobrante, $informacionIngresada, $cuota);
            $this->pagoSeleccionado->monto_abonado = $this->cuota->monto_acordado;
            $this->pagoSeleccionado->situacion = 3;
            $this->cuota->estado = 3;
        }
        //Si el monto abonado es igual al acordado
        elseif($this->pagoSeleccionado->monto_abonado == $this->cuota->monto_acordado)
        {
            $this->pagoSeleccionado->situacion = 3;
            $this->cuota->estado = 3;
        }
        //Si el monto abonado es menor al acordado
        elseif($this->pagoSeleccionado->monto_abonado < $this->cuota->monto_acordado)
        {
            if($this->cuota->concepto_cuota === 'Cancelación')
            {
                $this->pagoSeleccionado->situacion = 5;
                $this->cuota->estado = 2;
            }
            else
            {
                $this->pagoSeleccionado->situacion = 3;
                $this->cuota->estado = 3;
            }
        }
        $this->pagoSeleccionado->usuario_ultima_modificacion_id = auth()->id();
        $this->pagoSeleccionado->save();
        $this->cuota->usuario_ultima_modificacion_id = auth()->id();
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true);
    }
    public function cerrarModalAplicarPagoInformadoConIncompletos($pagoDeCuotaId)
    {
        $this->aplicarPagoInformadoConIncompletos[$pagoDeCuotaId] = false;
    }
    public function aplicarPagoInformadoConIncompletos($pagoDeCuotaId)
    {
        $pagoInformado = $this->pagoInformado;
        $pagosIncompletos = $this->pagosIncompletos;
        $sumaDeIncompletos = $this->sumaDeIncompletos;
        $cuota = $this->cuota;
        //La suma del pago informado y los anteriores incompletos es mayor a lo acordado
        if($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado >  $this->cuota->monto_acordado)
        {
            $sobrante = $pagoInformado->monto_abonado + $sumaDeIncompletos - $this->cuota->monto_acordado;
            $this->pagoInformado->monto_abonado = $this->cuota->monto_acordado - $this->sumaDeIncompletos;
            $this->pagoInformado->situacion = 6;
            $this->pagoInformado->save();
            foreach($pagosIncompletos as $pagoIncompleto)
            {
                $pagoIncompleto->situacion = 6;
                $pagoIncompleto->save(); 
            }
            //generar nuevo pago aplicado
            $pagoAplicado = new GestionCuota([
                'pago_id'=>$this->pagoInformado->pago_id,
                'fecha_de_pago'=>$this->pagoInformado->fecha_de_pago,
                'monto_abonado'=>$this->cuota->monto_acordado,
                'medio_de_pago'=>$this->pagoInformado->medio_de_pago,
                'sucursal'=>$this->pagoInformado->sucursal ?? null,
                'hora'=>$this->pagoInformado->hora ?? null,
                'cuenta'=>$this->pagoInformado->cuenta ?? null,
                'nombre_tercero'=>$this->pagoInformado->nombre_tercero ?? null,
                'central_de_pago'=>$this->pagoInformado->central_de_pago ?? null,
                'comprobante'=>$this->pagoInformado->comprobante ?? null,
                'usuario_informador_id'=>$this->pagoInformado->usuario_informador_id ?? null,
                'fecha_informe'=>$this->pagoInformado->fecha_informe ?? null,
                'situacion'=> 3,
                'usuario_ultima_modificacion_id'=>auth()->id()
            ]);
            $pagoAplicado->save();
            $cuota->estado = 3;
            $cuota->save();
            $informacionIngresada = $this->pagoInformado;
            $this->gestionarSobrante($sobrante, $informacionIngresada, $cuota);
        }
        //La suma del pago informado y los anteriores incompletos es igual a lo acordado
        elseif($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado ==  $this->cuota->monto_acordado)
        {
            $this->pagoInformado->situacion = 6;
            $this->pagoInformado->save();
            foreach($pagosIncompletos as $pagoIncompleto)
            {
                $pagoIncompleto->situacion = 6;
                $pagoIncompleto->save(); 
            }
            //generar nuevo pago aplicado
            $pagoAplicado = new GestionCuota([
                'pago_id'=>$this->pagoInformado->pago_id,
                'fecha_de_pago'=>$this->pagoInformado->fecha_de_pago,
                'monto_abonado'=>$this->cuota->monto_acordado,
                'medio_de_pago'=>$this->pagoInformado->medio_de_pago,
                'sucursal'=>$this->pagoInformado->sucursal ?? null,
                'hora'=>$this->pagoInformado->hora ?? null,
                'cuenta'=>$this->pagoInformado->cuenta ?? null,
                'nombre_tercero'=>$this->pagoInformado->nombre_tercero ?? null,
                'central_de_pago'=>$this->pagoInformado->central_de_pago ?? null,
                'comprobante'=>$this->pagoInformado->comprobante ?? null,
                'usuario_informador_id'=>$this->pagoInformado->usuario_informador_id ?? null,
                'fecha_informe'=>$this->pagoInformado->fecha_informe ?? null,
                'situacion'=> 3,
                'usuario_ultima_modificacion_id'=>auth()->id()
            ]);
            $pagoAplicado->save();
            $cuota->estado = 3;
            $cuota->save();
        }
        //La suma del pago informado y los anteriores incompletos es menor a lo acordado
        elseif($this->sumaDeIncompletos + $this->pagoInformado->monto_abonado <  $this->cuota->monto_acordado)
        {
            $this->pagoInformado->situacion = 5;
            $this->pagoInformado->save();
        }
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true);
    }
    //Boton eliminar en pago informado
    public function botonEliminarPagoInformado($pagoDeCuotaId)
    {
        $this->pagoSeleccionado = GestionCuota::find($pagoDeCuotaId);
        $this->eliminarPagoInformado[$pagoDeCuotaId] = true;
    }
    public function cerrarModalPagoInformadoEliminar($pagoDeCuotaId)
    {
        $this->eliminarPagoInformado[$pagoDeCuotaId] = false;
    }
    public function eliminarPagoInformado()
    {
        if($this->pagoSeleccionado->comprobante)
        {
            Storage::delete('public/comprobantes/' . $this->pagoSeleccionado->comprobante);
        }
        if($this->cuota->concepto_cuota = 'Saldo Excedente')
        {
            $pagosDeCuotaSaldoExcedente = GestionCuota::where('pago_id', $this->cuota->id)
                                                    ->where('id', '!=', $this->pagoSeleccionado->id)
                                                    ->first();
            if(!$pagosDeCuotaSaldoExcedente)
            {
                $this->pagoSeleccionado->delete();
                $this->cuota->delete();
                return redirect()->route('cuotas')
                             ->with('imprimirAlertaExito', true);
            }
            else
            {
                $this->pagoSeleccionado->delete();
            }
        }
        $this->eliminarPagoInformado = false;
        session()->flash('imprimirAlertaEliminacion', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true);
    }
    //Boton reversar en pago rechazado
    public function botonReversarPagoRechazado($pagoDeCuotaId)
    {
        $this->pagoSeleccionado = GestionCuota::find($pagoDeCuotaId);
        $cuotaId = $this->pagoSeleccionado->pago_id;
        //Busca pagos que tengan situacion de rechazados o incompletos
        $pagosDeLaCuotaQueNoSonVigentes = GestionCuota::where('pago_id', $cuotaId)
                                    ->whereIn('situacion', [2,3,4,5,6,7,8,9]) // Si tiene cualquier pago que no sea vigente
                                    ->where('id', '<>', $pagoDeCuotaId)
                                    ->first();
        //Si la cuota no tiene otros pagos o solo pagos vigentes
        if(!$pagosDeLaCuotaQueNoSonVigentes)
        {
            $this->mensajeModalUno =
            'El Pago Rechazado pasará a estado Informado';
            $this->mensajeModalDos =
            'La cuota o cancelación pasará a estado Vigente';    
        }
        //Si la cuota tiene otros que no son vigentes
        else
        {
            $this->mensajeModalUno =
            'El Pago Rechazado pasará a estado Informado';
            $this->mensajeModalDos =
            'La cuota o cancelación mantendrá su estado';
        } 
        $this->pagosDeLaCuotaQueNoSonVigentes = $pagosDeLaCuotaQueNoSonVigentes;
        $this->reversarPagoRechazado[$pagoDeCuotaId] = true;                          
    }
    public function cerrarModalPagoRechazadoReversar($pagoDeCuotaId)
    {
        $this->reversarPagoRechazado[$pagoDeCuotaId] = false;     
    }
    public function reversarPagoRechazado($pagoDeCuotaId)
    {
        $pagosDeLaCuotaQueNoSonVigentes = $this->pagosDeLaCuotaQueNoSonVigentes;
        //Si la cuota no tiene otros pagos o solo pagos vigentes
        if(!$pagosDeLaCuotaQueNoSonVigentes)
        {
            $this->cuota->estado = 1; //Cuota vigente;
            $this->cuota->save();
        }
        //Tanto si tiene o no tiene otros pagos rechazados el pago pasa a informado
        $pagoDeCuotaObservado = GestionCuota::find($pagoDeCuotaId);
        $pagoDeCuotaObservado->situacion = 1;
        $pagoDeCuotaObservado->save();
        $this->reversarPagoRechazado[$pagoDeCuotaId] = false;     
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);
    }
    //Boton reversar un pago incompleto
    public function admReversarPagoIncompleto($pagoDeCuotaId)
    {
        $this->pagoSeleccionado = GestionCuota::find($pagoDeCuotaId);
        $cuotaId = $this->pagoSeleccionado->pago_id;
        $pagosRechazadosOIncompletosDeCancelacionSeleccionada = GestionCuota::where('pago_id', $cuotaId)
                                    ->whereIn('situacion', [2, 5]) //Si en la consulta hay un pago en estado 2 o 5
                                    ->where('id', '<>', $pagoDeCuotaId)
                                    ->first();
        //Si la cuota no tiene otros pagos rechazados
        if(!$pagosRechazadosOIncompletosDeCancelacionSeleccionada)
        {
            $this->mensajeModalUno =
            'El Pago Incompleto pasará a estado Informado';
            $this->mensajeModalDos =
            'La Cancelación pasará a estado Vigente';    
        }
        //Si la cuota tiene otros pagos rechazados
        else
        {
            $this->mensajeModalUno =
            'El Pago Incompleto pasará a estado Informado';
            $this->mensajeModalDos =
            'La Cancelación mantendrá su estado Observada';
        } 
        $this->pagosRechazadosOIncompletosDeCancelacionSeleccionada = $pagosRechazadosOIncompletosDeCancelacionSeleccionada;
        $this->reversarPagoIncompleto[$pagoDeCuotaId] = true;
    }
    public function cerrarModalPagoIncompletoReversar($pagoDeCuotaId)
    {
        $this->reversarPagoIncompleto[$pagoDeCuotaId] = false;     
    }
    public function reversarPagoIncompleto($pagoDeCuotaId)
    {
        $pagosRechazadosOIncompletosDeCancelacionSeleccionada = $this->pagosRechazadosOIncompletosDeCancelacionSeleccionada;
        //Si la cuota no tiene otros pagos rechazados la cuota pasa a vigente
        if(!$pagosRechazadosOIncompletosDeCancelacionSeleccionada)
        {
            $this->cuota->estado = 1; //Cuota vigente;
            $this->cuota->save();
        }
        //Tanto si tiene o no tiene otros pagos rechazados el pago pasa a informado
        $pagoDeCuotaObservado = GestionCuota::find($pagoDeCuotaId);
        $pagoDeCuotaObservado->situacion = 1;
        $pagoDeCuotaObservado->save();
        $this->reversarPagoRechazado[$pagoDeCuotaId] = false;     
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);
    }
    //Procesar pagos incompletos y devolver aplicado en cta. saldo excedente
    public function botonesExtra()
    {
        //Busco si la cuota tiene pagos incompletos
        $this->pagosIncompletos = GestionCuota::where('pago_id', $this->cuota->id)
                                        ->where('situacion', 5)
                                        ->get();
        //Busco si la cuota tiene pagos informados
        $pagosVigentes = GestionCuota::where('pago_id', $this->cuota->id)
                                    ->where('situacion', 1)
                                    ->exists();
        if($this->cuota->concepto_cuota == 'Saldo Excedente')
        {
            $this->pagoAplicadoEnCuotaSaldoExcedente = GestionCuota::where('pago_id', $this->cuota->id)
                                                    ->where('situacion', 3)
                                                    ->first();
            if($this->pagoAplicadoEnCuotaSaldoExcedente && !$pagosVigentes)
            {
                $this->botonDevolverPagoAplicadoEnCuotaSaldoExcedente = true;
            }
        }
        //Si la cuota tiene incompletos y no tiene informados
        if($this->pagosIncompletos->isNotEmpty() && !$pagosVigentes)
        {
            $this->botonProcesarPagosIncompletos = true;
        }
    }
    public function modalProcesarPagosIncompletos()
    {
        $this->mensajeModalUno =
             'Vas a Procesar todos los pagos incompletos de la cuota.';
        $this->mensajeModalDos =
             'Se creará un nuevo Pago Para Rendir por la suma de los mismos.';
        $this->mensajeModalTres =
             'Tanto la cuota como los pagos pasarán a estado Procesados.';
        $this->modalProcesarPagosIncompletos = true;
    }
    public function cerrarModalProcesarPagosIncompletos()
    {
        $this->modalProcesarPagosIncompletos = false;
    }
    public function procesarPagosIncompletos()
    {
        $pagosIncompletos = $this->pagosIncompletos;
        $sumaDeIncompletos = $pagosIncompletos->sum('monto_abonado');
        foreach($pagosIncompletos as $pagoIncompleto)
        {
            $pagoIncompleto->situacion = 7;
            $pagoIncompleto->save();
        }
        // Obtener la gestión más reciente
        $pagoIncompletoMasReciente = $pagosIncompletos->sortByDesc('created_at')->first();
        $pagoProcesado = new GestionCuota([
            'pago_id' => $pagoIncompletoMasReciente->pago_id,
            'fecha_de_pago' => $pagoIncompletoMasReciente->fecha_de_pago,
            'monto_abonado' => $sumaDeIncompletos,
            'medio_de_pago' => $pagoIncompletoMasReciente->medio_de_pago,
            'sucursal' => $pagoIncompletoMasReciente->sucursal ?? null,
            'hora' => $pagoIncompletoMasReciente->hora ?? null,
            'cuenta' => $pagoIncompletoMasReciente->cuenta ?? null,
            'nombre_tercero' => $pagoIncompletoMasReciente->nombre_tercero ?? null,
            'central_de_pago' => $pagoIncompletoMasReciente->central_de_pago ?? null,
            'comprobante' => null,
            'usuario_informador_id' => auth()->id(),
            'situacion' => 8,
            'usuario_ultima_modificacion_id' => auth()->id()
        ]);
        $pagoProcesado->save();
        $this->cuota->estado = 6;
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true); 
    }
    public function modalDevolverPagoAplicadoEnCuotaSaldoExcedente()
    {
        $this->mensajeModalUno =
             'Vas a devolver un pago de Saldo Excedente.';
        $this->mensajeModalDos =
             'Tanto el pago como la cuota pasaron a Devueltas.';
        $this->modalDevolverPagoAplicadoEnCuotaSaldoExcedente = true;
    }
    public function cerrarModalDevolverPagoAplicadoEnCuotaSaldoExcedente()
    {
        $this->modalDevolverPagoAplicadoEnCuotaSaldoExcedente = false;
    }
    public function devolverPagoAplicadoEnCuotaSaldoExcedente()
    {
        $pagoAplicadoEnCuotaSaldoExcedente = $this->pagoAplicadoEnCuotaSaldoExcedente;
        $pagoAplicadoEnCuotaSaldoExcedente->situacion = 10;
        $pagoAplicadoEnCuotaSaldoExcedente->save();
        $this->cuota->estado = 8;
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true); 
    }
    //Reversar Pago Para Rendir
    public function admReversarPagoParaRendir($pagoDeCuotaId)
    {
        $this->mensajeModalUno =
            'El Pago Para Rendir se eliminará';
        $this->mensajeModalDos =
            'Los pagos procesados pasaran a Incompletos.';
        $this->mensajeModalTres =
            'La cuota pasará a estar Observada.';
        $this->modalReversarPagoParaRendir[$pagoDeCuotaId] = true;
    }
    public function cerrarModalReversarPagoParaRendir()
    {
        $this->modalReversarPagoParaRendir = false;
    }
    public function reversarPagoParaRendir($pagoDeCuotaId)
    {
        $pagoParaRendir = GestionCuota::find($pagoDeCuotaId);
        $pagosIncompletos = GestionCuota::where('pago_id', $pagoParaRendir->pago_id)
                                    ->where('situacion', 7)   
                                    ->get();
        foreach($pagosIncompletos as $pagoIncompleto)
        {
            $pagoIncompleto->situacion = 5;
            $pagoIncompleto->save();
        }
        $pagoParaRendir->delete();
        $this->cuota->estado = 2;
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true); 
    }
    //Boton reversar pago rendido a cuenta
    public function admReversarPagoRendidoACuenta($pagoDeCuotaId)
    {
        $this->mensajeModalUno =
            'El Pago Rendido a cuenta pasará a Pago Para Rendir.';
        $this->mensajeModalDos =
            'Los pagos procesados mantendrán su estado.';
        $this->mensajeModalTres =
            'La cuota pasará a estar Procesada.';
        $this->modalReversarPagoRendidoACuenta[$pagoDeCuotaId] = true;
    }
    public function cerrarModalReversarPagoRendidoACuenta()
    {
        $this->modalReversarPagoRendidoACuenta = false;
    }
    public function reversarPagoRendidoACuenta($pagoDeCuotaId)
    {
        $pagoRendidoACuenta = GestionCuota::find($pagoDeCuotaId);
        $pagoRendidoACuenta->situacion = 8;
        $pagoRendidoACuenta->save();
        $cuotaId = $pagoRendidoACuenta->pago_id;
        $cuota = Pago::find($cuotaId);
        $cuota->estado = 6;
        $cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true); 
    }
    //Reversar Pago Devuelto
    public function admReversarPagoDevuelto($pagoDeCuotaId)
    {
        $this->mensajeModalUno =
            'El Pago Devuelto y la cuota de Saldo Excedente';
        $this->mensajeModalDos =
            'cambiarán su a estado Aplicados.';
        $this->modalReversarPagoDevuelto[$pagoDeCuotaId] = true;
    }
    public function cerrarModalReversarPagoDevuelto()
    {
        $this->modalReversarPagoDevuelto = false;
    }
    public function reversarPagoDevuelto($pagoDeCuotaId)
    {
        $pagoDevuelto = GestionCuota::find($pagoDeCuotaId);
        $pagoDevuelto->situacion = 3;
        $pagoDevuelto->save();
        $this->cuota->estado = 3;
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true); 
    }
    //Boton reversar pago Aplicado
    public function admReversarPagoAplicado($pagoDeCuotaId)
    {
        $pagoAplicado = GestionCuota::find($pagoDeCuotaId);
        $this->pagoAplicado = $pagoAplicado;
        $cuotaId = $pagoAplicado->pago_id;
        //Busca pagos que tengan situacion de rechazados o incompletos
        $pagosDeLaCuotaObservados = GestionCuota::where('pago_id', $cuotaId)
                                    ->whereIn('situacion', [2,5]) // Si tiene cualquier pago que no sea vigente
                                    ->where('id', '<>', $pagoDeCuotaId)
                                    ->first();
        $this->pagosDeLaCuotaObservados = $pagosDeLaCuotaObservados;
        //Si la cuota no tiene otros pagos o solo pagos vigentes
        if(!$this->pagosDeLaCuotaObservados)
        {
            $this->mensajeModalUno =
            'El Pago Aplicado pasará a estado Informado';
            $this->mensajeModalDos =
            'La cuota o cancelación pasará a estado Vigente';    
        }
        else
        {
            $this->mensajeModalUno =
            'El Pago aplicado pasará a estado Informado';
            $this->mensajeModalDos =
            'Existen otros pagos observados por lo que la cuota será Observada.'; 
        }
        $this->reversarPagoAplicado[$pagoDeCuotaId] = true;
    }
    public function cerrarModalPagoAplicadoReversar($pagoDeCuotaId)
    {
        $this->reversarPagoAplicado[$pagoDeCuotaId] = false;
    }
    public function reversarPagoAplicado($pagoDeCuotaId)
    {
        $idDelAcuerdo = $this->cuota->acuerdo_id;
        $numeroDeCuotaActual = $this->cuota->nro_cuota;
        $cuotasSiguientes = Pago::where('acuerdo_id', $idDelAcuerdo)
                                 ->where('nro_cuota', '>', $numeroDeCuotaActual) // Solo cuotas posteriores
                                 ->where('estado', 3) // Revisar que el estado sea igual a 3
                                 ->get();
        //Si hay cuotas siguientes siguientes en estado aplicado
        if ($cuotasSiguientes->isNotEmpty())
        {
            $this->reversarPagoAplicado[$pagoDeCuotaId] = false;
            $this->mensajeModalUno =
            'El acuerdo tiene cuotas siguientes a la actual Aplicadas.';
            $this->mensajeModalDos =
            'Las mismas cambiarán su estado a Vigentes';
            $this->cuotasSiguientesAplicadas[$pagoDeCuotaId] = true;
        }
        //Si no hay cuotas siguientes en estado aplicado
        else
        {
            //Si no hay pagos observados
            if(!$this->pagosDeLaCuotaObservados)
            {
                $this->cuota->estado = 1;
            }
            //Si tiene pagos observados
            else
            {
                $this->cuota->estado = 2;
            }
            if($this->cuota->concepto_cuota == 'Cancelación')
            {
                $idDeLaCuota = $this->pagoAplicado->pago_id;
                $pagosCompletos = GestionCuota::where('pago_id', $idDeLaCuota)
                                                ->where('situacion', 6)
                                                ->get();
                if($pagosCompletos->isNotEmpty())  // Verificar si la colección no está vacía
                {
                    foreach($pagosCompletos as $pagoCompleto)
                    {
                        $pagoCompleto->situacion = 1;
                        $pagoCompleto->save();
                    }
                    $this->pagoAplicado->delete();
                }
                else
                {
                    $this->pagoAplicado->situacion = 1;
                    $this->pagoAplicado->save();  // No olvides guardar los cambios
                }
                //Si no hay pagos observados
                if(!$this->pagosDeLaCuotaObservados)
                {
                    $this->cuota->estado = 1;
                }
                //Si tiene pagos observados
                else
                {
                    $this->cuota->estado = 2;
                }
            }
            else
            {
                $this->pagoAplicado->situacion = 1;
                $this->pagoAplicado->save();
            }
            $this->cuota->save();
            session()->flash('imprimirAlertaExito', true);
            return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                    ->with('imprimirAlertaExito', true);         
        }
    }
    public function cerrarModalPagoAplicadoConCuotasSiguientesAplicadas($pagoDeCuotaId)
    {
        $this->cuotasSiguientesAplicadas[$pagoDeCuotaId] = false;
    }
    public function reversarPagoAplicadoYReversarCuotasSiguientes($pagoDeCuotaId)
    {
        $idDelAcuerdo = $this->cuota->acuerdo_id;
        $numeroDeCuotaActual = $this->cuota->nro_cuota;
        $cuotasSiguientes = Pago::where('acuerdo_id', $idDelAcuerdo)
                                 ->where('nro_cuota', '>', $numeroDeCuotaActual) // Solo cuotas posteriores
                                 ->where('estado', 3) // Revisar que el estado sea igual a 3
                                 ->get();
        foreach ($cuotasSiguientes as $cuotaSiguiente)
        {
            $pagoAsociado = GestionCuota::where('pago_id', $cuotaSiguiente->id)->first(); //Identifico al pago asociado a la cuota siguiente
            if ($pagoAsociado) {
                $pagoAsociado->delete();
            }
            $cuotaSiguiente->estado = 1;
            $cuotaSiguiente->save();
            if($cuotaSiguiente->concepto_cuota == 'Saldo Excedente')
            {
                $cuotaSiguiente->delete();//Si la cuota es de Saldo excedente se elimina
            }
        }
        if($this->cuota->concepto_cuota == 'Cancelación')
        {
            $idDeLaCuota = $this->pagoAplicado->pago_id;
            $pagosCompletos = GestionCuota::where('pago_id', $idDeLaCuota)
                                            ->where('situacion', 6)
                                            ->get();
            if($pagosCompletos->isNotEmpty())  // Verificar si la colección no está vacía
            {
                foreach($pagosCompletos as $pagoCompleto)
                {
                    $pagoCompleto->situacion = 1;
                    $pagoCompleto->save();
                }
                $this->pagoAplicado->delete();
            }
            else
            {
                $this->pagoAplicado->situacion = 1;
                $this->pagoAplicado->save();  // No olvides guardar los cambios
            }
            //Si no hay pagos observados
            if(!$this->pagosDeLaCuotaObservados)
            {
                $this->cuota->estado = 1;
            }
            //Si tiene pagos observados
            else
            {
                $this->cuota->estado = 2;
            }
        }
        else
        {
            $this->pagoAplicado->situacion = 1;
            $this->pagoAplicado->save();
            //Si no hay pagos observados
            if(!$this->pagosDeLaCuotaObservados)
            {
                $this->cuota->estado = 1;
            }
            //Si tiene pagos observados
            else
            {
                $this->cuota->estado = 2;
            }
        }
        $this->cuota->save();
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);
    }
    public function admReversarPagoRendido($pagoDeCuotaId)
    {
        //Obtengo la instancia del pago rendido
        $pagoDeCuota = GestionCuota::find($pagoDeCuotaId);
        $cuotaId = $pagoDeCuota->pago_id;
        //Obtengo la cuota y el nro de la misma a la que se le rindio el pago
        $cuota = Pago::find($cuotaId);
        //Busco si hay cuotas siguientes rendidas
        $cuotasSiguientesRendidas = $this->obtenerCuotasSiguientesRendidas($cuota);
        //Si hay cuotas siguientes rendidas
        if($cuotasSiguientesRendidas)
        {
            $this->mensajeModalUno =
            'No se puede revertir el Pago Rendido.';
            $this->mensajeModalDos =
            'El acuerdo tiene cuotas siguientes a la actual Rendidas.'; 
            $this->contexto = 1;
            $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
        }
        //Si no hay cuotas siguientes rendidas
        else
        {
            //Si la cuota es una cuota, antitipo, saldo pendiente o saldo excedente
            if($cuota->concepto_cuota == 'Cuota' || $cuota->concepto_cuota == 'Anticipo')
            {
                $this->pagosRendidosAnteriores = $this->obtenerPagosRendidosAnteriores($pagoDeCuotaId, $cuota);
                //Si la cuota tiene mas de un pago rendido
                if(!$this->pagosRendidosAnteriores->isEmpty())
                {
                    //Si la cuota esta rendida parcial
                    if($cuota->estado == 4)
                    {
                        $this->mensajeModalUno =
                        'El pago cambiará su estado a Aplicado y se';
                        $this->mensajeModalDos =
                        'lo asociará a la CSP que actualizará su monto.'; 
                        $this->mensajeModalTres =
                        'Si la misma tiene un pago aplicado pasará a informado';
                        $this->contexto = 2;
                        $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                    }
                    //Si la cuota esta rendida total
                    else
                    {
                        $this->ultimaCuota = $this->obtenerUltimaCuota($cuota);
                        $this->mensajeModalUno =
                        'El pago cambiará su estado a Aplicado y se';
                        $this->mensajeModalDos =
                        'lo asociará a una CSP con el monto de dicho pago.'; 
                        if($this->ultimaCuota->nro_cuota != $cuota->nro_cuota)
                        { 
                            $this->mensajeModalTres =
                            'La cuota pasará a Rendida Parcial.';
                            $this->contexto = 3;
                            $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                        }
                        else
                        {
                            $this->mensajeModalTres =
                            'La cta. pasará a R. Parcial. Al ser la últ. el acuerdo cambiará a Vigente.';
                            $this->contexto = 4;
                            $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                        }
                        $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                    }
                }
                //Si la cuota tiene un solo pago rendido
                else
                {
                    //Si la cuota esta rendida parcial
                    if($cuota->estado == 4)
                    {
                        $this->mensajeModalUno =
                        'El pago cambiará a Aplicado y se eliminará la CSP.';
                        $this->mensajeModalDos =
                        'Los pagos de la misma se pasarán a la cuota actual.'; 
                        $this->mensajeModalTres =
                        'que cambiará  su estado a Aplicada.';
                        $this->contexto = 5;
                        $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                    }
                    //La cuota esta rendida total
                    else
                    {
                        $this->ultimaCuota = $this->obtenerUltimaCuota($cuota);
                        $this->mensajeModalUno =
                        'Vas a reversar un Pago Rendido.';
                        $this->mensajeModalDos =
                        'El mismo y la cuota cambiarán su estado.'; 
                        if($this->ultimaCuota->nro_cuota != $cuota->nro_cuota)
                        { 
                            $this->mensajeModalTres =
                            'y pasarán a Aplicado.';
                            $this->contexto = 6;
                            $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                        }
                        else
                        {
                            $this->mensajeModalTres =
                            'La cta. pasará a R. Parcial. Al ser la últ. el acuerdo cambiará a Vigente.';
                            $this->contexto = 7;
                            $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
                        }
                    }
                }
            }
            //Si la cuota es una cancelacion
            elseif($cuota->concepto_cuota == 'Cancelación')
            {
                $this->mensajeModalUno =
                'El pago cambiará su estado a Aplicado.';
                $this->mensajeModalDos =
                'La Cancelación pasará a estado Aplicada'; 
                $this->mensajeModalTres =
                'El acuerdo cambiará a vigente.';
                $this->contexto = 8;
                $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
            }
            //Si la cuota es una CSE
            elseif($cuota->concepto_cuota == 'Saldo Excedente')
            {
                $this->mensajeModalUno =
                'El pago y la CSE cambiarán su estado a Aplicadas.';
                $this->mensajeModalDos =
                'Si tiene mas pagos no se modificaran'; 
                $this->contexto = 9;
                $this->modalReversarPagoRendido[$pagoDeCuotaId] = true;
            }
        }
    }
    public function cerrarModalReversarPagoRendido()
    {
        $this->modalReversarPagoRendido = false;
    }
    public function obtenerUltimaCuota($cuota)
    {
        return Pago::where('acuerdo_id', $cuota->acuerdo_id)
                        ->orderBy('nro_cuota', 'desc')
                        ->first();
    }
    public function reversarPagoRendido($pagoDeCuotaId, $contexto)
    {
        $pagoDeCuota = GestionCuota::find($pagoDeCuotaId);
        $cuota = $this->cuota;
        //Cuota con mas de un pago rendido
        if($contexto == 2 || $contexto == 3 || $contexto == 4)
        {
            $pagosRendidosAnteriores = $this->pagosRendidosAnteriores;
            //Obtengo la suma de los pagos rendidos anteriores
            $sumaRendidosAnteriores = $pagosRendidosAnteriores->sum('monto_abonado');
            //Calculo el nuevo monto de la CSP 
            $nuevoMontoCuotaSaldoPendiente = $cuota->monto_acordado - $sumaRendidosAnteriores;
            //Cuota en estado rendida parcial
            if($contexto == 2)
            {
                $cuotaDeSaldoPendiente = $this->obtenerCuotaSaldoPendiente($cuota);
                $cuotaDeSaldoPendiente->monto_acordado = $nuevoMontoCuotaSaldoPendiente;
                $cuotaDeSaldoPendiente->estado = 3;
                $cuotaDeSaldoPendiente->save();
                //Si la CSP tiene un pago aplicado pasa a informado
                $pagoAplicadoCuotaPendiente = $this->obtenerPagoAplicadoCuotaPendiente($cuotaDeSaldoPendiente);
                if($pagoAplicadoCuotaPendiente)
                {
                    $pagoAplicadoCuotaPendiente->situacion = 1;
                    $pagoAplicadoCuotaPendiente->save();
                }
                //El pago rendido revertido se lo asocia a la cuota de saldo pendiente
                $pagoDeCuota->pago_id = $cuotaDeSaldoPendiente->id;
            }
            //Cuota en estado rendida total
            else
            {
                //Creo una nueva CSP por el monto que que falta cubrir de la cuota luego de reversar el pago rendido
                $cuotaDeSaldoPendiente = new Pago([
                    'acuerdo_id' => $cuota['acuerdo_id'],
                    'responsable_id' => $cuota['responsable_id'],
                    'estado' => 3,//Aplicada
                    'concepto_cuota' => 'Saldo Pendiente',
                    'monto_acordado' => $nuevoMontoCuotaSaldoPendiente,
                    'nro_cuota' => $cuota['nro_cuota'],
                    'vencimiento_cuota' => $cuota['vencimiento_cuota'],
                    'usuario_ultima_modificacion_id' => auth()->id(),
                ]);
                $cuotaDeSaldoPendiente->save();
                $pagoDeCuota->pago_id = $cuotaDeSaldoPendiente->id;
                $pagoDeCuota->save();
                $cuota->estado = 4;//rendida parcial
                $cuota->save();
                //Si es la ultima cuota
                if($contexto == 4)
                {
                    $acuerdoId = $this->cuota->acuerdo_id;
                    $acuerdo = Acuerdo::find($acuerdoId);
                    $acuerdo->estado = 1;
                    $acuerdo->save();
                }
            }
        }
        //Cuota con un solo pago rendido
        elseif($contexto == 5 || $contexto == 6 || $contexto == 7 || $contexto == 9)
        {
            // Si la cuota está rendida parcial (contexto 5)
            if($contexto == 5)
            {
                // Obtengo la cuota de saldo pendiente y todos sus pagos
                $cuotaDeSaldoPendiente = $this->obtenerCuotaSaldoPendiente($cuota);
                $pagosDeSaldoPendiente = $this->obtenerPagosSaldoPendiente($cuotaDeSaldoPendiente);
                foreach($pagosDeSaldoPendiente as $pagoDeSaldoPendiente) {
                    // Todos los pagos pasan a la cuota que estaba rendida parcial
                    $pagoDeSaldoPendiente->pago_id = $cuota->id;
                    if($pagoDeSaldoPendiente->situacion == 3) {
                        // Si la CSP tenía un pago aplicado, pasa a informado
                        $pagoDeSaldoPendiente->situacion = 1;
                    }
                    $pagoDeSaldoPendiente->save();
                }
                // La CSP se elimina y la rendida parcial pasa a aplicada
                $cuotaDeSaldoPendiente->delete();
            }
            if($contexto == 7)
            {
                $acuerdoId = $this->cuota->acuerdo_id;
                $acuerdo = Acuerdo::find($acuerdoId);
                $acuerdo->estado = 1;
                $acuerdo->save();
            }
            // Lógica común para ambos contextos
            $cuota->estado = 3; // La cuota pasa a estado aplicado
            $cuota->save();
        }
        //Cancelacion
        elseif($contexto == 8)
        {
            $cuota->estado = 3; // La cuota pasa a estado aplicado
            $cuota->save();
            $acuerdoId = $this->cuota->acuerdo_id;
            $acuerdo = Acuerdo::find($acuerdoId);
            $acuerdo->estado = 1;
            $acuerdo->save();
        }
        
        $pagoDeCuota->situacion = 3;//El pago rendido pasa a aplicado
        $pagoDeCuota->save();
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);

    }
    private function obtenerPagosRendidosAnteriores($pagoDeCuotaId, $cuota)
    {
        return GestionCuota::where('pago_id', $cuota->id)
                        ->where('situacion', 4)
                        ->where('id', '!=', $pagoDeCuotaId)
                        ->get();
    }
    private function obtenerPagosCompletos($cuota)
    {
        return GestionCuota::where('pago_id', $cuota->id)
                        ->where('situacion', 6)
                        ->get();
    }
    private function obtenerCuotasSiguientesRendidas($cuota)
    {
        return Pago::where('acuerdo_id', $cuota->acuerdo_id)
                    ->where('estado', 5)
                    ->where('nro_cuota', '>', $cuota->nro_cuota)
                    ->first();
    }
    private function obtenerCuotaSaldoPendiente($cuota)
    {
        return Pago::where('acuerdo_id', $cuota->acuerdo_id)
                    ->where('concepto_cuota', 'Saldo Pendiente')
                    ->first();
    }
    private function obtenerPagoAplicadoCuotaPendiente($cuotaDeSaldoPendiente)
    {
        return GestionCuota::where('pago_id', $cuotaDeSaldoPendiente->id)
                        ->where('situacion', 3)
                        ->first();
    }
    private function obtenerPagosSaldoPendiente($cuotaDeSaldoPendiente)
    {
        return GestionCuota::where('pago_id', $cuotaDeSaldoPendiente->id)
                        ->get();
    }
    private function obtenerPagosCuotaSiguiente($cuotaSiguiente)
    {
        return GestionCuota::where('pago_id', $cuotaSiguiente->id)->get();
    }

    //Funciones que ejecutan acciones comunes para todos los estados
    protected function obtenerDatosComunes($informacionIngresada)
    {
        return [
            'pago_id' => $this->cuota->id,
            'fecha_de_pago' => $informacionIngresada['fecha_de_pago'],
            'medio_de_pago' => $informacionIngresada['medio_de_pago'],
            'monto_abonado' => $informacionIngresada['monto_abonado'],
            'sucursal' => $informacionIngresada['camposCondicionales']['sucursal'] ?? null,
            'hora' => $informacionIngresada['camposCondicionales']['hora'] ?? null,
            'cuenta' => $informacionIngresada['camposCondicionales']['cuenta'] ?? null,
            'nombre_tercero' => $informacionIngresada['camposCondicionales']['nombre_tercero'] ?? null,
            'central_de_pago' => $informacionIngresada['camposCondicionales']['central_de_pago'] ?? null,
            'comprobante' => $informacionIngresada['comprobante'] ?? null,
            'usuario_informador_id' => auth()->id(),
            'fecha_informe' => now()->format('Y-m-d'),
            'usuario_ultima_modificacion_id' => auth()->id(),
        ];
    }
    protected function gestionarSobrante($sobrante, $informacionIngresada, $cuota)
    {
        //Si hay sobrante de una Cancelacion
        if ($cuota['concepto_cuota'] === 'Cancelación')
        {
            // Crear cuota de saldo excedente
            $nuevaCuotaDeSaldoExcedente = $this->crearCuotaSaldoExcedente($sobrante, $cuota);
            // Registrar pago para la nueva cuota
            $this->registrarPago($nuevaCuotaDeSaldoExcedente->id, $sobrante, $informacionIngresada);
        }
        //Si hay sobrante en una cuota
        else
        {
            // Imputar sobrante en cuotas restantes
            $sobrante = $this->imputarEnCuotasRestantes($sobrante, $informacionIngresada, $cuota);
            // Si queda un sobrante, crear saldo excedente
            if ($sobrante > 0) {
                $nuevaCuotaDeSaldoExcedente = $this->crearCuotaSaldoExcedente($sobrante, $cuota, $cuota);
                $this->registrarPago($nuevaCuotaDeSaldoExcedente->id, $sobrante, $informacionIngresada);
            }
        }
    }
    protected function crearCuotaSaldoExcedente($sobrante, $cuota)
    {
        $nroCuotaMasAlto = Pago::where('acuerdo_id', $cuota['acuerdo_id'])
                                ->orderBy('nro_cuota', 'desc')
                                ->first();
        $nuevaCuota = new Pago([
            'acuerdo_id' => $cuota['acuerdo_id'],
            'responsable_id' => $cuota['responsable_id'],
            'estado' => 3, // Aplicado
            'concepto_cuota' => 'Saldo Excedente',
            'monto_acordado' => $sobrante,
            'nro_cuota' => ($nroCuotaMasAlto ? $nroCuotaMasAlto->nro_cuota : 0) + 1,
            'vencimiento_cuota' => now()->format('Y-m-d'),
            'usuario_ultima_modificacion_id' => auth()->id(),
        ]);
        $nuevaCuota->save();

        return $nuevaCuota;
    }
    protected function registrarPago($pagoId, $monto, $informacionIngresada)
    {
        $nuevoPago = new GestionCuota([
            'pago_id' => $pagoId,
            'fecha_de_pago' => $informacionIngresada['fecha_de_pago'],
            'monto_abonado' => $monto,
            'medio_de_pago' => $informacionIngresada['medio_de_pago'],
            'sucursal' => $informacionIngresada['camposCondicionales']['sucursal'] ?? null,
            'hora' => $informacionIngresada['camposCondicionales']['hora'] ?? null,
            'cuenta' => $informacionIngresada['camposCondicionales']['cuenta'] ?? null,
            'nombre_tercero' => $informacionIngresada['camposCondicionales']['nombre_tercero'] ?? null,
            'central_de_pago' => $informacionIngresada['camposCondicionales']['central_de_pago'] ?? null,
            'comprobante' => $informacionIngresada['comprobante'] ?? null,
            'usuario_informador_id' => auth()->id(),
            'situacion' => 3,
            'fecha_informe' => now()->format('Y-m-d'),
            'usuario_ultima_modificacion_id' => auth()->id(),
        ]);
        $nuevoPago->save();
    }
    protected function imputarEnCuotasRestantes($sobrante, $informacionIngresada, $cuota)
    {
        $cuotasRestantes = Pago::where('acuerdo_id', $cuota['acuerdo_id'])
                                ->where('nro_cuota', '>', $cuota['nro_cuota'])
                                ->where('estado', 1) // Solo cuotas vigentes
                                ->orderBy('nro_cuota', 'asc')
                                ->get();

        foreach ($cuotasRestantes as $cuotaRestante) {
            if ($sobrante <= 0) {
                break; // Si el sobrante se agota, detener el proceso
            }
            $montoAcordado = $cuotaRestante->monto_acordado;
            $montoAbonado = $sobrante >= $montoAcordado ? $montoAcordado : $sobrante;
            // Registrar pago para la cuota
            $this->registrarPago($cuotaRestante->id, $montoAbonado, $informacionIngresada);
            // Reducir el sobrante
            $sobrante -= $montoAbonado;
            // Cambiar el estado de la cuota a aplicado
            $cuotaRestante->estado = 3; // Aplicado
            $cuotaRestante->save();
        }
        return $sobrante;
    }

    //Funciones con llamado a funciones presentes en clases hijas
    protected function procesarInformacionAgente($datosComunes)
    {
        $procesarInformacionAgente = new GestionAgente($datosComunes);
        $procesarInformacionAgente->procesarInformacionFormularioAgente($datosComunes);
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);
    }
    protected function procesarInformacionAdministrador($datosComunes, $cuota)
    {
        $procesarInformacionAdministrador = new GestionAdministrador($datosComunes, $cuota);
        $procesarInformacionAdministrador->procesarInformacionFormularioAdministrador($datosComunes, $cuota);
        session()->flash('imprimirAlertaExito', true);
        return redirect()->route('gestion.cuota', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlertaExito', true);
    }

    public function render()
    {
        // Definir el orden de importancia de la situacion
        $ordenImportancia = [4, 9, 3, 8, 6, 7, 5, 2, 1, 10];

        // Obtener los pagos de la cuota ordenados por fecha de creación
        $pagosDeCuota = GestionCuota::where('pago_id', $this->cuota->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Aplicar el orden personalizado según la 'situacion'
        $pagosDeCuota = $pagosDeCuota->sortBy(function($pago) use ($ordenImportancia) {
            return array_search($pago->situacion, $ordenImportancia);
        });

        // Verificar si hay pagos y ajustar el valor de mostrarFormulario
        if ($pagosDeCuota->isNotEmpty()) {
            if ($pagosDeCuota->contains(function ($pago) {
                return in_array($pago->situacion, [1, 3, 4, 8, 9, 10]);
            })) {
                $this->mostrarFormulario = false;
            } else {
                $this->mostrarFormulario = true;
            }
        } else {
            $this->mostrarFormulario = true;
        }

        // Retornar la vista con la colección de pagos ordenada
        return view('livewire.gestiones.global-gestiones', [
            'pagosDeCuota' => $pagosDeCuota,
            'cuota' => $this->cuota
        ]);
    }

}
