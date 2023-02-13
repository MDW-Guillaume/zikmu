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

    <div class="artists-container">
        <h2>Artistes ></h2>
        <div class="artists-list d-flex">
            @foreach ($artists as $artist)
                {{--<div class="artist-element">  Link to artist page with slug --}}
                    {{-- <div class="artist-cover">
                        @if ($artist['cover'] == 'unfinded.jpg')
                        <img src="{{ URL::to('/img') }}/unknow.png" alt="">
                        @else
                        <img src="{{ URL::to('storage/files/artistes') }}/{{ $artist['style_slug'] }}/{{ $artist['cover'] }}"
                            alt="">
                        @endif
                    </div> --}}

                    <div class="artist-element">
                        <div class="artist-cover" style="background-image : 
                    @if ($artist['cover'] == 'unfinded.jpg')
                    url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url('{{ URL::to('storage/files/artistes') }}/{{ $artist['style_slug'] }}/{{ $artist['cover'] }}')
                    @endif
                    "></div>

                    <div class="artist-name">
                        <h3>{{ $artist['name'] }}</h3>
                    </div>
                    <div class="artist-follow">
                        <p><img src="{{URL::to('/img')}}fav-fill.svg" alt="">{{$artist['follow']}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
