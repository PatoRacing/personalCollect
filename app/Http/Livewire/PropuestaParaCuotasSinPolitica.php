<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use App\Models\User;
use Livewire\Component;

class PropuestaParaCuotasSinPolitica extends Component
{
    //Variables de livewire principal
    public $operacion;
    //Variables a guardar
    public $monto_ofrecido;
    public $anticipo;
    public $fecha_pago_anticipo;
    public $cantidad_de_cuotas_uno;
    public $monto_de_cuotas_uno;
    public $monto_total;
    public $fecha_pago_cuota;
    public $total_acp;
    public $honorarios;
    public $accion;
    public $usuario_ultima_modificacion_id;
    public $observaciones;
    //Varaible Auxiliar
    public $minimoAPagar;
    //Ventanas emergentes
    public $formulario = true;
    public $montoNoPermitido;
    public $negociacionPermitida;
    public $propuesta;

    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
        'anticipo'=> 'required|numeric|lt:monto_ofrecido|regex:/^[0-9]{1,}(000)$/',
        'cantidad_de_cuotas_uno'=> 'required|numeric|integer',
    ];

    public function messages()
    {
        return [
            'anticipo.lt' => 'El :attribute no puede superar el monto ofrecido',
        ];
    }

    public function calcularCuotas()
    {
        $datos = $this->validate();
        //Obtengo la deuda capital
        $deudaCapital = $this->operacion->deuda_capital;
        //Calculo el minimo a pagar (capital + honorarios)
        $this->minimoAPagar = $deudaCapital + ($deudaCapital * ($this->operacion->productoId->honorarios / 100));
        //Obtengo el ACP = monto ofrecido - los honorarios
        $this->total_acp = $this->monto_ofrecido / (1 + ($this->operacion->productoId->honorarios / 100));
        //Calculo los honorarios
        $this->honorarios = $this->monto_ofrecido - $this->total_acp;
        //Le descuento el anticipo al monto ofrecido
        $montoSinAnticipo = $this->monto_ofrecido - $this->anticipo;
        //Obtengo el monto de la cuota descontando el anticipo y redondeo
        $montoDeCuota = $montoSinAnticipo / $this->cantidad_de_cuotas_uno;
        $this->monto_de_cuotas_uno = ceil($montoDeCuota / 1000) * 1000;
        //Monto total redondeado
        $this->monto_total = ($this->monto_de_cuotas_uno * $this->cantidad_de_cuotas_uno) + $this->anticipo;
        if($this->monto_ofrecido < $this->minimoAPagar ) {
            $this->formulario = false;
            $this->montoNoPermitido = true;
        } else {
            $this->formulario = false;
            $this->negociacionPermitida = true;
        }
    }

    public function cancelarPropuesta()
    {
        $this->monto_ofrecido = null;
        $this->anticipo = null;
        $this->cantidad_de_cuotas_uno = null;
        $this->formulario = true;
        $this->montoNoPermitido = false;
        $this->negociacionPermitida = false;
        $this->propuesta = false;
    }

    public function propuesta()
    {
        $this->propuesta = true;
    }

    public function guardarPropuesta()
    {
        $reglasSegundoFormulario = [
            'accion' => 'required',
            'fecha_pago_cuota' => 'required|date',
            'usuario_ultima_modificacion_id' => 'required',
            'observaciones' => 'required|max:255'
        ];
        if ($this->anticipo > 0) {
            $reglasSegundoFormulario['fecha_pago_anticipo'] = 'required|date';
        }    
        
        $this->validate($reglasSegundoFormulario);

        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_total;
        $propuesta->tipo_de_propuesta = 2;
        if($this->anticipo == 0 || $this->anticipo === '') {
            $propuesta->anticipo = null; 
        } else {
            $propuesta->anticipo = $this->anticipo; 
        }
        if($this->anticipo == 0 || $this->anticipo === '') {
            $propuesta->fecha_pago_anticipo = null; 
        } else {
            $propuesta->fecha_pago_anticipo = $this->fecha_pago_anticipo; 
        }
        $propuesta->cantidad_de_cuotas_uno = $this->cantidad_de_cuotas_uno;
        $propuesta->monto_de_cuotas_uno = $this->monto_de_cuotas_uno;
        $propuesta->fecha_pago_cuota = $this->fecha_pago_cuota;
        $propuesta->total_acp = $this->total_acp;
        $propuesta->honorarios = $this->honorarios;
        $propuesta->accion = $this->accion;
        $propuesta->estado = 'Propuesta de Pago';
        $propuesta->observaciones = $this->observaciones;
        $propuesta->usuario_ultima_modificacion_id = $this->usuario_ultima_modificacion_id;
        $propuesta->save();
        return redirect()->route('nueva.gestion', ['operacion' => $this->operacion->id])->with('message', 'Propuesta generada correctamente');
    }

    public function render()
    {
        $usuarios = User::all();

        return view('livewire.operaciones.propuesta-para-cuotas-sin-politica',[
            'usuarios'=>$usuarios
        ]);
    }
}
