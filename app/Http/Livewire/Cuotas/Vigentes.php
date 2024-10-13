<?php

namespace App\Http\Livewire\Cuotas;

use App\Models\Deudor;
use App\Models\Pago;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Vigentes extends Component
{
    use WithPagination;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;

    protected $listeners = ['terminosBusquedaDeCuotasVigentes'=> 'buscarCuotasVigentes'];

    public function buscarCuotasVigentes($parametros)
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
        $cuotasVigentes = Pago::query();
        //Busqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                                ->pluck('id')
                                ->first();
            if ($deudorId) {
                $cuotasVigentes->whereHas('acuerdo.propuesta', function($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $cuotasVigentes->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        //busqueda por responsable
        if ($this->responsable) {
            $cuotasVigentes->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $cuotasVigentes->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Busqueda por mes
        if ($this->mes) {
            $cuotasVigentes->whereMonth('vencimiento_cuota', $this->mes);
        }
        //Busqueda por vencimiento
        if ($this->estado) {
            $hoy = Carbon::today();
            if ($this->estado == 'activo') {
                $cuotasVigentes->where('vencimiento_cuota', '>=', $hoy);
            } else if ($this->estado == 'vencido') {
                $cuotasVigentes->where('vencimiento_cuota', '<', $hoy);
            }
        }
        //Vista sin busqueda
        $cuotasVigentes = $cuotasVigentes->where('pagos.estado', 1)  // Especificamos que el estado es de la tabla pagos
                                     ->join('acuerdos', 'pagos.acuerdo_id', '=', 'acuerdos.id')
                                     ->join('propuestas', 'acuerdos.propuesta_id', '=', 'propuestas.id')
                                     ->orderBy('propuestas.deudor_id', 'asc')  // Agrupar por deudor_id
                                     ->orderBy('pagos.created_at', 'desc')     // Ordenar por fecha de creación
                                     ->select('pagos.*')                       // Seleccionar solo las columnas de pagos
                                     ->paginate(30);
        $cuotasVigentesTotales = $cuotasVigentes->total(); 
        
        return view('livewire.cuotas.vigentes',[
            'cuotasVigentes'=>$cuotasVigentes,
            'cuotasVigentesTotales'=>$cuotasVigentesTotales
        ]);
    }
}
