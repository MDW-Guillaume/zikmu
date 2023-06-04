@extends('layout.online')

@section('title')
    Accueil
@endsection

@section('content')
    <div id="content">
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
                    url({{ asset('origin/public/files/music/' . $artist['slug'] . '/' . $artist['cover'])}}) @endif
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
