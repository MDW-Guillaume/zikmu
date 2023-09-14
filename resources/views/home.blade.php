@extends('layout.online')

@section('title')
    Accueil
@endsection

@section('content')
    <div id="content">
        <div class="page-artist home_albums">
            <div class="artist-albums-list">
                <h2 class="home-title"><span>Écoutés récemment</span></h2>
                <div class="albums-container">
                    @foreach ($last_listened as $last_album)
                        <div class="album-element">

                            <div class="album-cover" style="border : 2px solid black;">
                                <div class="album-cover-container">
                                    <a href="{{ route('album.show', $last_album->slug) }}">
                                        <img src="{{ $last_album->cover }}">
                                    </a>
                                </div>

                                <form action="{{ route('play.album') }}" class="play-album fast-play-album" method="post">
                                    @csrf
                                    <input type="hidden" name="album_id" value="{{ $last_album->id }}">
                                    <input type="hidden" name="position" value="1">
                                    <input type="submit"
                                        style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                        value="">
                                </form>
                                <a href="{{ route('album.show', $last_album->slug) }}" class="album-details">
                                    <h3 class="album-name">{{ $last_album->name }}</h3>
                                    <span>par {{ $last_album->artist }}</span>
                                    <span>{{ $last_album->release }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="styles-container">
            <a href="{{ route('style.index') }}">
                <h2 class="home-title"><span>Genres</span><span>&rsaquo;</span></h2>
            </a>
            <div class="styles-list d-flex">
                @foreach ($styles as $style)
                    <a href="{{ route('style.show', $style->slug) }}" class="styles-element">
                        <h3>{{ $style->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>

        <a href="{{ route('artist.index') }}">
            <h2 class="home-title"><span>Artistes</span><span>&rsaquo;</span></h2>
        </a>
        <div class="artists-container">
            <div class="artists-list d-flex">
                @foreach ($artists as $artist)
                    <a href="{{ route('artist.show', $artist['slug']) }}" class="artist-element">
                        <div class="artist-cover"
                            style="background-image :
                    @if ($artist['cover'] == 'unfinded.jpg') url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url({{ asset('origin/public/files/music/' . $artist['slug'] . '/' . $artist['cover']) }}) @endif
                    ">
                        </div>

                        <div class="artist-name">
                            <h3>{{ $artist['name'] }}</h3>
                        </div>
                        <div class="artist-follow">
                            <p><img src="{{ URL::to('/img') }}/fav-fill.svg" alt="">{{ $artist['follow'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
