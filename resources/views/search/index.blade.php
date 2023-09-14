@extends('layout.online')

@section('title')
    Recherche
@endsection
@if (!isset($search_array))
    {
    @php
        header('Location: /home');
        exit();
    @endphp
    }
@endif
@section('content')
    <div id="content">
        <div class="page-search page-artist">
            <div class="search-result-informations">
                <h2 class="search-result-informatation-title">
                    Résultats pour :
                    <span id="searchRequested"></span>
                </h2>
                <script>
                    var searchArray = @json($search_array);
                </script>
                @if (count($search_array) > 0)
                    <div class="search-result-songs artist-albums-list">
                        @if (isset($search_array['songs']) && count($search_array['songs']) > 0)
                            <h3 class="search-result-songs-title">Titres</h3>
                            <div class="search-result-songs-show albums-container">

                                @foreach ($search_array['songs'] as $song)
                                    {{-- @dd($song); --}}
                                    <div class="search-result-songs-show-element album-element">
                                        <div class="song-element-cover album-cover" style="border : 2px solid black;">
                                            <img src="{{ $song['cover'] }}" alt="">

                                            <form action="/play-song" class="play-title"
                                                method="post">
                                                <input type="hidden" name="_token"
                                                    value="{{ csrf_token() }}">
                                                <input type="hidden" name="song_id" value="{{ $song['id'] }}">
                                                <input type="hidden" name="album_id" value="{{ $song['album_id'] }}">
                                                <input type="hidden" name="position" value="{{ $song['position'] }}">
                                                <input type="submit"
                                                    style="background-color : transparent; background-image : url(http://127.0.0.1:8000/img/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                                    value="">
                                            </form>
                                        </div>
                                        <a href="http://127.0.0.1:8000/album/{{ $song['album_slug'] }}" class="album-details">
                                            <h3 class="song-name">{{ $song['name'] }}</h3>
                                            <span>par {{ $song['artist'] }}</span>
                                            <span>{{ $song['release'] }}</span>
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                        @endif

                        @if (isset($search_array['albums']) && count($search_array['albums']) > 0)
                            <h3 class="search-result-songs-title">Albums</h3>
                            <div class="albums-container">

                                @foreach ($search_array['albums'] as $album)
                                    <div class="album-element">
                                        <div class="album-cover" style="border : 2px solid black;">
                                            <a href="{{ route('album.show', $album['slug']) }}">
                                                <img src="{{ $album['cover'] }}" alt="">
                                            </a>

                                            <form action="{{ route('play.fastplayalbum') }}"
                                                class="play-album fast-play-album" method="post">
                                                @csrf
                                                <input type="hidden" name="album_id" value="{{ $album['id'] }}">
                                                <input type="hidden" name="position" value="1">
                                                <input type="submit"
                                                    style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                                    value="">
                                            </form>
                                        </div>
                                        <a href="{{ route('album.show', $album['slug']) }}" class="album-details">
                                            <h3 class="album-name">{{ $album['name'] }}</h3>
                                            <span>par {{ $album['artist_name'] }}</span>
                                            <span>{{ $album['release'] }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if (isset($search_array['artists']) && count($search_array['artists']) > 0)
                            <h3 class="search-result-songs-title">Artistes</h3>
                            <div class="artists-list d-flex">
                                @foreach ($search_array['artists'] as $artist)
                                    <a href="{{ route('artist.show', $artist['slug']) }}" class="artist-element">
                                        <div class="artist-cover"
                                            style="background-image :
                                        @if (is_null($artist['cover'])) url('{{ URL::to('/img') }}/unknow.png')
                                        @else
                                        url({{ asset($artist['cover']) }}) @endif
                                        ">
                                        </div>

                                        <div class="artist-name">
                                            <h3>{{ $artist['name'] }}</h3>
                                        </div>
                                        <div class="artist-follow">
                                            <p><img src="{{ URL::to('/img') }}/fav-fill.svg"
                                                    alt="">{{ $artist['follow'] }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="message">
                        Il n'y a pas de resultats
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
