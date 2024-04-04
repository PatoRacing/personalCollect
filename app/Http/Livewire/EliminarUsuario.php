<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;


class EliminarUsuario extends Component
{
    public $usuario;    
    public $usuarioId;    
    public $confirmarEliminacionUsuario;    

    public function eliminarUsuario($usuarioId)
    {
        $this->usuarioId = $usuarioId;
        $this->confirmarEliminacionUsuario = true;
    }

    public function confirmarEliminacionUsuario()
    {
        User::find($this->usuarioId)->delete();
        $this->confirmarEliminacionUsuario = false;
        return redirect('usuario')->with('message', 'Usuario eliminado correctamente');
    }

    public function cancelarEliminacionUsuario()
    {
        $this->confirmarEliminacionUsuario = false;
    }

    public function render()
    {
        return view('livewire.eliminar-usuario');
    }
}
