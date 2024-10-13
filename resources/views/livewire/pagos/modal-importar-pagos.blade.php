<div>
    @if($modalImportarPagos && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1 font-bold text-sm">Antes de importar Pagos
                <span class="text-red-600">
                    tener en cuenta:
                </span>
            </p>
            <div class="text-sm p-1">
                <p>1- Revisa que todos los encabezados coincidan con los esperados</span></p>
                <p>2- Para que el pago se impute el monto debe ser igual al esperado a cobrar.</p>
                <p>3- También debe coincidir el nro de CUIL con el del deudor almacenado en la BD.</p>
            </div>
            
            @php
                $classesBtn ="text-white px-4 py-2 rounded"
            @endphp
            
            <div class="w-full flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 w-full"
                        wire:click="quitarModalImportarPagos">
                    Confirmar
                </button>
                <a href='pagos'
                    class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full text-center">
                    Volver
                </a>
            </div>
        </x-modal-estado>
    @endif
</div>
