<?php

namespace App\Http\Livewire\Gestiones\Cuota\Vigente;

use App\Models\GestionCuota;
use Livewire\Component;

class CuotaAdministradorVigenteSinGestionesDePago extends Component
{
    public $cuota;

    //Escucha el evento lanzado desde el formulario y llama a guardarNuevaGestionDePago
    protected $listeners = ['nuevaGestionDePagoIngresadaAdministradorCuota'=>'guardarNuevaGestionDePago'];

    //Esta funcion recibe la informacion ingresada por el administrador
    public function guardarNuevaGestionDePago($informacionIngresada)
    {
        //El monto abonado es mayor al acordado
        if($informacionIngresada['monto_abonado'] > $this->cuota->monto_acordado)
        {
            //Se calcula cual es el sobrante
            $sobranteDeCuota = $informacionIngresada['monto_abonado'] - $this->cuota->monto_acordado;
            //Se llama a la funcion crearNuevoPagoAplicado y se pasa el monto acordado y creara una nueva gestion de pago
            $this->crearNuevoPagoAplicado($informacionIngresada, $this->cuota->monto_acordado);
            //Se emite la funcion enviarSobranteDeCuota que es escuchada en CuotaAdministradorVigente
            $this->emit('enviarSobranteDeCuota', $sobranteDeCuota);
            //Se recarga la pagina con los cambios efectuados
            return redirect()->route('gestion.cuota.administrador', ['cuota' => $this->cuota->id])
                         ->with('imprimirAlerta', true);
        }
        //Si el monto abonado es igual o menor al acordado se llama a la funcion y se crea una nueva instancia de pago
        else
        {
            $this->crearNuevoPagoAplicado($informacionIngresada, $informacionIngresada['monto_abonado']);
            return redirect()->route('gestion.cuota.administrador', ['cuota' => $this->cuota->id])
                         ->with('imprimirAlerta', true);
        }
    }

    //Crea una nueva instancia de pago con los montos indicados y actualiza el estado de la cuota
    private function crearNuevoPagoAplicado($informacionIngresada, $monto)
    {
        $nuevoPagoAplicado = new GestionCuota([
            'pago_id' => $this->cuota->id,
            'fecha_de_pago' => $informacionIngresada['fecha_de_pago'],
            'monto_abonado' => $monto, // Aquí usamos el monto ajustado o abonado
            'medio_de_pago' => $informacionIngresada['medio_de_pago'],
            'sucursal' => $informacionIngresada['camposCondicionales']['sucursal'] ?? null,
            'hora' => $informacionIngresada['camposCondicionales']['hora'] ?? null,
            'cuenta' => $informacionIngresada['camposCondicionales']['cuenta'] ?? null,
            'nombre_tercero' => $informacionIngresada['camposCondicionales']['nombre_tercero'] ?? null,
            'central_de_pago' => $informacionIngresada['camposCondicionales']['central_de_pago'] ?? null,
            'comprobante' => $informacionIngresada['comprobante'] ?? null,
            'usuario_informador_id' => auth()->id(),
            'fecha_informe' => now()->format('Y-m-d'),
            'situacion' => 3, // Pago aplicado
            'usuario_ultima_modificacion_id' => auth()->id(),
        ]);
        $nuevoPagoAplicado->save();
        $this->cuota->estado = 3;
        $this->cuota->save();
    }

    
    
    public function render()
    {
        return view('livewire.gestiones.cuota.vigente.cuota-administrador-vigente-sin-gestiones-de-pago');
    }
}
