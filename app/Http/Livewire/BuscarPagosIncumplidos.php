<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscarPagosIncumplidos extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function terminosBusquedaPagosIncumplidos()
    {
        $this->emit('busquedaPagosIncumplidos', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-pagos-incumplidos');
    }
}
