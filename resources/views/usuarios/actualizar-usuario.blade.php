@section('titulo')
    Actualizar usuario
@endsection

<x-app-layout>
    <!--titulo-->
    <x-titulo>
        Actualizar Usuario
    </x-titulo>
    <!--Contenedor principal-->
    <div class="container mx-auto p-4">
        <!--Boton principal-->
        <x-btn-principal :href="route('usuarios')">
            Volver
        </x-btn-principal>
        <!--Contenedor listado-->
        <div class="container mx-auto border p-2 mt-4">
            <x-subtitulo>
                Completar todos los campos
            </x-subtitulo>
            <form 
                class="container mx-auto text-sm mt-2"
                action="{{ route('actualizar.usuario.store', ['id' => $usuario->id]) }}"
                method="POST"
                novalidate>
                @csrf
                <div class="grid grid-cols-1 justify-center md:grid-cols-2 gap-2 p-1 ">
                    <!-- Nombre -->
                    <div class="mt-2">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input
                            id="name"
                            placeholder="Nombre del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="$usuario->name" 
                            />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Apellido -->
                    <div class="mt-2">
                        <x-input-label for="apellido" :value="__('Apellido')" />
                        <x-text-input
                            id="apellido"
                            placeholder="Apellido del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="apellido"
                            :value="$usuario->apellido"
                            />
                        <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                    </div>
                    <!-- DNI -->
                    <div>
                        <x-input-label for="dni" :value="__('DNI')" />
                        <x-text-input
                            id="dni"
                            placeholder="DNI del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="dni"
                            :value="$usuario->dni" 
                            />
                        <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                    </div>
                    <!-- Rol -->
                    <div>
                        <x-input-label for="rol" :value="__('Rol del usuario')" />
                        <select
                            name="rol"
                            id="rol"
                            class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring
                            focus:ring-indigo-200 focus:ring-opacity-50 mt-1"
                        >
                            <option value="">--Selecciona un rol--</option>
                            <option value="Administrador" {{ $usuario->rol === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Agente" {{ $usuario->rol === 'Agente' ? 'selected' : '' }}>Agente</option>
                        </select>
                        <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                    </div>
                    <!-- Telefono -->
                    <div>
                        <x-input-label for="telefono" :value="__('Teléfono')" />
                        <x-text-input
                            id="telefono"
                            placeholder="Teléfono del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="telefono"
                            :value="$usuario->telefono" 
                            />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>          
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input
                            id="email"
                            placeholder="Email del Usuario"
                            class="block mt-1 w-full"
                            type="email"
                            name="email"
                            :value="$usuario->email"
                            />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Domicilio -->
                    <div>
                        <x-input-label for="domicilio" :value="__('Domicilio')" />
                        <x-text-input
                            id="domicilio"
                            placeholder="Domicilio del Usuario" 
                            class="block mt-1 w-full"
                            type="text"
                            name="domicilio"
                            :value="$usuario->domicilio" 
                            />
                        <x-input-error :messages="$errors->get('domicilio')" class="mt-2" />
                    </div>
                    <!-- Localidad -->
                    <div>
                        <x-input-label for="localidad" :value="__('Localidad')" />
                        <x-text-input
                            id="localidad"
                            placeholder="Localidad del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="localidad"
                            :value="$usuario->localidad"
                            />
                        <x-input-error :messages="$errors->get('localidad')" class="mt-2" />
                    </div>
                    <!-- Código Postal -->
                    <div>
                        <x-input-label for="codigo_postal" :value="__('Código Postal')" />
                        <x-text-input
                            id="codigo_postal"
                            placeholder="CP del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="codigo_postal"
                            :value="$usuario->codigo_postal"
                            />
                        <x-input-error :messages="$errors->get('codigo_postal')" class="mt-2" />
                    </div>
                    <!-- Fecha de ingreso -->
                    <div>
                        <x-input-label for="fecha_de_ingreso" :value="__('Fecha de ingreso')" />
                        <x-text-input
                            id="fecha_de_ingreso"
                            class="block mt-1 w-full"
                            type="date"
                            name="fecha_de_ingreso"
                            :value="$fechaIngreso"
                            />
                        <x-input-error :messages="$errors->get('fecha_de_ingreso')" class="mt-2" />
                    </div>
                    
                </div>
                <x-primary-button class="w-full py-2 px-4 mt-2 font-bold text-white bg-green-700 hover:bg-green-800">
                    {{ __('Actualizar usuario') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>

