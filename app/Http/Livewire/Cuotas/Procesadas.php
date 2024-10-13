<?php

namespace App\Http\Livewire\Cuotas;

use App\Exports\PagosParaRendirExport;
use App\Imports\PagosParaRendirImport;
use App\Models\Acuerdo;
use App\Models\Deudor;
use App\Models\GestionCuota;
use App\Models\Operacion;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Procesadas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;
    public $modalExportarPagosParaRendir;
    public $modalImportarPagosParaRendir;
    public $segmento;
    public $modalNoHayPagos;
    public $pagosADescargar = [];
    public $rendicionCG;
    public $proforma;
    public $fecha_rendicion;
    public $archivoSubido;
    public $modalImportando;

    protected $listeners = ['terminosBusquedaDeCuotasProcesadas'=> 'buscarCuotasProcesadas'];

    public function buscarCuotasProcesadas($parametros)
    {
        $this->deudor = $parametros['deudor'];
        $this->nro_doc = $parametros['nro_doc'];
        $this->responsable = $parametros['responsable'];
        $this->nro_operacion = $parametros['nro_operacion'];
        $this->mes = $parametros['mes'];
        $this->estado = $parametros['estado'];
    }

    public function exportarPagosParaRendir()
    {
        $this->modalExportarPagosParaRendir = true;
    }
    public function cerrarModalExportarPagosParaRendir()
    {
        $this->modalExportarPagosParaRendir = false;
    }
    public function descargarPagosParaRendir()
    {
        // Validación
        $this->validate([
            'segmento' => 'required'
        ]);
        $this->modalExportarPagosParaRendir = false;
        // Obtenemos los pagos aplicados (situacion = 3)
        $pagosParaRendir = GestionCuota::where('situacion', 8)->take(20)->get();
        foreach ($pagosParaRendir as $pagoParaRendir)
        {
            // Obtenemos la operacion relacionada al pago que tiene el segemento de la misma
            $operacionId = $pagoParaRendir->pago->acuerdo->propuesta->operacionId->id;
            $operacion = Operacion::find($operacionId);
            if($operacion->segmento == $this->segmento)
            {
                $this->pagosADescargar[] = $pagoParaRendir;
            }
            else
            {
                $this->modalNoHayPagos = true;
                return;
            }
        }
        $pagosADescargar = $this->pagosADescargar;
        $fechaHoraDescarga = now()->format('Ymd_His');
        $nombreArchivo  = 'pagosAplicadosParaRendir_' . $fechaHoraDescarga . '.xlsx';
        return Excel::download(new PagosParaRendirExport($pagosADescargar), $nombreArchivo);
    }

    public function cerrarModalNoHayPagos()
    {
        $this->modalNoHayPagos = false;
    }

    public function importarRendicionDePagosParaRendir()
    {
        $this->modalImportarPagosParaRendir = true;
    }

    public function cerrarModalImportarRendicionDePagosParaRendir()
    {
        $this->modalImportarPagosParaRendir = false;
    }
    public function importarPagosParaRendir()
    {
        //Validacion del formulario
        $this->validate([
            'rendicionCG'=> 'required',
            'proforma'=> 'required',
            'fecha_rendicion'=> 'required|date',
            'archivoSubido' => 'required|file|mimes:xls,xlsx|max:10240', 
        ]);
        $this->modalImportarPagosParaRendir = false;
        try
        {
            //Se obtiene el archivo excel
            $excel = $this->archivoSubido;
            //Realizo la importacion
            $importarPagosRendidos = new PagosParaRendirImport;
            Excel::import($importarPagosRendidos, $excel);
            $pagosParaRendirRendidos = $importarPagosRendidos->procesarPagosRendidos;
            foreach ($pagosParaRendirRendidos as $pagoParaRendirRendido)
            {
                //Actualizo la situacion del pago que se esta rindiendo
                $pagoId = $pagoParaRendirRendido['pago_id'];
                $pagoEnBD = GestionCuota::find($pagoId);
                $pagoEnBD->situacion = 9;//Pago Rendido a cuenta
                $pagoEnBD->usuario_ultima_modificacion_id = auth()->id();
                $pagoEnBD->monto_a_rendir = $pagoParaRendirRendido['monto_a_rendir'];
                $pagoEnBD->proforma = $this->proforma;
                $pagoEnBD->rendicionCG = $this->rendicionCG;
                $pagoEnBD->usuario_rendidor_id = auth()->id();
                $pagoEnBD->fecha_rendicion = $this->fecha_rendicion;
                $pagoEnBD->save();
                $cuota = Pago::find($pagoEnBD->pago_id);
                $cuota->estado = 7; //Cuota rendida a cuenta
                $cuota->save();
                $acuerdoId = $cuota->acuerdo_id;
                $acuerdo = Acuerdo::find($acuerdoId);
                $acuerdo->estado = 3;
                $acuerdo->save();
            }
        }
        catch(\Exception $e) 
        {
            DB::rollBack();
            $errorImportacion = 'Ocurrió un error inesperado. (' . $e->getMessage() . ')';
            return back()->withErrors(['error' => $errorImportacion]);
        }
    }

    public function render()
    {
        $cuotasProcesadas = Pago::query();
        //Busqueda por deudor
        if ($this->deudor) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                                ->pluck('id')
                                ->first();
            if ($deudorId) {
                $cuotasProcesadas->whereHas('acuerdo.propuesta', function($subquery) use ($deudorId) {
                    $subquery->where('deudor_id', $deudorId);
                });
            }
        }
        // Busqueda por nro_doc
        if ($this->nro_doc) {
            $cuotasProcesadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('nro_doc', $this->nro_doc);
            });
        }
        //busqueda por responsable
        if ($this->responsable) {
            $cuotasProcesadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('usuario_asignado_id', $this->responsable);
            });
        }
        // Busqueda por nro operacion
        if ($this->nro_operacion) {
            $cuotasProcesadas->whereHas('acuerdo.propuesta.operacionId', function($subquery) {
                $subquery->where('operacion', $this->nro_operacion);
            });
        }
        // Busqueda por mes
        if ($this->mes) {
            $cuotasProcesadas->whereMonth('vencimiento_cuota', $this->mes);
        }
        //Busqueda por vencimiento
        if ($this->estado) {
            $hoy = Carbon::today();
            if ($this->estado == 'activo') {
                $cuotasProcesadas->where('vencimiento_cuota', '>=', $hoy);
            } else if ($this->estado == 'vencido') {
                $cuotasProcesadas->where('vencimiento_cuota', '<', $hoy);
            }
        }
        //Vista sin busqueda
        $cuotasProcesadas = $cuotasProcesadas->where('pagos.estado', 6)  
                                    ->join('acuerdos', 'pagos.acuerdo_id', '=', 'acuerdos.id')
                                    ->join('propuestas', 'acuerdos.propuesta_id', '=', 'propuestas.id')
                                    ->orderBy('propuestas.deudor_id', 'asc')  // Agrupar por deudor_id
                                    ->orderBy('pagos.created_at', 'desc')     // Ordenar por fecha de creación
                                    ->select('pagos.*')                       // Seleccionar solo las columnas de pagos
                                    ->paginate(30);
        $cuotasProcesadasTotales = $cuotasProcesadas->total();

        return view('livewire.cuotas.procesadas',[
            'cuotasProcesadas'=>$cuotasProcesadas,
            'cuotasProcesadasTotales'=>$cuotasProcesadasTotales
        ]);
    }
}
