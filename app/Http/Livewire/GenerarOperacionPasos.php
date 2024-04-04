<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GenerarOperacionPasos extends Component
{
    public $pasoUno;
    public $pasoDos;

    public function pasoDos()
    {
        if($this->pasoUno === true) {
            $this->pasoUno === false;
            $this->pasoDos === true;
        }
    }

    public function render()
    {
        return view('livewire.generar-operacion-pasos');
    }
}
