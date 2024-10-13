<?php

namespace App\Http\Livewire;

use App\Exports\PagosExport;
use App\Models\Deudor;
use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PagosExcedentes extends Component
{
    use WithPagination;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;
    protected $listeners = ['busquedaPagosVigentes'=>'buscarPagoVigente', 'recargarPagina'=>'resetearPagina'];

    public function buscarPagoVigente($deudor, $nro_doc, $responsable, $nro_operacion, $mes, $estado)
    {
        $this->deudor = $deudor;
        $this->nro_doc = $nro_doc;
        $this->responsable = $responsable;
        $this->nro_operacion = $nro_operacion;
        $this->mes = $mes;
        $this->estado = $estado;
    }

    public function resetearPagina()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Pago::query();
        // Busqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                ->pluck('id')
                ->first();
            if ($deudorId) {
                $query->whereHas('acuerdo.propuesta', function($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $query->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        //busqueda por responsable
        if ($this->responsable) {
            $query->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $query->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Busqueda por mes
        if ($this->mes) {
            $query->whereMonth('vencimiento_cuota', $this->mes);
        }
        if ($this->estado) {
            $hoy = Carbon::today();
            if ($this->estado == 'activo') {
                $query->where('vencimiento_cuota', '>=', $hoy);
            } else if ($this->estado == 'vencido') {
                $query->where('vencimiento_cuota', '<', $hoy);
            }
        }
        $query->where('estado', 6)
            ->orderBy('created_at', 'desc');

        $pagosExcedentes = $query->paginate(30);
        $pagosExcedentesTotales = $pagosExcedentes->total();

        return view('livewire.pagos.pagos-excedentes',[
            'pagosExcedentes'=>$pagosExcedentes,
            'pagosExcedentesTotales'=>$pagosExcedentesTotales,
        ]);
    }
}
