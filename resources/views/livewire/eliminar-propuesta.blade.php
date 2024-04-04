<div class="flex justify-end">
    <button class="hover:text-white text-white mt-2 align bg-red-600 hover:bg-red-800 px-5 py-2 rounded"
            wire:click="eliminarPropuesta({{ $propuesta->id }})">
        Eliminar
    </button>
    @if($confirmarEliminacionPropuesta && !$errors->any())
        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50 bg-gray-90">
            <div class="flex flex-col items-center bg-white p-6 rounded-md border-8 border-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                <div>
                    <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                    <p>Confirmas que queres eliminar la propuesta</p>
                    <div class="p-2 flex justify-center gap-2">
                        <button class="p-2 w-full justify-center bg-green-700 hover:bg-green-800 text-white"
                            wire:click="confirmarEliminacionPropuesta">
                                Confirmar
                        </button>
                        <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                            wire:click="cancelarEliminacionPropuesta">
                                Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>