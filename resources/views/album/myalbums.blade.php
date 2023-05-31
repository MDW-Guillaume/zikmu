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
                            <span>par {{ $album->artist_name }}</span>
                            <span>{{ $album->release }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
