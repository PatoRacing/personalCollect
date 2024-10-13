<?php

namespace App\Http\Livewire;

use App\Models\GestionCuota;
use App\Models\Pago;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class HistorialGestionesCuota extends Component
{
    public $pago;
    public $gestionCuotaSeleccionada;
    //Campos formulario
    public $fecha_de_pago;
    public $monto_abonado;
    public $situacion;
    public $gestion_id;
    public $monto_a_rendir;
    public $proforma;
    public $fecha_rendicion;
    //Modales
    public $modalActualizarGestion = false;
    public $modalActualizarEstado = false;
    public $modalElimminarGestion = false;
    public $modalActualizarRendicion = false;
    public $modalEliminarRendicion = false;
    //Alertas
    public $alertaMensaje = false;
    public $alertaActualizado = false;
    public $alertaEstadoActualizado = false;
    public $alertaGestionEliminada = false;

    protected $listeners = ['pagoInformado', 'pagoRendido'=>'actualizarVista', 'BorrarAlertasDeGestiones'=>'quitarAlertas'];
    
    //funcion para eliminar las alertas previas
    public function quitarAlertas()
    {
        $this->alertaMensaje = false;
        $this->alertaActualizado = false;
        $this->alertaEstadoActualizado = false;
        $this->alertaGestionEliminada = false;
    }    
    //funcion para actualizar la vista
    public function actualizarVista()
    {
        $this->alertaMensaje = false;
        $this->alertaActualizado = false;
        $this->alertaEstadoActualizado = false;
        $this->alertaGestionEliminada = false;
        $this->render();
    }    
    //escuchar evento pagoinformado
    public function mount()
    {
        if (session()->has('pagoInformado')) {
            $this->alertaMensaje = true;
        }
    }

    //Funciones para editar las gestiones informadas
    public function mostrarModalActualizarGestion($gestionCuotaId)
    {
        $this->modalActualizarGestion = true;
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $this->gestionCuotaSeleccionada = $gestionCuota;
        $this->fecha_de_pago = $gestionCuota->fecha_de_pago;
        $this->monto_abonado = $gestionCuota->monto_abonado;
        $this->situacion = $gestionCuota->situacion;
    }
    public function actualizarGestion()
    {
        $this->validate([
            'fecha_de_pago'=> 'required|date',
            'monto_abonado'=> 'required',
            'situacion'=> 'required',
        ]);
        //Si la opcion elegida es informado (1)
        if($this->situacion == 1) {
            //Se actualiza la gestion de pago con la nueva informacion
            $this->gestionCuotaSeleccionada->update([
                'fecha_de_pago' => $this->fecha_de_pago,
                'monto_abonado' => $this->monto_abonado,
                'situacion' => $this->situacion, //1- Pago Informado
                'usuario_ultima_modificacion_id' => auth()->id()
            ]);
            //Se actualiza la cuota con la nueva informacion (cuota vigente)
            $this->pago->estado = 1; //
            $this->pago->usuario_ultima_modificacion_id = auth()->id();
            $this->pago->save();
        } 
        //Si la opcion elegida es rechazado (5)
        else {
            //Se actualiza la gestion de pago con la nueva informacion
            $this->gestionCuotaSeleccionada->update([
                'fecha_de_pago' => $this->fecha_de_pago,
                'monto_abonado' => $this->monto_abonado,
                'situacion' => $this->situacion, //5- Pago Rechazado
                'usuario_ultima_modificacion_id' => auth()->id()
            ]);
            //Se actualiza la cuota con la nueva informacion (cuota observada)
            $this->pago->estado = 5; //Cuota observada
            $this->pago->usuario_ultima_modificacion_id = auth()->id();
            $this->pago->save();
        }
        $this->modalActualizarGestion = false;
        $this->alertaMensaje = false;
        $this->alertaActualizado = true;
        $this->alertaEstadoActualizado = false;
        $this->alertaGestionEliminada = false;
        $this->emit('PagoInformado');
        $this->emit('AlertasDeGestiones');
    }
    public function cerrarModalActualizarGestion()
    {
        $this->modalActualizarGestion = false;
        $this->reset('fecha_de_pago', 'monto_abonado');
    }


    //Funciones para cambiar de informado a aplicado o viceversa
    public function mostrarModalCambiarEstado($gestionCuotaId)
    {
        $this->modalActualizarEstado = true;
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $this->gestionCuotaSeleccionada = $gestionCuota;
    }
    public function confirmarCambiarEstado()
    {
        //Si la cuota es un anticipo
        if($this->pago->concepto_cuota == 'Anticipo') {
            dd('es un anticipo');
        }
        //Si la cuota es una cuota
        elseif($this->pago->concepto_cuota == 'Cuota') {
            dd('es una cuota');
        }
        //Si la cuota es una cancelacion
        elseif($this->pago->concepto_cuota == 'Cancelación') {
            dd('es una cancelacion');
        }
        
    }
    public function cerrarModalActualizarEstado()
    {
        $this->modalActualizarEstado = false;
    }


    //Funciónes para eliminar gestion (informado o aplicado)
    public function mostrarModalEliminarGestion($gestionCuotaId)
    {
        $this->modalElimminarGestion = true;
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $this->gestionCuotaSeleccionada = $gestionCuota;
    }
    public function confirmarEliminarGestion($gestionCuotaId)
    {
        //Si la gestion del pago es un informe (1)
        if($this->gestionCuotaSeleccionada->situacion == 1) {
            $gestionCuota = GestionCuota::find($gestionCuotaId);
            if ($gestionCuota->comprobante) {
                Storage::delete('public/comprobantes/' . $gestionCuota->comprobante);
            }
            $gestionCuota->delete();
            $this->modalElimminarGestion = false;
            $this->alertaGestionEliminada = true;
            $this->alertaActualizado = false;
            $this->alertaEstadoActualizado = false;
            $this->emit('PagoInformado');
            return redirect()->to(request()->header('Referer'));
        }
        //Si la gestion del pago no es informe
        else {
            //Obtengo todas las gestiones previas de la cuota
            $gestionesPrevias = GestionCuota::where('pago_id', $this->pago->id)->get();
            //Si no hay gestiones previas elimino la gestion y cambio el estado de la cuota vuelve a su inicio 1 (vigente)
            if(!$gestionesPrevias) {
                $gestionCuota = GestionCuota::find($gestionCuotaId);
                if ($gestionCuota->comprobante) {
                    Storage::delete('public/comprobantes/' . $gestionCuota->comprobante);
                }
                $this->pago->estado = 1;
                $this->pago->usuario_ultima_modificacion_id = auth()->id();
                $this->pago->save();
                $this->modalElimminarGestion = false;
                $this->alertaGestionEliminada = true;
                $this->alertaActualizado = false;
                $this->alertaEstadoActualizado = false;
                $this->emit('PagoInformado');
                return redirect()->to(request()->header('Referer'));
            }
            //Si hay gestiones previas
            else {
                //Si la cuota es un anticipo o una cancelacion
                if($this->pago->concepto_cuota == 'Anticipo' || $this->pago->concepto_cuota == 'Cancelación') {
                    //Elimino la gestion
                    $gestionCuota = GestionCuota::find($gestionCuotaId);
                    if ($gestionCuota->comprobante) {
                        Storage::delete('public/comprobantes/' . $gestionCuota->comprobante);
                    }
                    //itero sobre las gestiones previas
                    foreach($gestionesPrevias as $gestionPrevia) {
                        //Si las gestiones previas no son informe (1) ni observada (4) ni rechazada (5) las actualizo
                        if($gestionPrevia->situacion != 1 || $gestionPrevia->situacion != 5 || $gestionPrevia->situacion != 4) {
                            $gestionPrevia->situacion = 4;//Pago Observado
                            $gestionPrevia->usuario_ultima_modificacion_id = auth()->id();
                            $gestionPrevia->save();
                        }
                    }
                    //Actualizo el estado de la cuota a observada (no cubre el monto total)
                    $this->pago->estado = 5; //Cuota Observada
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    $this->modalElimminarGestion = false;
                    $this->alertaGestionEliminada = true;
                    $this->alertaActualizado = false;
                    $this->alertaEstadoActualizado = false;
                    $this->emit('PagoInformado');
                    return redirect()->to(request()->header('Referer'));
                }
                //Si la cuota es una cuota
                elseif($this->pago->concepto_cuota == 'Cuota') {
                    //Elimino la gestion
                    $gestionCuota = GestionCuota::find($gestionCuotaId);
                    if ($gestionCuota->comprobante) {
                        Storage::delete('public/comprobantes/' . $gestionCuota->comprobante);
                    }
                    //Itero sobre las gestiones previas
                    foreach($gestionesPrevias as $gestionPrevia) {

                    }
                    //Actualizo el estado de la cuota
                    $this->pago->estado = 2; //Pago Aplicado
                    $this->pago->usuario_ultima_modificacion_id = auth()->id();
                    $this->pago->save();
                    $this->modalElimminarGestion = false;
                    $this->alertaGestionEliminada = true;
                    $this->alertaActualizado = false;
                    $this->alertaEstadoActualizado = false;
                    $this->emit('PagoInformado');
                    return redirect()->to(request()->header('Referer'));
                }
            }
        }
    }
    public function cerrarModalEliminarGestion()
    {
        $this->modalElimminarGestion = false;
    }


    //Funciones para editar la rendicion (rendido)
    public function mostrarModalActualizarRendicion($gestionCuotaId)
    {
        $this->modalActualizarRendicion = true;
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $this->gestionCuotaSeleccionada = $gestionCuota;
        $this->gestion_id = $gestionCuota->id;
        $this->monto_a_rendir = $gestionCuota->monto_a_rendir;
        $this->proforma = $gestionCuota->proforma;
        $this->fecha_rendicion = $gestionCuota->fecha_rendicion;
    }
    public function actualizarRendicionRendida()
    {
        $this->validate([
            'proforma'=> 'required',
            'fecha_rendicion'=> 'required|date',
        ]);
        $this->gestionCuotaSeleccionada->proforma = $this->proforma;
        $this->gestionCuotaSeleccionada->fecha_rendicion = $this->fecha_rendicion;
        $this->gestionCuotaSeleccionada->usuario_ultima_modificacion_id = auth()->id();
        $this->gestionCuotaSeleccionada->save();
        $this->modalActualizarGestion = false;
        $this->alertaActualizado = true;
        $this->alertaEstadoActualizado = false;
        $this->alertaGestionEliminada = false;
        $this->modalActualizarRendicion = false;
        $this->emit('AlertasDeGestiones');
    }
    public function cerrarModalActualizarRendicion()
    {
        $this->modalActualizarRendicion = false;
    }


    //Funciones para  modal eliminar rendicion
    public function mostrarModalEliminarRendicion($gestionCuotaId)
    {
        $this->modalEliminarRendicion = true;
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $this->gestionCuotaSeleccionada = $gestionCuota;
    }
    public function confirmarEliminarRendicion($gestionCuotaId)
    {
        $gestionCuota = GestionCuota::find($gestionCuotaId);
        $gestionCuota->situacion = 2;
        $gestionCuota->monto_a_rendir = '';
        $gestionCuota->proforma = '';
        $gestionCuota->usuario_rendidor_id = null;
        $gestionCuota->fecha_rendicion = null;
        $gestionCuota->usuario_ultima_modificacion_id = auth()->id();
        $gestionCuota->save();
        $this->emit('PagoInformado');
        $this->emit('AlertasDeGestiones');
        $this->modalEliminarRendicion = false;
    }
    public function cerrarModalEliminarRendicion()
    {
        $this->modalEliminarRendicion = false;
    }

    public function render()
    {
        $gestionesCuota = GestionCuota::where('pago_id', $this->pago->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('livewire.pagos.historial-gestiones-cuota',[
            'gestionesCuota'=>$gestionesCuota,
        ]);
    }
}
