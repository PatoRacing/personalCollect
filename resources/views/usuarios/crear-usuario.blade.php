@section('titulo')
    Crear Usuario
@endsection

<x-app-layout>
    <div class="container mx-auto ">
        <div class="overflow-x-auto">
            <div class="p-4 sticky left-0">
                <h1 class="font-extrabold text-2xl bg-white p-4 text-gray-900 text-center mb-5">Crear Usuario</h1>
                <a href="{{route('usuario')}}" class="text-white bg-blue-800 hover:bg-blue-900 px-5 py-3 rounded">Volver</a>                
            </div>
            <form method="POST" action="{{ route('crear.usuario')}}"
                novalidate class="container p-2">
                @csrf
                <h2 class="text-center bg-white font-bold text-gray-600 border-y-2 p-4 mb-4">Completa todos los campos</h2>
                <div class="bg-white grid grid-cols-1 gap-4 md:grid-cols-2 px-4 py-4">
                    

                <!-- Nombre -->
                    <div class="mt-2">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input
                            id="name"
                            placeholder="Nombre del Usuario"
                            class="block mt-1 w-full"
                            type="text"
                            name="name"
                            :value="old('name')"
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
                            :value="old('apellido')" 
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
                            type="text" name="dni"
                            name="dni"
                            :value="old('dni')" 
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
                            <option value="" {{ old('rol') === '' ? 'selected' : '' }}>--Selecciona un rol--</option>
                            <option value="Administrador" {{ old('rol') === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Agente" {{ old('rol') === 'Agente' ? 'selected' : '' }}>Agente</option>
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
                            :value="old('telefono')" 
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
                            :value="old('email')" 
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
                            :value="old('domicilio')"
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
                            :value="old('localidad')"
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
                            :value="old('codigo_postal')"
                            />
                        <x-input-error :messages="$errors->get('codigo_postal')" class="mt-2" />
                    </div>
            
                    <!-- Fecha de ingreso -->
                    <div>
                        <x-input-label for="fecha_de_ingreso" :value="__('Fecha de ingreso')" />
                        <x-text-input
                            id="fecha_de_ingreso"
                            class="block mt-1 w-full"
                            type="date" name="fecha_de_ingreso"
                            :value="old('fecha_de_ingreso')" 
                            />
                        <x-input-error :messages="$errors->get('fecha_de_ingreso')" class="mt-2" />
                    </div>
            
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
            
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        placeholder="Al menos 8 caracteres, una mayúscula y un signo especial"
                                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
            
                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Repetir Password')" />
            
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        placeholder="Repite el password"
                                        name="password_confirmation" required autocomplete="new-password" />
            
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
                <x-primary-button class="mt-4 pt-3 pb-3 w-full justify-center bg-blue-800 hover:bg-blue-900">
                    {{ __('Crear usuario') }}
                </x-primary-button>
            
            </form>
        </div>
    </div>
</x-app-layout>

