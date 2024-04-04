<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Livewire\Component;

class EliminarCliente extends Component
{
    public $cliente;    
    public $clienteId;    
    public $confirmaEliminacionCliente;    

    public function eliminarCliente($clienteId)
    {
        $this->clienteId = $clienteId;
        $this->confirmaEliminacionCliente = true;
    }

    public function confirmaEliminacionCliente()
    {
        Cliente::find($this->clienteId)->delete();
        $this->confirmaEliminacionCliente = false;
        session()->flash('successMessage', 'Cliente eliminado correctamente');
        session()->flash('messageType', 'cliente');
        return redirect('clientes');
    }

    public function cancelarEliminacionCliente()
    {
        $this->confirmaEliminacionCliente = false;
    }

    public function render()
    {
        return view('livewire.eliminar-cliente');
    }
}
