<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use App\Models\PagoInformado;
use Livewire\Component;
use Livewire\WithFileUploads;

class InformarPago extends Component
{
    use WithFileUploads;

    public $pagoId;
    public $pago;
    public $pasoUno = true;
    public $fecha_de_pago;
    public $monto_abonado;
    public $medio_de_pago;
    public $medioDePagoDeposito;
    public $medioDePagoTransferencia;
    public $medioDePagoEfectivo;
    public $sucursal;
    public $hora;
    public $cuenta;
    public $comprobante;
    public $nombre_tercero;
    public $central_de_pago;

    public function mount($pagoId)
    {
        $this->pagoId = $pagoId;
        $this->pago = Pago::find($this->pagoId);
    }

    public function siguientePasoUno()
    {
        $this->validate([
            'fecha_de_pago'=> 'required|date',
            'monto_abonado'=> 'required',
            'medio_de_pago'=> 'required',
        ]);
        $this->condiciones();
        $this->pasoUno = false;
    }

    public function condiciones()
    {
        if($this->medio_de_pago == 'deposito'){
            $this->medioDePagoDeposito = true;
        } elseif($this->medio_de_pago == 'transferencia') {
            $this->medioDePagoTransferencia = true;
        } elseif($this->medio_de_pago == 'efectivo'){
            $this->medioDePagoEfectivo = true;
        }
    }

    public function anterior()
    {
        $this->pasoUno = true;
        $this->medio_de_pago = null;
        $this->sucursal = null;
        $this->hora = null;
        $this->cuenta = null;
        $this->comprobante = null;
        $this->nombre_tercero = null;
        $this->central_de_pago = null;
        $this->medioDePagoDeposito = false;
        $this->medioDePagoTransferencia = false;
        $this->medioDePagoEfectivo = false;
    }

    public function guardarNuevaOperacion ()
    {
        if ($this->medioDePagoDeposito) {
            $this->validate([
                'sucursal'=> 'required',
                'hora'=> 'required',
                'cuenta'=> 'required'
            ]);
        } elseif ($this->medioDePagoTransferencia) {
            $this->validate([
                'nombre_tercero'=> 'required',
                'cuenta'=> 'required'
            ]);
        } elseif ($this->medioDePagoEfectivo) {
            $this->validate([
                'central_de_pago'=> 'required'
            ]);
        }
        $nombreComprobante = null;
        if($this->comprobante) {
            $comprobanteDePago = $this->comprobante->store('public/comprobantes');
            $nombreComprobante = str_replace('public/comprobantes/', '', $comprobanteDePago);
        }
        $this->pago->fecha_de_pago = $this->fecha_de_pago;
        $this->pago->monto_abonado = $this->monto_abonado;
        $this->pago->medio_de_pago = $this->medio_de_pago;
        $this->pago->sucursal = $this->sucursal;
        $this->pago->hora = $this->hora;
        $this->pago->cuenta = $this->cuenta;
        $this->pago->nombre_tercero = $this->nombre_tercero;
        $this->pago->central_de_pago = $this->central_de_pago;
        $this->pago->comprobante = $nombreComprobante;
        $this->pago->usuario_informador_id = auth()->id();
        $this->pago->fecha_informe = now()->format('Y-m-d');
        $this->pago->estado = 2;
        $this->pago->usuario_ultima_modificacion_id = auth()->id();
        $this->pago->save();
        $this->emit('pagoInformado');
        return redirect()->route('pagos')->with('pagoInformado', true);
    }

    public function render()
    {
        return view('livewire.pagos.informar-pago',[
            'pago'=>$this->pago
        ]);
    }
}
