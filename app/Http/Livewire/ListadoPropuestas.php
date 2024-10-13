<?php

namespace App\Http\Livewire;

use App\Exports\PropuestasExport;
use App\Models\Propuesta;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ListadoPropuestas extends Component
{
    public $propuestasSinEnviar = true;
    public $propuestasEnviadas = false;

    public function mostrarPropuestasSinEnviar()
    {
        $this->propuestasSinEnviar = true;
        $this->propuestasEnviadas = false;
    }

    public function mostrarPropuestasEnviadas()
    {
        $this->propuestasEnviadas = true;
        $this->propuestasSinEnviar = false;
    }
    public function render()
    {
        return view('livewire.propuestas.listado-propuestas');
    }
}
