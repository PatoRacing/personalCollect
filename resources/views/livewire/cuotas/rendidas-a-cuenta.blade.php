<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="7">
    @if($cuotasRendidasACuenta->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasRendidasACuenta as $cuotaRendidaACuenta)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-orange-500 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaRendidaACuenta->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaRendidaACuenta"
                        :cuotaId="$cuotaRendidaACuenta->id"
                        :cliente="$cuotaRendidaACuenta->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaRendidaACuenta->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaRendidaACuenta->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaRendidaACuenta->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaRendidaACuenta->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaRendidaACuenta->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaRendidaACuenta->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaRendidaACuenta->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaRendidaACuenta->monto_acordado"
                        :vencimientoCta="$cuotaRendidaACuenta->vencimiento_cuota"
                        :nroCuota="$cuotaRendidaACuenta->nro_cuota"
                        :conceptoCuota="$cuotaRendidaACuenta->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas rendidas a cuenta
        </p>
    @endif
    @if($cuotasRendidasACuentaTotales >= 30)
        <div class="p-2">
            {{$cuotasRendidasACuentaTotales->links('')}}
        </div>
    @endif
</div>
