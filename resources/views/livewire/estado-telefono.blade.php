<div>
    @php
    $bgColorClass = $telefono->estado === 1 ? 'bg-green-700 hover:bg-green-800' : 'bg-red-600 hover:bg-red-700';
    @endphp
    <button
        class="{{ $bgColorClass }} text-white py-2 px-4 rounded"
        wire:click="actualizarEstado({{ $telefono->id }})"
    >
        @if ($telefono->estado === 1)
                Verificado
        @else 
                No Verificado
        @endif
    </button>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('estadoTelefonoActualizado', function() {
            Swal.fire({
                title: 'Teléfono Actualizado',
                text: 'El estado del teléfono se actualizo correctamente',
                icon: 'success'
            }).then((result)=> {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                    })
            }
        )
    </script>
@endpush

