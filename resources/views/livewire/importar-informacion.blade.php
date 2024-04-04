<div>
    @if($importarInformacion && !$errors->any())
    <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-900 bg-opacity-50">
        <div class="flex flex-col items-center bg-gray-100 p-4 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            <div>
                <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                <p class="font-bold text-gray-800 text-center">Estás a punto de importar <span class="font-extrabold uppercase text-red-600">información de deudores</span></p>
                <p class="font-bold text-gray-800 text-center">Antes de realizar la importación ten en cuenta lo siguiente:</p>
                <p class="text-sm text-gray-600 mt-2">1- Asegurate de haber creado previamente los registros de deudores.</p>
                <p class="text-sm text-gray-600">2- Cada fila debe tener un nro. documento válido para asociarlo al deudor correcto</p>
                <p class="text-sm text-gray-600">3- Si el nro. documento no existe en BD de deudores el registro se omitirá</p>
                <p class="text-sm text-gray-600">4- De cada fila del excel, sólo se almacenarán los registros cuyas celdas tengan valores</p>
                <p class="text-sm text-gray-600 mb-2">5- Revisa que todos los encabezados del excel coincidan con los esperados</p>
                <p class="font-bold text-gray-800 text-center">Si se cumplen los requisitos puedes continuar con la importación</p>
                <button
                    class="mt-4 p-2 w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white"
                    wire:click="quitarModal">
                        Aceptar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
