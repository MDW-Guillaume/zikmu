@extends('layout.online')

@section('title')
    Lecteur
@endsection

@section('content')
    <div id="content">
        <div class="page-player">
                <h2 id="albumName" class="album-name"></h2>
            <div class="album-cover">
                <img src="" alt="cover" id="albumCover">
            </div>
            <div class="title-favorite">
                <form action="{{ route('favorite.store') }}" class="actionFavorite" method="post">
                    {{ csrf_field() }}
                    <input name="title" type="hidden" id="songIdFavorite">
                    {{-- <input name="user" type="hidden" value="{{ $album->slug }}"> --}}
                    <button type="submit" id="favoriteButton"
                        class="favorite-button {{-- @if($title->favorite==true)is-favorite@endif --}}">
                        <div class="favorite-album"><img src="{{ URL::to('/img') }}/fav-fill.svg"
                            alt=""><span>Retirer</span></div>
                    <div class="not-favorite-album"><img src="{{ URL::to('/img') }}/fav-not-fill.svg"
                            alt=""><span>Ajouter</span></div>
                    </button>
                </form>
            </div>
            <div class="music-player-command-container">
                <div class="music-player-command-slide">
                    <div class="music-player-command-slide-time">
                        <div class="music-player-command-slide-time-direct">
                            <span class="musicCurrentTime">00:00<span>
                        </div>
                        <div class="music-player-command-slide-time-total">
                            <span class="musicDuration">00:00<span>
                        </div>
                    </div>
                    <div class="music-player-command-slide-controller">
                        <input type="range" class="timeSlider" step="0.01">
                    </div>
                </div>
                <div class="music-player-command-title">
                    <span class="music-player-command-title-song playerInfoName" id="playerInfoNameMobile"></span><br>
                    <a href="" class="playerInfoAlbumSlug playerInfoAlbumSlugMobile"><span class="music-player-command-title-album playerInfoAlbum"
                        id="playerInfoAlbumMobile"></span></a>
                    <span class="music-player-command-title-separator">• </span>
                    <a href="" class="playerInfoArtistSlug playerInfoArtistSlugMobile"><span class="music-player-command-title-artist playerInfoArtist" id="playerInfoArtistMobile"></span></a>
                </div>
                <div class="music-player-command-controllers">
                    <div class="music-player-command-controllers-rewind">
                        <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon repeatBtn" data-status="initial" alt="">
                    </div>
                    <div class="music-player-command-controllers-player">
                        <img src="{{ URL::to('/img/previous.svg') }}" class="repeat-icon playerPrevious playerPreviousMobile"
                            alt="">
                        <img src="{{ URL::to('/img/pause.svg') }}" class="repeat-icon playerPause playerPauseMobile" alt="">
                        <img src="{{ URL::to('/img/play.svg') }}" class="repeat-icon playerPlay playerPlayMobile"  alt="">
                        <img src="{{ URL::to('/img/next.svg') }}" class="repeat-icon playerNext playerNextMobile"  alt="">
                    </div>
                    <div class="music-player-command-controllers-randomizer">
                        <img src="{{ URL::to('/img/randomizer.svg') }}" class="repeat-icon randomBtn randomBtnMobile"
                            alt="">

                    </div>
                </div>
            </div>
            <div class="music-player-waiting-list" id="waitingListButton">
                <a href="{{ route('waiting.index') }}" class="c-white" id="waitingLinkMobile">
                    <span class="waiting-icon-span"><img src="{{ URL::to('/img/queue2.svg') }}" class="waiting-icon"
                            alt=""></span>
                    <span class="waiting-text-span">File d'attente</span>
                </a>
            </div>
        </div>
    </div>
@endsection
