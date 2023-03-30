@extends('layout.online')

@section('title')
    {{ $style->name }}
@endsection

@section('scss')
    @vite(['resources/scss/stylepage.scss'])
@endsection

@section('content')
    <div id="content">
        <div class="page-style">
            <div class="style-name">
                <h2>{{ $style->name }}</h2>
            </div>

            <div class="albums-style">
                <h3>Albums essentiels</h3>
                <div class="albums-list">
                    @if (count($albums) > 0)
                        @foreach ($albums as $album)
                            {{-- {{ dd($album) }} --}}
                            <div class="album-element">
                                <div class="album-cover" style="border : 2px solid black;">
                                    @if (is_null($album->cover))
                                        <a href="{{ route('album.show', $album->slug) }}"><img
                                                src="{{ URL::to('/img') }}/unknown_cover.png" alt=""></a>
                                    @else
                                        <a href="{{ route('album.show', $album->slug) }}"><img
                                                src="{{ URL::to('storage/files/albums') }}/{{ $album->artist_slug }}/{{ $album->cover }}"
                                                alt=""></a>
                                    @endif
                                    <form action="{{ route('play.album') }}" class="play-album" method="post">
                                        @csrf
                                        <input type="hidden" name="album_id" value="{{ $album->id }}">
                                        <input type="submit"
                                            style="background-color : transparent; background-image : url({{ URL::to('/img') }}/play_song_btn.png); border : 0; cursor : pointer; border-radius : 50%;"
                                            value="">
                                    </form>
                                </div>
                                <a href="{{ route('album.show', $album->slug) }}" class="album-details">
                                    <h3 class="album-name">{{ $album->name }}</h3>
                                    <span>par {{ $album->artist }}</span>
                                    <span>{{ $album->release }}</span>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>Aucun album trouvé.</p>
                    @endif
                </div>
            </div>

            <div class="artists-container">
                <h3>Artistes essentiels</h3>
                <div class="artists-list d-flex">
                    @if (count($artists) > 0)
                        @foreach ($artists as $artist)
                            <a href="{{ route('artist.show', $artist->slug) }}" class="artist-element">
                                <div class="artist-cover"
                                    style="background-image :
                            @if ($artist->cover == 'unfinded.jpg') url('{{ URL::to('/img') }}/unknow.png')
                            @else
                            url('{{ URL::to('storage/files/artistes') }}/{{ $style->slug }}/{{ $artist->cover }}') @endif
                            ">
                                </div>

                                <div class="artist-name">
                                    <h3>{{ $artist->name }}</h3>
                                </div>
                                <div class="artist-follow">
                                    <p><img src="{{ URL::to('/img') }}/fav-fill.svg" alt="">{{ $artist->follow }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p>Aucun artiste trouvé.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
