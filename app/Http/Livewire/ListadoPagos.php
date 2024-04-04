<?php

namespace App\Http\Livewire;

use App\Models\Pago;
use Livewire\Component;

class ListadoPagos extends Component
{
    public $pagosVigentes = true;
    public $pagosInformados;
    public $pagosAplicados;
    public $pagosEnviados;
    public $pagosRendidos;
    public $pagosIncumplidos;

    public function mount()
    {
        if (session()->has('message')) {
            $this->pagosVigentes = false;
            $this->pagosInformados = false;
            $this->pagosAplicados = true; 
            $this->pagosEnviados = false;
            $this->pagosRendidos = false;
            $this->pagosIncumplidos = false;
        } elseif(session()->has('success.message')) {
            $this->pagosVigentes = false;
            $this->pagosInformados = true;
            $this->pagosAplicados = false; 
            $this->pagosEnviados = false;
            $this->pagosRendidos = false;
            $this->pagosIncumplidos = false;
        } elseif(session()->has('aplicado.message')){
            $this->pagosVigentes = false;
            $this->pagosInformados = false;
            $this->pagosAplicados = true; 
            $this->pagosEnviados = false;
            $this->pagosRendidos = false;
            $this->pagosIncumplidos = false;
        }
    }

    public function pagosVigentesActivo()
    {
        $this->pagosVigentes = true;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosEnviados = false;
        $this->pagosRendidos = false;
        $this->pagosIncumplidos = false;
    }
    
    public function pagosInformadosActivo()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = true;
        $this->pagosAplicados = false;
        $this->pagosEnviados = false;
        $this->pagosRendidos = false;
        $this->pagosIncumplidos = false;
    }
    
    public function pagosAplicadosActivo()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = true;
        $this->pagosEnviados = false;
        $this->pagosRendidos = false;
        $this->pagosIncumplidos = false;
    }
    
    public function pagosEnviadosActivo()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosEnviados = true;
        $this->pagosRendidos = false;
        $this->pagosIncumplidos = false;
    }

    public function pagosRendidosActivo()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosEnviados = false;
        $this->pagosRendidos = true;
        $this->pagosIncumplidos = false;
    }
    
    public function pagosIncumplidosActivo()
    {
        $this->pagosVigentes = false;
        $this->pagosInformados = false;
        $this->pagosAplicados = false;
        $this->pagosEnviados = false;
        $this->pagosRendidos = false;
        $this->pagosIncumplidos = true;
    }

    public function render()
    {

        return view('livewire.listado-pagos');
    }
}
