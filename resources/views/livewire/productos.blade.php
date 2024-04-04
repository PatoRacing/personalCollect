<div class="bg-white px-8 py-4 rounded mt-2">
    <div>
        <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Listado de productos</h3>
        <div class="p-3">
            <livewire:buscador-productos />
            @if($productos->count())
                <div>
                    <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-3">
                        @foreach ($productos as $producto)
                            <div class="border rounded">
                                <div class="px-4 text-gray-600">
                                    <!--classes-->
                                    @php
                                        $classesSpan = "font-bold text-black";
                                        if ($producto->estado === 1) {
                                            $classesNombre = "uppercase border-b-2 text-black font-bold text-center py-4";
                                            } else {
                                                $classesNombre = "uppercase border-b-2 text-red-600 font-bold text-center py-4";
                                        }
                                        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                                    @endphp
                                    <!--producto-->
                                    <h2 class= "{{$classesNombre}}">{{$producto->nombre}} <span class="rounded px-3 py-1 bg-blue-800 text-white">{{$producto->id}}</span></h2>
                                    <h3 class="{{$classesTitulo}}">Información:</h3>
                                    <p>Cliente: <span class="{{$classesSpan}}">{{$producto->clienteId->nombre}}</span></p>
                                    <p>Honorarios: <span class="{{$classesSpan}}">{{$producto->honorarios}}%</span></p>
                                    <p>Comisión: <span class="{{$classesSpan}}">{{$producto->comision_cliente}}%</span></p>
                                    <p>Cuotas Variables: 
                                        <span class="{{$classesSpan}}">
                                            @if($producto->acepta_cuotas_variables == 1)
                                                Sí
                                            @else
                                                No
                                            @endif
                                        </span>
                                    </p>
                                    <p>Ult. Modif:
                                        <span class="{{$classesSpan}}">
                                            {{ $producto->usuarioUltimaModificacion->name }}
                                            {{ $producto->usuarioUltimaModificacion->apellido }}
                                        </span>
                                    </p>
                                    <p class="mb-4 border-b-2 pb-4">Fecha Ult. Modif:
                                        <span class="{{$classesSpan}}">
                                            {{ \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y - H:i:s') }}
                                        </span>
                                    </p>
                                </div>
                                <!--botones-->
                                <div class="p-4 flex justify-center gap-2">
                                    <a href="{{ route('perfil.producto', ['producto' => $producto->id]) }}"
                                        class="text-white text-center bg-blue-800 hover:bg-blue-950 px-5 py-2 rounded">
                                        Perfil 
                                    </a>
                                    <!--Actualizar estado-->
                                    @php
                                        $bgColorClass = $producto->estado == 1 ? 'bg-green-700 hover:bg-green-800' : 'bg-gray-600 hover:bg-gray-700';
                                    @endphp
                                    <button
                                        class="{{ $bgColorClass }} text-white w-28 h-10 rounded"
                                        wire:click="estadoProducto({{ $producto->id }})"
                                        >
                                        @if ($producto->estado === 1)
                                                Activo
                                        @else 
                                                Inactivo
                                        @endif
                                    </button>
                                    <!--Eliminar Producto-->
                                    <button class="hover:text-white text-white text-center bg-red-600 hover:bg-red-800 px-5 py-2 rounded"
                                            wire:click="eliminarProducto({{ $producto->id }})">
                                        Eliminar
                                    </button>
                                    <!--Eliminar Producto-->
                                    @if($confirmaEliminacionProducto && !$errors->any())
                                        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50">
                                            <div class="flex flex-col items-center bg-gray-600 p-4 rounded w-1/3">
                                                <div class="flex flex-col items-center bg-white p-2 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                    <div>
                                                        <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                                                        <p class="mx-10">Confirmar eliminar el producto <span class="font-bold uppercase text-black">{{ \App\Models\Producto::find($this->productoId)->nombre }} de {{ \App\Models\Cliente::find(\App\Models\Producto::find($this->productoId)->cliente_id)->nombre }}</span></p>
                                                        <div class="p-2 flex justify-center gap-2">
                                                            <button class="p-2 w-full justify-center bg-green-700 hover:bg-green-800 text-white"
                                                                wire:click="confirmaEliminacionProducto">
                                                                    Confirmar
                                                            </button>
                                                            <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                                                                wire:click="cancelarEliminacionProducto">
                                                                    Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($productoConPoliticas && !$errors->any())
                                        <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50">
                                            <div class="flex flex-col items-center bg-gray-600 p-4 rounded w-1/3">
                                                <div class="flex flex-col items-center bg-white p-2 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-red-600 font-extrabold rounded-full cursor-not-allowed">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                    <div>
                                                        <h1 class="font-extrabold text-2xl p-2 text-black text-center">Atención</h1>
                                                        <p>No se puede eliminar <span class="font-bold uppercase text-black">{{ \App\Models\Producto::find($this->productoId)->nombre }} de {{ \App\Models\Cliente::find(\App\Models\Producto::find($this->productoId)->cliente_id)->nombre }}</span></p>
                                                        <p>El producto tiene políticas. Debes eliminar primero las políticas</p>
                                                        <div class="p-2 flex justify-center gap-2">
                                                            <button class="p-2 w-full justify-center bg-red-600 hover:bg-red-800 text-white"
                                                                wire:click="cancelarEliminacionProducto">
                                                                    Cerrar
                                                            </button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-800 p-2 text-center font-bold">
                    No hay productos
                </p>
            @endif
            <div class="my-5 pb-3">
                {{$productos->links()}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('estadoActualizado', function() {
            Swal.fire({
                title: 'Producto Actualizado',
                text: 'El estado del producto se actualizó correctamente',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    </script>
@endpush
