<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use Livewire\Component;

class ActualizarPago extends Component
{
    public $pago;

    public function actualizarEstado(Pago $pago)
    {
        if($pago->estado == 1)
        {
            $pago->estado = 2;
            $pago->usuario_ultima_modificacion_id =  auth()->id();

        } else {
            $pago->estado = 1;
            $pago->usuario_ultima_modificacion_id =  auth()->id();
        }
        
        $pago->save();
        $this->emit('actualizacionCompleta');
    }

    public function render()
    {
        return view('livewire.actualizar-pago');
    }
}
