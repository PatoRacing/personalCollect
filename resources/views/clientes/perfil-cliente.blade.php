@section('titulo')
    Perfil de Cliente
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Cartera {{$cliente->nombre}}
    </x-titulo>
    
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Botones principales-->
        <div>
            <x-btn-principal :href="route('clientes')" class="mr-1">
                Volver
            </x-btn-principal>
            <x-btn-principal :href="route('importar.operaciones', ['cliente' => $cliente->id])" class="bg-orange-400 hover:bg-orange-500 mr-1">
                + Importar
            </x-btn-principal>
        </div>
        <!--Informacion de cartera-->
        <div class="container text-sm mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 p-2 mt-4 border">
            <p>Total Casos: <span class="font-bold">{{ $totalCasos }}</span></p>
            <p>Casos Activos: <span class="font-bold">{{ $casosActivos }}</span></p>
            <p>Total DNI: <span class="font-bold">{{ $totalDNI }}</span></p>       
            <p>Deuda Capital Activa: <span class="font-bold">${{ number_format($deudaActiva, 2, ',', '.') }}</span></p>
        </div>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-2">
            <x-subtitulo>
                Listado de Operaciones
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
            <livewire:operaciones-cliente :cliente="$cliente"/>
        </div>
    </div>
</x-app-layout>