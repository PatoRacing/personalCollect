<div>
    @if($modalImportacion && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1 font-bold text-sm">Antes de importar Acuerdos de Pago
                <span class="text-red-600">
                    tener en cuenta:
                </span>
            </p>
            <div class="text-sm p-1">
                <p>1- Revisa que todos los encabezados coincidan con los esperados</p>
                <p>2- No deben existir acuerdos vigentes para las propuestas que estas importando.</p>
                <p>3- Durante la importación se generarán los acuerdos, sus PDF y sus respectivos pagos.</p>
            </div>
            
            @php
                $classesBtn ="text-white px-4 py-2 rounded"
            @endphp
            <div class="w-full flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 w-full"
                        wire:click="quitarModal">
                    Confirmar
                </button>
                <a href='acuerdos'
                    class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full text-center">
                    Volver
                </a>
            </div>
        </x-modal-estado>
    @endif
</div>
