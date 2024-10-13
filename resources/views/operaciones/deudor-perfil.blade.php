@section('titulo')
    Perfil del Deudor
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        {{$deudor->nombre}}
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('operaciones')" class="mr-1">
            Volver
        </x-btn-principal>
        @if(session('message'))
            <div class="px-2 py-1 bg-green-100 border-l-4 border-green-600 text-green-800 text-sm font-bold mt-3">
                {{ session('message') }}
            </div>
        @endif
        <!--Contenedor info personal-->
        <div class="container text-sm grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 lg:text-center gap-1 p-2 mt-4 border"> 
            <p class="p-1">Documento:
                <span class="font-bold">
                    {{ number_format($deudor->nro_doc, 0, '', '.') }}
                </span>
            </p>
            @if($deudor->cuil)
                <p class="p-1">CUIL:
                    <span class="font-bold">
                        {{ $deudor->cuil }}
                    </span>
                </p>
            @else
                <p class="p-1">CUIL:
                    <span class="font-bold">
                        -
                    </span>
                </p>
            @endif
            @if($deudor->domicilio)
                <p class="p-1">Domicilio:
                    <span class="font-bold">
                        {{ $deudor->domicilio }}
                    </span>
                </p>
            @else
                <p class="p-1">Domicilio:
                    <span class="font-bold">
                        -
                    </span>
                </p>
            @endif
            @if($deudor->localidad)
                <p class="p-1">Localidad:
                    <span class="font-bold">
                        {{ $deudor->localidad }}
                    </span>
                </p>
            @else
                <p class="p-1">Localidad:
                    <span class="font-bold">
                        -
                    </span>
                </p>
            @endif
            @if($deudor->codigo_postal)
                <p class="p-1">Codigo Postal:
                    <span class="font-bold">
                        {{ $deudor->codigo_postal }}
                    </span>
                </p>
            @else
                <p class="p-1">Codigo Postal:
                    <span class="font-bold">
                        -
                    </span>
                </p>
            @endif
            <a class="text-white text-center rounded p-1 text-sm bg-green-600 hover:bg-green-700"
                href="{{route('actualizar.deudor', ['deudor'=>$deudor->id])}}">
                Actualizar
            </a>
        </div>
        <livewire:deudor-perfil :deudor="$deudor"/>
    </div>
</x-app-layout>
 