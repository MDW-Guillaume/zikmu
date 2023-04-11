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
                // SI le clic vient de la page Favoris
                var url = '/play-form-favorite'
                console.log('ici')
            } else {
                // SI le clic vient d'ailleurs
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
                    // LECTURE DU SON
                    var songsArray = response.songs

                    if (response.songs.hasOwnProperty('clickedSong')) {
                        var clickedSong = response.songs['clickedSong']
                        var selection = null;
                    }


                    var lastSong = null;
                    var playlist = []; // List of songs
                    let i = -1

                    let coverSongArray = response.songs
                    let coverArray = []
                    let coverDiv = document.getElementById('coverSong')
                    let bottomSidebar = document.getElementById('bottomSidebar');


                    Object.values(songsArray).forEach(songArray => {
                        playlist.push("/storage/files/music/" + songArray.song)
                    });

                    Object.values(coverSongArray).forEach(coverElement => {
                        coverArray.push("/storage/files/albums/" + coverElement.cover)
                    });


                    var player = document.getElementById("audioplayer"); // Get audio element
                    player.autoplay = true;

                    player.addEventListener("ended", playSong);

                    function playSong() {
                        i++
                        while (selection == lastSong) {
                            selection = i
                        };
                        lastSong = selection; // Remember the last song
                        if(playlist[selection] != undefined){
                            player.src = playlist[selection]; // Tell HTML the location of the new song
                        }
                        if(coverArray[selection]!= undefined){
                            coverDiv.src = coverArray[selection]; // Tell HTML the location of the new song
                        }

                        player.addEventListener("ended", function () {
                            if (playlist.length - 1 == selection) {
                                bottomSidebar.style.height = "70px"
                            }
                        });
                    }

                    // LAUNCH

                    playSong();

                    player.play(); // Start song
                }
            })
        })
    }
}
