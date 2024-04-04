<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscadorOperaciones extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;
    public $situacion;

    public function leerTerminoBusqueda()
    {
        $this->emit('terminosDeBusqueda', $this->nro_doc, $this->nro_operacion, $this->deudor, $this->situacion);
    }
    public function render()
    {
        return view('livewire.buscador-operaciones');
    }
}
