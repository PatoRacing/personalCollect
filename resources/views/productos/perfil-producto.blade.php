@section('titulo')
    Perfil del Producto
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Detalle del Producto
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('productos')">
            Volver
        </x-btn-principal>
        <!--Alertas-->
        @if(session('message'))
            <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-3">
                {{ session('message') }}
            </div>
        @endif
        <!--Contenedor aspectos generales-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Aspectos Generales
            </x-subtitulo>
            <div class="grid grid-cols-1 justify-center md:grid-cols-2 gap-2 pt-2">
                <!--columna izquierda-->
                <div class="md:border-r pt-2">
                    <a class="text-white px-4 py-2 rounded text-sm bg-green-600 hover:bg-green-700"
                        href="{{ route('actualizar.producto', ['producto' => $producto->id]) }}">
                        Actualizar
                    </a>
                    <p class="mt-3">Nombre del Producto: 
                        <span class="font-bold">
                            {{ $producto->nombre }}
                        </span>
                    </p>
                    <p>Cliente:
                        <span class="font-bold">
                            {{ $producto->clienteId->nombre }}
                        </span>
                    </p>
                    <p>Honorarios:
                        <span class="font-bold">
                            {{ $producto->honorarios }}%
                        </span>
                    </p>
                    <p>Comisión Cliente:
                        <span class="font-bold">
                            {{ $producto->comision_cliente }}%
                        </span>
                    </p>
                    <p >Cuotas Variables: 
                        <span class="font-bold">
                            @if($producto->acepta_cuotas_variables == 1)
                                Sí
                            @else
                                No
                            @endif
                        </span>
                    </p>
                </div>
                <!--columna derecha-->
                <div class="pt-2">
                    <x-subtitulo-h-cuatro>
                        Operaciones del Producto
                    </x-subtitulo-h-cuatro>
                    <p class="mt-2">Nro. Operaciones:
                        <span class="font-bold">
                            {{ $cantidadOperaciones}}
                        </span>
                    </p>
                    <p>Suma Operaciones:
                        <span class="font-bold">
                            ${{ number_format($totalDeudaCapital, 2, ',', '.') }}
                        </span>
                    </p>
                    <p>Operaciones Activas:
                        <span class="font-bold">
                            {{ $operacionesActivas}}
                        </span>
                    </p>
                    <p>Suma Operaciones Activas:
                        <span class="font-bold">
                            ${{ number_format($sumaOperacionesActivas, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <!--Contenedor politicas del producto-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Políticas del Producto
            </x-subtitulo>
            @if(empty($cliente))
                <p class="p-2 text-center mt-2 bg-red-600 text-white">
                   Para aplicar políticas primero debes realizar una importación de operaciones.
                </p>
            @elseif($politicas->isEmpty())
                <div class="pt-4">
                    <a class="text-white px-4 py-2 rounded text-sm bg-green-600 hover:bg-green-700"
                        href="{{route('generar.politica', ['producto'=>$producto->id])}}">
                        + Política
                    </a>
                    <p class="text-center mt-3">
                        El producto aún no tiene políticas.
                    </p>
                </div>
            @else
                <div class="pt-4">
                    <a class="text-white px-4 py-2 rounded text-sm bg-green-600 hover:bg-green-700"
                        href="{{route('generar.politica', ['producto'=>$producto->id])}}">
                        + Política
                    </a>
                    <!--Listado de politicas-->
                    <div class="container mx-auto grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-4 gap-2 mt-3">
                        @foreach ($politicas as $politica)
                            <!--contenedor de politica-->
                            <livewire:politicas :politica="$politica"/>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>