<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AcuerdosDePago extends Component
{
    public $acuerdosVigentes = true;
    public $acuerdosEnProceso = false;
    public $acuerdosFinalizados = false;
    public $acuerdosObservados = false;

    public function mostrarAcuerdosVigentes()
    {
        $this->acuerdosVigentes = true;
        $this->acuerdosEnProceso = false;
        $this->acuerdosFinalizados = false;
        $this->acuerdosObservados = false;
    }

    public function mostrarAcuerdosEnProceso()
    {
        $this->acuerdosVigentes = false;
        $this->acuerdosEnProceso = true;
        $this->acuerdosFinalizados = true;
        $this->acuerdosObservados = false;
    }

    public function mostrarAcuerdosFinalizados()
    {
        $this->acuerdosVigentes = false;
        $this->acuerdosEnProceso = false;
        $this->acuerdosFinalizados = true;
        $this->acuerdosObservados = false;
    }

    public function mostrarAcuerdosObservados()
    {
        $this->acuerdosVigentes = false;
        $this->acuerdosFinalizados = false;
        $this->acuerdosFinalizados = false;
        $this->acuerdosObservados = true;
    }

    public function render()
    {
        return view('livewire.acuerdos.acuerdos-de-pago');
    }
}
