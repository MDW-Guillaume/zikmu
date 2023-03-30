if ($('.unique-song-form')[0] != 'undefined') {
    var playSongForm = $('.unique-song-form')
    console.log(playSongForm)
}
// console.log(typeof (playSongForm), $('.unique-song-form')[0], $('.unique-song-form')[0] != 'undefined')

if (typeof (playSongForm) != 'undefined') {
    for (let i = 0; i < playSongForm.length; i++) {
        playSongForm[i].addEventListener('submit', function (e) {
            e.preventDefault();

            var formData = $(playSongForm[i]).serialize();

            console.log(formData)


            if (playSongForm[i].classList.contains('favorite-unique-song-form')) {
                var url = '/play-form-favorite'
                console.log('ici')
            } else {
                var url = '/play-unique-song'
                console.log('la')
            }

            $.ajax({
                url: url,
                type: 'post',
                processData: false,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.request != null) {
                        var songArray = response.request
                        if (response.request.hasOwnProperty('clickedSong')) {
                            var clickedSong = response.request['clickedSong']
                            var selection = null;
                        }
                        var lastSong = null;
                        // var selection = null;
                        var playlist = []; // List of songs
                        let i = -1

                        console.log(typeof(songArray))

                        Object.values(songArray).forEach(sentSong => {
                            // playlist.push("music/music/" + sentSong) // Fonctionne pour les noms de fichiers en dur
                            playlist.push("/storage/files/music/" + sentSong)
                        });
                        console.log('playlist : ' + playlist)

                        var player = document.getElementById("audioplayer"); // Get audio element
                        player.autoplay = true;

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

                        player.play(); // Start song
                    }
                }
            })
        })
    }
}
