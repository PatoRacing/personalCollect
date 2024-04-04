<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class PropuestaParaCancelacionConDescuento extends Component
{
    //Variables de livewire principal
    public $operacion;
    public $limiteQuitaConDescuento;
    public $limiteCuotasQuitaConDescuento;
    //Varaible Auxiliar
    public $minimoAPagar;
    //Variables a guardar
    public $monto_ofrecido;
    public $cantidad_de_cuotas_uno;
    public $total_acp;
    public $honorarios;
    public $porcentaje_quita;
    public $monto_de_cuotas_uno;
    public $vencimiento;
    public $accion;
    public $observaciones;
    public $fecha_pago_cuota;
    //Ventanas emergentes
    public $formulario = true;
    public $montoMinimoNoPermitidoYCuotasNoPermitidas;
    public $montoMinimoPermitidoYCuotasNoPermitidas;
    public $montoMinimoNoPermitidoYCuotasPermitidas;
    public $montoMinimoPermitidoYCuotasPermitidas;
    public $negociacion;
    public $propuesta;

    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
        'cantidad_de_cuotas_uno'=> 'required|numeric'
    ];

    public function calcularCuotasConDescuento()
    {
        $datos = $this->validate();
        //Obtengo la deuda capital
        $deudaCapital = $this->operacion->deuda_capital;
        //Minimo a rendir al banco
        $minimoARendir = $deudaCapital - ($deudaCapital * ($this->limiteQuitaConDescuento / 100));
        //Minimo a pagar: Al minimo a rendir le agrego los honorarios
        $this->minimoAPagar = $minimoARendir * (1 + ($this->operacion->productoId->honorarios / 100));
        if($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotasQuitaConDescuento < $this->cantidad_de_cuotas_uno)
        { 
            //Monto minimo no permitido y cantidad de cuotas no permitada
            $this->formulario = false;
            $this->montoMinimoNoPermitidoYCuotasNoPermitidas = true;
        }
        elseif($this->monto_ofrecido > $this->minimoAPagar && $this->limiteCuotasQuitaConDescuento < $this->cantidad_de_cuotas_uno)
        {
            //Monto minimo permitido y cantidad de cuotas no permitada
            $this->formulario = false;
            $this->montoMinimoPermitidoYCuotasNoPermitidas = true;
        }
        elseif ($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotasQuitaConDescuento >= $this->cantidad_de_cuotas_uno)
        { 
            //Monto minimo no permitido y cantidad de cuotas permitada
            $this->formulario = false;
            $this->montoMinimoNoPermitidoYCuotasPermitidas = true;
        } 
        elseif ($this->monto_ofrecido > $this->minimoAPagar && $this->limiteCuotasQuitaConDescuento >= $this->cantidad_de_cuotas_uno)
        {
            //Monto minimo  permitido y cantidad de cuotas permitada
            $this->formulario = false;
            $this->montoMinimoPermitidoYCuotasPermitidas = true;
            //Calculo al ACP de acuerdo al monto a pagar
            $this->total_acp = $this->monto_ofrecido / (1 + ($this->operacion->productoId->honorarios / 100));
            //Calculo los honorarios de acuerdo al monto a pagar
            $this->honorarios = $this->monto_ofrecido - $this->total_acp;
            //Calculo el porcentaje de la quita
            $this->porcentaje_quita = (($deudaCapital - $this->total_acp) * 100) / $deudaCapital;
            //Obtengo el monto de la cuota descontando el anticipo
            $this->monto_de_cuotas_uno = $this->monto_ofrecido / $this->cantidad_de_cuotas_uno;
        }
    }

    public function cancelarPropuesta()
    {
        $this->monto_ofrecido = null;
        $this->cantidad_de_cuotas_uno = null;
        $this->montoMinimoNoPermitidoYCuotasNoPermitidas = false;
        $this->montoMinimoNoPermitidoYCuotasPermitidas = false;
        $this->montoMinimoPermitidoYCuotasNoPermitidas = false;
        $this->montoMinimoPermitidoYCuotasPermitidas = false;
        $this->negociacion = false;
        $this->propuesta = false;
        $this->formulario = true;
    }

    public function negociacion()
    {
        $this->negociacion = true;
        $this->propuesta = false;
    }

    public function guardarNegociacion ()
    {
        $reglasSegundoFormulario = [
            'accion' => 'required',
            'vencimiento' => 'required|date',
            'observaciones' => 'required|max:255'
        ];
        $this->validate($reglasSegundoFormulario);
        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_ofrecido;
        $propuesta->tipo_de_propuesta = 3;
        if($this->porcentaje_quita > 0) {
            $propuesta->porcentaje_quita = $this->porcentaje_quita;
        } else {
            $propuesta->porcentaje_quita = '';
        }
        $propuesta->cantidad_de_cuotas_uno = $this->cantidad_de_cuotas_uno;
        $propuesta->monto_de_cuotas_uno = $this->monto_de_cuotas_uno;
        $propuesta->total_acp = $this->total_acp;
        $propuesta->honorarios = $this->honorarios;
        $propuesta->vencimiento = $this->vencimiento;
        $propuesta->accion = $this->accion;
        $propuesta->estado = 'Negociación';
        $propuesta->observaciones = $this->observaciones;
        $propuesta->usuario_ultima_modificacion_id = auth()->id();  
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Gestión generada correctamente');
    }

    public function propuesta()
    {
        $this->propuesta = true;
        $this->negociacion = false;
    }

    public function guardarPropuesta()
    {
        $reglasSegundoFormulario = [
            'accion' => 'required',
            'fecha_pago_cuota' => 'required|date',
            'observaciones' => 'required|max:255'
        ];
        $this->validate($reglasSegundoFormulario);
        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_ofrecido;
        $propuesta->tipo_de_propuesta = 3;
        if($this->porcentaje_quita > 0) {
            $propuesta->porcentaje_quita = $this->porcentaje_quita;
        } else {
            $propuesta->porcentaje_quita = '';
        }
        $propuesta->cantidad_de_cuotas_uno = $this->cantidad_de_cuotas_uno;
        $propuesta->monto_de_cuotas_uno = $this->monto_de_cuotas_uno;
        $propuesta->fecha_pago_cuota = $this->fecha_pago_cuota;
        $propuesta->total_acp = $this->total_acp;
        $propuesta->honorarios = $this->honorarios;
        $propuesta->accion = $this->accion;
        $propuesta->estado = 'Propuesta de Pago';
        $propuesta->observaciones = $this->observaciones;
        $propuesta->usuario_ultima_modificacion_id = auth()->id();  
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Gestión generada correctamente');  
    }

    public function render()
    {
        return view('livewire.propuesta-para-cancelacion-con-descuento',[
            'minimoAPagar'=>$this->minimoAPagar,
            'limiteCuotasQuitaConDescuento'=>$this->limiteCuotasQuitaConDescuento,
            'total_acp'=>$this->total_acp,
            'porcentaje_quita'=>$this->porcentaje_quita,
            'cantidad_de_cuotas_uno'=>$this->cantidad_de_cuotas_uno,
            'monto_de_cuotas_uno'=>$this->monto_de_cuotas_uno,
        ]);
    }
}
