@extends('layout.online')

@section('content')
    <div id="content">
        <div class="page-edit-profile page-profile">
            <div class="profile-username-title">
                <h2>{{ $username }}</h2>
                <span>Membre depuis le : {{ $user_regitered }}</span>
            </div>

            <h3>Besoin de changement</h3>
            <div class="profile-update-container">
                <div class="profile-update-username">
                    <h4>Modifier mon nom</h4>
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div class="update-firstname">
                            <x-input-label for="firstname" :value="__('Prénom')" />
                            <x-text-input id="firstname" name="firstname" type="text" :value="old('firstname', $user->firstname)" required
                                autofocus autocomplete="firstname" />
                            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
                        </div>

                        <div class="update-lastname">
                            <x-input-label for="lastname" :value="__('Nom')" />
                            <x-text-input id="lastname" name="lastname" type="text" :value="old('lastname', $user->lastname)" required autofocus
                                autocomplete="lastname" />
                            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                    {{ __('Saved.') }}</p>
                            @endif
                        </div>

                    </form>
                </div>
                <div class="profile-update-password">
                    <h4>Modifier mon mot de passe</h4>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="current-password">
                            <x-input-label for="current_password" :value="__('Mot de passe actuel')" />
                            <x-text-input id="current_password" name="current_password" type="password"
                                autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
                        </div>

                        <div class="new-password">
                            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                            <x-text-input id="password" name="password" type="password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" />
                        </div>

                        <div class="new-password-confirmation">
                            <x-input-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                                    {{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <h3>Besoin de s'en aller</h3>
            <div class="profile-action-container">
                <div class="profile-disconnect">
                    <h4>Déconnexion</h4>
                    <p class="disconnect-text">&#x266b;	Ne me quitte pas &#x266b;</p>
                    <p> On se revoit vite !</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <input type="submit" value="Se déconnecter">
                    </form>
                </div>
                <div class="profile-destroy">
                    <form method="post" action="{{ route('profile.destroy') }}" class="profile-destroy-form">
                        @csrf
                        @method('delete')

                        <h4>Supprimer mon compte</h4>
                        <div class="profile-destroy-content">
                            <p>Une fois votre compte supprimé, toutes les données seront supprimées définitivement.</p>
                            <p>Pour supprimer votre compte, veuillez d'abord entrer votre mot de passe.</p>
                            <div class="current-password">
                                <x-input-label for="password" value="Mot de passe" class="sr-only" />
                                <x-text-input id="password" name="password" type="password"/>
                                <x-input-error :messages="$errors->userDeletion->get('password')"/>
                            </div>

                            <div>
                                <x-danger-button>
                                    {{ __('Supprimer mon compte') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
