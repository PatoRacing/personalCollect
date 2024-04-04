<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PropuestaParaCuotasVariables extends Component
{
    //Variables de livewire principal
    public $operacion;
    public $limiteCuotas;
    //Variables a guardar
    public $monto_ofrecido;
    public $anticipo;
    public $cantidad_de_cuotas_uno;
    public $cantidad_de_cuotas_dos;
    public $cantidad_de_cuotas_tres;
    public $total_acp;
    public $honorarios;
    public $monto_de_cuotas_uno;
    public $monto_de_cuotas_dos;
    public $monto_de_cuotas_tres;
    public $accion;
    public $vencimiento;
    public $observaciones;
    public $fecha_pago_anticipo;
    public $fecha_pago_cuota;
    //Varaible Auxiliar
    public $porcentaje_grupo_uno;
    public $porcentaje_grupo_dos;
    public $porcentaje_grupo_tres;
    public $minimoAPagar;
    public $monto_grupo_uno;
    public $monto_grupo_dos;
    public $monto_grupo_tres;
    //Ventanas emergentes
    public $formulario = true;
    public $montoYCuotasNoPermitidas;
    public $montoNoPermitido;
    public $cuotasNoPermitidas;
    public $negociacionPermitida;
    public $negociacion;
    public $propuesta;

    protected $rules = [
        'monto_ofrecido'=> 'required|numeric',
        'anticipo'=> 'required|numeric|lt:monto_ofrecido',
        'cantidad_de_cuotas_uno'=> 'required|numeric|integer',
        'cantidad_de_cuotas_dos'=> 'required|numeric|integer',
        'cantidad_de_cuotas_tres'=> 'required|numeric|integer',
        'porcentaje_grupo_uno'=> 'required|numeric|integer',
        'porcentaje_grupo_dos'=> 'required|numeric|integer',
        'porcentaje_grupo_tres'=> 'required|numeric|integer',
    ];

    public function messages()
    {
        return [
            'anticipo.lt' => 'El :attribute no puede superar el monto ofrecido'
        ];
    }

    public function calcularCuotasVariables()
    {
        $datos = $this->validate();
        //Validar que los porcentajes sumen 100
        $sumaPorcentajes = $datos['porcentaje_grupo_uno'] + $datos['porcentaje_grupo_dos'] + $datos['porcentaje_grupo_tres'];
        if ($sumaPorcentajes !== 100) {
            $this->addError('porcentaje_grupo_uno', 'La suma de porcentajes debe ser igual a 100');
            $this->addError('porcentaje_grupo_dos', 'La suma de porcentajes debe ser igual a 100');
            $this->addError('porcentaje_grupo_tres', 'La suma de porcentajes debe ser igual a 100');
            return;
        }
        //Obtengo la deuda capital
        $deudaCapital = $this->operacion->deuda_capital;
        //Calculo el minimo a pagar (capital + honorarios)
        $this->minimoAPagar = $deudaCapital + ($deudaCapital * ($this->operacion->productoId->honorarios / 100));
        //Obtengo el ACP = monto ofrecido - los honorarios
        $this->total_acp = $this->monto_ofrecido / (1 + ($this->operacion->productoId->honorarios / 100));
        //Calculo los honorarios
        $this->honorarios = $this->monto_ofrecido - $this->total_acp;
        //Le descuento el anticipo al monto ofrecido
        $montoSinAnticipo = $this->monto_ofrecido - $this->anticipo;
        //Calculo monto de cada cuota para el grupo 1
        $this->monto_grupo_uno = ($montoSinAnticipo *  $this->porcentaje_grupo_uno) / 100;
        $this->monto_de_cuotas_uno = $this->monto_grupo_uno /  $this->cantidad_de_cuotas_uno;
        //Calculo monto de cada cuota para el grupo 2
        $this->monto_grupo_dos = ($montoSinAnticipo *  $this->porcentaje_grupo_dos) / 100;
        $this->monto_de_cuotas_dos = $this->monto_grupo_dos /  $this->cantidad_de_cuotas_dos;
        //Si existe, calculo monto de cada cuota para el grupo 3
        if($this->porcentaje_grupo_tres && $this->cantidad_de_cuotas_tres) {
            $this->monto_grupo_tres = ($montoSinAnticipo *  $this->porcentaje_grupo_tres) / 100;
            $this->monto_de_cuotas_tres = $this->monto_grupo_tres /  $this->cantidad_de_cuotas_tres;
        } else {
            $this->monto_grupo_tres = null;
            $this->monto_de_cuotas_tres = null;
        }
        $cantidadDeCuotas = $this->cantidad_de_cuotas_uno + $this->cantidad_de_cuotas_dos + $this->cantidad_de_cuotas_tres;
        if($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotas < $cantidadDeCuotas)
        {
            //Monto no permitido y cuotas no permitidas
            $this->formulario = false;
            $this->montoYCuotasNoPermitidas = true;
        }
        elseif($this->monto_ofrecido > $this->minimoAPagar && $this->limiteCuotas < $cantidadDeCuotas)
        {
            //Monto permitido y cuotas no permitidas
            $this->formulario = false;
            $this->cuotasNoPermitidas = true;            
        }
        elseif($this->monto_ofrecido < $this->minimoAPagar && $this->limiteCuotas >= $cantidadDeCuotas)
        {
            //Monto permitido y cuotas no permitidas
            $this->formulario = false;
            $this->montoNoPermitido = true;
        }
        elseif($this->monto_ofrecido > $this->minimoAPagar && $this->limiteCuotas >= $cantidadDeCuotas)
        {
            //Monto permitido y cuotas no permitidas
            $this->formulario = false;
            $this->negociacionPermitida = true;
        }
    }

    public function cancelarPropuesta()
    {
        $this->monto_ofrecido = null;
        $this->anticipo = null;
        $this->cantidad_de_cuotas_uno = null;
        $this->cantidad_de_cuotas_dos = null;
        $this->cantidad_de_cuotas_tres = null;
        $this->porcentaje_grupo_uno = null;
        $this->porcentaje_grupo_dos = null;
        $this->porcentaje_grupo_tres = null;
        $this->formulario = true;
        $this->montoYCuotasNoPermitidas = false;
        $this->montoNoPermitido = false;
        $this->cuotasNoPermitidas = false;
        $this->negociacionPermitida = false;
    }

    public function negociacion()
    {
        $this->negociacion = true;
        $this->propuesta = false;
    }

    public function guardarNegociacion()
    {
        $reglasSegundoFormulario = [
            'accion' => 'required',
            'vencimiento' => 'required|date',
            'observaciones' => 'required|max:255'
        ];
        $this->validate($reglasSegundoFormulario);

        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_ofrecido;
        $propuesta->tipo_de_propuesta = 4;
        if($this->anticipo == 0) {
            $propuesta->anticipo='';
        } else {
            $propuesta->anticipo = $this->anticipo;
        }
        $propuesta->cantidad_de_cuotas_uno = $this->cantidad_de_cuotas_uno;
        $propuesta->monto_de_cuotas_uno = $this->monto_de_cuotas_uno;
        $propuesta->cantidad_de_cuotas_dos = $this->cantidad_de_cuotas_dos;
        $propuesta->monto_de_cuotas_dos = $this->monto_de_cuotas_dos;
        if($this->cantidad_de_cuotas_tres == 0) {
            $propuesta->cantidad_de_cuotas_tres = null;
        } else {
            $propuesta->cantidad_de_cuotas_tres = $this->cantidad_de_cuotas_tres;
        }
        if($this->monto_de_cuotas_tres == 0) {
            $propuesta->monto_de_cuotas_tres = null;
        } else {
            $propuesta->monto_de_cuotas_tres = $this->monto_de_cuotas_tres;
        }        
        $propuesta->total_acp = $this->total_acp;
        $propuesta->honorarios = $this->honorarios;
        $propuesta->vencimiento = $this->vencimiento;
        $propuesta->accion = $this->accion;
        $propuesta->estado = 'Negociación';
        $propuesta->observaciones = $this->observaciones;
        $propuesta->usuario_ultima_modificacion_id = auth()->id();  
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Gestión generada correctamente');
    }

    public function propuesta()
    {
        $this->propuesta = true;
        $this->negociacion = false;
    }

    public function guardarPropuesta()
    {
        $reglasSegundoFormulario = [
            'accion' => 'required',
            'fecha_pago_cuota' => 'required|date',
            'observaciones' => 'required|max:255'
        ];
        if ($this->anticipo > 0) {
            $reglasSegundoFormulario['fecha_pago_anticipo'] = 'required|date';
        }    
        
        $this->validate($reglasSegundoFormulario);

        $propuesta = new Propuesta();
        $propuesta->deudor_id = $this->operacion->deudor_id;
        $propuesta->operacion_id = $this->operacion->id;
        $propuesta->monto_ofrecido = $this->monto_ofrecido;
        $propuesta->tipo_de_propuesta = 4;
        if($this->anticipo == 0 || $this->anticipo === '') {
            $propuesta->anticipo = null; 
        } else {
            $propuesta->anticipo = $this->anticipo; 
        }
        if($this->anticipo == 0 || $this->anticipo === '') {
            $propuesta->fecha_pago_anticipo = null; 
        } else {
            $propuesta->fecha_pago_anticipo = $this->fecha_pago_anticipo; 
        }
        $propuesta->cantidad_de_cuotas_uno = $this->cantidad_de_cuotas_uno;
        $propuesta->monto_de_cuotas_uno = $this->monto_de_cuotas_uno;
        $propuesta->fecha_pago_cuota = $this->fecha_pago_cuota;
        $propuesta->cantidad_de_cuotas_dos = $this->cantidad_de_cuotas_dos;
        $propuesta->monto_de_cuotas_dos = $this->monto_de_cuotas_dos;
        if($this->cantidad_de_cuotas_tres == 0 || $this->cantidad_de_cuotas_tres === '') {
            $propuesta->cantidad_de_cuotas_tres = null; 
        } else {
            $propuesta->cantidad_de_cuotas_tres = $this->cantidad_de_cuotas_tres; 
        }
        if($this->monto_de_cuotas_tres == 0 || $this->monto_de_cuotas_tres === '') {
            $propuesta->monto_de_cuotas_tres = null; 
        } else {
            $propuesta->monto_de_cuotas_tres = $this->monto_de_cuotas_tres; 
        }
        $propuesta->total_acp = $this->total_acp;
        $propuesta->honorarios = $this->honorarios;
        $propuesta->accion = $this->accion;
        $propuesta->estado = 'Propuesta de Pago';
        $propuesta->observaciones = $this->observaciones;
        $propuesta->usuario_ultima_modificacion_id = auth()->id();      
        $propuesta->save();
        return redirect()->route('propuesta', ['operacion' => $this->operacion->id])->with('message', 'Propuesta generada correctamente');
    }

    public function render()
    {
        return view('livewire.propuesta-para-cuotas-variables', [
            'minimoAPagar' => $this->minimoAPagar,
            'limiteCuotas' => $this->limiteCuotas,
            'monto_ofrecido' => $this->monto_ofrecido,
            'cantidad_de_cuotas_uno' => $this->cantidad_de_cuotas_uno,
            'monto_de_cuotas_uno' => $this->monto_de_cuotas_uno,
            'cantidad_de_cuotas_dos' => $this->cantidad_de_cuotas_dos,
            'monto_de_cuotas_dos' => $this->monto_de_cuotas_dos,
            'cantidad_de_cuotas_tres' => $this->cantidad_de_cuotas_tres,
            'monto_de_cuotas_tres' => $this->monto_de_cuotas_tres,
        ]);
    }
}
