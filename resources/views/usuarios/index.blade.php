@section('titulo')
    Usuarios
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Usuarios</h1>
                <a href="{{route('crear.usuario')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">+ Usuario</a>
                @if(session('message'))
                    <div class="bg-green-100 border-l-4 border-green-600 text-green-800 font-bold mt-4 p-3 ">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            
            <div class="bg-white px-8 py-4 rounded mt-2">
                <div>
                    <h3 class="text-center bg-gray-200 border-b-2 py-4 font-bold rounded mb-4 uppercase">Listado de usuario</h3>
                    <div class="p-3">
                        @if($usuarios->count())
                            <div>
                                <div class="p-6 container grid grid-cols-1 gap-4 md:grid-cols-3">
                                    @foreach ($usuarios as $usuario)
                                        @if($usuario->id !=100)
                                            <div class="border">
                                                <div class="px-4 text-gray-600">
                                                    <h2 class= "uppercase border-b-2 text-black font-bold text-center py-4">{{$usuario->name}} {{$usuario->apellido}} <span class="rounded px-3 py-1 bg-blue-800 text-white">{{$usuario->id}}</span></h2>
                                                    @php
                                                        $classesSpan = "font-bold text-black";
                                                        if ($usuario->rol == 'Agente') {
                                                            $classesTitulo = "text-center bg-gray-200 text-black py-2 font-bold rounded my-4 uppercase";
                                                        } else {
                                                            $classesTitulo = "text-center bg-blue-800 text-white py-2 font-bold rounded my-4 uppercase";
                                                        }
                                                    @endphp
                                                    <h3 class="{{$classesTitulo}}">Información general:</h3>
                                                    <p>Rol: <span class="{{$classesSpan}}">{{$usuario->rol}}</span></p>
                                                    <p>DNI: <span class="{{$classesSpan}}">{{ number_format($usuario->dni, 0, ',', '.') }}</span></p>
                                                    <p>Ingreso: <span class="{{$classesSpan}}">{{ \Carbon\Carbon::parse($usuario->fecha_de_ingreso)->format('d/m/Y') }}</span></p>
                                                    <p>Teléfono: <span class="{{$classesSpan}}">{{$usuario->telefono}}</span></p>
                                                    <p class="mb-4">Email: <span class="{{$classesSpan}}">{{$usuario->email}}</span></p>
                                                </div>

                                                <div class="px-4 text-gray-600">
                                                    <h3 class="{{$classesTitulo}}">Dirección:</h3>
                                                    <p class="">Domicilio: <span class="{{$classesSpan}}">{{$usuario->domicilio}}</span></p>
                                                    <p class="">Localidad: <span class="{{$classesSpan}}">{{$usuario->localidad}}</span></p>
                                                    <p class=" mb-4 border-b-2 pb-4">Cod. Postal: <span class="{{$classesSpan}}">{{$usuario->codigo_postal}}</span></p>
                                                </div>

                                                <p class="px-4 mt-4">Ult. Modif:
                                                    <span class="{{$classesSpan}}">
                                                        {{ \App\Models\User::find($usuario->usuario_ultima_modificacion_id)->name }}
                                                        {{ \App\Models\User::find($usuario->usuario_ultima_modificacion_id)->apellido }}
                                                    </span>
                                                </p>

                                                <p class="px-4">Fecha:
                                                    <span class="{{$classesSpan}}">
                                                        {{ ($usuario->updated_at)->format('d/m/Y - H:i') }}
                                                    </span>
                                                </p>

                                                <div class="p-4 flex justify-center gap-2">                                                   
                                                    <a href="{{route('actualizar.usuario', ['id'=>$usuario->id])}}"
                                                        class="text-white text-center bg-blue-800 hover:bg-blue-950 px-5 py-2 rounded">
                                                        Actualizar
                                                    </a>
                                                    <livewire:actualizar-estado :usuario="$usuario"/>
                                                    <livewire:eliminar-usuario :usuario="$usuario"/>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-800 p-2 text-center font-bold">
                                Aun no hay Usuarios
                            </p>
                        @endif
                        <div class="my-5 pb-3">
                            {{$usuarios->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>







