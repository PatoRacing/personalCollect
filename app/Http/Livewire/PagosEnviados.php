<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Pago;
use Livewire\Component;

class PagosEnviados extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;
    protected $listeners = ['busquedaPagosEnviados'=>'buscarPagoEnviado'];

    public function buscarPagoEnviado($nro_doc, $nro_operacion, $deudor)
    {
        $this->nro_doc = $nro_doc;
        $this->nro_operacion = $nro_operacion;
        $this->deudor = $deudor;
    }

    public function render()
    {
        $query = Pago::query();

        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $query->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }

        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $query->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }

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
        $query->where('estado', 4)
            ->orderBy('created_at', 'desc');
        $pagosEnviados = $query->paginate(30);

        return view('livewire.pagos-enviados', [
            'pagosEnviados' => $pagosEnviados
        ]);
    }
}
