<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class UsuarioModal extends Component
{

    public $usuario;
    public $index;
    
    public function render()
    {
        return view('livewire.usuario-modal');
    }
}
