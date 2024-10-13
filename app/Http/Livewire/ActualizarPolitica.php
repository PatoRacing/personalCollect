<?php

namespace App\Http\Livewire;

use App\Models\Operacion;
use App\Models\Politica;
use Livewire\Component;

class ActualizarPolitica extends Component
{
    public $paso = 1;
    public $politica;
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

    public function mount(Politica $politica)
    {
        $this->propiedad_politica_uno = $politica->propiedad_politica_uno;
        $this->valor_propiedad_uno = $politica->valor_propiedad_uno;
        $this->obtenerValoresUno();
        $this->propiedad_politica_dos = $politica->propiedad_politica_dos;
        $this->valor_propiedad_dos = $politica->valor_propiedad_dos;
        $this->obtenerValoresDos();
        $this->propiedad_politica_tres = $politica->propiedad_politica_tres;
        $this->valor_propiedad_tres = $politica->valor_propiedad_tres;
        $this->obtenerValoresTres();
        $this->propiedad_politica_cuatro = $politica->propiedad_politica_cuatro;
        $this->valor_propiedad_cuatro = $politica->valor_propiedad_cuatro;
        $this->obtenerValoresCuatro();
        $this->valor_quita = $politica->valor_quita;
        $this->valor_cuota = $politica->valor_cuota;
        $this->valor_quita_descuento = $politica->valor_quita_descuento;
        $this->valor_cuota_descuento = $politica->valor_cuota_descuento;
    }

    public function limpiarPoliticasPosteriores()
    {
        if ($this->politica_posible_uno == 2) {
            $this->propiedad_politica_dos = null;
            $this->valor_propiedad_dos = null;
            $this->propiedad_politica_tres = null;
            $this->valor_propiedad_tres = null;
            $this->propiedad_politica_cuatro = null;
            $this->valor_propiedad_cuatro = null;
        }
        if ($this->politica_posible_dos == 2) {
            $this->propiedad_politica_tres = null;
            $this->valor_propiedad_tres = null;
            $this->propiedad_politica_cuatro = null;
            $this->valor_propiedad_cuatro = null;
        }
        if ($this->politica_posible_tres == 2) {
            $this->propiedad_politica_cuatro = null;
            $this->valor_propiedad_cuatro = null;
        }
    }

    public function actualizarPoliticaPosibleUno()
    {
        $this->limpiarPoliticasPosteriores();
    }

    public function actualizarPoliticaPosibleDos()
    {
        $this->limpiarPoliticasPosteriores();
    }

    public function actualizarPoliticaPosibleTres()
    {
        $this->limpiarPoliticasPosteriores();
    }

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
        $this->valores_uno = [];
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
        $this->valores_dos = [];
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
        $this->valores_tres = [];
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
        $this->valores_tres = [];
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
            $this->actualizarPoliticaPosibleUno();
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
            $this->actualizarPoliticaPosibleDos();
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
            $this->actualizarPoliticaPosibleTres();
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
            'valor_cuota'=> 'required',
        ]);
        $this-> valoresQuitaCuota = false;
        $this-> resumen = true;
    }

    public function volverValoresQuitaCuota()
    {
        $this-> valoresQuitaCuota = true;
        $this-> resumen = false;
    }

    public function actualizarPolitica()
    {
        $politica = Politica::find($this->politica->id);

        $politica->producto_id = $this->politica->producto_id;
        $politica->propiedad_politica_uno = $this->propiedad_politica_uno;
        $politica->valor_propiedad_uno = $this->valor_propiedad_uno;

        if ($this->propiedad_politica_dos) {
            $politica->propiedad_politica_dos = $this->propiedad_politica_dos;
            $politica->valor_propiedad_dos = $this->valor_propiedad_dos;
        } else {
            $politica->propiedad_politica_dos = null;
            $politica->valor_propiedad_dos = null;
        }

        if ($this->propiedad_politica_tres) {
            $politica->propiedad_politica_tres = $this->propiedad_politica_tres;
            $politica->valor_propiedad_tres = $this->valor_propiedad_tres;
        } else {
            $politica->propiedad_politica_tres = null;
            $politica->valor_propiedad_tres = null;
        }

        if ($this->propiedad_politica_cuatro) {
            $politica->propiedad_politica_cuatro = $this->propiedad_politica_cuatro;
            $politica->valor_propiedad_cuatro = $this->valor_propiedad_cuatro;
        } else {
            $politica->propiedad_politica_cuatro = null;
            $politica->valor_propiedad_cuatro = null;
        }

        $politica->valor_quita = $this->valor_quita;
        $politica->valor_cuota = $this->valor_cuota;
        $politica->valor_quita_descuento = $this->valor_quita_descuento;
        $politica->valor_cuota_descuento = $this->valor_cuota_descuento;
        $politica->estado = 1;
        $politica->usuario_ultima_modificacion_id = auth()->id();
        $politica->save();

        return redirect()->route('perfil.producto', ['producto' => $this->politica->producto_id])->with('message', 'Política actualizada correctamente');
    }

    public function render()
    {
        return view('livewire.productos.actualizar-politica');
    }
}
