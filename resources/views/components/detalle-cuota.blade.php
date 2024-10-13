@props([
    'cuotaActual',
    'cuotaId',
    'cliente',
    'dniDeudor',
    'cuilDeudor',
    'operacion',
    'segmento',
    'producto',
    'responsable',
    'montoAcordado',
    'vencimientoCta',
    'nroCuota',
    'conceptoCuota',
    'rutaGestion'
])

<x-subtitulo-h-cuatro>
    Detalle de la Operación:
</x-subtitulo-h-cuatro>
<div class="p-1">
    <p class="mt-1">Cliente:
        <span class="font-bold">
            {{ $cliente }}
        </span>
    </p>
    <p>DNI Deudor:
        <span class="font-bold">
            {{ $dniDeudor }}
        </span>
    </p>
    <p>CUIL Deudor:
        @if($cuilDeudor)
            <span class="font-bold">
                {{ $cuilDeudor }}
            </span>
        @else
            -
        @endif
    </p>
    <p>Operación:
        <span class="font-bold">
            {{ $operacion }}
        </span>
    </p>
    <p>Segmento:
        <span class="font-bold">
            @if($segmento)
                {{ $segmento }}
            @else
                <span class="text-red-600 font-bold">
                    Sin datos
                </span>
            @endif
        </span>
    </p>
    <p>Producto:
        <span class="font-bold">
            {{ $producto }}
        </span>
    </p>
</div>
<!-- Detalle del Pago -->
<x-subtitulo-h-cuatro>
    Detalle de la Cuota:
</x-subtitulo-h-cuatro>
<div class="p-1">
    <p>Responsable:
        <span class="font-bold">
            {{ $responsable }}
        </span>
    </p>
    <p>$ de Cuota Acordado:
        <span class="font-bold">
            ${{ number_format($montoAcordado, 2, ',', '.') }}
        </span>
    </p>
    <p>Vencimiento Cta:
        <span class="font-bold">
            {{ \Carbon\Carbon::parse($vencimientoCta)->format('d/m/Y') }}
        </span>
    </p>
    <p>Nro. Cuota:
        <span class="font-bold">
            {{ $nroCuota }}
        </span>
    </p>
</div>
<!-- Botones -->
<div class="mt-1 grid grid-cols-2 justify-center gap-1 text-sm text-center text-white">
    @if($conceptoCuota == 'Cancelación')
        <p class="p-2 bg-cyan-600">
            <span class="font-bold">
                Cancelación
            </span>
        </p>
    @elseif($conceptoCuota == 'Cuota')
        <p class="p-2 bg-green-600">
            <span class="font-bold">
                Cuotas Fijas
            </span>
        </p>
    @elseif($conceptoCuota == 'Anticipo')
        <p class="p-2 bg-orange-600">
            <span class="font-bold">
                Anticipo
            </span>
        </p>
    @elseif($conceptoCuota == 'Saldo Excedente')
        <p class="p-2 bg-indigo-600">
            <span class="font-bold">
                Saldo Excedente
            </span>
        </p>
    @elseif($conceptoCuota == 'Saldo Pendiente')
        <p class="p-2 bg-red-600">
            <span class="font-bold">
                Saldo Pendiente
            </span>
        </p>
    @endif
    @php
        $rutaGestion = route('gestion.cuota', ['cuota' => $cuotaId])
    @endphp
    @if($cuotaActual->cuotasPreviasGestionadas())
        <a href="{{ $rutaGestion }}"
            class="text-white block rounded bg-blue-800 py-2 hover:bg-blue-900">
            Gestionar
        </a>
    @else
        <p class="text-white block rounded bg-gray-500 py-2 cursor-not-allowed"
            title="Hay una cuota previa para gestionar">
            Gestionar
        </p>
    @endif
</div>