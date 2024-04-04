<div>
    @if ($resultadoMasReciente !== 'Ubicado')
    <span class=" text-white rounded bg-orange-500 px-4 py-3 hover:bg-orange-600 opacity-50 cursor-not-allowed"
        title="Primero debes ubicar al deudor">
    Cambiar
    </span>
    @elseif ($ultimaPropuesta && $ultimaPropuesta->estado == 'Propuesta de Pago')
    <span class=" text-white rounded bg-orange-500 px-4 py-3 hover:bg-orange-600 opacity-50 cursor-not-allowed"
        title="La operación tiene una propuesta de Pago">
    Cambiar
    </span>
    @elseif ($ultimaPropuesta && $ultimaPropuesta->estado == 'Preaprobado')
    <span class=" text-white rounded bg-orange-500 px-4 py-3 hover:bg-orange-600 opacity-50 cursor-not-allowed"
        title="La operación tiene una propuesta preaprobada">
    Cambiar
    </span>
    @elseif ($ultimaPropuesta && $ultimaPropuesta->estado == 'Acuerdo de Pago')
    <span class=" text-white rounded bg-orange-500 px-4 py-3 hover:bg-orange-600 opacity-50 cursor-not-allowed"
        title="La operación tiene un Acuerdo de Pago">
    Cambiar
    </span>
    @else
    <button class=" text-white rounded bg-orange-500 px-4 py-3 hover:bg-orange-600"
        wire:click="cobrable({{$operacion->id}})"
    >
    Cambiar
    </button>
    @endif
</div>

