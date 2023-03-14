@extends('layout.online')

@section('title')
    Coups de coeur
@endsection

@section('scss')
    @vite(['resources/scss/favorite.scss'])
    @vite(['resources/js/favorite-play.js'])

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

@endsection

@section('content')
    <div class="page-favorite">
        <div class="favorite-card">
            <div class="favorite-cover" style="background-image : url('{{ URL::to('/img') }}/favorite-playlist.png')">
            </div>
            <div class="favorite-details">
                <div class="favorite-specs">
                    <h2 class="favorite-name">Coups de coeur</h2>
                    <p>par
                        @if (!is_null($user->firstname))
                            {{$user->firstname}} {{$user->lastname}}
                        @else
                            {{$user->username}}
                        @endif

                        {{-- Nom prénom / ou / nom d'utilisateur --}}</p>
                    <span>Durée : {{ $length }}</span>
                </div>
                <div class="favorite-actions">
                    <form action="{{route('favorite.play')}}" method="post" id="playPlaylist">
                        @csrf
                        @foreach ($songs as $song)
                            {{-- {{dd($song->id)}} --}}
                            <input type="hidden" value="{{$song->id}}" name="{{$song->id}}">
                        @endforeach
                    <button type="submit"  class="play-playlist"><img src="{{ URL::to('/img') }}/play.svg"
                            alt=""><span>Lire</span></button>
                        </form>
                    <button id="playPlaylistRandom" class="play-playlist-random"><img
                            src="{{ URL::to('/img') }}/randomizer.svg" alt=""><span>Aléatoire</span></button>
                </div>
            </div>
        </div>

        <div class="favorite-playlist">
            @foreach ($songs as $song)
                <div class="favorite-element">
                    <div class="favorite-cover">
                        @if(is_null($song->album_cover))
                            <img src="{{ URL::to('/img') }}/unknown_cover.png" alt="">
                        @else
                            <img src="{{ URL::to('storage/files/albums') }}/{{ $song->artist_slug }}/{{ $song->album_cover }}" alt="">
                        @endif
                    </div>
                    <div class="favorite-info">
                        <div class="favorite-title">
                            <span>{{$song->name}}</span>
                            <p>{{$song->artist_name}} • {{$song->album_name}}</p>
                        </div>
                    </div>
                    <div class="favorite-delete">
                        <img src="{{ URL::to('/img') }}/close.svg" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
