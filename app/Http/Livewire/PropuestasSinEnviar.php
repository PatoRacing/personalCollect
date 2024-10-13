<?php

namespace App\Http\Livewire;

use App\Exports\PropuestasExport;
use App\Models\Propuesta;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PropuestasSinEnviar extends Component
{
    public $modalConfirmarExportacion;

    public function confirmarExportar()
    {
        $this->modalConfirmarExportacion = true;
    }

    public function confirmarExportarPropuestas()
    {
        $this->modalConfirmarExportacion = false;
        $fechaHoraDescarga = now()->format('Ymd_His');
        $nombreArchivo  = 'propuestas_' . $fechaHoraDescarga . '.xlsx';
        return Excel::download(new PropuestasExport, $nombreArchivo);
    }

    public function cancelarExportarPropuestas()
    {
        $this->modalConfirmarExportacion = false;
    }

    public function render()
    {
        $propuestasNoEnviadas = Propuesta::where('estado', 'Propuesta de Pago')
                                        ->orderBy('created_at', 'desc')                                    
                                        ->get();
        $totalPropuestasNoEnviadas = $propuestasNoEnviadas->count();

        return view('livewire.propuestas.propuestas-sin-enviar',[
            'propuestasNoEnviadas'=>$propuestasNoEnviadas,
            'totalPropuestasNoEnviadas'=>$totalPropuestasNoEnviadas,
        ]);
    }
}
