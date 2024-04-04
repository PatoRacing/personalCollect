<?php

namespace App\Http\Livewire;

use App\Models\Operacion;
use App\Models\Propuesta;
use Livewire\Component;

class Cobrable extends Component
{
    public $operacion;
    public $resultadoMasReciente;
    public $ultimaPropuesta;
    public $nuevoEstadoPropuesta = false;

    public function mount($operacion)
    {
        $this->operacion = $operacion;
    }

    public function cobrable(Operacion $operacion)
    {
        $this->emit('confirmarIncobrable', $operacion);
    }

    public function render()
    {
        return view('livewire.cobrable',);
    }
}
