<td class="font-bold border text-blue-800 hover:text-blue-900 px-4 py-4 text-center sticky left-0
    {{ $index % 2 === 0 ? 'bg-white' : 'bg-blue-100' }}">
    @if($cliente->estado === 1)
        <button
            wire:click="$emit('modalCliente', {{ ($cliente) }})"
        >
        {{ $cliente->nombre }}
        </button>
    @else
        <span class="text-red-600 cursor-not-allowed"
                title="El cliente esta inactivo" >
            {{$cliente->nombre}}
        </span>
    @endif
</td>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('modalCliente', function (cliente) {
            Swal.fire({
                title: `<p class="p-1 text-xl font-bold">${cliente.nombre}</p>`,
                icon: 'info',
                html: `
                    <p class="p-1 text-base">Email: <span class="font-bold text-black">${cliente.email}</span></p>
                    <p class="p-1 text-base">Domicilio: <span class="font-bold text-black">${cliente.domicilio}</span></p>
                    <p class="p-1 text-base">Localidad: <span class="font-bold text-black">${cliente.localidad}</span></p>
                    <p class="p-1 text-base">Código Postal: <span class="font-bold text-black">${cliente.codigo_postal}</span></p>
                    <p class="p-1 text-base">Provincia: <span class="font-bold text-black">${cliente.provincia}</span></p>
                    <p class="p-1 text-base">Creado: <span class="font-bold text-black">${cliente.creadoFormateado}</span></p>
                `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Actualizar',
                confirmButtonColor: '#15803D',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#DC2626',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Usar el usuarioId pasado desde Livewire
                    window.location.href = "{{ route('actualizar.cliente', '') }}" + '/' + cliente.id;
                }
            });
        });
    </script>
@endpush

