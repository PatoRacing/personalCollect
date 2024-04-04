<?php

namespace App\Http\Livewire;

use App\Models\Operacion;
use App\Models\Propuesta;
use Livewire\Component;

class PropuestaParaCancelacion extends Component
{
    //Variables de livewire principal
    public $operacion;
    public $limiteQuita;
    //Variables a guardar
    public $monto_ofrecido;
    public $porcentaje_quita;
    public $fecha_pago_cuota;
    public $total_acp;
    public $honorarios;
    public $vencimiento;
    public $accion;
    public $estado;
    public $observaciones;
    //Varaible Auxiliar
    public $minimoAPagar;
    //Ventanas emergentes 
    public $formulario = true;
    public $negociacionPermitida;    
    public $negociacionNoPermitida;    
    public $negociacion;
    public $propuesta;     
        

    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
    ];
    
    public function calcularQuita()
    {
        $datos = $this->validate();
        //Obtengo la deuda capital
        $deudaCapital = $this->operacion->deuda_capital;
        //Minimo a rendir al banco
        $minimoARendir = $deudaCapital - ($deudaCapital * ($this->limiteQuita / 100));
        //Minimo a pagar: Al minimo a rendir le agrego los honorarios
        $this->minimoAPagar = $minimoARendir * (1 + ($this->operacion->productoId->honorarios / 100));

        //Validacion de pago inferior al permitido
        if($this->monto_ofrecido < $this->minimoAPagar) {
            $this->formulario = false;
            $this->negociacionNoPermitida = true;
        //Negociacion Permitida
        } else {
            $this->formulario = false;
            $this->negociacionPermitida = true;
            //Calculo al ACP de acuerdo al monto a pagar
            $this->total_acp = $this->monto_ofrecido / (1 + ($this->operacion->productoId->honorarios / 100));
            //Calculo los honorarios de acuerdo al monto a pagar
            $this->honorarios = $this->monto_ofrecido - $this->total_acp;
            //Calculo el porcentaje de la quita
            $this->porcentaje_quita = (($deudaCapital - $this->total_acp) * 100) / $deudaCapital;
        }
    }

    public function cancelarPropuesta()
    {
        $this->monto_ofrecido = null;
        $this->negociacionNoPermitida = false;
        $this->negociacionPermitida = false;
        $this->negociacion = false;
        $this->propuesta = false;
        $this->formulario = true;
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
        $propuesta->tipo_de_propuesta = 1;
        if($this->porcentaje_quita > 0) {
            $propuesta->porcentaje_quita = $this->porcentaje_quita;
        } else {
            $propuesta->porcentaje_quita = '';
        }
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
        $propuesta->tipo_de_propuesta = 1;
        if($this->porcentaje_quita > 0) {
            $propuesta->porcentaje_quita = $this->porcentaje_quita;
        } else {
            $propuesta->porcentaje_quita = '';
        }
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
        return view('livewire.propuesta-para-cancelacion',[
            'operacion'=>$this->operacion,
            'monto_ofrecido'=>$this->monto_ofrecido,
            'minimoAPagar'=>$this->minimoAPagar,
            'porcentaje_quita'=>$this->porcentaje_quita
        ]);
    }
}
