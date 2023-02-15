@extends('layout.online')

@section('title')
    {{ $artist->name }}
@endsection

@section('scss')
@vite(['resources/scss/artist.scss'])
@endsection

@section('content')
    <div class="page-artist">
        <div class="artist-card">
            <div class="artist-cover"
                style="background-image : 
                    @if (is_null($artist->cover)) url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url('{{ URL::to('storage/files/artistes') }}/{{ $style->slug }}/{{ $artist->cover }}') @endif
                    ">
            </div>
            <div class="artist-details">
                <h2 class="artist-name">{{ $artist->name }}</h2>
                <p><img src="{{ URL::to('/img') }}/fav-fill.svg" alt="">{{ $artist->follow }}</p>
                <button id="addToFavorite"><img src="{{ URL::to('/img') }}/fav-fill.svg" alt=""><span>Ajouter</span></button>
            </div>
        </div>
        <div class="artist-albums-list">
            <h2>Discographie</h2>
            <div class="albums-container">
                @foreach ($albums as $album)
                    {{-- {{ dd($album) }} --}}
                    <div  class="album-element">
                        <div class="album-cover" style="border : 2px solid black;">
                            @if (is_null($album->cover))
                                <a href="{{ route('album.show', $album->slug) }}"><img src="{{ URL::to('/img') }}/unknown_cover.png" alt=""></a>
                            @else
                                <a href="{{ route('album.show', $album->slug) }}"><img src="{{ URL::to('storage/files/albums') }}/{{ $artist->slug }}/{{ $album->cover }}"
                                    alt=""></a>
                            @endif
                            <button style="background-color : transparent; border : 0; cursor : pointer; border-radius : 50%;"><img src="{{URL::to('/img')}}/play_song_btn.png" alt=""></button>
                        </div>
                        <a href="{{ route('album.show', $album->slug) }}" class="album-details">
                            <h3 class="album-name">{{$album->name}}</h3>
                            <span>par {{$artist->name}}</span>
                            <span>{{$album->release}}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
