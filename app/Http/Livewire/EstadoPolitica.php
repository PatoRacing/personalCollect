<?php

namespace App\Http\Livewire;

use App\Models\Politica;
use Livewire\Component;

class EstadoPolitica extends Component
{
    public $politica;

    public function estadoPolitica(Politica $politica)
    {
        if ($politica->estado == 1) {
            $politica->estado = 2;
        } else {
            $politica->estado = 1;
        }

        $politica->usuario_ultima_modificacion_id = auth()->id();
        $politica->save();
        $this->emit('politicaActualizado');
    }

    public function render()
    {
        return view('livewire.estado-politica');
    }
}
