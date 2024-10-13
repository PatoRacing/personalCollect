<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModalImportacion extends Component
{
    public $cliente;
    public $modalImportacion = true;

    public function quitarModal()
    {
        $this->modalImportacion = false;
    }

    public function render()
    {
        return view('livewire.clientes.modal-importacion');
    }
}
