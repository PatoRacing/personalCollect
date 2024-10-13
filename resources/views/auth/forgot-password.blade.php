@section('titulo')
    Olvidaste tu password?
@endsection

@section('contenido')
    <div>
        <a href="/" class="flex justify-center">
            <x-application-logo />
        </a>
    </div>
    <h1 class="text-center font-bold text-2xl mt-10">
        Recuperá tu acceso a la plataforma
    </h1>
@endsection

<x-guest-layout>
    
    <div class="mb-4 font-bold text-gray-800">
        {{ __('Ingresá tu mail de registro para reestablecer tu password.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-between my-5">
            <x-link
                :href="route('login')"
            >
                Iniciar Sesión
            </x-link>

        </div>

        <x-primary-button class="w-full py-2 px-4 mt-2 font-bold text-white bg-blue-800 hover:bg-blue-950">
            {{ __('Enviar instrucciones') }}
        </x-primary-button>
    </form>
</x-guest-layout>
