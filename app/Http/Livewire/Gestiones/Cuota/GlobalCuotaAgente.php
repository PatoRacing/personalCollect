<?php

namespace App\Http\Livewire\Gestiones\Cuota;

use App\Models\GestionCuota;
use Livewire\Component;

class GlobalCuotaAgente extends Component
{
    public $cuota;
    public $imprimirAlerta = false;
    //Escucha el ingreso de informacion desde el formulario
    //Escucha el evento disparado desde los botones de Pagos
    protected $listeners = ['nuevaGestionDePagoIngresadaAgente'=>'guardarNuevaGestionDePago',
                            'eventoCuota' => 'manejarAccionCuota'];

    //Gestiona acciones de acuerdo al boton cliqueado    
    public function manejarAccionCuota($accion, $pagoDeCuotaId)
    {
        // Lógica específica para las cuotas
        if ($accion === 'agtActualizarPagoInformado') {
            dd('un agente quiere actualizar un pago informado de una cuota en estado vigente');
        } else {
            dd('un agente quiere eliminar un pago informado de una cuota en estado vigente');
        }
        // Otras acciones según sea necesario
    }

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
                return 'gestiones.cuota.vigente.cuota-agente-vigente';
            case '2':
                return 'gestiones.cuota.observada.cuota-agente-observada';
            case '3':
                return 'gestiones.cuota.aplicada.cuota-agente-aplicada';
            case '4':
                return 'gestiones.cuota.rendida-parcial.cuota-agente-rendida-parcial';
            case '5':
                return 'gestiones.cuota.rendida-total.cuota-agente-rendida-total';
            default:
                return null;  // Opcionalmente, podrías manejar un estado desconocido
        }
    }

    //Crea una nueva instancia de Pago con estado informado
    public function guardarNuevaGestionDePago($informacionIngresada)
    {
        $nuevoPagoInformado = New GestionCuota([
            'pago_id'=> $this->cuota->id,
            'fecha_de_pago' => $informacionIngresada['fecha_de_pago'],
            'monto_abonado' => $informacionIngresada['monto_abonado'],
            'medio_de_pago' => $informacionIngresada['medio_de_pago'],
            'sucursal' => $informacionIngresada['camposCondicionales']['sucursal'] ?? null, // Si existe en camposCondicionales
            'hora' => $informacionIngresada['camposCondicionales']['hora'] ?? null,        // Si existe en camposCondicionales
            'cuenta' => $informacionIngresada['camposCondicionales']['cuenta'] ?? null,
            'nombre_tercero' => $informacionIngresada['camposCondicionales']['nombre_tercero'] ?? null,
            'central_de_pago' => $informacionIngresada['camposCondicionales']['central_de_pago'] ?? null, // Si aplica
            'comprobante'=>$informacionIngresada['comprobante'] ?? null,
            'usuario_informador_id'=> auth()->id(),
            'fecha_informe'=> now()->format('Y-m-d'),
            'situacion' => 1, //Pago informado
            'usuario_ultima_modificacion_id'=>auth()->id(),
        ]);
        $nuevoPagoInformado->save();
        return redirect()->route('gestion.cuota.agente', ['cuota' => $this->cuota->id])
                     ->with('imprimirAlerta', true);    
    }

    public function render()
    {
        $mostrarLivewireCorrespondiente = $this->obtenerLivewirePorEstado($this->cuota->estado);

        return view('livewire.gestiones.cuota.global-cuota-administrador',[
            'mostrarLivewireCorrespondiente'=>$mostrarLivewireCorrespondiente
        ]);
    }
}
