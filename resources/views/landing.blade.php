@extends('layout.app')

@section('title')
    Zik&Mu - Bienvenue
@endsection

@section('content')
    <div class="container login">
        <h1>
            <a href="{{ route('landing') }}">
                <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
            </a>
        </h1>

        <h2>Écoutez votre musique favorite<br>en un seul clic</h2>

        <div class="login-method">
            <div class="signup-method">
                <span>Profiter gratuitement<br>de toute votre musique</span>
                <a href="">S'inscrire</a>
            </div>
            <div class="signin-method">
                <span>Vous avez déjà un compte ?</span>
                <a href="/login">Se connecter</a>
            </div>
        </div>

        <p class="description-text">
            Explorez tout un monde de musique sans publicité, hors connexion et même avec l’écran verrouillé. Disponible sur
            mobile et ordinateur. Ziq&mu propose des albums officiels, des playlists, des singles et plus encore.
        </p>
    </div> 
@endsection 


