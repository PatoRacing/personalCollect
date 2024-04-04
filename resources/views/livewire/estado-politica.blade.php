<div>
    @php
    $bgColorClass = $politica->estado == 1 ? 'bg-green-700 hover:bg-green-800' : 'bg-gray-600 hover:bg-gray-700';
    @endphp
    <button
        class="{{ $bgColorClass }} text-white w-28 h-10 rounded"
        wire:click="estadoPolitica({{ $politica->id }})"
    >
        @if ($politica->estado == 1)
                Activo
        @else 
                Inactivo
        @endif
    </button>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('politicaActualizado', function() {
            Swal.fire({
                title: 'Politica Actualizada',
                text: 'El estado de la política se actualizó correctamente',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    </script>
@endpush
