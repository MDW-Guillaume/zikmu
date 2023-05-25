<div class="sidebar">
    <div class="sidebar-container">
        <div class="top-sidebar">
            <h1>
                <a href="{{ route('home') }}">
                    <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
                </a>
            </h1>

            <div class="search-bar">
                <form action="/search" method="post" class="searchbar-form relative" id="searchBarForm">
                    {{ csrf_field() }}
                    <input type="search" name="search" id="sidebarSearch"
                        placeholder="Artistes, titres, albums...">
                    <img src="{{ URL::to('/img/search.svg') }}" class="search-icon absolute" alt="">
                </form>
            </div>
        </div>

        <div class="middle-sidebar" id="sidebarMenu">
            <nav class="sidebar-navigation">
                <ul>
                    <li><a href="{{ route('favorite.show') }}"><img src="{{ URL::to('/img') }}/fav-not-fill.svg">Coups
                            de coeur</a></li>
                    <li><a href="{{ route('artist.myartists') }}"><img src="{{ URL::to('/img') }}/microphone.png">Mes
                            artistes</a></li>
                    <li><a href="{{ route('album.myalbums') }}"><img src="{{ URL::to('/img') }}/compact-disc.png">Mes
                            albums</a></li>
                </ul>
            </nav>
        </div>

    </div>
    <div class="bottom-sidebar" id="bottomSidebar">
        <div class="profile-container">
            <a href="{{ route('profile.index') }}" class="c-white">
                <span class="profile-icon-span"><img src="{{ URL::to('/img/user.svg') }}" class="profile-icon"
                        alt=""></span>
                <span class="profile-text-span">Mon compte</span>
            </a>
        </div>
        <audio id="audioplayer" controls></audio>
        <div class="music-player">
            <div class="music-player-cover-container">
                <img src="" class="music-player-cover-image" id="coverSong" alt="">
                <img src="{{ URL::to('/img') }}/arrow-down.png" alt="" id="reducePlayer">
            </div>

            <div class="music-player-command-container c-white">
                <img src="{{ URL::to('/img') }}/arrow-up.png" alt="" id="showPlayer">
                <div class="music-player-command-slide">
                    <div class="music-player-command-slide-time">
                        <div class="music-player-command-slide-time-direct">
                            <span id="musicCurrentTime">00:00<span>
                        </div>
                        <div class="music-player-command-slide-time-total">
                            <span id="musicDuration">00:00<span>
                        </div>
                    </div>
                    <div class="music-player-command-slide-controller">
                        <input type="range" id="timeSlider" step="0.01">
                    </div>
                </div>
                <div class="music-player-command-title">
                    <span class="music-player-command-title-song" id="playerInfoName">Space Oddity (2015
                        Remaster){{-- Variable song.name --}}</span><br>
                    <span class="music-player-command-title-album"
                        id="playerInfoAlbum">ChangesOneBowie{{-- Variable album.name --}}</span>
                    <span class="music-player-command-title-separator">• </span>
                    <span class="music-player-command-title-artist" id="playerInfoArtist">David
                        Bowie{{-- Variable artist.name --}}</span>
                </div>
                <div class="music-player-command-controllers">
                    <div class="music-player-command-controllers-rewind">
                        {{-- <img src="{{ URL::to('/img/repeatOnce.svg') }}" class="repeat-icon" id="repeatOnce" alt="">
                        <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon" id="repeat" alt=""> --}}
                        <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon" id="repeat" data-status="initial" alt="">
                    </div>
                    <div class="music-player-command-controllers-player">
                        <img src="{{ URL::to('/img/previous.svg') }}" class="repeat-icon" id="playerPrevious"
                            alt="">
                        <img src="{{ URL::to('/img/pause.svg') }}" class="repeat-icon" id="playerPause" alt="">
                        <img src="{{ URL::to('/img/play.svg') }}" class="repeat-icon" id="playerPlay" alt="">
                        <img src="{{ URL::to('/img/next.svg') }}" class="repeat-icon" id="playerNext" alt="">
                    </div>
                    <div class="music-player-command-controllers-randomizer">
                        <img src="{{ URL::to('/img/randomizer.svg') }}" class="repeat-icon" id="randomBtn"
                            alt="">

                    </div>
                </div>
            </div>
            <div class="music-player-waiting-list">
                <a href="{{ route('waiting.index') }}" class="c-white">
                    <span class="waiting-icon-span"><img src="{{ URL::to('/img/queue.svg') }}" class="waiting-icon"
                            alt=""></span>
                    <span class="waiting-text-span">File d'attente</span>
                </a>
            </div>
        </div>
    </div>
</div>
