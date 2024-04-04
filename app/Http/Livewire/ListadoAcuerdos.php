<?php

namespace App\Http\Livewire;

use App\Models\Acuerdo;
use Livewire\Component;

class ListadoAcuerdos extends Component
{
    public function render()
    {
        $acuerdosVigentes = Acuerdo::where('estado', 1)->get();

        return view('livewire.listado-acuerdos', [
            'acuerdosVigentes'=>$acuerdosVigentes
        ]);
    }
}
