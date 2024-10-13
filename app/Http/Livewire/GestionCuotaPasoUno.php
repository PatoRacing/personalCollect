<?php

namespace App\Http\Livewire;

use App\Models\GestionCuota;
use App\Models\Pago;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class GestionCuotaPasoUno extends Component
{
    use WithFileUploads;

    public $pago;
    public $pasoUno = true;
    public $fecha_de_pago;
    public $monto_abonado;
    public $medio_de_pago;
    public $medioDePagoDeposito;
    public $medioDePagoTransferencia;
    public $medioDePagoEfectivo;
    public $sucursal;
    public $hora;
    public $cuenta;
    public $comprobante;
    public $nombre_tercero;
    public $central_de_pago;
    public $montoAbonadoSuperior = false;

    protected $listeners = ['PagoFinalizado'=>'actualizarVista', 'PagoInformado'=>'actualizarVista'];

    //funcion para actualizar la vista
    public function actualizarVista()
    {
        $this->render();
    }
    public function siguientePasoUno()
    {
        $this->validate([
            'fecha_de_pago'=> 'required|date',
            'monto_abonado'=> 'required',
            'medio_de_pago'=> 'required',
        ]);
        //Si el usuario es un administrador
        if(auth()->user()->rol == 'Administrador') {
            //Si el monto abonado es superior al acordado se muestra modal
            if($this->monto_abonado > $this->pago->monto_acordado) {
                $this->pasoUno = false;
                $this->montoAbonadoSuperior = true;
            }
            //Si el monto abonado es menor al acordado se muestra modal
            else {
                $this->condiciones();
                $this->pasoUno = false;
            }
        }
        //Si el usuario es agente no se muestra la modal
        else {
            $this->condiciones();
            $this->pasoUno = false;
        }
    }
    public function condiciones()
    {
        $this->montoAbonadoSuperior = false;
        if($this->medio_de_pago == 'Depósito'){
            $this->medioDePagoDeposito = true;
        } elseif($this->medio_de_pago == 'Transferencia') {
            $this->medioDePagoTransferencia = true;
        } elseif($this->medio_de_pago == 'Efectivo'){
            $this->medioDePagoEfectivo = true;
        }
    }
    public function anterior()
    {
        $this->pasoUno = true;
        $this->medio_de_pago = null;
        $this->sucursal = null;
        $this->hora = null;
        $this->cuenta = null;
        $this->comprobante = null;
        $this->nombre_tercero = null;
        $this->central_de_pago = null;
        $this->medioDePagoDeposito = false;
        $this->medioDePagoTransferencia = false;
        $this->medioDePagoEfectivo = false;
    }
    public function cerrarModalMontoAbonadoSuperior()
    {
        $this->montoAbonadoSuperior = false;
        $this->pasoUno = true;
        $this->monto_abonado = null;
    }
    public function guardarInforme()
    {
        if ($this->medioDePagoDeposito) {
            $this->validate([
                'sucursal'=> 'required',
                'hora'=> 'required',
                'cuenta'=> 'required'
            ]);
        } elseif ($this->medioDePagoTransferencia) {
            $this->validate([
                'nombre_tercero'=> 'required',
                'cuenta'=> 'required'
            ]);
        } elseif ($this->medioDePagoEfectivo) {
            $this->validate([
                'central_de_pago'=> 'required'
            ]);
        }
        $nombreComprobante = null;
        if($this->comprobante) {
            $comprobanteDePago = $this->comprobante->store('public/comprobantes');
            $nombreComprobante = str_replace('public/comprobantes/', '', $comprobanteDePago);
        }
        //Si el usuario es administrador
        if(auth()->user()->rol == 'Administrador') {
            //Si la cuota es un Anticipo
            if($this->pago->concepto_cuota == 'Anticipo') {
                //Si el anticipo tiene estado 5 (Cuota Observada)
                if($this->pago->estado == 5) {
                    //Obtengo todos los pagos abonados de las gestiones previas
                    $gestionesPrevias = GestionCuota::where('pago_id', $this->pago->id)->sum('monto_abonado');
                    //Calculo cuanto le falta pagar para cumplir con lo acordado
                    $saldoAPagar = $this->pago->monto_acordado - $gestionesPrevias;
                    //Si el monto abonado todavia no alcanza para cubrir el monto acordado
                    if($this->monto_abonado < $saldoAPagar) {
                        //Se genera una nueva gestion de pago para esta cuota con el pago realizado
                        $gestionCuota = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$this->monto_abonado,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 4, //Pago observado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuota->save();
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                    //Si con lo abonado cubre el saldo a pagar
                    elseif($this->monto_abonado == $saldoAPagar) {
                        //Se actualiza el estado de la cuota a 2 (cuota con pago aplicado)
                        $this->pago->estado = 2; // Cuota con pago aplicado
                        $this->pago->usuario_ultima_modificacion_id = auth()->id();
                        $this->pago->save();
                        //Se genera una nueva gestion de pago para esta cuota con el pago realizado
                        $gestionCuota = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$this->monto_abonado,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 2, //Pago aplicado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuota->save();
                        //Actualizo las gestiones previas de pagos a estado 2 (pagos aplicados)
                        $nuevosEstadosDeGestionesPrevias = GestionCuota::where('pago_id', $this->pago->id)->get();
                        foreach($nuevosEstadosDeGestionesPrevias as $nuevoEstadoDeGestionPrevia) {
                            $nuevoEstadoDeGestionPrevia->situacion = 2; //Pago aplicado
                            $nuevoEstadoDeGestionPrevia->usuario_ultima_modificacion_id = auth()->id();
                            $nuevoEstadoDeGestionPrevia->save();
                        }
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                    //Si el monto abonado supera el saldo a pagar
                    elseif($this->monto_abonado > $saldoAPagar) {
                        //Se actualiza el estado de la cuota a 2 (cuota con pago aplicado)
                        $this->pago->estado = 2; // Cuota con pago aplicado
                        $this->pago->usuario_ultima_modificacion_id = auth()->id();
                        $this->pago->save();
                        //Se genera una nueva gestion de pago para esta cuota con un monto que cubra el saldo del monto acordado
                        $gestionCuota = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$saldoAPagar,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 2, //Pago aplicado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuota->save();
                        //Actualizo los pagos anteriores a estado 2 (pagos aplicados)
                        $nuevosEstadosDeGestionesPrevias = GestionCuota::where('pago_id', $this->pago->id)->get();
                        foreach($nuevosEstadosDeGestionesPrevias as $nuevoEstadoDeGestionPrevia) {
                            $nuevoEstadoDeGestionPrevia->situacion = 2; //Pago aplicado
                            $nuevoEstadoDeGestionPrevia->usuario_ultima_modificacion_id = auth()->id();
                            $nuevoEstadoDeGestionPrevia->save();
                        }
                        //Como es anticipo es un acuerdo de cuotas->permite aplicacion parcial
                        //Se calcula cuanto sobra para aplicar a las siguiente cuotas
                        $saldoRestanteParaAplicar = $this->monto_abonado - $saldoAPagar;
                        // Se imputa el saldo restante a las cuotas sucesivas hasta que se agote el monto abonado
                        $nroCuota = $this->pago->nro_cuota + 1;
                        while ($saldoRestanteParaAplicar > 0) {
                            $cuotaSiguiente = Pago::where('acuerdo_id', $this->pago->acuerdo_id)
                                                    ->where('nro_cuota', $nroCuota)
                                                    ->first();
                            if ($cuotaSiguiente) {
                                // Calculamos el monto a imputar a la cuota siguiente
                                $montoParaImputar = min($cuotaSiguiente->monto_acordado, $saldoRestanteParaAplicar);
                                $cuotaSiguiente->estado = 2; // Cuota con pago aplicado
                                $cuotaSiguiente->usuario_ultima_modificacion_id = auth()->id();
                                $cuotaSiguiente->save();
                                //Generamos una nueva gestion de pago para la siguiente cuota
                                $gestionCuotaSiguiente = new GestionCuota([
                                    'pago_id' => $cuotaSiguiente->id,
                                    'fecha_de_pago' => $this->fecha_de_pago,
                                    'monto_abonado' => $montoParaImputar,
                                    'medio_de_pago' => $this->medio_de_pago,
                                    'sucursal' => $this->sucursal,
                                    'hora' => $this->hora,
                                    'cuenta' => $this->cuenta,
                                    'nombre_tercero' => $this->nombre_tercero,
                                    'central_de_pago' => $this->central_de_pago,
                                    'comprobante' => $nombreComprobante,
                                    'usuario_informador_id' => auth()->id(),
                                    'fecha_informe' => now()->format('Y-m-d'),
                                    'situacion' => 2, // Pago aplicado
                                    'usuario_ultima_modificacion_id' => auth()->id(),
                                ]);
                                $gestionCuotaSiguiente->save();
                                // Reducimos el monto abonado a favor por el monto imputado
                                $saldoRestanteParaAplicar -= $montoParaImputar;
                                // Actualizamos el número de cuota para la siguiente iteración
                                $nroCuota++;
                            } else {
                                // No hay más cuotas, se puede generar una devolución o manejar el saldo de otra forma
                                $devolucion = new Pago([
                                    'acuerdo_id' => $this->pago->acuerdo_id,
                                    'responsable_id' => $this->pago->responsable_id,
                                    'estado' => 6,
                                    'concepto_cuota' => 'Excedente',
                                    'monto_acordado' => $saldoRestanteParaAplicar,
                                    'nro_cuota' => 1,
                                    'vencimiento_cuota' => now()->format('Y-m-d'),
                                    'usuario_ultima_modificacion_id' => auth()->id(),
                                ]);
                                $devolucion->save();
                                break;
                            }
                        }
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                }
                //Si el anticipo tiene estado 1 (cuota vigente)
                elseif($this->pago->estado == 1) {
                    //Si el monto acordado es mayor al monto abonado (el pago no se puede imputar)
                    if($this->pago->monto_acordado > $this->monto_abonado) {
                        $this->pago->estado = 5; // Cuota Observada
                        $this->pago->usuario_ultima_modificacion_id = auth()->id();
                        $this->pago->save();
                        //Se genera una nueva gestion de pago para esta cuota
                        $gestionCuota = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$this->monto_abonado,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 4, //Pago observado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuota->save();
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                    //Si el monto acordado es igual al monto abonado (se puede imputar)
                    elseif($this->pago->monto_acordado == $this->monto_abonado) {
                        $this->pago->estado = 2; // Cuota con pago aplicado
                        $this->pago->usuario_ultima_modificacion_id = auth()->id();
                        $this->pago->save();
                        //Se genera una nueva gestion de pago para esta cuota
                        $gestionCuota = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$this->monto_abonado,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 2, //Pago aplicado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuota->save();
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                    // Si el monto abonado es mayor al monto acordado (se puede imputar y calcular la diferencia para imputar al siguiente pago)
                    elseif ($this->pago->monto_acordado < $this->monto_abonado) {
                        $montoAbonadoAFavor = $this->monto_abonado;
                        // Se genera una nueva gestion de pago para esta cuota (anticipo)
                        $gestionCuota = new GestionCuota([
                            'pago_id' => $this->pago->id,
                            'fecha_de_pago' => $this->fecha_de_pago,
                            'monto_abonado' => $this->pago->monto_acordado,
                            'medio_de_pago' => $this->medio_de_pago,
                            'sucursal' => $this->sucursal,
                            'hora' => $this->hora,
                            'cuenta' => $this->cuenta,
                            'nombre_tercero' => $this->nombre_tercero,
                            'central_de_pago' => $this->central_de_pago,
                            'comprobante' => $nombreComprobante,
                            'usuario_informador_id' => auth()->id(),
                            'fecha_informe' => now()->format('Y-m-d'),
                            'situacion' => 2, // Pago aplicado
                            'usuario_ultima_modificacion_id' => auth()->id(),
                        ]);
                        $gestionCuota->save();
                        // Reducimos el monto abonado por el monto del anticipo
                        $montoAbonadoAFavor -= $this->pago->monto_acordado;
                        // Actualizamos la cuota actual (el anticipo)
                        $this->pago->estado = 2; // Cuota con pago aplicado
                        $this->pago->usuario_ultima_modificacion_id = auth()->id();
                        $this->pago->save();
                        // Se imputan las cuotas sucesivas hasta que se agote el monto abonado
                        $nroCuota = $this->pago->nro_cuota + 1;
                        while ($montoAbonadoAFavor > 0) {
                            $cuotaSiguiente = Pago::where('acuerdo_id', $this->pago->acuerdo_id)
                                                    ->where('nro_cuota', $nroCuota)
                                                    ->first();
                            if ($cuotaSiguiente) {
                                // Calculamos el monto a imputar a la cuota siguiente
                                $montoParaImputar = min($cuotaSiguiente->monto_acordado, $montoAbonadoAFavor);
                                $cuotaSiguiente->estado = 2; // Cuota con pago aplicado
                                $cuotaSiguiente->usuario_ultima_modificacion_id = auth()->id();
                                $cuotaSiguiente->save();
                                //Generamos una nueva gestion de pago para la siguiente cuota
                                $gestionCuotaSiguiente = new GestionCuota([
                                    'pago_id' => $cuotaSiguiente->id,
                                    'fecha_de_pago' => $this->fecha_de_pago,
                                    'monto_abonado' => $montoParaImputar,
                                    'medio_de_pago' => $this->medio_de_pago,
                                    'sucursal' => $this->sucursal,
                                    'hora' => $this->hora,
                                    'cuenta' => $this->cuenta,
                                    'nombre_tercero' => $this->nombre_tercero,
                                    'central_de_pago' => $this->central_de_pago,
                                    'comprobante' => $nombreComprobante,
                                    'usuario_informador_id' => auth()->id(),
                                    'fecha_informe' => now()->format('Y-m-d'),
                                    'situacion' => 2, // Pago aplicado
                                    'usuario_ultima_modificacion_id' => auth()->id(),
                                ]);
                                $gestionCuotaSiguiente->save();
                                // Reducimos el monto abonado a favor por el monto imputado
                                $montoAbonadoAFavor -= $montoParaImputar;
                                // Actualizamos el número de cuota para la siguiente iteración
                                $nroCuota++;
                            } else {
                                // No hay más cuotas, se puede generar una devolución o manejar el saldo de otra forma
                                $devolucion = new Pago([
                                    'acuerdo_id' => $this->pago->acuerdo_id,
                                    'responsable_id' => $this->pago->responsable_id,
                                    'estado' => 6,
                                    'concepto_cuota' => 'Devolución',
                                    'monto_acordado' => $montoAbonadoAFavor,
                                    'nro_cuota' => 1,
                                    'vencimiento_cuota' => now()->format('Y-m-d'),
                                    'usuario_ultima_modificacion_id' => auth()->id(),
                                ]);
                                $devolucion->save();
                                break;
                            }
                        }
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    }
                }
            }
            //Si la cuota es una cuota
            elseif($this->pago->concepto_cuota == 'Cuota') {
                //Si el monto acordado es mayor o igual al monto abonado (se puede imputar)
                if($this->pago->monto_acordado > $this->monto_abonado || $this->pago->monto_acordado = $this->monto_abonado) {
                    $this->pago->estado = 2; // Cuota con pago aplicado
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    //Se genera una nueva gestion de pago para esta cuota
                    $gestionCuota = new GestionCuota([
                        'pago_id'=>$this->pago->id,
                        'fecha_de_pago'=>$this->fecha_de_pago,
                        'monto_abonado'=>$this->monto_abonado,
                        'medio_de_pago'=>$this->medio_de_pago,
                        'sucursal'=>$this->sucursal,
                        'hora'=>$this->hora,
                        'cuenta'=>$this->cuenta,
                        'nombre_tercero'=>$this->nombre_tercero,
                        'central_de_pago'=>$this->central_de_pago,
                        'comprobante'=>$nombreComprobante,
                        'usuario_informador_id'=>auth()->id(),
                        'fecha_informe'=> now()->format('Y-m-d'),
                        'situacion' => 2, //Pago aplicado
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                    $gestionCuota->save();
                    $this->emit('pagoInformado');
                    session()->flash('pagoInformado', true);
                    return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                }
                //Si el monto acordado es menor al monto abonado (se puede imputar y calcular la diferencia para imputar al siguiente pago o para devolucion)
                elseif($this->pago->monto_acordado < $this->monto_abonado) {
                    $this->pago->estado = 2; // Cuota con pago aplicado
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    //Se genera una nueva gestion de pago para esta cuota
                    $gestionCuota = new GestionCuota([
                        'pago_id'=>$this->pago->id,
                        'fecha_de_pago'=>$this->fecha_de_pago,
                        'monto_abonado'=>$this->monto_abonado,
                        'medio_de_pago'=>$this->medio_de_pago,
                        'sucursal'=>$this->sucursal,
                        'hora'=>$this->hora,
                        'cuenta'=>$this->cuenta,
                        'nombre_tercero'=>$this->nombre_tercero,
                        'central_de_pago'=>$this->central_de_pago,
                        'comprobante'=>$nombreComprobante,
                        'usuario_informador_id'=>auth()->id(),
                        'fecha_informe'=> now()->format('Y-m-d'),
                        'situacion' => 2, //Pago aplicado
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                    $gestionCuota->save();
                    //Se calcula la diferencia y se ubica la cuota siguiente
                    $montoAbonadoAFavor = $this->monto_abonado - $this->pago->monto_acordado;
                    $cuotaSiguiente = Pago::where('acuerdo_id', $this->pago->acuerdo_id)
                                        ->where('nro_cuota', $this->pago->nro_cuota + 1)
                                        ->first();
                    //Si hay una cuota siguiente se le imputa un pago equivalente por la diferencia                    
                    if($cuotaSiguiente) {
                        $cuotaSiguiente->estado = 2; // Cuota con pago aplicado
                        $cuotaSiguiente->usuario_ultima_modificacion_id = auth()->id();
                        $cuotaSiguiente->save();
                        $gestionCuotaSiguiente = new GestionCuota([
                            'pago_id'=>$this->pago->id,
                            'fecha_de_pago'=>$this->fecha_de_pago,
                            'monto_abonado'=>$montoAbonadoAFavor,
                            'medio_de_pago'=>$this->medio_de_pago,
                            'sucursal'=>$this->sucursal,
                            'hora'=>$this->hora,
                            'cuenta'=>$this->cuenta,
                            'nombre_tercero'=>$this->nombre_tercero,
                            'central_de_pago'=>$this->central_de_pago,
                            'comprobante'=>$nombreComprobante,
                            'usuario_informador_id'=>auth()->id(),
                            'fecha_informe'=> now()->format('Y-m-d'),
                            'situacion' => 2, //Pago aplicado
                            'usuario_ultima_modificacion_id'=>auth()->id(),
                        ]);
                        $gestionCuotaSiguiente->save();
                        $this->emit('pagoInformado');
                        session()->flash('pagoInformado', true);
                        return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                    } 
                    //Si no hay una cuota siguiente se genera una y se imputa un pago como devolucion por la diferencia
                    else {
                        $nuevaCuota = new Pago([
                            'acuerdo_id'=>$this->pago->acuerdo_id,
                            'responsable_id'=>$this->pago->responsable_id,
                            'estado'=> 2,
                            'concepto_cuota'=> 'Devolución',
                            'monto_acordado'=> $montoAbonadoAFavor,
                            'nro_cuota'=> 1,
                            'vencimiento_cuota'=> today(),
                            'usuario_ultima_modificacion_id'=> auth()->id
                        ]);
                    }
                }
            }
            //Si la cuota es una cancelación
            elseif($this->pago->concepto_cuota == 'Cancelación') {
                //Si el monto acordado es mayor al monto abonado (no se puede imputar)
                if($this->pago->monto_acordado > $this->monto_abonado) {
                    $this->pago->estado = 5; //Cuota observada
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    //Generar una nueva gestion de pago sobre la cuota
                    $gestionCuota = new GestionCuota([
                        'pago_id'=>$this->pago->id,
                        'fecha_de_pago'=>$this->fecha_de_pago,
                        'monto_abonado'=>$this->monto_abonado,
                        'medio_de_pago'=>$this->medio_de_pago,
                        'sucursal'=>$this->sucursal,
                        'hora'=>$this->hora,
                        'cuenta'=>$this->cuenta,
                        'nombre_tercero'=>$this->nombre_tercero,
                        'central_de_pago'=>$this->central_de_pago,
                        'comprobante'=>$nombreComprobante,
                        'usuario_informador_id'=>auth()->id(),
                        'fecha_informe'=> now()->format('Y-m-d'),
                        'situacion' => 4,//Pago Observado
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                    $gestionCuota->save();
                    $this->emit('pagoInformado');
                    session()->flash('pagoInformado', true);
                    return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                }
                //Si el monto acordado es igual al monto abonado (se puede imputar)
                elseif($this->pago->monto_acordado = $this->monto_abonado) {
                    $this->pago->estado = 2; //Cuota con pago aplicado
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    //Generar una nueva gestion de pago sobre la cuota
                    $gestionCuota = new GestionCuota([
                        'pago_id'=>$this->pago->id,
                        'fecha_de_pago'=>$this->fecha_de_pago,
                        'monto_abonado'=>$this->monto_abonado,
                        'medio_de_pago'=>$this->medio_de_pago,
                        'sucursal'=>$this->sucursal,
                        'hora'=>$this->hora,
                        'cuenta'=>$this->cuenta,
                        'nombre_tercero'=>$this->nombre_tercero,
                        'central_de_pago'=>$this->central_de_pago,
                        'comprobante'=>$nombreComprobante,
                        'usuario_informador_id'=>auth()->id(),
                        'fecha_informe'=> now()->format('Y-m-d'),
                        'situacion' => 2,//Pago Aplicado
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                    $gestionCuota->save();
                    $this->emit('pagoInformado');
                    session()->flash('pagoInformado', true);
                    return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                }
                //Si el monto acordado es menor al monto abonado (se puede imputar y se calcula la diferencia para devolucion)
                elseif($this->pago->monto_acordado < $this->monto_abonado) {
                    $this->pago->estado = 2; //Cuota con pago aplicado
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    //Generar una nueva gestion de pago sobre la cuota
                    $gestionCuota = new GestionCuota([
                        'pago_id'=>$this->pago->id,
                        'fecha_de_pago'=>$this->fecha_de_pago,
                        'monto_abonado'=>$this->monto_abonado,
                        'medio_de_pago'=>$this->medio_de_pago,
                        'sucursal'=>$this->sucursal,
                        'hora'=>$this->hora,
                        'cuenta'=>$this->cuenta,
                        'nombre_tercero'=>$this->nombre_tercero,
                        'central_de_pago'=>$this->central_de_pago,
                        'comprobante'=>$nombreComprobante,
                        'usuario_informador_id'=>auth()->id(),
                        'fecha_informe'=> now()->format('Y-m-d'),
                        'situacion' => 2,//Pago Aplicado
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                    $gestionCuota->save();
                    //Establecer la diferencia y generar una nueva instancia de cuota
                    $montoAbonadoAFavor = $this->monto_abonado - $this->pago->monto_acordado;
                    $nuevaCuota = new Pago([
                        'acuerdo_id'=>$this->pago->acuerdo_id,
                        'responsable_id'=>$this->pago->responsable_id,
                        'estado'=> 2,
                        'concepto_cuota'=> 'Devolución',
                        'monto_acordado'=> $montoAbonadoAFavor,
                        'nro_cuota'=> 1,
                        'vencimiento_cuota'=> today(),
                        'usuario_ultima_modificacion_id'=> auth()->id
                    ]);
                    $this->emit('pagoInformado');
                    session()->flash('pagoInformado', true);
                    return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
                }
            }
        }
        //El usuario es un agente solo puede informar un pago (no se modifica la cuota)
        else {
            $gestionCuota = new GestionCuota([
                'pago_id'=>$this->pago->id,
                'fecha_de_pago'=>$this->fecha_de_pago,
                'monto_abonado'=>$this->monto_abonado,
                'medio_de_pago'=>$this->medio_de_pago,
                'sucursal'=>$this->sucursal,
                'hora'=>$this->hora,
                'cuenta'=>$this->cuenta,
                'nombre_tercero'=>$this->nombre_tercero,
                'central_de_pago'=>$this->central_de_pago,
                'comprobante'=>$nombreComprobante,
                'usuario_informador_id'=>auth()->id(),
                'fecha_informe'=> now()->format('Y-m-d'),
                'situacion' => 1,//Pago Informado
                'usuario_ultima_modificacion_id'=>auth()->id(),
            ]);
            $gestionCuota->save();
            $this->emit('pagoInformado');
            session()->flash('pagoInformado', true);
            return redirect()->route('gestion.cuota', ['pago' => $this->pago->id]);
        }
    }

    public function render()
    {
        $sumaDePagos = GestionCuota::where('pago_id', $this->pago->id)
                                    ->whereNotIn('situacion', [1,5])
                                    ->sum('monto_abonado');                                    
        if($sumaDePagos >= $this->pago->monto_acordado) {
            $aplicacionDePago = false;
        } else {
            $aplicacionDePago = true;
        }
        return view('livewire.pagos.gestion-cuota-paso-uno',[
            'aplicacionDePago'=>$aplicacionDePago
        ]);
    }
}
