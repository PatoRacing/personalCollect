<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use Livewire\Component;

class DeudorNombre extends Component
{
    public $deudor;

    public function deudorNombre(Deudor $deudor)
    {
        $this->emit('modalDeudor', $deudor);
    }

    public function render()
    {
        return view('livewire.deudor-nombre');
    }
}
