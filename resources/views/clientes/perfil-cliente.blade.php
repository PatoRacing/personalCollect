@section('titulo')
    Perfil de Cliente
@endsection

<x-app-layout>
        <div class="container mx-auto ">
            <div class="overflow-x-auto">
                <div class="p-4 sticky left-0">
                    <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Cartera {{$cliente->nombre}}</h1>
                    <a href="{{route('clientes')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                    <a href="{{ route('importar.operaciones', ['cliente' => $cliente->id]) }}" class="text-white bg-green-700 hover:bg-green-900 px-5 py-3 rounded">+ Importar</a>
                    @if(session('message'))
                        <div class="bg-white rounded p-4 mt-8">
                            <h1 class="font-extrabold text-2xl text-black">Importación realizada con éxito:</h1>
                            <p class="font-bold text-gray-600 mb-2">Detalle de acciones generadas:</p>
                            <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold p-2">
                                {!! nl2br(session('message')) !!}
                            </div>
                        </div>
                    @endif                
                </div>
                <div class="px-14 py-4 mb-2 lg:flex lg:items-center lg:justify-between text-sm
                            bg-white rounded border border-gray-200 border-1 text-gray-600">
                    <p>Total Casos: <span class="font-bold text-black">{{ $totalCasos }}</span></p>
                    <p>Casos Activos: <span class="font-bold text-black">{{ $casosActivos }}</span></p>
                    <p>Total DNI: <span class="font-bold text-black">{{ $totalDNI }}</span></p>
                    <p>Deuda Capital (suma): <span class="font-bold text-black">${{ number_format($deudaTotal, 2, ',', '.') }}</span></p>        
                    <p>Deuda Capital Activa: <span class="font-bold text-black">${{ number_format($deudaActiva, 2, ',', '.') }}</span></p>               
                </div>
                <livewire:operaciones-cliente :cliente="$cliente"/>
            </div>
        </div>
</x-app-layout>