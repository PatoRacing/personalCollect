<div>
    @if($cuotaVigenteSinGestionesDePago)
        <livewire:gestiones.cuota.vigente.cuota-administrador-vigente-sin-gestiones-de-pago :cuota="$cuota"/>
    @else
        <livewire:gestiones.cuota.vigente.cuota-administrador-vigente-con-pagos-informados :cuota="$cuota"/>
    @endif
</div>
