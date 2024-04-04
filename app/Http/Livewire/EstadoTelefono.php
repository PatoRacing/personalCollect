<?php

namespace App\Http\Livewire;

use App\Models\Telefono;
use Livewire\Component;

class EstadoTelefono extends Component
{
    public $telefono;


    public function actualizarEstado(Telefono $telefono)
    {
        if($telefono->estado === 1)
        {
            $telefono->estado = 2;
            $telefono->usuario_ultima_modificacion_id =  auth()->id();
            $telefono->updated_at = now();

        } else {
            $telefono->estado = 1;
            $telefono->usuario_ultima_modificacion_id =  auth()->id();
            $telefono->updated_at = now();
        }
        
        $telefono->save();
        $this->emit('estadoTelefonoActualizado');
    }

    public function render()
    {
        return view('livewire.estado-telefono');
    }
}
