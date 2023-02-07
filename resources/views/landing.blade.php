@extends('layout.app')

@section('title')
    Bienvenue
@endsection

@section('content')

        <?php if (isset($status)) : ?>
        <script> alert(<?php echo $status;?>); </script>
        <?php endif; ?>

        <h2>Écoutez votre musique favorite<br>en un seul clic</h2>

        <div class="login-method">
            <div class="signup-method">
                <span>Profiter gratuitement<br>de toute votre musique</span>
                <a class="btn-primary" href="/register">S'inscrire</a>
            </div>
            <div class="signin-method">
                <span>Vous avez déjà un compte ?</span>
                <a class="btn-primary" href="/login">Se connecter</a>
            </div>
        </div>

        <p class="description-text">
            Explorez tout un monde de musique sans publicité, hors connexion et même avec l’écran verrouillé. Disponible sur
            mobile et ordinateur. Ziq&mu propose des albums officiels, des playlists, des singles et plus encore.
        </p>

@endsection


