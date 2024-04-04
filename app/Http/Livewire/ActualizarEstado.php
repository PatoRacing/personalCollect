<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ActualizarEstado extends Component
{
    public $usuario;

    public function actualizarEstado(User $usuario)
    {
        if($usuario->estado == 1)
        {
            $usuario->estado = 2;
        } else {
            $usuario->estado = 1;
        }
        $usuario->usuario_ultima_modificacion_id = auth()->id();
        $usuario->save();
        $this->emit('actualizacionCompleta');
    }

    //$this->emit('refreshComponent');
    public function render()
    {
        return view('livewire.actualizar-estado');
    }
}
