@props([
    'cuota'
])
<div class="grid grid-cols-1 md:grid-cols-2 gap-2 my-2">
    <div class="p-3 border">
        <x-subtitulo-h-cuatro>
            Detalle de operacion
        </x-subtitulo-h-cuatro>
        <p class="mt-1">Cliente:
            <span class="font-bold">
                {{ $cuota->acuerdo->propuesta->operacionId->clienteId->nombre }}
            </span>
        </p>
        <p>DNI Deudor:
            <span class="font-bold">
                {{ $cuota->acuerdo->propuesta->deudorId->nro_doc }}
            </span>
        </p>
        <p>CUIL Deudor:
            @if($cuota->acuerdo->propuesta->deudorId->cuil)
                <span class="font-bold">
                    {{ $cuota->acuerdo->propuesta->deudorId->cuil}}
                </span>
            @else
                -
            @endif
        </p>
        <p>Operación:
            <span class="font-bold">
                {{ $cuota->acuerdo->propuesta->operacionId->operacion }}
            </span>
        </p>
        <p>Segmento:
            <span class="font-bold">
                @if ( $cuota->acuerdo->propuesta->operacionId->segmento )
                    {{ $cuota->acuerdo->propuesta->operacionId->segmento }}
                @else
                    <span class="text-red-600 font-bold">
                        Sin datos
                    </span>
                @endif
            </span>
        </p>
        <p>Producto:
            <span class="font-bold">
                {{ $cuota->acuerdo->propuesta->operacionId->productoId->nombre }}
            </span>
        </p>
    </div>
    <div class="p-3 border">
        <x-subtitulo-h-cuatro>
            Detalle del Acuerdo
        </x-subtitulo-h-cuatro>
        <p class="mt-1">Responsable:
            <span class="font-bold">
                {{$cuota->acuerdo->propuesta->operacionId->usuarioAsignado->name}}
                {{$cuota->acuerdo->propuesta->operacionId->usuarioAsignado->apellido}}
            </span>
        </p>
        <p>Tipo de Acuerdo:
            @if($cuota->acuerdo->propuesta->tipo_de_propuesta == 1)
                <span class="font-bold">
                    Cancelación
                </span>
            @elseif($cuota->acuerdo->propuesta->tipo_de_propuesta == 2)
                <span class="font-bold">
                    Cuotas Fijas
                </span>
            @elseif($cuota->acuerdo->propuesta->tipo_de_propuesta == 4)
                <span class="font-bold">
                    Cuotas Variables
                </span>
            @endif
        </p>
        <p>Monto Acordado:
            <span class="font-bold">
                ${{ number_format($cuota->monto_acordado, 2, ',', '.') }}
            </span>
        </p>
        <p>Concepto: 
            <span class="font-bold">
                {{$cuota->concepto_cuota}}
            </span>
        </p>
        <p>Vencimiento Cta: 
            <span class="font-bold">
                {{ \Carbon\Carbon::parse($cuota->vencimiento_cuota)->format('d/m/Y') }}
            </span>
        </p>
        <p>Nro. Cuota: 
            <span class="font-bold">
                {{$cuota->nro_cuota}}
            </span>
        </p>
    </div>
</div>