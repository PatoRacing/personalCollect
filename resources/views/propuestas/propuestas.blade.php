@section('titulo')
    Propuestas de Pago
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Propuestas de Pago
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('propuesta.manual')" class="mr-1">
            + Propuesta
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Listado de Propuestas
            </x-subtitulo>
            <!--alerta de importacion exitosa-->
            @if(session('message'))
                <div class="bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1 px-2 py-1">
                    {!! nl2br(session('message')) !!}
                </div>
            @endif
            <livewire:listado-propuestas />
        </div>
    </div>
</x-app-layout>