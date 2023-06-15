<footer>
    <div class="mobile-player" id="mobileMinPlayer">
        <div class="mobile-player-cover">
            <img src="" class="music-player-cover-image coverSong" id="coverSong" alt="">
        </div>

        <div class="mobile-player-details">
            <span class="music-player-command-title-song playerInfoName" id="playerInfoName"></span>
            <p>
                <span class="music-player-command-title-album playerInfoAlbum" id="playerInfoAlbum"></span>
                <span class="music-player-command-title-artist playerInfoArtist" id="playerInfoArtist"></span>
            </p>
        </div>

        <div class="mobile-player-commands">
            <img src="{{ URL::to('/img/pause.svg') }}" class="repeat-icon playerPause" id="playerPause" alt="">
            <img src="{{ URL::to('/img/play.svg') }}" class="repeat-icon playerPlay" id="playerPlay" alt="">
            <img src="{{ URL::to('/img/next.svg') }}" class="repeat-icon playerNext" id="playerNext" alt="">
        </div>

    </div>

    <div class="footer-container">
        <ul class="footer-links">
            <li><a href="#">Mentions légales</a></li>
            <li><a href="#">CGV</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <ul class="social-links">
            <li><a href="#"><img src="{{ URL::to('/img') }}/facebook.svg" alt=""></a></li>
            <li><a href="#"><img src="{{ URL::to('/img') }}/instagram.svg" alt=""></a></li>
            <li><a href="#"><img src="{{ URL::to('/img') }}/pinterest.svg" alt=""></a></li>
        </ul>
    </div>
</footer>
