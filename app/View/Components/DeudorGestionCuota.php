<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeudorGestionCuota extends Component
{
    public $cuota;
    public $bgColor;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cuota)
    {
        $this->cuota = $cuota;
        $this->bgColor = $this->determinarBg($cuota->estado);
    }

    protected function determinarBg($estado)
    {
        switch ($estado) {
            case 1:
                return 'bg-blue-800'; // Cuota vigente
            case 2:
                return 'bg-red-600'; // Cuota observada
            case 3:
                return 'bg-indigo-600'; // Cuota aplicada
            case 4:
                return 'bg-cyan-600'; // Cuota rendida parcial
            case 5:
                return 'bg-green-600'; // Cuota rendida total
            case 6:
                return 'bg-yellow-500'; // Cuota procesada
            case 7:
                return 'bg-orange-500'; // Cuota rendida a cuenta
            case 8:
                return 'bg-gray-600'; // Cuota devuelta
            default:
                return 'bg-gray-200'; // Estado desconocido
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.deudor-gestion-cuota');
    }
}
