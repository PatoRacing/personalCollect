<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DetalleOperacion extends Component
{
    public $operacion;
    
    public function render()
    {
        return view('livewire.operaciones.detalle-operacion');
    }
}
