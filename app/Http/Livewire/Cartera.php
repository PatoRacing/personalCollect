<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Operacion;
use Livewire\Component;

class Cartera extends Component
{
    public $nro_doc;
    public $nro_operacion;
    public $deudor;
    protected $listeners = ['terminosDeBusquedaCartera'=>'buscarOperacion'];

    public function buscarOperacion($nro_doc, $nro_operacion, $deudor)
    {
        $this->nro_doc = $nro_doc;
        $this->nro_operacion = $nro_operacion;
        $this->deudor = $deudor;
    }

    public function render()
    {
        //Busqueda por nro_doc
        $operaciones = Operacion::when($this->nro_doc, function($query){
            $query->where('nro_doc', $this->nro_doc);

        //Busqueda por nro operacion
        })->when($this->nro_operacion, function($query){
            $query->where('operacion', $this->nro_operacion);

        //Busqueda por deudor
        })->when($this->deudor, function($query) {
            $deudorId = Deudor::where('nombre', 'LIKE', "%" . $this->deudor . "%")
                ->pluck('id')
                ->first();
            $query->where('deudor_id', $deudorId);

        //Vista Inicial
        })->where('situacion', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $casosActivos = Operacion::where('situacion', 1)->count();
        $totalDNI = Operacion::distinct('nro_doc')->count();
        $deudaTotal = Operacion::sum('deuda_capital');
        $deudaActiva = Operacion::where('situacion', 1)->sum('deuda_capital');

        return view('livewire.cartera', [
            'operaciones'=>$operaciones,
            'casosActivos'=>$casosActivos,
            'totalDNI'=>$totalDNI,
            'deudaTotal'=>$deudaTotal,
            'deudaActiva'=>$deudaActiva,
        ]);
    }
}
