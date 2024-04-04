<div>
    <form 
        class="container p-2"
        wire:submit.prevent='subirComprobante'
        >
                
        @csrf
        <h2 class="text-center bg-white font-bold text-gray-600 border-y-2 p-4 mb-4">Selecciona el comprobante</h2>
        <div class="bg-white grid grid-cols-1 px-4 py-4">

            <!-- Concepto -->
            <div class="mt-2">
                <x-input-label for="comprobante" :value="__('Comprobante')" />
                <x-text-input
                    id="comprobante"
                    class="block mt-1 w-full border p-1.5"
                    type="file"
                    wire:model="comprobante"
                    accept=".jpg, .jpeg, .pdf, .png"
                    />
                    <div class="my-5">
                        @if ($comprobante)
                            @if (Str::startsWith($comprobante->getMimeType(), 'image'))
                                Imagen:
                                <img src="{{$comprobante->temporaryUrl()}}" alt="Vista previa de la imagen">
                            @elseif (Str::startsWith($comprobante->getMimeType(), 'application/pdf'))
                                Vista previa no disponible para PDF.
                            @endif
                        @endif
                    </div>
                <x-input-error :messages="$errors->get('comprobante')" class="mt-2" />
            </div>

        </div>
        <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
            {{ __('Subir pago') }}
        </x-primary-button>
    
    </form>
</div>
