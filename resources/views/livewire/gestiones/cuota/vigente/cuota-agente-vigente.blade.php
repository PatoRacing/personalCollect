<div>
    @if($cuotaVigenteSinGestionesDePago)
        <livewire:gestiones.cuota.vigente.cuota-agente-vigente-sin-gestiones-de-pago :cuota="$cuota"/>
    @else
        <livewire:gestiones.cuota.vigente.cuota-agente-vigente-con-pagos-informados :cuota="$cuota"/>
    @endif
</div>
