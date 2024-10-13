<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AsignarOperaciones extends Component
{
    public $modalAsignar =  true;

    public function quitarModal()
    {
        $this->modalAsignar = false;
    }

    public function render()
    {
        return view('livewire.operaciones.asignar-operaciones');
    }
}
