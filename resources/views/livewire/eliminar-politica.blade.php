<div>
    <button class="hover:text-white text-white text-center bg-red-600 hover:bg-red-800 px-5 py-2 rounded"
            wire:click="$emit('alertaPoliticaEliminada', {{ $politica->id }})">
        Eliminar
    </button>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('alertaPoliticaEliminada', function (politicaId) {
            Swal.fire({
                title: `Eliminar Política?`,
                text: `Recuerda que si la eliminas no se puede recuperar`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                confirmButtonColor: '#15803D',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#DC2626',
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('eliminarPolitica', politicaId)
                    Swal.fire(
                        'Se elimino la política',
                        'Eliminado correctamente',
                    ).then(()=>{
                        location.reload();
                    })
                }
            });
        });
    </script>
@endpush
