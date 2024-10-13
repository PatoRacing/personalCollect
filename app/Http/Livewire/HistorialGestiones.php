<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class HistorialGestiones extends Component
{
    public $operacion;
    public $modalEliminar;
    public $propuestaSeleccionada;
    public $alertaMensaje;
    public $alertaTipo;

    //Función mostrar modal eliminar telefono
    public function mostrarModalEliminar($propuestaId)
    {
        $this->propuestaSeleccionada=Propuesta::find($propuestaId);
        $this->modalEliminar = true;
    }

    //Función eliminar usuario
    public function confirmarEliminarPropuesta()
    {
        $this->propuestaSeleccionada->delete();
        $this->modalEliminar = false;
        return redirect()->route('nueva.gestion', ['operacion' => $this->operacion->id])->with('message', 'Propuesta eliminada correctamente');
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }
    
    public function render()
    {
        $propuestas = Propuesta::where('operacion_id', $this->operacion->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('livewire.operaciones.historial-gestiones',[
            'propuestas'=>$propuestas
        ]);
    }
}
