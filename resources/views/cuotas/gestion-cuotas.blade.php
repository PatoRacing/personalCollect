@section('titulo')
    @if($cuota->concepto_cuota === 'Anticipo')
        Gestionar Anticipo
    @elseif($cuota->concepto_cuota === 'Cuota')
        Gestionar Cuota
    @elseif($cuota->concepto_cuota === 'Cancelación')
        Gestionar Cancelación
    @elseif($cuota->concepto_cuota === 'Saldo Pendiente')
        Gestionar Cuota de Saldo Pendiente
    @elseif($cuota->concepto_cuota === 'Saldo Excedente')
        Gestionar Cuota de Saldo Excedente
    @endif
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        @if($cuota->concepto_cuota === 'Anticipo')
            Gestionar Anticipo
        @elseif($cuota->concepto_cuota === 'Cuota')
            Gestionar Cuota
        @elseif($cuota->concepto_cuota === 'Cancelación')
            Gestionar Cancelación
        @elseif($cuota->concepto_cuota === 'Saldo Pendiente')
            Gestionar Cuota de Saldo Pendiente
        @elseif($cuota->concepto_cuota === 'Saldo Excedente')
            Gestionar Cuota de Saldo Excedente
        @endif
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('cuotas')" class="mr-1">
            Volver
        </x-btn-principal>
        <livewire:gestiones.global-gestiones :cuota="$cuota">
    </div>
</x-app-layout>