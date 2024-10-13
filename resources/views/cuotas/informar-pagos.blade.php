@section('titulo')
    Informar Pagos
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Informar Pago
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('pagos')" class="mr-1">
            Volver
        </x-btn-principal>
        <!--principal-->
        <div class="container mx-auto p-2 mt-4">
            <livewire:informar-pago :pagoId="$pagoId"/>
        </div>
    </div>
</x-app-layout>