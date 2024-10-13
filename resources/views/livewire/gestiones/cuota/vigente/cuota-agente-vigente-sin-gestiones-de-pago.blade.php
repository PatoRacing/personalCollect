@php
    $classesBtn ="text-white py-2 rounded text-sm"
@endphp
<div>
    <x-deudor-gestion-cuota :cuota="$cuota"/>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-1">
        <div class="col-span-2">
            <x-detalle-gestion-cuota
                :cuota="$cuota"
            />
            <div class="p-1 border mt-2 lg:mt-0">
                <x-subtitulo-h-cuatro>
                    Informar un pago
                </x-subtitulo-h-cuatro>
                <livewire:gestiones.cuota.formulario-gestion-cuota :cuota="$cuota" :classesBtn="$classesBtn"/>
            </div>
        </div>
        <div class="grid-cols-1 gap-1 lg:mt-2 border p-3">
            <x-subtitulo-h-cuatro>
                Gestiones de Pago
            </x-subtitulo-h-cuatro>
            <p class="font-bold text-center pt-3">
                La cuota no tiene gestiones
            </p>
        </div>
    </div>
</div>
