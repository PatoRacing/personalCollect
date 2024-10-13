<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Usuarios extends Component
{
    use WithPagination;

    public $modalEstado = false;
    public $modalEliminar = false;
    public $usuarioSeleccionado;
    public $alertaMensaje;
    public $alertaTipo;

    //Función mostrar modal cambiar estado
    public function mostrarModalEstado($usuarioId)
    {
        $this->usuarioSeleccionado=User::find($usuarioId);
        $this->modalEstado = true;
    }

    //Función cambiar estado
    public function confirmarCambiarEstado()
    {
        if($this->usuarioSeleccionado->estado == 1)
        {
            $this->usuarioSeleccionado->estado = 2;
        } else {
            $this->usuarioSeleccionado->estado = 1;
        }
        $this->usuarioSeleccionado->usuario_ultima_modificacion_id = auth()->id();
        $this->usuarioSeleccionado->save();
        $this->modalEstado = false;
        $this->alertaMensaje = 'Usuario actualizado correctamente';
        $this->alertaTipo = 'green';
    }

    //Funcion cerrar modal estado
    public function cerrarModalEstado()
    {
        $this->modalEstado = false;
    }

    //Función mostrar modal eliminar usuario
    public function mostrarModalEliminar($usuarioId)
    {
        $this->usuarioSeleccionado=User::find($usuarioId);
        $this->modalEliminar = true;
    }

    //Función eliminar usuario
    public function confirmarEliminarUsuario()
    {
        $this->usuarioSeleccionado->delete();
        $this->modalEliminar = false;
        $this->alertaMensaje = 'Usuario eliminado correctamente';
        $this->alertaTipo = 'red';
    }

    //Funcion cerrar modal eliminar
    public function cerrarModalEliminar()
    {
        $this->modalEliminar = false;
    }

    public function render()
    {
        $usuarios = User::orderBy('created_at', 'desc')->paginate(20);
        return view('livewire.usuarios.usuarios',[
            'usuarios'=>$usuarios
        ]);
    }
}
