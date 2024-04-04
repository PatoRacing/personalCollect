<div>
    @php
    $bgColorClass = $pago->estado == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-700 hover:bg-green-800';
    @endphp
    <button
        class="{{ $bgColorClass }} text-white w-28 h-10 rounded"
        wire:click="actualizarEstado({{ $pago->id }})"
    >
        @if ($pago->estado == 1)
                Impago
        @else 
                Cobrado
        @endif
    </button>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('actualizacionCompleta', function() {
            Swal.fire({
                title: 'Pago Actualizado',
                text: 'El Pago cliente se actualizó correctamente',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    </script>
@endpush
