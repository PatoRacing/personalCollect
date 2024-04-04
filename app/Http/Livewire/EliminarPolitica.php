<?php

namespace App\Http\Livewire;

use App\Models\Politica;
use Livewire\Component;

class EliminarPolitica extends Component
{
    public $politica;
    protected $listeners = ['eliminarPolitica'];


    public function eliminarPolitica(Politica $politica)
    {
        $politica->delete();
    }
    public function render()
    {
        return view('livewire.eliminar-politica');
    }
}
