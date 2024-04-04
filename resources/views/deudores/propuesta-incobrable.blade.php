@section('titulo')
    Operación incobrable
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="pt-4 sticky left-0">
                <!--Titulo-->
                <div class="font-extrabold text-2xl bg-white p-4 text-gray-900 hover:text-gray-500 text-center mb-5 flex items-center justify-center space-x-8">
                    <h1>{{ucwords(strtolower($deudorNombre))}}</h1>
                </div>
                <a href="{{ route('deudor.perfil', ['deudor' => $operacion->deudor_id]) }}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>
                
                <!--Bajada-->
                <div class="px-14 py-4 lg:flex lg:items-center lg:justify-between text-lg
                        bg-white rounded border border-gray-200 border-1 text-gray-600 mt-4">
                    <p>Operación: <span class="font-bold text-black">{{$operacion->operacion}}</span></p>
                    <p>Cliente: <span class="font-bold text-black">{{ \App\Models\Cliente::find($operacion->cliente_id)->nombre }}</span></p>
                    <p>Producto: <span class="font-bold text-black">{{ \App\Models\Producto::find($operacion->producto_id)->nombre }}</span></p>
                    <p>Deuda Total: <span class="font-bold text-black">${{number_format($operacion->deuda_total, 2, ',', '.')}}</span></p>                    
                    <p>Situacion: 
                        <span class="font-bold text-black">
                            @php
                                $ultimaPropuesta = $operacion->propuestas()->latest('updated_at')->first();
                            @endphp
                            @if($ultimaPropuesta)
                                {{ $ultimaPropuesta->estado }}
                            @else
                                Sin gestión
                            @endif
                        </span>
                    </p>
                </div>
            </div>
            <livewire:operacion-incobrable :operacion="$operacion" :deudorId="$deudorId"/>
        </div>
    </div>
</x-app-layout>