@extends('layout.online')

@section('title')
    {{ $album->name }}
@endsection

@section('scss')
    @vite(['resources/scss/album.scss'])
    @vite(['resources/js/favorite.js'])
    @vite(['resources/js/song-play.js'])

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection

@section('content')
    <div id="content">
        <div class="page-album">
            <div class="album-card">
                <div class="album-cover"
                    style="background-image :
                    @if (is_null($album->cover)) url('{{ URL::to('/img') }}/unknown_cover.png')
                    @else
                    url('{{ URL::to('storage/files/albums') }}/{{ $artist->slug }}/{{ $album->cover }}') @endif
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
                <button id="addToFavorite" class="favorite"><img src="{{ URL::to('/img') }}/fav-fill.svg"
                        alt=""><span>Ajouter</span></button>


                <form action="{{ route('song.play') }}" method="post" id="playPlaylist">
                    @csrf
                    @foreach ($titles as $song)
                        {{-- {{dd($song->id)}} --}}
                        <input type="hidden" value="{{ $song->id }}" name="{{ $song->id }}">
                    @endforeach

                    <button id="playOnce" type="submit" value="linear" class="listen"><img
                            src="{{ URL::to('/img') }}/play.svg" alt=""><span>Écouter</span></button>
                </form>

            </div>

            <div class="titles-list">
                @foreach ($titles as $title)
                    {{-- {{ dd($title->slug); }} --}}
                    <div class="title-element">
                        <div class="title-position"><span class="title-position-span"
                                style="color : white;">{{ $title->position }}</span></div>
                        <div class="title-name">{{ $title->name }}</div>
                        <div class="title-favorite">
                            {{-- @if -- Si l'utilisateur a aimé le son alors coeur plein sinon coeur vide --}}
                            {{-- @if ($title->favorite == true) --}}
                            <form action="{{ route('favorite.store', $album->slug) }}" class="actionFavorite"
                                method="post">
                                {{ csrf_field() }}
                                <input name="title" type="hidden" value="{{ $title->id }}">
                                <input name="user" type="hidden" value="{{ $album->slug }}">
                                <button type="submit" id="favoriteButton"
                                    class="favorite-button @if ($title->favorite == true) is-favorite @endif">
                                    <img src="{{ URL::to('/img') }}/fav-fill.svg" alt="Supprimer des favoris"
                                        title="Supprimer des favoris" class="favorite-img">
                                    <img src="{{ URL::to('/img') }}/fav-not-fill.svg" alt="Ajouter aux favoris"
                                        title="Ajouter aux favoris" class="no-favorite-img">
                                </button>
                            </form>
                            {{-- @else
                        <form id="addFavorite" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$title->id}}" name="song_id">
                            <button type="submit"></button>
                        </form>
                        @endif --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
