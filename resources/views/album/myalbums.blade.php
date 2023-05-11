@extends('layout.online')

@section('title')
    Mes albums
@endsection

@section('scss')
    @vite(['resources/scss/album.scss'])
@endsection

@section('content')
    <div id="content">
        <div class="page-album page-index page-artist">
            <h2>Mes albums</h2>
            <div class="albums-list d-flex">
                @foreach ($albums as $album)
                    {{-- {{ dd($album) }} --}}
                    <div class="album-element">
                        <div class="album-cover" style="border : 2px solid black;">
                            @if (is_null($album->cover))
                                <a href="{{ route('album.show', $album->slug) }}"><img
                                        src="{{ URL::to('/img') }}/unknown_cover.png" alt=""></a>
                                <form action="{{ route('play.album') }}" class="play-album" method="post">
                                    @csrf
                                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                                    <input type="submit"
                                        style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                        value="">
                                </form>
                            @else
                                <a href="{{ route('album.show', $album->slug) }}"><img
                                        src="{{ URL::to('storage/files/albums') }}/{{ $album->artist_slug }}/{{ $album->cover }}"
                                        alt="{{ $album->id }}"></a>
                                <form action="{{ route('play.album') }}" class="play-album" method="post">
                                    @csrf
                                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                                    <input type="submit"
                                        style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                        value="">
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('album.show', $album->slug) }}" class="album-details">
                            <h3 class="album-name">{{ $album->name }}</h3>
                            <span>par {{ $album->artist_name }}</span>
                            <span>{{ $album->release }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
