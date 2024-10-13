<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PagoDeCuota extends Component
{
    public $pagoDeCuota;
    public $index;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pagoDeCuota)
    {
        $this->pagoDeCuota = $pagoDeCuota;
    }

    public function bgPagoDeCuota()
    {
        switch ($this->pagoDeCuota->situacion) {
            case 1:
                return 'bg-blue-800';
            case 2:
                return 'bg-red-600';
            case 3:
                return 'bg-indigo-600';
            case 4:
                return 'bg-green-600';
            case 5:
                return 'bg-orange-500';
            case 6:
                return 'bg-cyan-600';
            case 7:
                return 'bg-yellow-500';
            case 8:
                return 'bg-gray-400';
            case 9:
                return 'bg-blue-300';
            case 10:
                return 'bg-gray-600';
            default:
                return '';
        }
    }

    public function estadoPagoDeCuota()
    {
        switch ($this->pagoDeCuota->situacion) {
            case 1:
                return 'Pago Informado';
            case 2:
                return 'Pago Rechazado';
            case 3:
                return 'Pago Aplicado';
            case 4:
                return 'Pago Rendido';
            case 5:
                return 'Pago Incompleto';
            case 6:
                return 'Pago Completo';
            case 7:
                return 'Pago Procesado';
            case 8:
                return 'Pago Para Rendir';
            case 9:
                return 'Pago Rendido a Cuenta';
            case 10:
                return 'Pago Devuelto';
            default:
                return '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pago-de-cuota');
    }
}
