<div>
    @if($importarInformacion && !$errors->any())
        <x-modal-estado>
            <!--Contenedor Parrafos-->
            <p class="px-1 font-bold text-sm">Antes de importar información de deudores
                <span class="text-red-600">
                    tener en cuenta
                </span>
            </p>
            <div class="text-sm p-1">
                <p>1- Asegurate de haber creado previamente los deudores.</p>
                <p>2- El nro. documento debe ser válido para asociarlo al deudor correcto.</p>
                <p>3- Si el nro. documento no existe en BD de deudores el registro se omitirá.</p>
                <p>4- Sólo se almacenarán los registros cuyas celdas tengan valores.</p>
                <p>5- Revisa que todos los encabezados del excel coincidan con los esperados.</p>           
            </div>
            @php
                $classesBtn ="text-white px-4 py-2 rounded"
            @endphp
            <div class="w-full flex justify-center gap-2 mt-2">
                <button class="{{$classesBtn}} bg-green-600 hover:bg-green-700 w-full"
                        wire:click="quitarModal">
                    Confirmar
                </button>
                <a href='clientes'
                    class="{{$classesBtn}} bg-red-600 hover:bg-red-700 w-full text-center">
                    Volver
                </a>
            </div>
        </x-modal-estado>
    @endif
</div>
