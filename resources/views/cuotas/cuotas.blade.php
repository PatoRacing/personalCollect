@section('titulo')
    Cuotas
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Cuotas de Acuerdos
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('importar.pagos')" class="mr-1">
            + Importar
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Listado de Cuotas
            </x-subtitulo>
            <!--alerta de importacion exitosa-->
            @if(session('message'))
                <div class="container mx-auto px-2 py-1 mt-1 border">
                    <h5 class="font-bold text-black text-xl">Importación exitosa:</h5>
                    <p>Detalle de acciones generadas:</p>
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-1 px-2 py-1">
                        {!! nl2br(session('message')) !!}
                    </div>
                </div>
            @endif
            <livewire:listado-cuotas />
        </div>
    </div>
</x-app-layout>