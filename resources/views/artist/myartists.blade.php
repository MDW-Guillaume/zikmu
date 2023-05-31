@extends('layout.online')

@section('title')
    Artistes
@endsection

@section('scss')
    @vite(['resources/scss/artist.scss'])
@endsection

@section('content')
    <div id="content">
        <div class="page-artist page-index">
            <h2>Mes artistes</h2>
            <div class="artists-list d-flex">
                @foreach ($artists as $artist)
                    <a href="{{ route('artist.show', $artist->slug) }}" class="artist-element">
                        <div class="artist-cover"
                            style="background-image :
                    @if (is_null($artist->cover)) url('{{ URL::to('/img') }}/unknow.png')
                    @else
                    url({{ asset('origin/public/files/music/' . $artist->slug . '/' . $artist->cover) }}) @endif
                    ">
                        </div>

                        <div class="artist-name">
                            <h3>{{ $artist->name }}</h3>
                        </div>
                        <div class="artist-follow">
                            <p>Artiste</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
