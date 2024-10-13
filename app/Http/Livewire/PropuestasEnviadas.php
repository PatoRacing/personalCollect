<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class PropuestasEnviadas extends Component
{
    public $modalCambiarEstado;
    public $propuestaSeleccionada;

    public function modalCambiarEstado($propuestaId)
    {
        $this->propuestaSeleccionada=Propuesta::find($propuestaId);
        $this->modalCambiarEstado = true;
    }

    public function confirmarCambiarEstado()
    {  
        $this->propuestaSeleccionada->estado = 'Propuesta de Pago';
        $this->propuestaSeleccionada->usuario_ultima_modificacion_id = auth()->id();
        $this->propuestaSeleccionada->save();
        $this->modalCambiarEstado = false;
        return redirect()->route('propuestas')->with('message', 'Propuesta actualizada correctamente');
    }

    public function cancelarCambiarEstado()
    {
        $this->modalCambiarEstado = false;
    }

    public function render()
    {
        $propuestasEnviadas = Propuesta::where('estado', 'Enviada')
                                        ->orderBy('created_at', 'desc')                                    
                                        ->get();

        return view('livewire.propuestas.propuestas-enviadas',[
            'propuestasEnviadas'=>$propuestasEnviadas
        ]);
    }
}
