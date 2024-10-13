<?php

namespace App\Http\Livewire\Gestiones;
use App\Http\Livewire\Gestiones\GlobalGestiones;
use App\Models\GestionCuota;
use App\Models\Pago;

class GestionAdministrador extends GlobalGestiones
{

    protected function procesarInformacionFormularioAdministrador($datosComunes, $cuota)
    {
        $pagosIncompletos = GestionCuota::where('pago_id', $cuota['id'])
                                                ->where('situacion', 5) // Pago incompleto
                                                ->get();
        if(!$pagosIncompletos->isEmpty())
        {
            $sumaDeIncompletos = $pagosIncompletos->sum('monto_abonado');
            //La suma del nuevo pago y los anteriores incompletos es menor a lo acordado
            if($sumaDeIncompletos + $datosComunes['monto_abonado'] <  $cuota['monto_acordado'])
            {
                $datosComunes['situacion'] = 5; // Pago Incompleto
                $nuevoPagoObservado = new GestionCuota($datosComunes);
                $nuevoPagoObservado->save();
                $cuotaId = $cuota['id'];
            }
            //La suma del nuevo pago y los anteriores incompletos es igual a lo acordado
            elseif($sumaDeIncompletos + $datosComunes['monto_abonado'] ==  $cuota['monto_acordado'])
            {
                $datosComunes['situacion'] = 6; // Pago completo
                $nuevoPagoCompleto = new GestionCuota($datosComunes);
                $nuevoPagoCompleto->save();
                foreach($pagosIncompletos as $pagoIncompleto)
                {
                    $pagoIncompleto->situacion = 6; //Pago Completo
                    $pagoIncompleto->save();
                }
                $cuotaId = $cuota['id'];
                $actualizarCuota = Pago::find($cuotaId);
                $actualizarCuota->estado = 3; // Cuota Aplicada
                $actualizarCuota->save();
                $datosComunes['monto_abonado'] = $cuota['monto_acordado'];
                $datosComunes['situacion'] = 3; //Pago Aplicado
                $nuevoPagoAplicado = new GestionCuota($datosComunes);
                $nuevoPagoAplicado->save();
            }
            //La suma del nuevo pago y los anteriores incompletos es mayor  a lo acordado
            elseif($sumaDeIncompletos + $datosComunes['monto_abonado'] >  $cuota['monto_acordado'])
            {
                $sobrante = $sumaDeIncompletos + $datosComunes['monto_abonado'] - $cuota['monto_acordado'];
                $datosComunes['situacion'] = 6; // Pago completo
                $datosComunes['monto_abonado'] = $cuota['monto_acordado'] - $sumaDeIncompletos; // El monto es lo que tenia qe pagar - lo que ya pago
                $nuevoPagoCompleto = new GestionCuota($datosComunes);
                $nuevoPagoCompleto->save();
                foreach($pagosIncompletos as $pagoIncompleto)
                {
                    $pagoIncompleto->situacion = 6; //Pago Completo
                    $pagoIncompleto->save();
                }
                $cuotaId = $cuota['id'];
                $actualizarCuota = Pago::find($cuotaId);
                $actualizarCuota->estado = 3; // Cuota Aplicada
                $actualizarCuota->save();
                //Se emite el evento para gestionar el sobrante
                $this->gestionarSobrante($sobrante, $datosComunes, $cuota);
                //Se crea el pago aplicado con mismo monto que lo acordado en la cuota
                $datosComunes['monto_abonado'] = $cuota['monto_acordado'];
                $datosComunes['situacion'] = 3; //Pago Aplicado
                $nuevoPagoAplicado = new GestionCuota($datosComunes);
                $nuevoPagoAplicado->save();
            }
        }
        else
        {
            //si el monto abonado es menor al monto acordado
            if($datosComunes['monto_abonado'] < $cuota['monto_acordado'])
            {
                //Si la cuota es una cancelacion se genera un Pago incompleto y la misma pasa a observada
                if($cuota['concepto_cuota'] === 'Cancelación')
                {
                    $datosComunes['situacion'] = 5; // Pago Incompleto
                    $nuevoPagoObservado = new GestionCuota($datosComunes);
                    $nuevoPagoObservado->save();
                    $cuotaId = $cuota['id'];
                    $actualizarCuota = Pago::find($cuotaId);
                    $actualizarCuota->estado = 2; // Cuota Observada
                    $actualizarCuota->save();
                }
                //Si la cuota no es cancelacion se genera un pago aplicado y la misma pasa a aplicada
                else
                {
                    $datosComunes['situacion'] = 3; // Pago aplicado
                    $nuevoPagoAplicado = new GestionCuota($datosComunes);
                    $nuevoPagoAplicado->save();
                    $cuotaId = $cuota['id'];
                    $actualizarCuota = Pago::find($cuotaId);
                    $actualizarCuota->estado = 3; // Cuota Aplicada
                    $actualizarCuota->save();
                }
            }
            // Si el monto abonado es igual a lo acordado
            elseif($datosComunes['monto_abonado'] === $cuota['monto_acordado'])
            //Se genera un pago aplicado y cualquier tipo de cuota pasa a aplicada
            {
                $datosComunes['situacion'] = 3; // Pago aplicado
                $nuevoPagoAplicado = new GestionCuota($datosComunes);
                $nuevoPagoAplicado->save();
                $cuotaId = $cuota['id'];
                $actualizarCuota = Pago::find($cuotaId);
                $actualizarCuota->estado = 3; // Cuota Aplicada
                $actualizarCuota->save();
            }
            // Si el monto abonado es mayor a lo acordado
            elseif($datosComunes['monto_abonado'] > $cuota['monto_acordado'])
            //Se genera un pago aplicado cuyo monto es el monto acordado y cualquier tipo de cuota pasa a aplicada
            {
                $sobrante = $datosComunes['monto_abonado'] - $cuota['monto_acordado'];
                $datosComunes['monto_abonado'] = $cuota['monto_acordado']; // Solo el monto acordado
                $datosComunes['situacion'] = 3; // Pago aplicado
                $nuevoPagoAplicado = new GestionCuota($datosComunes);
                $nuevoPagoAplicado->save();
                $cuotaId = $cuota['id'];
                $actualizarCuota = Pago::find($cuotaId);
                $actualizarCuota->estado = 3;  //Cuota Aplicada
                $actualizarCuota->save();
                //Se emite el evento para gestionar el sobrante
                $this->gestionarSobrante($sobrante, $datosComunes, $cuota);
            }
        }
    }
}