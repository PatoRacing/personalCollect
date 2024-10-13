<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="2">
    @if($cuotasObservadas->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasObservadas as $cuotaObservada)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-red-600 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaObservada->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaObservada"
                        :cuotaId="$cuotaObservada->id"
                        :cliente="$cuotaObservada->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaObservada->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaObservada->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaObservada->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaObservada->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaObservada->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaObservada->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaObservada->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaObservada->monto_acordado"
                        :vencimientoCta="$cuotaObservada->vencimiento_cuota"
                        :nroCuota="$cuotaObservada->nro_cuota"
                        :conceptoCuota="$cuotaObservada->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas observadas
        </p>
    @endif
    @if($cuotasObservadasTotales >= 30)
        <div class="p-2">
            {{$cuotasObservadas->links('')}}
        </div>
    @endif
</div>