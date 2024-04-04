<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use App\Models\User;
use Livewire\Component;

class PropuestaParaCancelacionSinPolitica extends Component
{
    //Variables de livewire principal
    public $operacion;
    //Variables a guardar
    public $monto_ofrecido;
    public $porcentaje_quita;
    public $fecha_pago_cuota;
    public $total_acp;
    public $honorarios;
    public $accion;
    public $estado;
    public $observaciones;    
    public $usuario_ultima_modificacion_id; 
    //Ventanas emergentes 
    public $formulario = true;
    public $negociacionPermitida;
    public $propuesta;
    
    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
    ];
    
    public function calcularQuita()
    {
        $datos = $this->validate();
        $this->formulario = false;
        //Obtengo la deuda capital
        $deudaCapital = $this->operacion->deuda_capital;
        //Calculo al ACP de acuerdo al monto a pagar
        $this->total_acp = $this->monto_ofrecido / (1 + ($this->operacion->productoId->honorarios / 100));
        //Calculo los honorarios de acuerdo al monto a pagar
        $this->honorarios = $this->monto_ofrecido - $this->total_acp;
        //Calculo el porcentaje de la quita
        $this->porcentaje_quita = (($deudaCapital - $this->total_acp) * 100) / $deudaCapital;
        $this->negociacionPermitida = true;
    }

    public function cancelarPropuesta()
    {
        $this->monto_ofrecido = null;
        $this->negociacionPermitida = false;
        $this->propuesta = false;
        $this->formulario = true;
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
        $propuesta->usuario_ultima_modificacion_id = $this->usuario_ultima_modificacion_id;
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Propuesta generada correctamente');
    }

    public function render()
    {
        $usuarios = User::all();

        return view('livewire.propuesta-para-cancelacion-sin-politica',[
            'monto_ofrecido'=>$this->monto_ofrecido,
            'porcentaje_quita'=>$this->porcentaje_quita,
            'usuarios'=>$usuarios
        ]);
    }
}
