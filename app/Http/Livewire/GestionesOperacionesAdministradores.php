<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Livewire\Component;

class GestionesOperacionesAdministradores extends Component
{
    public $operacion;
    
    public function render()
    {
        $ultimaPropuesta = Propuesta::where('operacion_id', $this->operacion->id)
                                    ->latest('created_at')
                                    ->first();

        return view('livewire.operaciones.gestiones-operaciones-administradores',[
            'ultimaPropuesta'=>$ultimaPropuesta
        ]);
    }
}
