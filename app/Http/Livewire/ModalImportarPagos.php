<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModalImportarPagos extends Component
{
    public $modalImportarPagos = true;

    public function quitarModalImportarPagos()
    {
        $this->modalImportarPagos = false;
    }

    public function render()
    {
        return view('livewire.modal-importar-pagos');
    }
}
