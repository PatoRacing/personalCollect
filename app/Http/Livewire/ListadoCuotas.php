<?php

namespace App\Http\Livewire;

use App\Models\Deudor;
use App\Models\Pago;
use Livewire\Component;
use Livewire\WithPagination;

class ListadoCuotas extends Component
{
    use WithPagination;

    public $cuotasVigentes = true;
    public $cuotasObservadas = false;
    public $cuotasAplicadas = false;
    public $cuotasRendidasParcial = false;
    public $cuotasRendidasTotal = false;
    public $cuotasProcesadas = false;
    public $cuotasRendidasACuenta = false;
    public $cuotasDevueltas = false;
    public $contexto;

    public function mostrarCuotas($tipoCuota)
    {
        // Reiniciamos todas las cuotas a false
        $this->cuotasVigentes = false;
        $this->cuotasObservadas = false;
        $this->cuotasAplicadas = false;
        $this->cuotasRendidasParcial = false;
        $this->cuotasRendidasTotal = false;
        $this->cuotasProcesadas = false;
        $this->cuotasRendidasACuenta = false;
        $this->cuotasDevueltas = false;
        //Activamos segun el boton presionado
        switch ($tipoCuota) {
            case 'vigentes':
                $this->cuotasVigentes = true;
                break;
            case 'observadas':
                $this->cuotasObservadas = true;
                break;
            case 'aplicadas':
                $this->cuotasAplicadas = true;
                break;
            case 'rendidasParcial':
                $this->cuotasRendidasParcial = true;
                break;
            case 'rendidasTotal':
                $this->cuotasRendidasTotal = true;
                break;
            case 'procesadas':
                $this->cuotasProcesadas = true;
                break;
            case 'rendidasACuenta':
                $this->cuotasRendidasACuenta = true;
                break;
            case 'devueltas':
                $this->cuotasDevueltas = true;
                break;
        }
    }

    public function mount()
    {
        // Recuperar el contexto desde la URL
        $this->contexto = request()->query('contexto', '1');  // El valor '1' es el valor por defecto (vigentes)

        // Activar la cuota correspondiente según el contexto
        $this->mostrarCuotasPorContexto($this->contexto);
    }

    public function mostrarCuotasPorContexto($contexto)
    {
        // Reiniciar todas las cuotas a false
        $this->cuotasVigentes = false;
        $this->cuotasObservadas = false;
        $this->cuotasAplicadas = false;
        $this->cuotasRendidasParcial = false;
        $this->cuotasRendidasTotal = false;
        $this->cuotasProcesadas = false;
        $this->cuotasRendidasACuenta = false;
        $this->cuotasDevueltas = false;

        // Activar la cuota según el contexto
        switch ($contexto) {
            case '1':  // Vigentes
                $this->cuotasVigentes = true;
                break;
            case '2':  // Observadas
                $this->cuotasObservadas = true;
                break;
            case '3':  // Aplicadas
                $this->cuotasAplicadas = true;
                break;
            case '4':  // Rendidas Parcial
                $this->cuotasRendidasParcial = true;
                break;
            case '5':  // Rendidas Total
                $this->cuotasRendidasTotal = true;
                break;
            case '6':  // Procesadas
                $this->cuotasProcesadas = true;
                break;
            case '7':  // Rendidas a Cuenta
                $this->cuotasRendidasACuenta = true;
                break;
            case '8':  // Devueltas
                $this->cuotasDevueltas = true;
                break;
            // Agregar más casos según lo necesario
        }
    }


    
    public function render()
    {
        return view('livewire.pagos.listado-cuotas');
    }
}
