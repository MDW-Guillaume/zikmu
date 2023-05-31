@extends('layout.online')

@section('title')
    {{ $artist->name }}
@endsection

@section('scss')
    @vite(['resources/scss/artist.scss'])
@endsection

@section('content')
    <div id="content">
        <div class="page-artist">
            <div class="artist-card">
                <div class="artist-cover"
                    style="background-image :
                    @if (is_null($artist->cover)) url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url({{asset('storage/files/music/' . $artist->slug . '/' . $artist->cover)}}) @endif
                    ">
                </div>
                <div class="artist-details">
                    <h2 class="artist-name">{{ $artist->name }}</h2>
                    <p><img src="{{ URL::to('/img') }}/fav-fill.svg" alt="">{{ $artist->follow }}</p>
                    <form action="{{ route('artist.store') }}" method="post" id="addArtistToFavorite">
                        {{ csrf_field() }}
                        <input type="hidden" name="artist_id" value="{{ $artist->id }}">
                        <button type="submit" id="favButton" class="@if (isset($artist->favorite)) is_favorite @endif">
                            <span class="favorite-artist"><img src="{{ URL::to('/img') }}/fav-fill.svg"
                                    alt="">Retirer</span>
                            <span class="not-favorite-artist"><img src="{{ URL::to('/img') }}/fav-not-fill.svg"
                                    alt="">Ajouter</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="artist-albums-list">
                <h2>Discographie</h2>
                <div class="albums-container">
                    @foreach ($albums as $album)
                        <div class="album-element">
                            <div class="album-cover" style="border : 2px solid black;">
                                <a href="{{ route('album.show', $album->slug) }}">
                                    <img src="{{$album->cover}}">
                                </a>

                                <form action="{{ route('play.album') }}" class="play-album fast-play-album" method="post">
                                    @csrf
                                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                                    <input type="hidden" name="position" value="1">
                                    <input type="submit"
                                        style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                        value="">
                                </form>
                            </div>
                            <a href="{{ route('album.show', $album->slug) }}" class="album-details">
                                <h3 class="album-name">{{ $album->name }}</h3>
                                <span>par {{ $artist->name }}</span>
                                <span>{{ $album->release }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
