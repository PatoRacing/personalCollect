<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Pago;
use Livewire\Component;
use Livewire\WithPagination;

class PagosFinalizados extends Component
{
    use WithPagination;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;

    protected $listeners = ['busquedaPagosVigentes' => 'buscarPagoVigente'];

    public function buscarPagoVigente($deudor, $nro_doc, $responsable, $nro_operacion, $mes)
    {
        $this->deudor = $deudor;
        $this->nro_doc = $nro_doc;
        $this->responsable = $responsable;
        $this->nro_operacion = $nro_operacion;
        $this->mes = $mes;
    }

    public function render()
    {
        $query = Pago::query();
        // Búsqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                ->pluck('id')
                ->first();
            if ($deudorId) {
                $query->whereHas('acuerdo.propuesta', function ($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Búsqueda por nro_doc
        if ($this->nro_doc) {
            $query->whereHas('acuerdo.propuesta.operacionId', function ($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        // Búsqueda por responsable
        if ($this->responsable) {
            $query->whereHas('acuerdo.propuesta.operacionId', function ($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Búsqueda por nro operacion
        if ($this->nro_operacion) {
            $query->whereHas('acuerdo.propuesta.operacionId', function ($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Búsqueda por mes
        if ($this->mes) {
            $query->whereMonth('vencimiento_cuota', $this->mes);
        }
        $query->where('estado', 3)
            ->orderBy('created_at', 'desc');

        $pagosFinalizados = $query->paginate(30);

        $pagosFinalizadosTotales = $pagosFinalizados->total();

        return view('livewire.pagos.pagos-finalizados', [
            'pagosFinalizados' => $pagosFinalizados,
            'pagosFinalizadosTotales' => $pagosFinalizadosTotales,
        ]);
    }
}
