<?php

namespace App\Http\Livewire\Cuotas;

use App\Models\Deudor;
use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Observadas extends Component
{
    use WithPagination;
    
    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;

    protected $listeners = ['terminosBusquedaDeCuotasObservadas'=> 'buscarCuotasObservadas'];

    public function buscarCuotasObservadas($parametros)
    {
        $this->deudor = $parametros['deudor'];
        $this->nro_doc = $parametros['nro_doc'];
        $this->responsable = $parametros['responsable'];
        $this->nro_operacion = $parametros['nro_operacion'];
        $this->mes = $parametros['mes'];
        $this->estado = $parametros['estado'];
    }

    public function render()
    {
        $cuotasObservadas = Pago::query();
        //Busqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                                ->pluck('id')
                                ->first();
            if ($deudorId) {
                $cuotasObservadas->whereHas('acuerdo.propuesta', function($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $cuotasObservadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        //busqueda por responsable
        if ($this->responsable) {
            $cuotasObservadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $cuotasObservadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Busqueda por mes
        if ($this->mes) {
            $cuotasObservadas->whereMonth('vencimiento_cuota', $this->mes);
        }
        //Busqueda por vencimiento
        if ($this->estado) {
            $hoy = Carbon::today();
            if ($this->estado == 'activo') {
                $cuotasObservadas->where('vencimiento_cuota', '>=', $hoy);
            } else if ($this->estado == 'vencido') {
                $cuotasObservadas->where('vencimiento_cuota', '<', $hoy);
            }
        }
        //Vista sin busqueda
        $cuotasObservadas = $cuotasObservadas->where('pagos.estado', 2)  // Especificamos el estado 2 para observadas
                                         ->join('acuerdos', 'pagos.acuerdo_id', '=', 'acuerdos.id')
                                         ->join('propuestas', 'acuerdos.propuesta_id', '=', 'propuestas.id')
                                         ->orderBy('propuestas.deudor_id', 'asc')  // Agrupar por deudor_id
                                         ->orderBy('pagos.created_at', 'desc')     // Ordenar por fecha de creación
                                         ->select('pagos.*')                       // Seleccionar solo las columnas de pagos
                                         ->paginate(30);
        $cuotasObservadasTotales = $cuotasObservadas->total();

        return view('livewire.cuotas.observadas', [
            'cuotasObservadas'=>$cuotasObservadas,
            'cuotasObservadasTotales'=>$cuotasObservadasTotales,
        ]);
    }
}
