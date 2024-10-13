<?php

namespace App\Http\Livewire\Cuotas;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BuscadorCuotas extends Component
{
    use WithPagination;

    public $deudor;
    public $nro_doc;
    public $responsable;
    public $nro_operacion;
    public $mes;
    public $estado;
    public $contexto;

    public function recargarBusqueda()
    {
        return redirect()->to('/cuotas?contexto=' . $this->contexto);
    }

    public function busquedaDeCuotas()
    {
        $parametros = [
            'deudor' => $this->deudor,
            'nro_doc' => $this->nro_doc,
            'responsable' => $this->responsable,
            'nro_operacion' => $this->nro_operacion,
            'mes' => $this->mes,
            'estado' => $this->estado
        ];
        if ($this->contexto == "1") {
            $this->emit('terminosBusquedaDeCuotasVigentes', $parametros);
        } elseif ($this->contexto == "2") {
            $this->emit('terminosBusquedaDeCuotasObservadas', $parametros);
        } elseif ($this->contexto == "3") {
            $this->emit('terminosBusquedaDeCuotasAplicadas', $parametros);
        } elseif ($this->contexto == "4") {
            $this->emit('terminosBusquedaDeCuotasRendidasParcial', $parametros);
        } elseif ($this->contexto == "5") {
            $this->emit('terminosBusquedaDeCuotasRendidasTotal', $parametros);
        } elseif ($this->contexto == "6") {
            $this->emit('terminosBusquedaDeCuotasProcesadas', $parametros);
        } elseif ($this->contexto == "7") {
            $this->emit('terminosBusquedaDeCuotasRendidasACuenta', $parametros);
        } elseif ($this->contexto == "8") {
            $this->emit('terminosBusquedaDeCuotasDevueltas', $parametros);
        }
        
    }

    public function render()
    {
        $responsables = User::all();

        return view('livewire.cuotas.buscador-cuotas',[
            'responsables'=>$responsables
        ]);
    }
}
