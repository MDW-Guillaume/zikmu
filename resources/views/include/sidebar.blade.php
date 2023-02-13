<div class="sidebar">
    <div class="sidebar-container">
        <div class="top-sidebar">
            <h1>
                <a href="{{ route('home') }}">
                    <img src="{{ URL::to('/') }}/img/logo.png" alt="Zik&Mu">
                </a>
            </h1>

            <div class="search-bar">
                <div class="relative">
                <input type="search" name="sidebar-search" id="sidebarSearch" placeholder="Artistes, titres, albums...">
                <img src="{{ URL::to('/img/search.svg') }}" class="search-icon absolute"
                        alt="">
                </div>
            </div>
        </div>
        <div class="bottom-sidebar">
            <div class="profile-container">
                <a href="{{ route('profile.index') }}" class="c-white">
                    <span class="profile-icon-span"><img src="{{ URL::to('/img/user.svg') }}" class="profile-icon"
                            alt=""></span>
                    <span class="profile-text-span">Mon compte</span>
                </a>
            </div>

            <div class="music-player">
                <div class="music-player-cover-container">
                    <img src="{{ URL::to('/img/Frame 37.png') }}{{-- Variable album.cover --}}" class="profile-icon" alt="">
                </div>

                <div class="music-player-command-container c-white">
                    <div class="music-player-command-slide">
                        <div class="music-player-command-slide-time">
                            <div class="music-player-command-slide-time-direct">
                                {{-- JS pour ajouter 1 seconde / package de lecture de musique? --}}
                                <span class="music-player-command-slide-time-direct-minute">00</span>
                                <span class="music-player-command-slide-time-direct-divider">:</span>
                                <span class="music-player-command-slide-time-direct-second">00</span>
                            </div>
                            <div class="music-player-command-slide-time-total">
                                <span class="">00:00{{-- Variable song.length --}}</span>
                            </div>
                        </div>
                        <div class="music-player-command-slide-controller">
                            <input type="range" id="seek-slider" max="100" value="0">
                        </div>
                    </div>
                    <div class="music-player-command-title">
                        <span class="music-player-command-title-song">Space Oddity (2015 Remaster){{-- Variable song.name --}}</span><br>
                        <span class="music-player-command-title-album">ChangesOneBowie{{-- Variable album.name --}} •</span>
                        <span class="music-player-command-title-artist">David Bowie{{-- Variable artist.name --}}</span>
                    </div>
                    <div class="music-player-command-controllers">
                        <div class="music-player-command-controllers-rewind">
                            <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon" id="repeatOnce"
                                alt="">
                            <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon" id="repeat"
                                alt="">
                            <img src="{{ URL::to('/img/repeat.svg') }}" class="repeat-icon" id="repeatNone"
                                alt="">
                        </div>
                        <div class="music-player-command-controllers-player">
                            <img src="{{ URL::to('/img/previous.svg') }}" class="repeat-icon" id="playerPrevious"
                                alt="">
                            <img src="{{ URL::to('/img/pause.svg') }}" class="repeat-icon" id="playerPause"
                                alt="">
                            <img src="{{ URL::to('/img/play.svg') }}" class="repeat-icon" id="playerPlay"
                                alt="">
                            <img src="{{ URL::to('/img/next.svg') }}" class="repeat-icon" id="playerNext"
                                alt="">
                        </div>
                        <div class="music-player-command-controllers-randomizer">
                            <img src="{{ URL::to('/img/randomizer.svg') }}" class="repeat-icon" id="randomActive"
                                alt="">
                            <img src="{{ URL::to('/img/randomizer.svg') }}" class="repeat-icon" id="randomInactive"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="music-player-waiting-list">
                    <a href="{{-- route('waiting.index')--}}" class="c-white">
                        <span class="waiting-icon-span"><img src="{{ URL::to('/img/queue.svg') }}" class="waiting-icon"
                                alt=""></span>
                        <span class="waiting-text-span">File d'attente</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
