@extends('layout.online')

@section('title')
    {{ $album->name }}
@endsection

@section('scss')
@vite(['resources/scss/album.scss'])
@endsection

@section('content')
    <div class="page-album">
        <div class="album-card">
            <div class="album-cover"
                style="background-image : 
                    @if (is_null($album->cover)) url('{{ URL::to('/img') }}/unknown_cover.png')
                    @else
                    url('{{ URL::to('storage/files/albums') }}/{{ $artist->slug }}/{{ $album->cover }}') @endif
                    ">
            </div>
            <div class="album-details">
                <h2 class="album-name">{{ $album->name }}</h2>
                <p>par <a href="{{route('artist.show', $artist->slug)}}">{{$artist->name}}</a></p>
                <a href="{{ route('style.show', $style->slug); }}" class="album-style">{{ $style->name }} <span>&rsaquo;</span></a>
                <div class="album-specs">
                    <span>{{ count($titles); }} titres • {{ $length }} • {{ $album->release }}</span>
                </div>
            </div>
        </div>

        <div class="album-actions">
            <button id="addToFavorite" class="favorite"><img src="{{ URL::to('/img') }}/fav-fill.svg" alt=""><span>Ajouter</span></button>
            <button id="addToFavorite" class="listen"><img src="{{ URL::to('/img') }}/play.svg" alt=""><span>Écouter</span></button>
        </div>

        <div class="titles-list">
            @foreach ($titles as $title)
                <div class="title-element">
                    <div class="title-position"><span class="title-position-span">{{$title->position}}</span></div>
                    <div class="title-name">{{$title->name}}</div>
                    <div class="title-favorite">
                        {{-- @if -- Si l'utilisateur a aimé le son alors coeur plein sinon coeur vide--}}
                        <img src="{{URL::to('/img')}}/fav-fill.svg" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection