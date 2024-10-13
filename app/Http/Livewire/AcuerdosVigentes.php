<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Acuerdo;
use App\Models\Deudor;
use Livewire\WithPagination;

class AcuerdosVigentes extends Component
{
    use WithPagination;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    protected $listeners = ['terminosDeBusquedaAcuerdosVigentes'=>'buscarAcuerdo'];

    public function buscarAcuerdo($deudor, $nro_doc, $responsable, $nro_operacion)
    {
        $this->deudor = $deudor;
        $this->nro_doc = $nro_doc;
        $this->responsable = $responsable;
        $this->nro_operacion = $nro_operacion;
    }

    public function render()
    {
        $acuerdosVigentes = Acuerdo::where('estado', 1)
            ->when($this->deudor || $this->nro_doc || $this->nro_operacion, function ($query) {
                $query->whereHas('propuesta', function ($query) {
                    $query->whereHas('deudorId', function ($query) {
                        if ($this->deudor) {
                            $query->where('nombre', 'LIKE', "%" . $this->deudor . "%");
                        }
                        if ($this->nro_doc) {
                            $query->where('nro_doc', 'LIKE', "%" . $this->nro_doc . "%");
                        }
                    });
                    if ($this->nro_operacion) {
                        $query->whereHas('operacionId', function ($query) {
                            $query->where('operacion', 'LIKE', "%" . $this->nro_operacion . "%");
                        });
                    }
                });
            })
            ->when($this->responsable, function ($query) {
                $query->where('responsable', $this->responsable);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $acuerdosVigentesTotales = $acuerdosVigentes->total();

        return view('livewire.acuerdos.acuerdos-vigentes', [
            'acuerdosVigentes' => $acuerdosVigentes,
            'acuerdosVigentesTotales' => $acuerdosVigentesTotales,
        ]);
    }
}
