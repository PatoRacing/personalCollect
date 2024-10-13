<?php

namespace App\Http\Livewire\Gestiones\Cuota;

use Illuminate\Queue\Listener;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormularioGestionCuota extends Component
{
    use WithFileUploads;
    
    //Variables iniciales
    public $cuota;
    public $classesBtn;
    public $pasoUno = true;
    public $alertaDeMonto = false;
    public $calculoDeMonto;
    public $camposCondicionales;

    //Paso uno formulario
    //Campos comunes
    public $fecha_de_pago;
    public $monto_abonado;
    public $medio_de_pago;
    public $comprobante;
    
    //Paso dos formulario
    //Campos para Deposito
    public $medioDePagoDeposito;
    public $sucursal;
    public $hora;
    public $cuenta; //Valido tambien para transferencia

    //Campos para transferencia
    public $medioDePagoTransferencia;
    public $nombre_tercero;

    //Campos para efectivo
    public $medioDePagoEfectivo;
    public $central_de_pago;  
    
    protected $listeners = ['reiniciarFormulario'=>'volverPasoUno'];

    //Funcion del boton siguiente del formulario que valida los datos ingresados
    public function aplicarPasoDos()
    {
        $this->validate([
            'fecha_de_pago'=> 'required|date',
            'monto_abonado'=> 'required|numeric',
            'medio_de_pago'=> 'required',
        ]);
        //Si el monto abonado es diferente al monto acordado se dispara la alerta que identica la diferencia
        if($this->monto_abonado != $this->cuota->monto_acordado) {
            //Alerta de monto abonado inferior al acordado
            if($this->cuota->monto_acordado > $this->monto_abonado) {
                $this->calculoDeMonto =
                'El monto ingresado es inferior al monto acordado en $'
                . number_format($this->cuota->monto_acordado - $this->monto_abonado, 2, ',', '.');
            }
            ////Alerta de monto abonado superior al acordado
            elseif($this->cuota->monto_acordado < $this->monto_abonado) {
                $this->calculoDeMonto =
                'El monto ingresado supera al monto acordado en $'
                . number_format($this->monto_abonado - $this->cuota->monto_acordado, 2, ',', '.'); 
            }
            $this->alertaDeMonto = true;
        } 
        //Si el monto abonado coincide con el monto acordado
        else {
            $this->condiciones();
        }
    }

    //Funcion que cierra modal de advertencia de diferencia de monto
    public function cerrarAlertaDeMonto()
    {
        $this->alertaDeMonto = false;
    }

    //Funcion que evalua el medio de pago ingresado para mostrar campos correspondientes a dicho medio
    public function condiciones()
    {
        $this->alertaDeMonto = false;
        $this->pasoUno = false;
        if($this->medio_de_pago == 'Depósito'){
            $this->medioDePagoDeposito = true;
        } elseif($this->medio_de_pago == 'Transferencia') {
            $this->medioDePagoTransferencia = true;
        } elseif($this->medio_de_pago == 'Efectivo'){
            $this->medioDePagoEfectivo = true;
        }
    }

    //Si en el paso 2 se vuelve al paso 1 se reinician todos los campos del paso 2
    public function volverPasoUno()
    {
        $this->pasoUno = true;
        $this->fecha_de_pago = null;
        $this->monto_abonado = null;
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

    //Si se confirma el paso 2 se valida los campos requeridos segun el medio de pago elegido
    public function nuevaGestionIngresada()
    {
        //Si el medio de pago es deposito
        if($this->medio_de_pago == 'Depósito') {
            $this->validate([
                'sucursal'=> 'required',
                'hora'=> 'required',
                'cuenta'=> 'required'
            ]);
            //En el arreglo se almacenan solo los datos correspondientes al medio de pago elegido
            $this->camposCondicionales = [
                'sucursal' => $this->sucursal,
                'hora' => $this->hora,
                'cuenta'=> $this->cuenta
            ];
        } 
        //Si el medio de pago es trnasferencia
        elseif($this->medio_de_pago == 'Transferencia') {
            $this->validate([
                'nombre_tercero'=> 'required',
                'cuenta'=> 'required'
            ]);
            //En el arreglo se almacenan solo los datos correspondientes al medio de pago elegido
            $this->camposCondicionales = [
                'nombre_tercero' => $this->nombre_tercero,
                'cuenta'=> $this->cuenta
            ];
        } 
        //Si el medio de pago es efectivo
        elseif($this->medio_de_pago == 'Efectivo') {
            $this->validate([
                'central_de_pago'=> 'required'
            ]);
            //En el arreglo se almacenan solo los datos correspondientes al medio de pago elegido
            $this->camposCondicionales = [
                'central_de_pago' => $this->central_de_pago
            ];
        }
        $nombreComprobante = null;
        if($this->comprobante) {
            $comprobanteDePago = $this->comprobante->store('public/comprobantes');
            $nombreComprobante = str_replace('public/comprobantes/', '', $comprobanteDePago);
        }

        //Toda la informacion se guarda en el arreglo que unicamente tiene la informacion ingresada
        $informacionIngresada = [
            'fecha_de_pago' => $this->fecha_de_pago,
            'monto_abonado' => $this->monto_abonado,
            'medio_de_pago' => $this->medio_de_pago,
            'camposCondicionales' =>  $this->camposCondicionales,
            'comprobante'=>$nombreComprobante,
        ];
        //Si el usuario es administrador se emite el evento escuchado en el GlobalGestiones 
        $this->emit('nuevaGestionDeFormulario', $informacionIngresada, $this->cuota);
    }

    public function render()
    {
        return view('livewire.gestiones.cuota.formulario-gestion-cuota');
    }
}
