<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use App\Models\PagoInformado;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormularioInformarPago extends Component
{
    public $pagoId;
    public $paso = 1;
    public $nro_cuota;
    public $nombre_deudor;
    public $dni_deudor;
    public $fecha_de_pago;
    public $monto;
    public $medio_de_pago;
    public $sucursal;
    public $hora;
    public $nombre_tercero;
    public $cuenta;
    public $central_de_pago;
    public $comprobante;
    public $medioDePagoDeposito;
    public $medioDePagoTransferencia;
    public $medioDePagoEfectivo;

    use WithFileUploads;

    public function siguientePasoUno()
    {
        $this->validate([
            'fecha_de_pago'=> 'required|date',
            'monto'=> 'required',
            'medio_de_pago'=> 'required',
        ]);
        $this->paso ++;
        $this->condiciones();
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

    public function guardarNuevaOperacion()
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
        $pagoInformado = new PagoInformado([
            'pago_id'=>$this->pagoId,
            'nombre_deudor'=>$this->nombre_deudor,
            'dni_deudor'=>$this->dni_deudor,
            'nro_cuota'=>$this->nro_cuota,
            'fecha_de_pago'=>$this->fecha_de_pago,
            'monto'=>$this->monto,
            'medio_de_pago'=>$this->medio_de_pago,
            'sucursal'=>$this->sucursal,
            'hora'=>$this->hora,
            'cuenta'=>$this->cuenta,
            'nombre_tercero'=>$this->nombre_tercero,
            'central_de_pago'=>$this->central_de_pago,
            'comprobante' => $nombreComprobante,
            'usuario_ultima_modificacion_id' => auth()->id()
        ]);
        $pagoInformado->save();
        $pago = Pago::find($this->pagoId);
        $pago->estado = 2;
        $pago->usuario_ultima_modificacion_id = auth()->id();
        $pago->save();
        return redirect()->route('pagos')->with('success.message', 'Pago informado correctamente');
    }

    public function anterior()
    {
        $this->paso --;
        $this->medio_de_pago = null;
        $this->sucursal = null;
        $this->hora = null;
        $this->cuenta = null;
        $this->nombre_tercero = null;
        $this->central_de_pago = null;
        $this->comprobante = null;
        $this->medioDePagoDeposito = false;
        $this->medioDePagoTransferencia = false;
        $this->medioDePagoEfectivo = false;
    }

    public function render()
    {
        $pago = Pago::where('id', $this->pagoId)->first();
        $this->nombre_deudor = $pago->acuerdo->propuesta->deudorId->nombre;
        $this->dni_deudor = $pago->acuerdo->propuesta->deudorId->nro_doc;
        $this->nro_cuota = $pago->nro_cuota;

        return view('livewire.formulario-informar-pago', [
            'pago'=>$pago
        ]);
    }
}
