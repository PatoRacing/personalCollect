<?php

namespace App\Http\Livewire\Gestiones\Cancelacion;

use Livewire\Component;

class GlobalCancelacionAgente extends Component
{
    public $cuota;
    public $imprimirAlerta = false;

    public function mount()
    {
        if (session()->has('imprimirAlerta')) {
            $this->imprimirAlerta = true;
        }
    }

    private function obtenerLivewirePorEstado($estado)
    {
        switch ($estado) {
            case '1':
                return 'gestiones.cancelacion.vigente.cancelacion-agente-vigente';
            case '2':
                return 'gestiones.cancelacion.observada.cancelacion-agente-observada';
            case '3':
                return 'gestiones.cancelacion.aplicada.cancelacion-agente-aplicada';
            case '5':
                return 'gestiones.cancelacion.rendida-total.cancelacion-agente-rendida-total';
            case '6':
                return 'gestiones.cancelacion.procesada.cancelacion-agente-procesada';
            case '7':
                return 'gestiones.cancelacion.rendida-a-cuenta.cancelacion-agente-rendida-a-cuenta';
            default:
                return null;  // Opcionalmente, podrías manejar un estado desconocido
        }
    }

    public function render()
    {
        $mostrarLivewireCorrespondiente = $this->obtenerLivewirePorEstado($this->cuota->estado);
        return view('livewire.gestiones.cancelacion.global-cancelacion-agente',[
            'mostrarLivewireCorrespondiente'=>$mostrarLivewireCorrespondiente
        ]);
    }
}
