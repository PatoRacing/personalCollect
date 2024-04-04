<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscarPagosRendidos extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function terminosBusquedaPagosRendidos()
    {
        $this->emit('busquedaPagosRendidos', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-pagos-rendidos');
    }
}
