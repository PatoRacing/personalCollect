<td class="font-bold border text-blue-800 hover:text-blue-900 px-4 py-2 text-center sticky left-0
    {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
    <button
        wire:click="$emit('modalUsuario', {{ ($usuario) }})"
    >
    {{ $usuario->name }} {{ $usuario->apellido }}
    </button>
</td>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('modalUsuario', function (usuario) {
            Swal.fire({
                title: `<p class="p-1 text-xl font-bold">${usuario.name} ${usuario.apellido}</p>`,
                icon: 'info',
                html: `
                    <p class="p-1 text-base">Teléfono: <span class="font-bold text-black">${usuario.telefono}</span></p>
                    <p class="p-1 text-base">Email: <span class="font-bold text-black">${usuario.email}</span></p>
                    <p class="p-1 text-base">Domicilio: <span class="font-bold text-black">${usuario.domicilio}</span></p>
                    <p class="p-1 text-base">Localidad: <span class="font-bold text-black">${usuario.localidad}</span></p>
                    <p class="p-1 text-base">Ingreso: <span class="font-bold text-black">${usuario.fecha_de_ingreso_formateada}</span></p>
                `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                confirmButtonColor: '#15803D',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#DC2626',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('actualizar.usuario', '') }}" + '/' + usuario.id;
                }
            });
        });
    </script>
@endpush

