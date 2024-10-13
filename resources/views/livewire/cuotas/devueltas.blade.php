<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="8">
    @if($cuotasDevueltas->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasDevueltas as $cuotaDevuelta)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-gray-600 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaDevuelta->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaDevuelta"
                        :cuotaId="$cuotaDevuelta->id"
                        :cliente="$cuotaDevuelta->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaDevuelta->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaDevuelta->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaDevuelta->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaDevuelta->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaDevuelta->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaDevuelta->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaDevuelta->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaDevuelta->monto_acordado"
                        :vencimientoCta="$cuotaDevuelta->vencimiento_cuota"
                        :nroCuota="$cuotaDevuelta->nro_cuota"
                        :conceptoCuota="$cuotaDevuelta->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas devueltas
        </p>
    @endif
    @if($cuotasDevueltasTotales >= 30)
        <div class="p-2">
            {{$cuotasDevueltasTotales->links('')}}
        </div>
    @endif
</div>