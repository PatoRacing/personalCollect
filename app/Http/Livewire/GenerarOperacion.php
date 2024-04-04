<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Deudor;
use App\Models\Operacion;
use App\Models\Producto;
use App\Models\Telefono;
use DateTime;
use Livewire\Component;

class GenerarOperacion extends Component
{
    public $nombre;
    public $tipo_doc;
    public $nro_doc;
    public $cuil;
    public $domicilio;
    public $localidad;
    public $codigo_postal;
    public $tipo;
    public $contacto;
    public $numero;
    public $clientes;
    public $cliente_id;
    public $productos = [];
    public $producto_id;
    public $segmento;
    public $operacion;
    public $sucursal;
    public $dias_atraso;
    public $deuda_capital;
    public $deuda_total;
    public $estado;
    public $ciclo;
    public $fecha_asignacion;
    public $sub_producto;
    public $compensatorio;
    public $punitivos;
    public $paso = 1;
    public $deudorNuevo = 0;
    public $telefonoNuevo = 0;
    public $operacionNueva = 0;
    public $operacionActualizada = 0;

    //Funciones para pasar al siguiente paso del formulario y validacion de campos obligatorios
    public function siguientePasoUno()
    {
        $this->validate([
            'nro_doc'=> 'required'
        ]);
        $this->paso ++;
    }

    public function siguientePasoDos()
    {
        $this->paso ++;
    }

    public function siguientePasoTres()
    {
        $this->validate([
            'cliente_id'=> 'required',
            'producto_id'=> 'required',
            'operacion'=> 'required'
        ]);
        $this->paso ++;
    }

    public function siguientePasoCuatro()
    {
        $fecha_asignacion = new DateTime($this->fecha_asignacion);
        $this->validate([
            'deuda_capital'=> 'required',
            'fecha_asignacion' => 'after_or_equal:1970-01-01'
        ]);
        $this->paso ++;
    }

    //Funcion para pasar al paso anterior al actual
    public function anterior()
    {
        $this->paso --;
    }

    //Función para obtener el listado de productos que corresponde al cliente seleccionado
    public function obtenerProductos()
    {
       $this->productos = Producto::where('cliente_id', $this->cliente_id)->get();
    }

    //Funcion para obtener el cliente seleccionado del formulario
    public function clienteSeleccionado()
    {
        $this->obtenerProductos();
    }

    public function nombreCliente()
    {
        $cliente = Cliente::find($this->cliente_id);
        return $cliente ? $cliente->nombre : '';
    }

    public function nombreProducto()
    {
        $producto = Producto::find($this->producto_id);
        return $producto ? $producto->nombre : '';
    }

    public function guardarNuevaOperacion()
    {
        //Revisamos si existe el deudor. Si no existe creamos uno nuevo
        $deudor = Deudor::where('nro_doc', $this->nro_doc)->first();
        if(!$deudor) {
            Deudor::create([
                'nombre'=> $this->nombre,
                'tipo_doc'=>$this->tipo_doc,
                'nro_doc'=>$this->nro_doc,
                'cuil'=>$this->cuil,
                'domicilio'=>$this->domicilio,
                'localidad'=>$this->localidad,
                'codigo_postal'=>$this->codigo_postal,
                'usuario_ultima_modificacion_id'=>auth()->id(),
            ]);
            $this->deudorNuevo++;
        }

        //Obtenemos todos los telefonos de deudor.
        $deudor = Deudor::where('nro_doc', $this->nro_doc)->first();
        $telefonos = Telefono::where('deudor_id', $deudor->id)->pluck('numero');
        //Si no tiene registros de telefonos se almacena uno nuevo
        if($this->numero) {
            if($telefonos->count() === 0) {
                Telefono::create([
                    'deudor_id'=>$deudor->id,
                    'tipo'=>$this->tipo,
                    'contacto'=>$this->contacto,
                    'numero'=>$this->numero,
                    'estado'=> 2,
                    'usuario_ultima_modificacion_id'=>auth()->id(),
                ]);
                $this->telefonoNuevo++;
            } else {
                //Si  tiene registros de telefonos pero el nuevo es diferente al que esta almacenado crea un nuevo telefono
                if(!$telefonos->contains($this->numero)) {
                    Telefono::create([
                        'deudor_id'=>$deudor->id,
                        'tipo'=>$this->tipo,
                        'contacto'=>$this->contacto,
                        'numero'=>$this->numero,
                        'estado'=> 2,
                        'usuario_ultima_modificacion_id'=>auth()->id(),
                    ]);
                }
                $this->telefonoNuevo++;
            }
        }

        $operacion = Operacion::where('operacion', $this->operacion)->first();
        if (!$operacion) {
            //Si no hay operación se crea una nueva
            Operacion::create ([
                'segmento'=>$this->segmento,
                'producto_id'=>$this->producto_id,
                'operacion'=>$this->operacion,
                'nro_doc'=>$this->nro_doc,
                'sucursal'=>$this->sucursal,
                'dias_atraso'=>$this->dias_atraso,
                'deuda_total'=>$this->deuda_total,
                'deuda_capital'=>$this->deuda_capital,
                'estado'=>$this->estado,
                'fecha_asignacion'=>$this->fecha_asignacion,
                'ciclo'=>$this->ciclo,
                'sub_producto'=>$this->sub_producto,
                'compensatorio'=>$this->compensatorio,
                'punitivos'=>$this->punitivos,
                'situacion'=> 1,
                'cliente_id'=>$this->cliente_id,
                'deudor_id'=>$deudor->id,
                'usuario_asignado_id'=>100,
                'usuario_ultima_modificacion_id' => auth()->user()->id
                ]);
                $this->operacionNueva++;
        } else {
            //Si hay operacion se actualiza
            $operacion->update([
                'segmento'=>$this->segmento,
                'producto_id'=>$this->producto_id,
                'nro_doc'=>$this->nro_doc,
                'sucursal'=>$this->sucursal,
                'dias_atraso'=>$this->dias_atraso,
                'deuda_total'=>$this->deuda_total,
                'deuda_capital'=>$this->deuda_capital,
                'estado'=>$this->estado,
                'fecha_asignacion'=>$this->fecha_asignacion,
                'ciclo'=>$this->ciclo,
                'sub_producto'=>$this->sub_producto,
                'compensatorio'=>$this->compensatorio,
                'punitivos'=>$this->punitivos,
                'situacion'=> 1,
                'cliente_id'=>$this->cliente_id,
                'deudor_id'=>$deudor->id,
                'usuario_ultima_modificacion_id' => auth()->user()->id
            ]);
            $this->operacionActualizada++;
        }

        $mensajes = [];

        //Mensaje de Nuevo Deudor
        if ($this->deudorNuevo === 1) {
            $mensajes[] = "Se creo un nuevo deudor";
        } else {
            $mensajes[] = "No se creo deudor porque ya existía en la BD";
        }

        //Mensaje de Nuevo Telefono
        if ($this->telefonoNuevo === 1) {
            $mensajes[] = "Se creo un nuevo telefono";
        } else {
            $mensajes[] = "No se creó telefono (ya existía en la BD o no se ingresaron valores)";
        }

        //Mensaje de Nuevo Telefono
        if ($this->operacionActualizada === 1) {
            $mensajes[] = "Se actualizaron los valores de una operación existente en la BD.";
        } elseif($this->operacionNueva === 1) {
            $mensajes[] = "Se creo creo una nueva operación";
        }

        return redirect()->route('perfil.cliente', ['cliente' => $this->cliente_id])->with('message', implode('<br>', $mensajes));
    }

    public function render()
    {

        return view('livewire.generar-operacion',[
            'nombre'=> $this->nombre,
            'tipo_doc'=>$this->tipo_doc,
            'nro_doc'=>$this->nro_doc,
            'cuil'=>$this->cuil,
            'domicilio'=>$this->domicilio,
            'localidad'=>$this->localidad,
            'codigo_postal'=>$this->codigo_postal,
            'tipo'=>$this->tipo,
            'contacto'=>$this->contacto,
            'numero'=>$this->numero,
            'cliente_id'=>$this->cliente_id,
            'producto_id'=>$this->producto_id,
            'segmento'=>$this->segmento,
            'operacion'=>$this->operacion,
            'sucursal'=>$this->sucursal,
            'dias_atraso'=>$this->dias_atraso,
            'deuda_capital'=>$this->deuda_capital,
            'deuda_total'=>$this->deuda_total,
            'estado'=>$this->estado,
            'ciclo'=>$this->ciclo,
            'fecha_asignacion'=>$this->fecha_asignacion,
            'sub_producto'=>$this->sub_producto,
            'compensatorio'=>$this->compensatorio,
            'punitivos'=>$this->punitivos,
        ]);
    }
}
