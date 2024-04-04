<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubirComprobante extends Component
{
    public $pago;
    public $concepto;
    public $monto;
    public $vencimiento;
    public $comprobante;

    use WithFileUploads;

    protected $rules = [
        'comprobante' => 'required|max:2048'
    ];

    public function mount(Pago $pago)
    {
        $this->concepto = $pago->concepto;
        $this->monto = $pago->monto;
        $this->vencimiento = $pago->vencimiento;
        $this->comprobante = $pago->comprobante;
    }

    public function subirComprobante() 
    {
        $datos = $this->validate();
        $comprobanteDePago = $this->comprobante->store('public/comprobantes');
        $nombreComprobante = str_replace('public/comprobantes/', '', $comprobanteDePago);

        //Pago Correspondiente
        $pago = Pago::find($this->pago->id);
        $pago->update([
            'comprobante' => $nombreComprobante,
            'estado' => 2,
        ]);
        return redirect()->route('acuerdo', ['acuerdo' => $pago->acuerdo->id])->with('message', 'Comprobante subido correctamente');
    }


    public function render()
    {
        return view('livewire.subir-comprobante');
    }
}
