<?php

namespace App\Http\Livewire\Gestiones\Cancelacion;

use Livewire\Component;

class GlobalCancelacionAdministrador extends Component
{
    public $cuota;
    public $imprimirAlerta = false;

    protected $listeners = ['eventoCancelacion' => 'manejarAccionCuota'];

    private function obtenerLivewirePorEstado($estado)
    {
        switch ($estado) {
            case '1':
                return 'gestiones.cancelacion.vigente.cancelacion-administrador-vigente';
            case '2':
                return 'gestiones.cancelacion.observada.cancelacion-administrador-observada';
            case '3':
                return 'gestiones.cancelacion.aplicada.cancelacion-administrador-aplicada';
            case '5':
                return 'gestiones.cancelacion.rendida-total.cancelacion-administrador-rendida-total';
            case '6':
                return 'gestiones.cancelacion.procesada.cancelacion-administrador-procesada';
            case '7':
                return 'gestiones.cancelacion.rendida-a-cuenta.cancelacion-administrador-rendida-a-cuenta';
            default:
                return null;  // Opcionalmente, podrías manejar un estado desconocido
        }
    }

    public function render()
    {
        $mostrarLivewireCorrespondiente = $this->obtenerLivewirePorEstado($this->cuota->estado);

        return view('livewire.gestiones.cancelacion.global-cancelacion-administrador',[
            'mostrarLivewireCorrespondiente'=>$mostrarLivewireCorrespondiente
        ]);
    }
}
