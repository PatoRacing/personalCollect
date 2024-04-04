<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class EliminarPropuesta extends Component
{
    public $operacion;
    public $propuesta;
    public $propuestaId;
    public $confirmarEliminacionPropuesta;

    public function eliminarPropuesta($propuestaId)
    {
        $this->propuestaId = $propuestaId;
        $this->confirmarEliminacionPropuesta = true;
    }

    public function confirmarEliminacionPropuesta()
    {
        Propuesta::find($this->propuestaId)->delete();
        $this->confirmarEliminacionPropuesta = false;
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Propuesta eliminada correctamente');
    }

    public function cancelarEliminacionPropuesta()
    {
        $this->confirmarEliminacionPropuesta = false;
    }

    public function render()
    {
        return view('livewire.eliminar-propuesta',[
            'propuestaId'=>$this->propuestaId
        ]);
    }
}
