<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;

class BuscarCartera extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function leerTerminoBusquedaCartera()
    {
        $this->emit('terminosDeBusquedaCartera', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-cartera');
    }
}
