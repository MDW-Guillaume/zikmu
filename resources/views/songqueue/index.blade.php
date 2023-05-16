@extends('layout.online')

@section('title')
    File d'attente
@endsection

@section('scss')
    @vite(['resources/scss/songqueue.scss'])

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
@endsection

@section('content')
    <div id="content">
        <div class="page-songqueue page-album" id="songQueuePage">
            <input name="csrf" type="hidden" value="{{ csrf_token() }}" id="csrfToken">
            <div class="style-name">
                <h2>A suivre</h2>
            </div>

            <div class="song-playing-container">
                <img src="" alt="" class="song-playing-cover" id="coverSongPlayed">
                <div class="song-playing-container-info">
                    <p class="music-player-command-title-song" id="NameSongPlayed"></p>
                    <span class="music-player-command-title-album" id="NameAlbumPlayed"></span>
                    <span class="music-player-command-title-separator"> • </span>
                    <span class="music-player-command-title-artist" id="NameArtistPlayed"></span>
                </div>
            </div>

            <div class="playlist-panel">
                <div class="playlist-panel-info">
                    <div class="playlist-panel-info-titles">
                        <span class="playlist-panel-info-titles-number" id="songQueueTitles"></span>
                        <span class="playlist-panel-info-titles-text">titres</span>
                    </div>
                    <div class="separator"> • </div>
                    <div class="playlist-panel-info-length">
                        <span class="playlist-panel-info-length-number" id="songQueueLength"></span>
                    </div>
                </div>
                <div class="playlist-panel-action" id="randomPlaylistAction">
                    <span class="playlist-panel-action-label">lecture aléatoire</span>
                    <img src="{{ URL::to('/img/randomizer.svg') }}" alt="" class="playlist-pannel-action-img">
                </div>
            </div>

            <div class="songQueue-container titles-list" id="songQueueContainer">

            </div>
        </div>
    </div>
@endsection
