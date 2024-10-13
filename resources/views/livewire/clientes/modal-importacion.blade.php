<div>
    @if($modalImportacion && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1 font-bold text-sm">Antes de importar operaciones
                <span class="text-red-600">
                    tener en cuenta
                </span>
            </p>
            <div class="text-sm p-1">
                <p>1- Asegurate que <span class="font-bold uppercase">{{$cliente->nombre}}</span> es el cliente al que le deseas realizar la importación.</p>
                <p>2- Si en la fila el nro_doc no existe en la BD de deudores, la misma se omitirá.</p>
                <p>3- Antes de importar operaciones es obligatorio crear clientes, productos y deudores.</p>
                <p>4- La importación se debe realizar sobre la totalidad de cartera.</p>
                <p>5- Si deseas cargar casos puntuales debes realizarlo manualmente.</p>           
                <p>6- El nombre del producto guardado debe coincidir exactamente con el que se está importando</p>        
                <p>7- Recordá que si una operación de la BD no está presente en la importación, la misma se desactivará</p>        
                <p>8- Revisa que todos los encabezados coincidan con los esperados</p>        
            </div>
            @php
                $classesBtn ="text-white px-4 py-2 rounded"
            @endphp
            <div class="w-full flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 w-full"
                        wire:click="quitarModal">
                    Confirmar
                </button>
                <a href='/clientes'
                    class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full text-center">
                    Volver
                </a>
            </div>
        </x-modal-estado>
    @endif
</div>
