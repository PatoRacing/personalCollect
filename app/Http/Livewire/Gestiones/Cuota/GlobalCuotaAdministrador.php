<?php

namespace App\Http\Livewire\Gestiones\Cuota;

use App\Models\GestionCuota;
use Livewire\Component;

class GlobalCuotaAdministrador extends Component
{
    public $cuota;
    public $imprimirAlerta = false;

    protected $listeners = ['eventoCuota' => 'manejarAccionCuota'];

    public function mount()
    {
        if (session()->has('imprimirAlerta')) {
            $this->imprimirAlerta = true;
        }
    }

    public function manejarAccionCuota($accion, $pagoDeCuota)
    {
        // Lógica específica para las cuotas
        if ($accion === 'admActualizarPagoInformado') {
            dd('actualizar un pago informado');
        } elseif($accion === 'admAplicarPagoInformado') {
            if($pagoDeCuota['monto_abonado'] > $this->cuota->monto_acordado) {
                $sobranteDeCuota = $pagoDeCuota['monto_abonado'] - $this->cuota->monto_acordado;
                $this->emit('enviarSobranteDeCuota', $sobranteDeCuota);
            } else {
                GestionCuota::where('id', $pagoDeCuota['id'])->update(['situacion' => 3]);
                $this->cuota->estado = 3;
                $this->cuota->save();
                return redirect()->route('gestion.cuota.administrador', ['cuota' => $this->cuota->id])
                                ->with('imprimirAlerta', true);
            }
        } elseif($accion === 'admEliminarPagoInformado') {
            dd('un administrador quiere eliminar un pago informado de una cuota en estado vigente');
        }
    }

    private function obtenerLivewirePorEstado($estado)
    {
        switch ($estado) {
            case '1':
                return 'gestiones.cuota.vigente.cuota-administrador-vigente';
            case '2':
                return 'gestiones.cuota.observada.cuota-administrador-observada';
            case '3':
                return 'gestiones.cuota.aplicada.cuota-administrador-aplicada';
            case '4':
                return 'gestiones.cuota.rendida-parcial.cuota-administrador-rendida-parcial';
            case '5':
                return 'gestiones.cuota.rendida-total.cuota-administrador-rendida-total';
            default:
                return null;  // Opcionalmente, podrías manejar un estado desconocido
        }
    }
    
    public function render()
    {
        $mostrarLivewireCorrespondiente = $this->obtenerLivewirePorEstado($this->cuota->estado);

        return view('livewire.gestiones.cuota.global-cuota-administrador',[
            'mostrarLivewireCorrespondiente'=>$mostrarLivewireCorrespondiente
        ]);
    }

    
}
