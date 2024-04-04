<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscarPagosAplicados extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function terminosBusquedaPagosAplicados()
    {
        $this->emit('busquedaPagosAplicados', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-pagos-aplicados');
    }
}
