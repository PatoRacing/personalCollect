<?php

namespace App\Http\Livewire;

use App\Models\GestionesDeudores;
use App\Models\Operacion;
use Livewire\Component;

class DeudorPerfilOperaciones extends Component
{
    public $deudor;
    protected $listeners = ['nuevaGestion'];

    public function render()
    {
        $operacionesDeudor = Operacion::where('deudor_id', $this->deudor->id)->get();
        $situacionDeudor = GestionesDeudores::where('deudor_id', $this->deudor->id)->latest('created_at')->first();
        
        return view('livewire.operaciones.deudor-perfil-operaciones',[
            'operacionesDeudor'=>$operacionesDeudor,
            'situacionDeudor'=>$situacionDeudor
        ]);
    }

    //Si el deudor es ubicado se llama a esta funcion para que renderice el nuevo estado para poder gestionar operaciones
    public function nuevaGestion()
    {
        $this->render();
    }
}
