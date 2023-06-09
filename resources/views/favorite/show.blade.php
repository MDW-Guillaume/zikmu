@extends('layout.online')

@section('title')
    Coups de coeur
@endsection

@section('scss')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection

@section('content')
    <div id="content">
        <div class="page-favorite">
            <div class="favorite-card">
                <div class="favorite-cover" style="background-image : url('{{ URL::to('/img') }}/favorite-playlist.png')">
                </div>
                <div class="favorite-details">
                    <div class="favorite-specs">
                        <h2 class="favorite-name">Coups de coeur</h2>
                        <p>par
                            @if (!is_null($user->firstname))
                                {{ $user->firstname }} {{ $user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif

                            {{-- Nom prénom / ou / nom d'utilisateur --}}
                        </p>
                        @if (count($songs) == 0)
                    </div>
                </div>
            </div>
            <div class="no-favorite-content">
                <p class="message">
                    Vous n'avez aucun titre dans vos favoris...<br>Qu'attentez-vous?
                </p>
            </div>
        @else
            <span>Durée : {{ $length }}</span>
        </div>
        <div class="favorite-actions">
            <form action="{{ route('play.fastplayfavorite') }}" method="post" id="playFavoriteBtn">
                @csrf
                <input type="hidden" value="1" name="position">
                <button type="submit" class="play-playlist"><img src="{{ URL::to('/img') }}/play.svg"
                        alt=""><span>Lire</span></button>

            </form>
            <form action="{{ route('play.randomplayfavorite') }}" method="post" id="playRandomFavorite">
                @csrf
                <button type="submit" id="playPlaylistRandom" class="play-playlist-random"><img
                        src="{{ URL::to('/img') }}/randomizer.svg" alt=""><span>Aléatoire</span></button>
            </form>
        </div>
    </div>
    </div>

    <div class="favorite-playlist">
        @php
            $i = 1;
        @endphp
        @foreach ($songs as $song)
            <form action="" method="post" class="favorite-unique-song-form"
                data-id="{{ $song->id }}">
                @csrf
                <div class="favorite-element">
                    <div class="favorite-cover">
                        <img src="{{ $song->album_cover }}">
                    </div>
                    <div class="favorite-info">
                        <div class="favorite-title">
                            <span>{{ $song->name }}</span>
                            <p><a href="{{ route('artist.show', $song->artist_slug) }}">{{ $song->artist_name }}</a> •
                                <a href="{{ route('album.show', $song->album_slug) }}">{{ $song->album_name }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="favorite-delete">
                        {{-- <form action="{{ route('favorite.store') }}" class="actionFavorite" method="post"> --}}
                        {{-- {{ csrf_field() }} --}}
                        <input name="title" type="hidden" value="{{ $song->id }}">
                        <input name="csrf" type="hidden" value="{{ csrf_token() }}">
                        {{-- @csrf --}}
                        <button type="button" id="favoriteButton" class="favorite-button" data-id="{{ $song->id }}">
                            <img src="{{ URL::to('/img') }}/close.svg" alt="">
                        </button>
                        {{-- </form> --}}

                    </div>
                    <input type="submit" class="play-song-submit" value="">
                    <input type="hidden" name="song_id" value="{{ $song->id }}">
                    <input type="hidden" name="position" value="{{ $i }}">
                </div>

            </form>
            @php
                $i++;
            @endphp
        @endforeach
    </div>
    @endif
    </div>
    </div>
@endsection
