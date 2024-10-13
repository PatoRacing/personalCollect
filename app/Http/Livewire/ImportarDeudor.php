<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImportarDeudor extends Component
{
    public $importarDeudor =  true;

    public function quitarModal()
    {
        $this->importarDeudor = false;
    }

    public function render()
    {
        return view('livewire.clientes.importar-deudor');
    }
}
