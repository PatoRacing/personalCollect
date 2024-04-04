<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class OperacionIncobrable extends Component
{
    public $operacion;
    public $deudorId;
    public $accion;
    public $observaciones;
    public $operacion_id;

    protected $rules = [
        'accion' => 'required',
        'observaciones' => 'required|max:255'
    ];

    public function operacionIncobrable()
    {
        $datos = $this->validate();
        $deudorId = $this->deudorId;
        $operacionId = $this->operacion->id;

        $propuesta = Propuesta::create([
            'usuario_ultima_modificacion_id' => auth()->id(),
            'operacion_id' => $operacionId,
            'monto_negociado' => 0,
            'honorarios' => 0,
            'monto_total' => 0,
            'vencimiento' => now(),
            'accion' => $datos['accion'],
            'estado' => 'Incobrable', 
            'observaciones' => $datos['observaciones'],
            'deudor_id' => $deudorId,
            'tipo_de_propuesta' => 0,
        ]);

        return redirect()->route('historial.propuesta', ['operacion' => $this->operacion->id])->with('message', 'Gestión generada correctamente');
    }

    public function render()
    {
        return view('livewire.operacion-incobrable');
    }
}
