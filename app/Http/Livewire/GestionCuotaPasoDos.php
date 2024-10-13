<?php

namespace App\Http\Livewire;

use App\Models\GestionCuota;
use Livewire\Component;

class GestionCuotaPasoDos extends Component
{
    public $pago;
    public $gestion_id;
    public $monto_a_rendir;
    public $proforma;
    public $fecha_rendicion;
    public $modalFinalizarPago = false;
    //Alertas
    public $alertaNoGestion = false;
    public $alertaPagoNoAplicado = false;
    public $alertaMontosNoIguales = false;
    public $alertaNuevaRendicion = false;
    public $alertaPagoRendido = false;
    public $alertaPagoFinalizado = false;

    protected $listeners = ['PagoInformado' => 'actualizarVista', 'AlertasDeGestiones'=>'borrarAlertas'];

    public function borrarAlertas()
    {
         $this->alertaNoGestion = false;
         $this->alertaPagoNoAplicado = false;
         $this->alertaMontosNoIguales = false;
         $this->alertaNuevaRendicion = false;
         $this->alertaPagoRendido = false;
         $this->alertaPagoFinalizado = false;
    }
    public function actualizarVista()
    {
        $this->render();
    }

    public function rendirPago()
    {
        $this->validate([
            'gestion_id'=> 'required|numeric',
            'monto_a_rendir'=> 'required',
            'proforma'=> 'required',
            'fecha_rendicion'=> 'required|date',
        ]);
        $gestionCuota = GestionCuota::where('id', $this->gestion_id)->first();
        //Si no hay gestion para el ID que se quiere rendir
        if(!$gestionCuota) {
            $this->alertaNoGestion = true;
            $this->alertaPagoNoAplicado = false;
            $this->alertaMontosNoIguales = false;
            $this->alertaNuevaRendicion = false;
            $this->alertaPagoRendido = false;
            $this->emit('BorrarAlertasDeGestiones');
        } else {
            //Si ademas no esta aplicada
            if($gestionCuota->situacion == 1) {
                $this->alertaNoGestion = false;
                $this->alertaPagoNoAplicado = true;
                $this->alertaMontosNoIguales = false;
                $this->alertaNuevaRendicion = false;
                $this->alertaPagoRendido = false;
                $this->emit('BorrarAlertasDeGestiones');
            //Si ademas esta rendida
            } elseif($gestionCuota->situacion == 3) {
                $this->alertaNoGestion = false;
                $this->alertaPagoNoAplicado = false;
                $this->alertaMontosNoIguales = false;
                $this->alertaNuevaRendicion = false;
                $this->alertaPagoRendido = true;
                $this->emit('BorrarAlertasDeGestiones');
            //Si ademas no coinciden el monto a rendir con el monto abonado
            } else {
                if($gestionCuota->monto_abonado != $this->monto_a_rendir) {
                    $this->alertaNoGestion = false;
                    $this->alertaPagoNoAplicado = false;
                    $this->alertaMontosNoIguales = true;
                    $this->alertaNuevaRendicion = false;
                    $this->alertaPagoRendido = false;
                    $this->emit('BorrarAlertasDeGestiones');
                //Si todo es correcto se rinde el pago
                } else {
                    $gestionCuota->situacion = 3;
                    $gestionCuota->monto_a_rendir = $this->monto_a_rendir;
                    $gestionCuota->proforma = $this->proforma;
                    $gestionCuota->fecha_rendicion = $this->fecha_rendicion;
                    $gestionCuota->usuario_rendidor_id = auth()->id();
                    $gestionCuota->fecha_rendicion = now()->format('Y-m-d');
                    $gestionCuota->usuario_ultima_modificacion_id = auth()->id();
                    $gestionCuota->save();
                    $this->actualizarVista();
                    $this->emit('pagoRendido', 'BorrarAlertasDeGestiones');
                    $this->alertaNoGestion = false;
                    $this->alertaPagoNoAplicado = false;
                    $this->alertaMontosNoIguales = false;
                    $this->alertaPagoRendido = false;
                    $this->alertaNuevaRendicion = true;
                    $this->gestion_id = null;
                    $this->monto_a_rendir = null;
                    $this->proforma = null;
                    $this->fecha_rendicion = null;
                }
            }
        }
    }

    public function mostrarModalFinalizarPago()
    {
        $this->modalFinalizarPago = true;
    }

    public function confirmarFinalizarPago()
    {
        $this->pago->estado = 3;
        $this->pago->usuario_ultima_modificacion_id = auth()->id();
        $this->pago->save();
        $this->modalFinalizarPago = false;
        $this->alertaNoGestion = false;
        $this->alertaPagoNoAplicado = false;
        $this->alertaMontosNoIguales = false;
        $this->alertaNuevaRendicion = false;
        $this->alertaPagoRendido = false;
        $this->alertaPagoFinalizado = true;
        $this->emit('PagoFinalizado');
    }

    public function cerrarModalFinalizarPago()
    {
        $this->modalFinalizarPago = false;
    }

    public function render()
    {
        //Consulta para habilitar modulo de aplicacion de pagos
        $pagosAplicados = GestionCuota::where('pago_id', $this->pago->id)
                                        ->where('situacion', [2, 3])
                                        ->get();

        //Consulta para obtener pagos aplicados sin rendir y su suma
        $pagosAplicadosSinRendir = GestionCuota::where('pago_id', $this->pago->id)
                                        ->where('situacion', 2)
                                        ->get();
        $pagosAplicadosSinRendirSuma = $pagosAplicadosSinRendir->sum('monto_abonado');

        //Consulta para % correspondiente a Cliente
        $pagosaplicadosCliente =
            $pagosAplicadosSinRendirSuma / (1 + ($this->pago->acuerdo->propuesta->operacionId->productoId->honorarios / 100));

        //Consulta para % correspondiente a Honorarios
        $pagosAplicadosHonorarios = $pagosAplicadosSinRendirSuma -$pagosaplicadosCliente;

        //Consulta para obtener todos los pagos rendidos y su suma
        $pagosRendidos = GestionCuota::where('pago_id', $this->pago->id)
                                        ->where('situacion', 3)
                                        ->get();
         $pagosRendidosSuma = $pagosRendidos->sum('monto_abonado');

         //Consulta para obtener Rendicion Cliente
         $rendicionCliente = 
            $pagosRendidosSuma / (1 + ($this->pago->acuerdo->propuesta->operacionId->productoId->honorarios / 100));

        //Consulta para obtener Rendicón honorarios
        $rendicionHonorarios = $pagosRendidosSuma - $rendicionCliente;

        //Consulta para obtener saldo a rendir
        $saldoRestanteARendir = $this->pago->monto_acordado - $pagosRendidosSuma;

        return view('livewire.pagos.gestion-cuota-paso-dos',[
            'pagosAplicados' => $pagosAplicados,
            'pagosAplicadosSinRendirSuma' => $pagosAplicadosSinRendirSuma,
            'pagosRendidosSuma' => $pagosRendidosSuma,
            'saldoRestanteARendir' => $saldoRestanteARendir,
            'rendicionCliente' => $rendicionCliente,
            'rendicionHonorarios' => $rendicionHonorarios,
            'pagosaplicadosCliente' => $pagosaplicadosCliente,
            'pagosAplicadosHonorarios' => $pagosAplicadosHonorarios,
        ]);
    }
}
