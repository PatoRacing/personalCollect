<div>
    <!-- clases-->
    @php
        $classesSpan = "font-bold text-black";
        $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-2 text-center py-2";
        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
        $classesTipo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
        $classesButtonTrue = "text-white rounded-md text-sm bg-blue-400 border-2 text-center p-3";
        $classesButtonFalse = "text-white rounded-md bg-blue-300 text-sm border-2 text-center py-3 px-6";
    @endphp
    <div>
        @if($modalImportarPagos && !$errors->any())
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-900 bg-opacity-50">
            <div class="flex flex-col items-center bg-gray-100 p-4 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <div>
                    <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                    <p class="font-bold text-gray-800 text-center">Estás a punto de importar <span class="font-extrabold uppercase text-red-600">Pagos realizados.</span></p>
                    <p class="font-bold text-gray-800 text-center">Antes de realizar la importación ten en cuenta lo siguiente:</span></p>
                    <p class="text-sm text-gray-600">1- Revisa que todos los encabezados coincidan con los esperados</p>
                    <p class="text-sm text-gray-600">2- Para que el pago se impute el monto debe ser igual al esperado a cobrar .</p>
                    <p class="text-sm text-gray-600">3- También debe coincidir el nro de CUIL con el del deudor almacenado en la BD.</p>
                    <p class="font-bold text-gray-800 text-center">Si se cumplen los requisitos puedes continuar con la importación</p>
                    <button
                        class="mt-4 p-2 w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white"
                        wire:click="quitarModalImportarPagos">
                            Aceptar
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
