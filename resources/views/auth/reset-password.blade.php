@section('titulo')
    Restablecer Password
@endsection

@section('contenido')
    <div>
        <a href="/" class="flex justify-center">
            <x-application-logo />
        </a>
    </div>
    <h1 class="text-center font-bold text-2xl mt-10">
        Ingresá tu nueva contraseña
    </h1>
@endsection

<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Repetir Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full py-2 px-4 mt-2 font-bold text-white bg-blue-800 hover:bg-blue-950">
                {{ __('Restablecer Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
