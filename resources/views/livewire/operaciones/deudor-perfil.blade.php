<div class="grid grid-cols-1 lg:grid-cols-4 gap-2">
    <div class="col-span-3">
        <livewire:gestiones-deudor :deudor="$deudor"/>
        <livewire:deudor-perfil-operaciones :deudor="$deudor"/>
    </div>
    <div class="col-span-1">
        <livewire:deudor-perfil-telefonos :deudor="$deudor" />
    </div>
</div>
