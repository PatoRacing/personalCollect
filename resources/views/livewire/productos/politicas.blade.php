<div class="border border-gray-700 pt-1 px-1">
    <x-subtitulo-h-tres :variable="$politica">
        Política ID {{$politica->id}}
    </x-subtitulo-h-tres>
    <!--Condicion Uno-->
    <x-subtitulo-h-cuatro>
        Condiciones
    </x-subtitulo-h-cuatro>
    <!--Contenedor parrafos información-->
    <div class="p-2">
        <h5 class="font-extrabold">Condición 1:</h5>
        <p>Propiedad:
            <span class="font-bold">
                {{$politica->propiedad_politica_uno}}
            </span>
        </p>
        <p>Valor:
            <span class="font-bold">
                {{$politica->valor_propiedad_uno}}
            </span>
        </p>
    </div>
    <!--Condicion Dos-->
    @if($politica->propiedad_politica_dos)
        <!--Contenedor parrafos información-->
        <div class="p-2 border-t border-gray-700">
            <h5 class="font-extrabold">Condición 2:</h5>
            <p>Propiedad:
                <span class="font-bold">
                    {{$politica->propiedad_politica_dos}}
                </span>
            </p>
            <p>Valor:
                <span class="font-bold">
                    {{$politica->valor_propiedad_dos}}
                </span>
            </p>
        </div>
    @endif
    <!--Condicion Tres-->
    @if($politica->propiedad_politica_tres)
        <!--Contenedor parrafos información-->
        <div class="p-2 border-t border-gray-700">
            <h5 class="font-extrabold">Condición 3:</h5>
            <p>Propiedad:
                <span class="font-bold">
                    {{$politica->propiedad_politica_tres}}
                </span>
            </p>
            <p>Valor:
                <span class="font-bold">
                    {{$politica->valor_propiedad_tres}}
                </span>
            </p>
        </div>
    @endif
    <!--Condicion Tres-->
    @if($politica->propiedad_politica_cuatro)
        <!--Contenedor parrafos información-->
        <div class="p-2 border-t border-gray-700">
            <h5 class="font-extrabold">Condición 4:</h5>
            <p>Propiedad:
                <span class="font-bold">
                    {{$politica->propiedad_politica_cuatro}}
                </span>
            </p>
            <p>Valor:
                <span class="font-bold">
                    {{$politica->valor_propiedad_cuatro}}
                </span>
            </p>
        </div>
    @endif
    <x-subtitulo-h-cuatro>
        Límites
    </x-subtitulo-h-cuatro>
    <div class="pt-1 px-1">
        <p>Límite de Quita:
            <span class="font-bold">
                {{$politica->valor_quita}}%
            </span>
        </p>
        <p>Límite de Cuotas:
            <span class="font-bold">
                {{$politica->valor_cuota}} cuotas
            </span>
        </p>
    </div>
    <div class="pt-1 px-1 border-t border-gray-700">
        <p>Ult. Modif:
            <span class="font-bold">
                {{$politica->usuarioUltimaModificacion->name}}
                {{$politica->usuarioUltimaModificacion->apellido}}
            </span>
        </p>
        <p>Fecha:
            <span class="font-bold">
                {{ \Carbon\Carbon::parse($politica->updated_at)->format('d/m/Y - H:i:s') }}
            </span>
        </p>
    </div>
    <div class="pt-1 px-1 mb-1 grid grid-cols-3 justify-center gap-1">
        @php
            $classesBtn ="text-white px-4 py-2 rounded text-sm"
        @endphp
        <a href="{{route('actualizar.politica', ['politica'=>$politica->id])}}"
            class="{{$classesBtn}} bg-blue-800 hover:bg-blue-900 text-center">
            Actualizar
        </a>
        @if($politica->estado == 1)
            <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                    wire:click="mostrarModalEstado({{ $politica->id }})">
                Activo
            </button>
        @else
            <button class="{{$classesBtn}} bg-gray-700 hover:bg-gray-800"
                    wire:click="mostrarModalEstado({{ $politica->id }})">
                Inactivo
            </button>
        @endif
        <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                wire:click="mostrarModalEliminar({{ $politica->id }})">
            Eliminar
        </button>
        <!--Modal cambiar estado-->
        @if($modalEstado && !$errors->any())
            <x-modal-estado>
                <!--Contenedor Parrafos-->
                <p class="px-1">Confirmar cambiar estado de política 
                    <span class="font-bold">
                        ID {{$politica->id}}
                    </span>
                </p>
                <!--Contenedor Botones-->
                <div class="flex justify-center gap-2 mt-2">
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                            wire:click="confirmarCambiarEstado({{ $politicaSeleccionada->id }})">
                        Confirmar
                    </button>
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                            wire:click="cerrarModalEstado">
                        Cancelar
                    </button>
                </div>
            </x-modal-estado>
        @endif
        <!--Modal eliminar usuario-->
        @if($modalEliminar && !$errors->any())
            <x-modal-estado>
                <!--Contenedor Parrafos-->
                <p class="px-1">Confirmar eliminar política 
                    <span class="font-bold">
                        ID {{$politicaSeleccionada->id}}
                    </span>
                </p>
                <!--Contenedor botones-->
                <div class="flex justify-center gap-2 mt-2">
                    <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700"
                            wire:click="confirmarEliminarPolitica({{ $politicaSeleccionada->id }})">
                        Confirmar
                    </button>
                    <button class="{{$classesBtn}} bg-red-600 hover:bg-red-700"
                            wire:click="cerrarModalEliminar">
                        Cancelar
                    </button>
                </div>
            </x-modal-estado>
        @endif                           
    </div>
</div>
