<div class="bg-white px-8 py-4 rounded mt-2">
    <div>
        <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Listado de Operaciones</h3>
        <div class="p-3 border">
            <livewire:buscador-operaciones />
            @if($operacionesCliente->count())
                <div>
                    <!--contenedor de operaciones-->
                    <div class="p-4 container grid grid-cols-1 gap-4 md:grid-cols-3">
                        @foreach ($operacionesCliente as $operacionCliente)
                            <!--operacion-->
                            <div class="border rounded">
                                <div class="px-4 text-gray-600">
                                    <!-- clases-->
                                    @php
                                        $classesSpan = "font-bold text-black";
                                        if($operacionCliente->situacion === 1) {
                                            $classesNombre = "uppercase border-b-2 text-black font-bold bg-blue-200 mt-4 text-center py-4";
                                        } else {
                                            $classesNombre = "uppercase border-b-2 text-black font-bold bg-red-600 text-white mt-4 text-center py-4";
                                        }
                                        
                                        if($operacionCliente->usuario_asignado_id === 100)
                                            $classesAsignacion = "uppercase border-b-2 text-white font-bold bg-red-600 mt-4 text-center py-2";
                                        else
                                            $classesAsignacion = "uppercase border-b-2 text-white font-bold bg-green-700 mt-4 text-center py-2";
                                        $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                                    @endphp
                                    <!-- detalle operacion-->
                                    <h2 class= "{{$classesNombre}}">
                                        @if($operacionCliente->deudorId->nombre)
                                            {{$operacionCliente->deudorId->nombre}}
                                        @else
                                            <span class="text-red-600">Sin datos</span>
                                        @endif
                                    </h2>
                                    <h3 class="{{$classesTitulo}}">Detalle de la Operación:</h3>
                                    <p>DNI Deudor: <span class="{{$classesSpan}}">{{ $operacionCliente->nro_doc }}</span></p>
                                    <p>Operación: <span class="{{$classesSpan}}">{{ $operacionCliente->operacion }}</span></p>
                                    <p>Segmento:
                                        <span class="{{$classesSpan}}">
                                            @if ( $operacionCliente->segmento)
                                                {{ $operacionCliente->segmento }}
                                            @else
                                                <span class="text-red-600"> Sin datos </span>
                                            @endif
                                        </span>
                                    </p>
                                    <p>Producto: <span class="{{$classesSpan}}">{{ $operacionCliente->productoId->nombre }}</span></p>
                                    <p>Deuda Capital: 
                                        <span class="{{$classesSpan}}">
                                            ${{ number_format($operacionCliente->deuda_capital, 2, ',', '.') }}
                                        </span>
                                    </p>
                                    <p>Días Atraso:
                                        <span class="{{$classesSpan}}">
                                            @if ( $operacionCliente->dias_atraso)
                                                {{ $operacionCliente->dias_atraso }}
                                            @else
                                                <span class="text-red-600"> Sin datos </span>
                                            @endif      
                                        </span>
                                    </p>
                                    <p>Fecha Asig.:
                                        <span class="{{$classesSpan}}">
                                            @if ( $operacionCliente->fecha_asignacion)
                                                {{ \Carbon\Carbon::parse($operacionCliente->fecha_asignacion)->format('d/m/Y') }}
                                            @else
                                                <span class="text-red-600"> Sin datos </span>
                                            @endif      
                                        </span>
                                    </p>
                                    <p class="mb-4 border-b-2 pb-4">Situación:
                                        <span class="{{$classesSpan}}">
                                            @if ($operacionCliente->situacion === 1)
                                                Activa
                                            @else 
                                                <span class="text-red-600">Inactiva</span>
                                            @endif
                                        </span>
                                    </p>
                                    <!--Asignacion-->
                                    <div class="border-b-2 pb-4">
                                        <h2 class= "{{$classesAsignacion}}">Agente:
                                            @if($operacionCliente->usuario_asignado_id !== 100)
                                                <span>
                                                    {{$operacionCliente->usuarioAsignado->name}}
                                                    {{$operacionCliente->usuarioAsignado->apellido}}
                                                </span>
                                            @else
                                                <span>Sin Asignar</span>
                                            @endif
                                        </h2>
                                    </div>
                                </div>                                            
                                <!--botones-->
                                <div class="flex justify-center gap-2 mt-4">  
                                    <a href="{{ route('deudor.perfil', ['deudor' => $operacionCliente->deudor_id]) }}"
                                        class="mb-4 text-white rounded px-5 py-2 bg-blue-800 hover:bg-blue-800">
                                        Ver
                                    </a>
                                    <div>
                                        <button class="hover:text-white text-white text-center bg-cyan-600 hover:bg-cyan-800 px-5 py-2 rounded"
                                                wire:click="asignarOperacion({{ $operacionCliente->id }})">
                                            Asignar
                                        </button>
                                        @if($asignarOperacion)
                                            <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center z-50">
                                                <div class="flex flex-col items-center bg-gray-600 p-7 rounded-md w-1/3">
                                                    <form 
                                                        class="container p-4 bg-white "
                                                        wire:submit.prevent='guardarUsuarioAsignado'
                                                        id="asignar-operacion-form"
                                                        >
                                                        <h1 class="font-bold text-lg uppercase bg-gray-200 py-2 text-black text-center">Asignar operación</h1>
                                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-1 p-4">
                                                            <!-- Listado de usuario -->
                                                            <div>
                                                                <x-input-label for="usuario_asignado_id" :value="__('Seleccionar agente')" />
                                                                <select
                                                                    id="usuario_asignado_id"
                                                                    class="block mt-1 w-full rounded-md border-gray-300"
                                                                    wire:model="usuario_asignado_id">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach ($usuarios as $usuario)
                                                                        @if ($usuario->id !== 100)
                                                                            <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->apellido}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <x-input-error :messages="$errors->get('usuario_asignado_id')" class="mt-2" />
                                                            </div>
                                                        </div>
                                                        <div class="p-2 flex justify-center gap-2">
                                                            <button class="p-2 w-full rounded justify-center bg-green-700 hover:bg-green-800 text-white"
                                                                wire:click.prevent="guardarUsuarioAsignado">
                                                                    Asignar
                                                            </button>
                                                            <button class="p-2 w-full rounded justify-center bg-red-600 hover:bg-red-800 text-white"
                                                                wire:click.prevent="cancelarAsignacion">
                                                                    Cancelar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-gray-800 p-2 text-center font-bold">
                    Sin operaciones
                </p>
            @endif
            <div class="my-5 pb-3">
                {{$operacionesCliente->links()}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('operacionAsignada', function() {
            Swal.fire({
                title: 'Operación asignada',
                text: 'La operación fue asignada correctamente.',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    </script>
@endpush