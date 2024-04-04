<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BuscarPagosEnviados extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;

    public function terminosBusquedaPagosEnviados()
    {
        $this->emit('busquedaPagosEnviados', $this->nro_doc, $this->nro_operacion, $this->deudor);
    }

    public function render()
    {
        return view('livewire.buscar-pagos-enviados');
    }
}
