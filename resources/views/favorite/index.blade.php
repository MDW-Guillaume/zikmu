@extends('layout.online')

@section('title')
    Coups de coeur
@endsection

@section('scss')
    @vite(['resources/scss/favorite.scss'])
@endsection

@section('content')
    <div class="page-favorite">
        <div class="favorite-card">
            <div class="favorite-cover" style="background-image : url('{{ URL::to('/img') }}/favorite-playlist.png')">
            </div>
            <div class="favorite-details">
                <div class="favorite-specs">
                    <h2 class="favorite-name">Coups de coeur</h2>
                    <p>par {{-- Nom prénom / ou / nom d'utilisateur --}}</p>
                    <span>Durée : {{-- $length --}}</span>
                </div>
                <div class="favorite-actions">
                    <button id="playPlaylist" class="play-playlist"><img src="{{ URL::to('/img') }}/play.svg"
                            alt=""><span>Lire</span></button>
                    <button id="playPlaylistRandom" class="play-playlist-random"><img
                            src="{{ URL::to('/img') }}/randomizer.svg" alt=""><span>Aléatoire</span></button>
                </div>
            </div>
        </div>
    </div>
@endsection
