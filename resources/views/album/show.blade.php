@extends('layout.online')

@section('title')
    {{ $album->name }}
@endsection

@section('scss')
    @vite(['resources/scss/album.scss'])
    @vite(['resources/js/favorite.js'])

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection

@section('content')
    <div id="content">
        <div class="page-album">
            <div class="album-card">
                <div class="album-cover"
                    style="background-image :@if (is_null($album->cover)) url('{{ URL::to('/img') }}/unknow-cover.png')
                    @else url({{$album->cover}}) @endif
                    ">
                </div>
                <div class="album-details">
                    <h2 class="album-name">{{ $album->name }}</h2>
                    <p>par <a href="{{ route('artist.show', $artist->slug) }}">{{ $artist->name }}</a></p>
                    @if (isset($style->slug))
                        <a href="{{ route('style.show', $style->slug) }}" class="album-style">{{ $style->name }}
                            <span>&rsaquo;</span></a>
                    @endif
                    <div class="album-specs">
                        <span>{{ count($titles) }} titres • {{ $length }} • {{ $album->release }}</span>
                    </div>
                </div>
            </div>

            <div class="album-actions">
                <form action="{{ route('album.store') }}" method="post" id="addAlbumToFavorite">
                    {{ csrf_field() }}
                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                    <button type="submit" id="favButton" class="favorite @if (isset($album->favorite))is_favorite @endif">
                        <span class="favorite-album"><img src="{{ URL::to('/img') }}/fav-fill.svg"
                                alt="">Retirer</span>
                        <span class="not-favorite-album"><img src="{{ URL::to('/img') }}/fav-not-fill.svg"
                                alt="">Ajouter</span>
                    </button>
                </form>


                <form action="{{ route('song.play') }}" method="post" class="fast-play-album" id="playPlaylist">
                    @csrf
                    {{-- @foreach ($titles as $song)
                        <input type="hidden" value="{{ $song->id }}" name="{{ $song->id }}">
                    @endforeach --}}

                    <input type="hidden" name="album_id" value="{{$album->id}}">
                    <input type="hidden" name="position" value="1">
                    <button id="playOnce" type="submit" value="linear" class="listen"><img
                            src="{{ URL::to('/img') }}/play.svg" alt=""><span>Écouter</span></button>
                </form>

            </div>

            <div class="titles-list">
                @foreach ($titles as $title)
                    <div class="title-list-element">
                        <form action="{{ route('song.uniqueplay') }}" method="post" class="unique-song-form">
                            @csrf
                            <div class="title-element">
                                <div class="title-position"><span class="title-position-span"
                                        style="color : white;">{{ $title->position }}</span></div>
                                <div class="title-name">{{ $title->name }}</div>
                                <div class="title-favorite">
                                </div>
                                <input type="submit" class="play-song-submit" value="">
                                <input type="hidden" name="song_id" value="{{ $title->id }}">
                            </div>
                        </form>
                        <form action="{{ route('favorite.store', $album->slug) }}" class="actionFavorite" method="post">
                            {{ csrf_field() }}
                            <input name="title" type="hidden" value="{{ $title->id }}">
                            {{-- <input name="user" type="hidden" value="{{ $album->slug }}"> --}}
                            <button type="submit" id="favoriteButton"
                                class="favorite-button @if ($title->favorite == true) is-favorite @endif">
                                <img src="{{ URL::to('/img') }}/fav-fill.svg" alt="Supprimer des favoris"
                                    title="Supprimer des favoris" class="favorite-img">
                                <img src="{{ URL::to('/img') }}/fav-not-fill.svg" alt="Ajouter aux favoris"
                                    title="Ajouter aux favoris" class="no-favorite-img">
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
