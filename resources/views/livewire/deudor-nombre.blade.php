<button
    wire:click="deudorNombre({{ $deudor }})"
>
    {{ucwords(strtolower($deudor->nombre))}}
</button>

