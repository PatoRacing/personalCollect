@section('titulo')
    Gestionar Cuota
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Gestionar Anticipo/Cuota
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('cuotas')" class="mr-1">
            Volver
        </x-btn-principal>
        <livewire:gestiones.cuota.global-cuota-agente :cuota="$cuota"/>
    </div>
</x-app-layout>
