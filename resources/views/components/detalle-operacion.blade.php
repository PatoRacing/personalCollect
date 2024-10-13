<div class="border border-gray-700 p-1">
    <x-subtitulo>
        Detalle de la Operación
    </x-subtitulo>
    <div class="px-2 pt-2">   
        <p class="mb-0.5">Deudor:
            @if($operacion->deudorId->nombre)
                <span class="font-bold">
                    {{ucwords(strtolower($operacion->deudorId->nombre))}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Nro. Documento:
            <span class="font-bold">
                {{ $operacion->deudorId->nro_doc }}
            </span>
        </p>
        <p class="mb-0.5">Cliente:
            <span class="font-bold">
                {{ucwords(strtolower($operacion->clienteId->nombre))}}
            </span>
        </p>
        <p class="mb-0.5">Producto:
            <span class="font-bold">
                {{ucwords(strtolower($operacion->productoId->nombre))}}
            </span>
        </p>
        <p class="mb-0.5">Operación:
            <span class="font-bold">
                {{$operacion->operacion}}
            </span>
        </p>
        <p class="mb-0.5">Fecha Asig:
            <span class="font-bold">
                {{ \Carbon\Carbon::parse($operacion->fecha_asignacion)->format('d/m/Y') }}
            </span>
        </p>
        <p class="mb-0.5">Subproducto:
            @if($operacion->subproducto)
                <span class="font-bold">
                    {{ucwords(strtolower($operacion->sub_producto))}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Segmento:
            @if($operacion->segmento)
                <span class="font-bold">
                    {{$operacion->segmento }}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Sucursal:
            @if($operacion->sucursal)
                <span class="font-bold">
                    {{$operacion->sucursal }}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Deuda Capital:
            <span class="font-bold">
                ${{number_format($operacion->deuda_capital, 2, ',', '.')}}
            </span>
        </p>
        <p class="mb-0.5">Días Atraso:
            @if($operacion->dias_atraso)
                <span class="font-bold">
                    {{$operacion->dias_atraso}} días
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Compensatorio:
            @if($operacion->compensatorio)
                <span class="font-bold">
                    ${{number_format($operacion->compensatorio, 2, ',', '.')}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Punitivos:
            @if($operacion->punitivos)
                <span class="font-bold">
                    ${{number_format($operacion->punitivos, 2, ',', '.')}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Deuda Total:
            @if($operacion->deuda_total)
                <span class="font-bold">
                    ${{number_format($operacion->deuda_total, 2, ',', '.')}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Estado:
            @if($operacion->estado)
                <span class="font-bold">
                    {{$operacion->estado}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
        <p class="mb-0.5">Ciclo:
            @if($operacion->ciclo)
                <span class="font-bold">
                    {{$operacion->ciclo}}
                </span>
            @else
                <span class="font-bold">
                    -
                </span>
            @endif
        </p>
    </div>
</div>