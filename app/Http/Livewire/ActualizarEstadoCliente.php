<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\User;
use Livewire\Component;

class ActualizarEstadoCliente extends Component
{
    public $cliente;

    public function actualizarEstado(Cliente $cliente)
    {
        if($cliente->estado == 1)
        {
            $cliente->estado = 2;
        } else {
            $cliente->estado = 1;
            
        }
        $cliente->usuario_ultima_modificacion_id = auth()->id();
        $cliente->fecha_ultima_modificacion = now();
        $cliente->save();
        $this->emit('actualizacionCompleta');
    }

    public function render()
    {
        return view('livewire.actualizar-estado-cliente');
    }
}
