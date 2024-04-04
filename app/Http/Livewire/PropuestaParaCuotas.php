<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PropuestaParaCuotas extends Component
{
    //Variables de livewire principal
    public $operacion;
    public $limiteCuotas;
    //Variables a guardar
    public $monto_ofrecido;
    public $anticipo;
    public $fecha_pago_anticipo;
    public $cantidad_de_cuotas_uno;
    public $monto_de_cuotas_uno;
    public $fecha_pago_cuota;
    public $total_acp;
    public $honorarios;
    public $vencimiento;
    public $accion;
    public $observaciones;
    //Varaible Auxiliar
    public $minimoAPagar;
    //Ventanas emergentes
    public $formulario = true;
    public $montoYCuotasNoPermitidas;
    public $montoNoPermitido;
    public $cuotasNoPermitidas;
    public $negociacionPermitida;
    public $negociacion;
    public $propuesta;

    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
        'anticipo'=> 'required|numeric|lt:monto_ofrecido',
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
        //Obtengo el monto de la cuota descontando el anticipo
        $this->monto_de_cuotas_uno = $montoSinAnticipo / $this->cantidad_de_cuotas_uno;

        if($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotas < $this->cantidad_de_cuotas_uno) {
            $this->formulario = false;
            $this->montoYCuotasNoPermitidas = true;
        } elseif($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotas >= $this->cantidad_de_cuotas_uno){
            $this->formulario = false;
            $this->montoNoPermitido = true;
        } elseif($this->limiteCuotas < $this->cantidad_de_cuotas_uno && $this->monto_ofrecido > $this->minimoAPagar) {
            $this->formulario = false;
            $this->cuotasNoPermitidas = true;
        } elseif($this->limiteCuotas >= $this->cantidad_de_cuotas_uno && $this->monto_ofrecido > $this->minimoAPagar) {
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
        $this->montoYCuotasNoPermitidas = false;
        $this->montoNoPermitido = false;
        $this->cuotasNoPermitidas = false;
        $this->negociacionPermitida = false;
        $this->propuesta = false;
        $this->negociacion = false;
    }

    public function negociacion()
    {
        $this->negociacion = true;
        $this->propuesta = false;
    }

    public function guardarNegociacion()
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
        $propuesta->tipo_de_propuesta = 2;
        if($this->anticipo == 0) {
            $propuesta->anticipo='';
        } else {
            $propuesta->anticipo = $this->anticipo;
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
        if ($this->anticipo > 0) {
            $reglasSegundoFormulario['fecha_pago_anticipo'] = 'required|date';
        }    
        
        $this->validate($reglasSegundoFormulario);

        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_ofrecido;
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
        $propuesta->usuario_ultima_modificacion_id = auth()->id();      
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Propuesta generada correctamente');
    }

    public function render()
    {
        return view('livewire.propuesta-para-cuotas', [
            'minimoAPagar' => $this->minimoAPagar,
            'limiteCuotas' => $this->limiteCuotas,
            'monto_ofrecido' => $this->monto_ofrecido,
            'cantidad_de_cuotas_uno' => $this->cantidad_de_cuotas_uno,
            'monto_de_cuotas_uno' => $this->monto_de_cuotas_uno,
        ]);
    }
}


