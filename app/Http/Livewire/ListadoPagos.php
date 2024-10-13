<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use Livewire\Component;

class ListadoPagos extends Component
{
    public $pagosVigentes ;
    public $pagosInformados = true;
    public $pagosAplicados;
    public $pagosRendidos;
    public $pagosObservados;
    public $alertaPagoInformado;
    public $alertaPagoAplicado;
    public $alertaPagoAplicadoEnviado;
    
    protected $listeners = ['pagoInformado', 'pagoAplicado', 'pagoAplicadoEnviado'=>'alertaPagoAplicadoEnviado'];

    public function mount()
    {
        if (session()->has('pagoInformado')) {
            $this->alertaPagoInformado = true;
            $this->pagosVigentes = false;
            $this->pagosInformados = true;
            $this->pagosAplicados = false;
            $this->pagosRendidos = false;
            $this->pagosObservados = false;
        } elseif (session()->has('pagoAplicado')) {
            $this->alertaPagoAplicado = true;
            $this->pagosVigentes = false;
            $this->pagosInformados = false;
            $this->pagosAplicados = true;
            $this->pagosRendidos = false;
            $this->pagosObservados = false;
        } 
    }

    public function alertaPagoAplicadoEnviado()
    {
        $this->alertaPagoAplicadoEnviado = true;
    }

    public function mostrarPagosVigentes()
    {
        $this->pagosVigentes = true;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosRendidos = false;
        $this->pagosObservados = false;
        $this->alertaPagoInformado = false;
        $this->alertaPagoAplicado = false;
        $this->alertaPagoAplicadoEnviado = false;
    }

    public function mostrarPagosInformados()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = true;
        $this->pagosAplicados = false;
        $this->pagosRendidos = false;
        $this->pagosObservados = false;
        $this->alertaPagoInformado = false;
        $this->alertaPagoAplicado = false;
        $this->alertaPagoAplicadoEnviado = false;
    }

    public function mostrarPagosObservados()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosRendidos = false;
        $this->pagosObservados = true;
        $this->alertaPagoInformado = false;
        $this->alertaPagoAplicado = false;
        $this->alertaPagoAplicadoEnviado = false;
    }

    public function mostrarPagosAplicados()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = true;
        $this->pagosRendidos = false;
        $this->pagosObservados = false;
        $this->alertaPagoInformado = false;
        $this->alertaPagoAplicado = false;
        $this->alertaPagoAplicadoEnviado = false;
    }

    public function mostrarPagosRendidos()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosRendidos = true;
        $this->pagosObservados = false;
        $this->alertaPagoInformado = false;
        $this->alertaPagoAplicado = false;
        $this->alertaPagoAplicadoEnviado = false;
    }

    

    public function render()
    {
        return view('livewire.pagos.listado-pagos');
    }
}
