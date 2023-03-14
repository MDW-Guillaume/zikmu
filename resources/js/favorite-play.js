let playOnce = $('#playPlaylist')[0]
console.log(playOnce)
playOnce.addEventListener('submit', function(e){
    e.preventDefault();
    alert('ok')
    var formData = $(playOnce).serialize();
    // console.log(formData)
    $.ajax({
        url: '/favorite',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if(response.request != null){
                // var songArray = JSON.stringify(response.request)
                var songArray = response.request
                console.log(songArray)

                var lastSong = null;
                var selection = null;
                var playlist = []; // List of songs



                songArray.forEach(sentSong => {
                    console.log('sentSong : ' + sentSong)
                    playlist.push("music/music/" + sentSong)
                });
                console.log('playlist : ' +playlist)

                var player = document.getElementById("audioplayer"); // Get audio element
                player.autoplay = true;
                player.addEventListener("ended", selectRandom); // Run function when the song ends

                function selectRandom() {
                    while (selection == lastSong) { // Repeat until a different song is selected
                        selection = Math.floor(Math.random() * playlist.length);
                    }
                    lastSong = selection; // Remember the last song
                    player.src = playlist[selection]; // Tell HTML the location of the new song
                }

                selectRandom(); // Select initial song
                player.play(); // Start song
            }
        }
    })

})
