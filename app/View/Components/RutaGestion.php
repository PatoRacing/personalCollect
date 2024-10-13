<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RutaGestion extends Component
{
    public $rutaGestion;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($rutaGestion)
    {
        $this->rutaGestion = $rutaGestion;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */


    public function render()
    {
        return view('components.ruta-gestion');
    }
}
