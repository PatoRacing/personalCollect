<div class="border p-1 mt-1">
    <livewire:cuotas.buscador-cuotas :contexto="1">
    @if($cuotasVigentes->count())
        <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-2 p-1">
            @foreach ($cuotasVigentes as $cuotaVigente)
                <div class="border border-gray-700 p-1 overflow-y-auto" style="max-height: 450px">
                    <!--Si la cuota esta vencida el bg es gris-->
                    @if(\Carbon\Carbon::parse($cuotaVigente->vencimiento_cuota)->isPast())
                        <p class="bg-black mb-1 text-white uppercase py-1 text-center block">
                            {{$cuotaVigente->acuerdo->propuesta->deudorId->nombre}}
                        </p>
                    @else
                    <!--Si la cuota esta vigente el bg es azul-->
                        <p class="bg-blue-800 mb-1 text-white uppercase py-1 text-center block">
                            {{$cuotaVigente->acuerdo->propuesta->deudorId->nombre}}
                        </p>
                    @endif
                    <x-detalle-cuota
                        :cuotaActual="$cuotaVigente"
                        :cuotaId="$cuotaVigente->id"
                        :cliente="$cuotaVigente->acuerdo->propuesta->operacionId->clienteId->nombre"
                        :dniDeudor="$cuotaVigente->acuerdo->propuesta->deudorId->nro_doc"
                        :cuilDeudor="$cuotaVigente->acuerdo->propuesta->deudorId->cuil"
                        :operacion="$cuotaVigente->acuerdo->propuesta->operacionId->operacion"
                        :segmento="$cuotaVigente->acuerdo->propuesta->operacionId->segmento"
                        :producto="$cuotaVigente->acuerdo->propuesta->operacionId->productoId->nombre"
                        :responsable="$cuotaVigente->acuerdo->propuesta->operacionId->usuarioAsignado->name . ' ' . $cuotaVigente->acuerdo->propuesta->operacionId->usuarioAsignado->apellido"
                        :montoAcordado="$cuotaVigente->monto_acordado"
                        :vencimientoCta="$cuotaVigente->vencimiento_cuota"
                        :nroCuota="$cuotaVigente->nro_cuota"
                        :conceptoCuota="$cuotaVigente->concepto_cuota"
                    />
                </div>
            @endforeach
        </div>
    @else
        <p class="font-bold text-center pt-3">
            No hay cuotas vigentes
        </p>
    @endif
    @if($cuotasVigentesTotales >= 30)
        <div class="p-2">
            {{$cuotasVigentes->links('')}}
        </div>
    @endif
</div>
