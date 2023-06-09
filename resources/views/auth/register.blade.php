@extends('layout.app')

@section('title')
    Inscription
@endsection

@section('content')
    <h2 class="connect-text">Créer un compte</h2>

    <form method="POST" action="{{ route('register') }}" class="login-form">
        @csrf

        <!-- Email Address -->
        <div class="input-field">
            <x-input-label for="email" :value="__('Votre email')" />
            <x-text-input id="email" class="block mt-1 w-full input-element" type="email" name="email" :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 input-field">
            <x-input-label for="password" :value="__('Votre mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full input-element" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-text-input type="hidden" name="creation" value="null" />

        <div class="d-flex flex-column connect-button center">
            <p class="register-checkbox"><input type="checkbox" name="newsletter"> <span>m’envoyer des suggestions</span>
            </p>
            <p class="register-checkbox"><input type="checkbox" name="cgv"> <span>J'accepte les <a class="c-white"
                        href="/cgv">CGV</a></span></p>

            <div class="register-bottom-information">
                <p class="register-bottom-information-text">Nous pouvons utiliser votre e-mail et vos appareils pour vous
                    envoyer des actualités et des conseils sur les produits et services Ziq&Mu. </p>
            </div>

            <x-primary-button class="m-auto btn-primary border-none ">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>


    </form>
@endsection

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
