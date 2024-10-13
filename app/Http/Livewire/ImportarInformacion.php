<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImportarInformacion extends Component
{
    public $importarInformacion =  true;

    public function quitarModal()
    {
        $this->importarInformacion = false;
    }

    public function render()
    {
        return view('livewire.clientes.importar-informacion');
    }
}
