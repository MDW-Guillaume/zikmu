<footer>
    <div class="mobile-player" id="mobileMinPlayer">
        <div class="mobile-player-informations">
        <div class="mobile-player-cover">
            <img src="" class="music-player-cover-image coverSong" id="coverSongMobile" alt="">
        </div>

        <div class="mobile-player-details">
            <span class="music-player-command-title-song playerInfoName" id="playerInfoNameMobile"></span>
            <span class="music-player-command-title-artist playerInfoArtist" id="playerInfoArtistMobile"></span>
        </div>
    </div>
        <div class="mobile-player-commands">
            <img src="{{ URL::to('/img/pause.svg') }}" class="repeat-icon playerPause playerPauseMobile" id="playerPause" alt="">
            <img src="{{ URL::to('/img/play.svg') }}" class="repeat-icon playerPlay playerPlayMobile" id="playerPlay" alt="">
            <img src="{{ URL::to('/img/next.svg') }}" class="repeat-icon playerNext" id="playerNext" alt="">
        </div>

    </div>

    <div class="footer-container">
        <ul class="footer-links">
            <li><a href="{{ route('ml') }}">Mentions légales</a></li>
            <li><a href="{{ route('cgv') }}">CGV</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <ul class="social-links">
            <li><a href="https://facebook.com" id="facebookLink" target="_blank"><img
                        src="{{ URL::to('/img') }}/facebook.svg" alt=""></a></li>
            <li><a href="https://instagram.com" id="instagramLink" target="_blank"><img
                        src="{{ URL::to('/img') }}/instagram.svg" alt=""></a></li>
            <li><a href="https://pinterest.com" id="pinterestLink" target="_blank"><img
                        src="{{ URL::to('/img') }}/pinterest.svg" alt=""></a></li>
        </ul>
    </div>
</footer>
