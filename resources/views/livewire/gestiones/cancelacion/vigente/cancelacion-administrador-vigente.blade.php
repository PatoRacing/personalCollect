<div>
   @if($cancelacionVigenteSinGestionesDePago)
       <livewire:gestiones.cancelacion.vigente.cancelacion-administrador-vigente-sin-gestiones-de-pago :cuota="$cuota"/>
   @else
       <livewire:gestiones.cancelacion.vigente.cancelacion-administrador-vigente-con-pagos-informados :cuota="$cuota"/>
   @endif
</div>

