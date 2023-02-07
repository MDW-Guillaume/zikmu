@extends('layout.app')

@section('title')
    Mot de passe oublié
@endsection

@section('content')
    <h2 class="connect-text">Regénérer votre mot de passe</h2>

    <form method="POST" action="{{ route('password.store') }}" class="login-form">
        @csrf

        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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

        <!-- Password Confirmation-->
        <div class="mt-4 input-field">
            <x-input-label for="password_confirmation" :value="__('Confirmez votre mot de passe')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full input-element"
                                type="password"
                                name="password_confirmation" required />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-flex flex-column connect-button center">
            <x-primary-button class="m-auto btn-primary border-none ">
                {{ __('Reinitialiser') }}
            </x-primary-button>
        </div>


    </form>
@endsection


{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
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
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
