<?php

namespace App\Http\Livewire;

use App\Models\Politica;
use Livewire\Component;

class PropuestaTipos extends Component
{
    public $operacion;
    public $ultimaPropuesta;

    public function render()
    {
        $politicas = Politica::where('producto_id', $this->operacion->producto_id)->get();
        $limiteQuita = '';
        $limiteCuotas = '';
        $limiteQuitaConDescuento = '';
        $limiteCuotasQuitaConDescuento = '';
        if($politicas) {
            foreach ($politicas as $politica) {
                $columna_uno = $politica->propiedad_politica_uno;
                $valor_uno = $politica->valor_propiedad_uno;
                $columna_dos = $politica->propiedad_politica_dos ?? null; 
                $valor_dos = $politica->valor_propiedad_dos ?? null;
                $columna_tres = $politica->propiedad_politica_tres ?? null; 
                $valor_tres = $politica->valor_propiedad_tres ?? null;
                $columna_cuatro = $politica->propiedad_politica_cuatro ?? null; 
                $valor_cuatro = $politica->valor_propiedad_cuatro ?? null;
                
                if ($this->operacion->getAttribute($columna_uno) == $valor_uno && 
                    (!$columna_dos || $this->operacion->getAttribute($columna_dos) == $valor_dos) &&
                    (!$columna_tres || $this->operacion->getAttribute($columna_tres) == $valor_tres) &&
                    (!$columna_cuatro || $this->operacion->getAttribute($columna_cuatro) == $valor_cuatro)) {
                    $limiteQuita = $politica->valor_quita;
                    $limiteCuotas = $politica->valor_cuota;
                    $limiteQuitaConDescuento = $politica->valor_quita_descuento;
                    $limiteCuotasQuitaConDescuento = $politica->valor_cuota_descuento;
                }
            }
        }

        return view('livewire.propuesta-tipos',[
            'limiteQuita'=>$limiteQuita,
            'limiteCuotas'=>$limiteCuotas,
            'limiteQuitaConDescuento'=>$limiteQuitaConDescuento,
            'limiteCuotasQuitaConDescuento'=>$limiteCuotasQuitaConDescuento,
        ]);
    }
}
