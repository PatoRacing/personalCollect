<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscarPagosVigentes extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function terminosBusquedaPagosVigentes()
    {
        $this->emit('busquedaPagosVigentes', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-pagos-vigentes');
    }
}
