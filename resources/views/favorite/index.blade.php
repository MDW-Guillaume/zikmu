@extends('layout.online')

@section('title')
    Coups de coeur
@endsection

@section('scss')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection

@section('content')
    <div id="content">
        <div class="page-favorite">
            <div class="favorite-card">
                <div class="favorite-cover" style="background-image : url('{{ URL::to('/img') }}/favorite-playlist.png')">
                </div>
                <div class="favorite-details">
                    <div class="favorite-specs">
                        <h2 class="favorite-name">Coups de coeur</h2>
                        <p>par
                            @if (!is_null($user->firstname))
                                {{ $user->firstname }} {{ $user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif

                            {{-- Nom prénom / ou / nom d'utilisateur --}}
                        </p>
                        <span>Durée : {{ $length }}</span>
                    </div>
                    <div class="favorite-actions">
                        <form action="{{ route('song.play') }}" method="post" id="playPlaylist">
                            @csrf
                            @foreach ($songs as $song)
                                {{-- {{dd($song->id)}} --}}
                                <input type="hidden" value="{{ $song->id }}" name="{{ $song->id }}">
                            @endforeach
                            <button type="submit" value="linear" class="play-playlist"><img
                                    src="{{ URL::to('/img') }}/play.svg" alt=""><span>Lire</span></button>
                            <button type="submit" value="random" id="playPlaylistRandom" class="play-playlist-random"><img
                                    src="{{ URL::to('/img') }}/randomizer.svg"
                                    alt=""><span>Aléatoire</span></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="favorite-playlist">
                @foreach ($songs as $song)
                <form action="{{ route('song.uniqueplay') }}" method="post" class="unique-song-form favorite-unique-song-form" data-id="{{$song->id}}">
                    @csrf
                    <div class="favorite-element">
                        <div class="favorite-cover">
                            @if (is_null($song->album_cover))
                                <img src="{{ URL::to('/img') }}/unknown_cover.png" alt="">
                            @else
                                <img src="{{ URL::to('storage/files/albums') }}/{{ $song->artist_slug }}/{{ $song->album_cover }}"
                                    alt="">
                            @endif
                        </div>
                        <div class="favorite-info">
                            <div class="favorite-title">
                                <span>{{ $song->name }}</span>
                                <p><a href="{{ route('artist.show', $song->artist_slug) }}">{{ $song->artist_name }}</a> •
                                    <a href="{{ route('album.show', $song->album_slug) }}">{{ $song->album_name }}</a></p>
                            </div>
                        </div>
                        <div class="favorite-delete">
                            {{-- <form action="{{ route('favorite.store') }}" class="actionFavorite" method="post"> --}}
                                {{-- {{ csrf_field() }} --}}
                                <input name="title" type="hidden" value="{{ $song->id }}">
                                <input name="csrf" type="hidden" value="{{ csrf_token() }}">
                                {{-- @csrf --}}
                                <button type="button" id="favoriteButton" class="favorite-button" data-id="{{ $song->id }}">
                                    <img src="{{ URL::to('/img') }}/close.svg" alt="">
                                </button>
                            {{-- </form> --}}

                        </div>
                        <input type="submit" class="play-song-submit" value="">
                        <input type="hidden" name="title_id" value="{{ $song->id }}">
                    </div>

                </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
