<?php

namespace App\Http\Livewire;

use App\Models\Operacion;
use App\Models\Politica;
use App\Models\Producto;
use Livewire\Component;

class GenerarPolitica extends Component
{
    public $producto;
    public $paso = 1;
    public $valoresQuitaCuota;
    public $resumen;
    public $propiedadesOperacion;
    public $propiedad;
    public $politica_posible_uno;
    public $politica_posible_dos;
    public $politica_posible_tres;
    public $valores_uno = [];
    public $valores_dos = [];
    public $valores_tres = [];
    public $valores_cuatro = [];
    public $propiedad_politica_uno;
    public $valor_propiedad_uno;
    public $propiedad_politica_dos;
    public $valor_propiedad_dos;
    public $propiedad_politica_tres;
    public $valor_propiedad_tres;
    public $propiedad_politica_cuatro;
    public $valor_propiedad_cuatro;
    public $valor_quita;
    public $valor_cuota;
    public $valor_quita_descuento;
    public $valor_cuota_descuento;

    public function obtenerValoresUno()
    {
        // Verificar que se haya seleccionado una propiedad
        if (!empty($this->propiedad_politica_uno)) {
            // Obtener los valores únicos de la propiedad uno de operación, omitiendo los nulos y ordenándolos alfabéticamente
            $this->valores_uno = Operacion::whereNotNull($this->propiedad_politica_uno)
                ->orderBy($this->propiedad_politica_uno)
                ->distinct()
                ->pluck($this->propiedad_politica_uno);
        } 
    }

    public function propiedadSeleccionadaUno()
    {
        $this->obtenerValoresUno();
    }

    public function obtenerValoresDos()
    {
        // Verificar que se haya seleccionado una propiedad
        if (!empty($this->propiedad_politica_dos)) {
            // Obtener los valores únicos de la propiedad uno de operación, omitiendo los nulos y ordenándolos alfabéticamente
            $this->valores_dos = Operacion::whereNotNull($this->propiedad_politica_dos)
                ->orderBy($this->propiedad_politica_dos)
                ->distinct()
                ->pluck($this->propiedad_politica_dos);
        } 
    }

    public function propiedadSeleccionadaDos()
    {
        $this->obtenerValoresDos();
    }

    public function obtenerValoresTres()
    {
        // Verificar que se haya seleccionado una propiedad
        if (!empty($this->propiedad_politica_tres)) {
            // Obtener los valores únicos de la propiedad uno de operación, omitiendo los nulos y ordenándolos alfabéticamente
            $this->valores_tres = Operacion::whereNotNull($this->propiedad_politica_tres)
                ->orderBy($this->propiedad_politica_tres)
                ->distinct()
                ->pluck($this->propiedad_politica_tres);
        } 
    }

    public function propiedadSeleccionadaTres()
    {
        $this->obtenerValoresTres();
    }

    public function obtenerValoresCuatro()
    {
        // Verificar que se haya seleccionado una propiedad
        if (!empty($this->propiedad_politica_cuatro)) {
            // Obtener los valores únicos de la propiedad uno de operación, omitiendo los nulos y ordenándolos alfabéticamente
            $this->valores_cuatro = Operacion::whereNotNull($this->propiedad_politica_cuatro)
                ->orderBy($this->propiedad_politica_cuatro)
                ->distinct()
                ->pluck($this->propiedad_politica_cuatro);
        } 
    }

    public function propiedadSeleccionadaCuatro()
    {
        $this->obtenerValoresCuatro();
    }

    public function siguientePasoUno()
    {
        $this->validate([
            'propiedad_politica_uno'=> 'required',
            'valor_propiedad_uno'=> 'required',
            'politica_posible_uno'=> 'required'
        ]);

        if($this->politica_posible_uno == 1){
            $this->paso ++;
        } else {
            $this->paso = 0;
            $this->valoresQuitaCuota = true;
        }
    }

    public function siguientePasoDos()
    {
        $this->validate([
            'propiedad_politica_dos'=> 'required',
            'valor_propiedad_dos'=> 'required',
            'politica_posible_dos'=> 'required'
        ]);

        if($this->politica_posible_dos == 1){
            $this->paso ++;
        } else {
            $this->paso = 0;
            $this->valoresQuitaCuota = true;
        }
    }

    public function siguientePasoTres()
    {
        $this->validate([
            'propiedad_politica_tres'=> 'required',
            'valor_propiedad_tres'=> 'required',
            'politica_posible_tres'=> 'required'
        ]);

        if($this->politica_posible_tres == 1){
            $this->paso ++;
        } else {
            $this->paso = 0;
            $this->valoresQuitaCuota = true;
        }
    }

    public function valoresQuitaCuota()
    { 
        $this->validate([
            'propiedad_politica_cuatro'=> 'required',
            'valor_propiedad_cuatro'=> 'required'
        ]);
        $this->valoresQuitaCuota = true;
        $this->paso = 0;
    }

    public function pasoAnterior()
    {
        $this->paso --;
    }

    public function anteriorValoresQuitaCuota()
    {
        if($this->propiedad_politica_cuatro) {
            $this->paso = 4;
            $this-> valoresQuitaCuota = false;
        } elseif(!$this->propiedad_politica_cuatro && $this->propiedad_politica_tres) {
            $this->paso = 3;
            $this-> valoresQuitaCuota = false;
        } elseif(!$this->propiedad_politica_cuatro && !$this->propiedad_politica_tres && $this->propiedad_politica_dos) {
            $this->paso = 2;
            $this-> valoresQuitaCuota = false;
        } else {
            $this->paso = 1;
            $this-> valoresQuitaCuota = false;
        }
    }

    public function resumen()
    {
        $this->validate([
            'valor_quita'=> 'required',
            'valor_cuota'=> 'required'
        ]);
        $this-> valoresQuitaCuota = false;
        $this-> resumen = true;
    }

    public function volverValoresQuitaCuota()
    {
        $this-> valoresQuitaCuota = true;
        $this-> resumen = false;
    }

    public function guardarPolitica()
    {
        $politica = new Politica();

        $politica->producto_id = $this->producto->id;
        $politica->propiedad_politica_uno = $this->propiedad_politica_uno;
        $politica->valor_propiedad_uno = $this->valor_propiedad_uno;

        if ($this->propiedad_politica_dos) {
            $politica->propiedad_politica_dos = $this->propiedad_politica_dos;
            $politica->valor_propiedad_dos = $this->valor_propiedad_dos;
        }
        if ($this->propiedad_politica_tres) {
            $politica->propiedad_politica_tres = $this->propiedad_politica_tres;
            $politica->valor_propiedad_tres = $this->valor_propiedad_tres;
        }
        if ($this->propiedad_politica_cuatro) {
            $politica->propiedad_politica_cuatro = $this->propiedad_politica_cuatro;
            $politica->valor_propiedad_cuatro = $this->valor_propiedad_cuatro;
        }
        $politica->valor_quita = $this->valor_quita;
        $politica->valor_cuota = $this->valor_cuota;
        $politica->valor_quita_descuento = $this->valor_quita_descuento;
        $politica->valor_cuota_descuento = $this->valor_cuota_descuento;
        $politica->estado = 1;
        $politica->usuario_ultima_modificacion_id = auth()->id();
        $politica->save();
        return redirect()->route('perfil.producto', ['producto'=>$this->producto->id])->with('message', 'Política generada correctamente');
    }

    public function render()
    {
        return view('livewire.productos.generar-politica');
    }
}
