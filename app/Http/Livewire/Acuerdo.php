<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Acuerdo extends Component
{
    public $modalImportacion = true;

    public function quitarModal()
    {
        $this->modalImportacion = false;
    }

    public function render()
    {
        return view('livewire.acuerdos.acuerdo');
    }
}
