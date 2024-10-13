<div>
    @if($imprimirAlerta)
        <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-sm font-bold mt-3">
            <p>Gestion generada correctamente</p>
        </div>
    @endif
    <livewire:dynamic-component :component="$mostrarLivewireCorrespondiente" :cuota="$cuota" />
</div>