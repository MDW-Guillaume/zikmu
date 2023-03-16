let playOnce = $('#playPlaylist')[0]
console.log(playOnce)

playOnce.addEventListener('submit', function (e) {
    e.preventDefault();
    
    let playerMethod = e.submitter.value
    // getPlayerMethod()
    console.log(playerMethod)
    // const submitButtons = e.target.querySelectorAll('button[type="submit"]');

    // for (let i = 0; i < submitButtons.length; i++) {
    //     submitButtons[i].addEventListener('click', function (event) {
    //         const submittedButtonValue = event.target.getAttribute('value');
    //         if (submittedButtonValue === 'linear') {
    //             const playerMethod = 'linear'
    //         } else if (submittedButtonValue === 'random') {
    //             const playerMethod = 'random'
    //         }
    //     });
    // }

    // console.log(submittedButtonValue)

    var formData = $(playOnce).serialize();
    // console.log(formData)
    $.ajax({
        url: '/favorite',
        type: 'post',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.request != null) {
                // var songArray = JSON.stringify(response.request)
                var songArray = response.request
                // console.log(songArray)

                var lastSong = null;
                var selection = null;
                var playlist = []; // List of songs
                let i = -1


                songArray.forEach(sentSong => {
                    // playlist.push("music/music/" + sentSong) // Fonctionne pour les noms de fichiers en dur
                    playlist.push("storage/files/music/" + sentSong) 
                });
                console.log('playlist : ' + playlist)

                var player = document.getElementById("audioplayer"); // Get audio element
                player.autoplay = true;

                if (playerMethod === 'linear') {

                    player.addEventListener("ended", playSong);

                    function playSong() {
                        i++
                        while (selection == lastSong) {
                            selection = i
                        };
                        lastSong = selection; // Remember the last song
                        player.src = playlist[selection]; // Tell HTML the location of the new song
                    }

                    playSong();

                } else if (playerMethod === 'random') {

                    player.addEventListener("ended", selectRandom); // Run function when the song ends

                    function selectRandom() {
                        while (selection == lastSong) { // Repeat until a different song is selected
                            selection = Math.floor(Math.random() * playlist.length);
                        }
                        lastSong = selection; // Remember the last song
                        player.src = playlist[selection]; // Tell HTML the location of the new song
                    }

                    selectRandom(); // Select initial song
                }

                player.play(); // Start song
            }
        }
    })

})
