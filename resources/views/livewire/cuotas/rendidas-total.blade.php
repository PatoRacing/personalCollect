<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="5">
    @if($cuotasRendidasTotal->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasRendidasTotal as $cuotaRendidaTotal)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-green-600 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaRendidaTotal->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaRendidaTotal"
                        :cuotaId="$cuotaRendidaTotal->id"
                        :cliente="$cuotaRendidaTotal->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaRendidaTotal->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaRendidaTotal->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaRendidaTotal->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaRendidaTotal->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaRendidaTotal->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaRendidaTotal->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaRendidaTotal->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaRendidaTotal->monto_acordado"
                        :vencimientoCta="$cuotaRendidaTotal->vencimiento_cuota"
                        :nroCuota="$cuotaRendidaTotal->nro_cuota"
                        :conceptoCuota="$cuotaRendidaTotal->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas rendidas en su totalidad
        </p>
    @endif
    @if($cuotasRendidasTotalTotales >= 30)
        <div class="p-2">
            {{$cuotasRendidasTotales->links('')}}
        </div>
    @endif
</div>
