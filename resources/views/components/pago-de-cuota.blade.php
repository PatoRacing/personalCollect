<h4 class="{{ $bgPagoDeCuota() }} text-white font-bold py-1 text-center mb-1">
    {{ $estadoPagoDeCuota() }}
</h4>
<p>Fecha de Pago:
    <span class="font-bold">{{ \Carbon\Carbon::parse($pagoDeCuota->fecha_de_pago)->format('d/m/Y') }}</span>
</p>
<p>Monto Abonado:
    <span class="font-bold">${{ number_format($pagoDeCuota->monto_abonado, 2, ',', '.') }}</span>
</p>
<p>Medio de Pago:
    <span class="font-bold">{{ $pagoDeCuota->medio_de_pago }}</span>
</p>
@if($pagoDeCuota->sucursal)
    <p>Sucursal:
        <span class="font-bold">{{ $pagoDeCuota->sucursal }}</span>
    </p>
@endif
@if($pagoDeCuota->hora)
    <p>Hora:
        <span class="font-bold">{{ $pagoDeCuota->hora }}</span>
    </p>
@endif
@if($pagoDeCuota->cuenta)
    <p>Cuenta:
        <span class="font-bold">{{ $pagoDeCuota->cuenta }}</span>
    </p>
@endif
@if($pagoDeCuota->nombre_tercero)
    <p>Titular Cuenta:
        <span class="font-bold">{{ $pagoDeCuota->nombre_tercero }}</span>
    </p>
@endif
@if($pagoDeCuota->central_de_pago)
    <p>Central de Pago:
        <span class="font-bold">{{ $pagoDeCuota->central_de_pago }}</span>
    </p>
@endif
@if($pagoDeCuota->comprobante)
    <p>Comprobante:
        <a href="{{ Storage::url('comprobantes/' . $pagoDeCuota->comprobante) }}" class="text-blue-800 font-bold" target="_blank">Ver</a>
    </p>
@endif
<p>Informado por:
    <span class="font-bold">{{ $pagoDeCuota->usuarioInformador->name }} {{ $pagoDeCuota->usuarioInformador->apellido }}</span>
</p>
<p>Fecha Informe:
    <span class="font-bold">{{ \Carbon\Carbon::parse($pagoDeCuota->fecha_informe)->format('d/m/Y') }}</span>
</p>
<livewire:gestiones.botones-de-gestiones-de-pago :pagoDeCuota="$pagoDeCuota" wire:key="gestiones-botones-{{ $pagoDeCuota->id }}" />
