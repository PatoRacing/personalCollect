<div>
    @if($modalAsignar && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1 font-bold text-sm">Antes de asignar operaciones
                <span class="text-red-600">
                    tener en cuenta:
                </span>
            </p>
            <div class="text-sm p-1">
                <p>1- La operación se le asignará al agente indicado en la columna <span class="font-bold">agente_id.</span></p>
                <p>2- No es obligatorio asignar la totalidad de las operaciones almacenadas en la BD.</p>
                <p>3- Podrás reasignar las operaciones de forma manual desde el modulo de operaciones.</p>
                <p>4- Revisa que todos los encabezados del excel coincidan con los esperados.</p>
            </div>
            
            @php
                $classesBtn ="text-white px-4 py-2 rounded"
            @endphp
            <div class="w-full flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 w-full"
                        wire:click="quitarModal">
                    Confirmar
                </button>
                <a href='operaciones'
                    class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full text-center">
                    Volver
                </a>
            </div>
        </x-modal-estado>
    @endif
</div>
