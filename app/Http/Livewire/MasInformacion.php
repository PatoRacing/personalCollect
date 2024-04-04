<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use App\Models\User;
use Livewire\Component;

class MasInformacion extends Component
{
    public $propuesta;

    public function masInformacionPropuesta(Propuesta $propuesta)
    {
        $usuario = User::find($propuesta->usuario_ultima_modificacion_id);
        $this->emit('modalInformacionPropuesta',[
            'propuesta'=>$propuesta,
            'usuario'=>$usuario,
        ]);
    }

    public function render()
    {
        return view('livewire.mas-informacion');
    }
}
