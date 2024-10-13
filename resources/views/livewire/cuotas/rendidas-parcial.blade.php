<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="4">
    @if($cuotasRendidasParcial->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasRendidasParcial as $cuotaRendidaParcial)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <p class="bg-cyan-600 mb-1 text-white uppercase py-1 text-center block">
                        {{$cuotaRendidaParcial->acuerdo->propuesta->deudorId->nombre}}
                    </p>
                    <x-detalle-cuota
                        :cuotaActual="$cuotaRendidaParcial"
                        :cuotaId="$cuotaRendidaParcial->id"
                        :cliente="$cuotaRendidaParcial->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaRendidaParcial->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaRendidaParcial->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaRendidaParcial->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaRendidaParcial->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaRendidaParcial->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaRendidaParcial->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaRendidaParcial->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaRendidaParcial->monto_acordado"
                        :vencimientoCta="$cuotaRendidaParcial->vencimiento_cuota"
                        :nroCuota="$cuotaRendidaParcial->nro_cuota"
                        :conceptoCuota="$cuotaRendidaParcial->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas rendidas parcialmente
        </p>
    @endif
    @if($cuotasRendidasParcialTotales >= 30)
        <div class="p-2">
            {{$cuotasRendidasParcial->links('')}}
        </div>
    @endif
</div>
