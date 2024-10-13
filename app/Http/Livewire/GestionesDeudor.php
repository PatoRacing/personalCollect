<?php

namespace App\Http\Livewire;

use App\Models\GestionesDeudores;
use Livewire\Component;
use Livewire\WithPagination;

class GestionesDeudor extends Component
{
    use WithPagination;

    public $deudor;
    public $accion;
    public $resultado;
    public $observaciones;
    public $alertaMensaje;
    public $alertaTipo;
    public $gestionSeleccionada;
    public $modalEliminar;

    //Reglas de validacion de formulario Gestion Deudor
    protected $rules = [
        'accion'=> 'required',
        'resultado'=> 'required',
        'observaciones'=> 'required|max:255',
    ];

    //Guiardar nueva gestion deudor
    public function deudorGestion()
    {
        $datos = $this->validate();
        $deudorId = $this->deudor['id'];
        $gestion = GestionesDeudores::create([
            'deudor_id'=> $deudorId,
            'accion'=>$datos['accion'],
            'resultado'=>$datos['resultado'],
            'observaciones'=>$datos['observaciones'],
            'usuario_ultima_modificacion_id'=>auth()->id(),
            ]);
        $this->alertaMensaje = 'Gestión generada correctamente';
        $this->alertaTipo = 'green';
        $this->reset(['accion', 'resultado', 'observaciones']);
        $this->emit('nuevaGestion');
    }

    //Función mostrar modal eliminar gestion
    public function mostrarModalEliminar($gestionId)
    {
        $this->gestionSeleccionada=GestionesDeudores::find($gestionId);
        $this->modalEliminar = true;
    }

    //Función eliminar gestion
    public function confirmarEliminarUsuario()
    {
        $this->gestionSeleccionada->delete();
        $this->modalEliminar = false;
        $this->alertaMensaje = 'Gestión eliminada correctamente';
        $this->alertaTipo = 'red';
        $this->emit('nuevaGestion');
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }
    
    public function render()
    {
        $deudorId = $this->deudor['id'];
        $gestionesDeudor = GestionesDeudores::where('deudor_id', $deudorId)
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('livewire.operaciones.gestiones-deudor',[
            'gestionesDeudor'=>$gestionesDeudor
        ]);
    }
}
