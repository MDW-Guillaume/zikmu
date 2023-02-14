@extends('layout.online')

@section('content')
    <div class="styles-container">
        <h2>Genres ></h2>
        <div class="styles-list d-flex">
            @foreach ($styles as $style)
                <div class="styles-element">
                    <h3>{{ $style->name }}</h3>
                </div>
            @endforeach
        </div>
    </div>

    <h2>Artistes ></h2>
    <div class="artists-container">
        <div class="artists-list d-flex">
            @foreach ($artists as $artist)
                <a href="{{ route('artist.show', $artist['slug']) }}" class="artist-element">
                    <div class="artist-cover"
                        style="background-image : 
                    @if ($artist['cover'] == 'unfinded.jpg') url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url('{{ URL::to('storage/files/artistes') }}/{{ $artist['style_slug'] }}/{{ $artist['cover'] }}') @endif
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
@endsection
