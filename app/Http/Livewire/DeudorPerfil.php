<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeudorPerfil extends Component
{
    public $deudor;
    
    public function render()
    {
        return view('livewire.operaciones.deudor-perfil');
    }
}
