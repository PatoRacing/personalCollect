@section('titulo')
    Perfil del Producto
@endsection

<x-app-layout>
        <div class="container mx-auto ">
            <div class="overflow-x-auto">
                <div class="p-4 sticky left-0">
                    <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Detalle del producto</h1>
                    <a href="{{route('productos')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 mb-2 rounded">Volver</a>
                    @if(session('message'))
                        <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-4 p-3 ">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                
                <div class="bg-white px-8 py-4 rounded">
                    <!--Aspectos Generales del producto y detalle de operaciones-->
                    <div>
                        <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Aspectos Generales</h3>
                        <div class="container grid grid-cols-1 gap-4 md:grid-cols-2 mb-4 p-3">
                            <div class="border-r">
                                <p class="text-gray-600">Nombre del Producto: <span class="font-bold text-black">{{ $producto->nombre }}</span></p>
                                <p class="text-gray-600">Cliente: <span class="font-bold text-black">{{ $producto->clienteId->nombre }}</span></p>
                                <p class="text-gray-600">Honorarios: <span class="font-bold text-black">{{ $producto->honorarios }}%</span></p>
                                <p class="text-gray-600">Comisión Cliente: <span class="font-bold text-black">{{ $producto->comision_cliente }}%</span></p>
                                <p class="text-gray-600 mb-4">
                                    Cuotas Variables: 
                                    <span class="font-bold text-black">
                                        @if($producto->acepta_cuotas_variables == 1)
                                            Sí
                                        @else
                                            No
                                        @endif
                                    </span>
                                </p>
                                <a class="bg-indigo-600 hover:bg:indigo:800 text-white px-4 py-3 rounded"
                                    href="{{ route('actualizar.producto', ['producto' => $producto->id]) }}"
                                >
                                    Actualizar
                                </a>
                            </div>
                            <div>
                                <p class="text-gray-600">Nro. Operaciones: <span class="font-bold text-black">{{ $cantidadOperaciones}}</span></p>
                                <p class="text-gray-600">Suma Operaciones: <span class="font-bold text-black">${{ number_format($totalDeudaCapital, 2, ',', '.') }}</span></p>
                                <p class="text-gray-600">Operaciones Activas: <span class="font-bold text-black">{{ $operacionesActivas}}</span></p>
                                <p class="text-gray-600">Suma Operaciones Activas: <span class="font-bold text-black">${{ number_format($sumaOperacionesActivas, 2, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!--Politicas del producto-->
                    <div>
                        <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Políticas del producto</h3>
                        <div class="p-3">
                            @if(empty($cliente))
                                <p class="text-gray-800 p-2 text-center font-bold">
                                    El cliente aun no tiene operaciones: debes importar operaciones para que se puedan aplicar políticas sobre las mismas.
                                </p>
                            @elseif($politicas->isEmpty())
                                <p class="text-gray-800 p-2 text-center font-bold">
                                    El producto aun no tiene políticas
                                </p>
                                <a href="{{route('generar.politica', ['producto'=>$producto->id])}}"
                                    class="text-white bg-green-700 hover:bg-green-800 px-5 py-3 rounded">
                                    + Política
                                </a>
                            @else
                                <a href="{{route('generar.politica', ['producto'=>$producto->id])}}"
                                    class="text-white bg-green-700 hover:bg-green-800 px-5 py-3 rounded">
                                    + Política
                                </a>
                                @if($politicas->count())
                                    <div>
                                        <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-3">
                                            @foreach ($politicas as $politica)
                                            <div class="border">
                                                <!--Condicion uno-->
                                                @if($politica->propiedad_politica_uno)
                                                    <div class="px-4">
                                                        <h2 class="uppercase border-b-2 font-bold text-center py-4">Política número <span class="rounded px-3 py-1 bg-blue-800 text-white">{{$loop->iteration}}</span></h2>
                                                        <h3 class="text-center bg-gray-200 py-2 font-bold rounded my-4 uppercase">Condición uno:</h3>
                                                        <p class="text-gray-600">Propiedad: <span class="font-bold uppercase text-black">{{$politica->propiedad_politica_uno}}</span></p>
                                                        <p class="text-gray-600 mb-4">Valor: <span class="font-bold uppercase text-black">{{$politica->valor_propiedad_uno}}</span></p>
                                                    </div>
                                                @endif

                                                <!--Condicion dos-->
                                                @if($politica->propiedad_politica_dos)
                                                    <div class="px-4">
                                                        <h3 class="text-center bg-gray-200 py-2 font-bold rounded my-4 uppercase">Condición dos:</h3>
                                                        <p class="text-gray-600">Propiedad: <span class="font-bold uppercase text-black">{{$politica->propiedad_politica_dos}}</span></p>
                                                        <p class="text-gray-600 mb-4">Valor: <span class="font-bold uppercase text-black">{{$politica->valor_propiedad_dos}}</span></p>
                                                    </div>
                                                @endif

                                                <!--Condicion tres-->
                                                @if($politica->propiedad_politica_tres)
                                                    <div class="px-4">
                                                        <h3 class="text-center bg-gray-200 py-2 font-bold rounded my-4 uppercase">Condición tres:</h3>
                                                        <p class="text-gray-600">Propiedad: <span class="font-bold uppercase text-black">{{$politica->propiedad_politica_tres}}</span></p>
                                                        <p class="text-gray-600 mb-4">Valor: <span class="font-bold uppercase text-black">{{$politica->valor_propiedad_tres}}</span></p>
                                                    </div>
                                                @endif

                                                <!--Condicion cuatro-->
                                                @if($politica->propiedad_politica_cuatro)
                                                    <div class="px-4">
                                                        <h3 class="text-center bg-gray-200 py-2 font-bold rounded my-4 uppercase">Condición cuatro:</h3>
                                                        <p class="text-gray-600">Propiedad: <span class="font-bold uppercase text-black">{{$politica->propiedad_politica_cuatro}}</span></p>
                                                        <p class="text-gray-600 mb-4">Valor: <span class="font-bold uppercase text-black">{{$politica->valor_propiedad_cuatro}}</span></p>
                                                    </div>
                                                @endif

                                                <!--Politica-->
                                                <div class="px-4">
                                                    <h3 class="text-center bg-gray-200 py-2 font-bold rounded my-4 uppercase">política:</h3>
                                                    <p class="text-gray-600">Límite de Quita: <span class="font-bold uppercase text-black">{{$politica->valor_quita}}%</span></p>
                                                    <p class="text-gray-600">Límite de Cuotas: <span class="font-bold uppercase text-black">{{$politica->valor_cuota}} cuotas</span></p>
                                                    <p class="text-gray-600">Límite Quita c/dto.: <span class="font-bold uppercase text-black">{{$politica->valor_quita_descuento}}%</span></p>
                                                    <p class="text-gray-600 border-b-2 pb-4">Límite Cuota c/dto.: <span class="font-bold uppercase text-black">{{$politica->valor_cuota_descuento}} cuotas</span></p>
                                                </div>

                                                <p class="px-4 mt-4">Ult. Modif:
                                                    <span class="font-bold text-black">
                                                        {{$politica->usuarioUltimaModificacion->name}} 
                                                        {{$politica->usuarioUltimaModificacion->apellido}}
                                                    </span>
                                                </p>

                                                <p class="px-4">Fecha Ult. Modif:
                                                    <span class="font-bold text-black">
                                                        {{ \Carbon\Carbon::parse($politica->updated_at)->format('d/m/Y - H:i:s') }}
                                                    </span>
                                                </p>

                                                <div class="p-4 flex justify-center gap-2">                                                   
                                                    <a href="{{route('actualizar.politica', ['politica'=>$politica->id])}}"
                                                        class="text-white text-center bg-blue-800 hover:bg-blue-950 px-5 py-2 rounded">
                                                        Actualizar
                                                    </a>
                                                    <livewire:estado-politica :politica="$politica"/>
                                                    <livewire:eliminar-politica :politica="$politica"/>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p class="text-gray-800 p-2 text-center font-bold">
                                        No hay Productos aún
                                    </p>
                                @endif
                                <div class="my-5 pb-3">
                                    {{$politicas->links()}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>