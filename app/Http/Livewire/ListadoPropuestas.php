<?php

namespace App\Http\Livewire;

use App\Exports\PropuestasExport;
use App\Models\Propuesta;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ListadoPropuestas extends Component
{
    public $confirmarExportacion;
    public $totalPropuestasNoEnviadas;
    public $totalPropuestasEnviadas;
    public $noEnviadas = true;
    public $enviadas;

    public function noEnviadas()
    {
        $this->noEnviadas = true;
        $this->enviadas = false;
    }

    public function enviadas()
    {
        $this->noEnviadas = false;
        $this->enviadas = true;
    }

    public function confirmarExportar()
    {
        $this->confirmarExportacion = true;
    }

    public function confirmarExportarPropuestas()
    {
        $this->confirmarExportacion = false;
        $this->noEnviadas = false;
        $this->enviadas = true;
        $fechaHoraDescarga = now()->format('Ymd_His');
        $nombreArchivo  = 'propuestas_' . $fechaHoraDescarga . '.xlsx';
        return Excel::download(new PropuestasExport, $nombreArchivo);
    }

    public function cancelarExportarPropuestas()
    {
        $this->confirmarExportacion = false;
    }

    public function render()
    {
        $propuestasNoEnviadas = Propuesta::where('estado', 'Propuesta de Pago')->paginate(24);
        $this->totalPropuestasNoEnviadas = $propuestasNoEnviadas->total();
        $propuestasEnviadas = Propuesta::where('estado', 'Enviado')->paginate(24);
        $this->totalPropuestasEnviadas = $propuestasEnviadas->total();

        return view('livewire.listado-propuestas',[
            'propuestasNoEnviadas'=>$propuestasNoEnviadas,
            'propuestasEnviadas'=>$propuestasEnviadas,
        ]);
    }
}
