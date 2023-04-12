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

            if (playSongForm[i].classList.contains('favorite-unique-song-form')) {
                // SI le clic vient de la page Favoris
                var url = '/play-form-favorite'
            } else {
                // SI le clic vient d'ailleurs
                var url = '/play-unique-song'
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

                    console.log('la')
                    console.log(response.songs)

                    if (response.songs.hasOwnProperty('clickedSong')) {
                        var clickedSong = response.songs['clickedSong']
                        var selection = null;
                    }


                    var lastSong = null;
                    var playlist = []; // List of songs
                    var clickedSongPath = '';

                    let coverSongArray = response.songs
                    let coverArray = []
                    let coverDiv = document.getElementById('coverSong')
                    let bottomSidebar = document.getElementById('bottomSidebar');


                    Object.entries(songsArray).forEach(([key, songArray]) => {
                        console.log(`${key}: ${songArray}`)
                        if (key != 'clickedSong') {
                            playlist.push("/storage/files/music/" + songArray.song)
                        } else {
                            clickedSongPath = "/storage/files/music/" + songArray.song
                        }
                    });

                    localStorage.setItem("playlist", playlist);

                    Object.values(coverSongArray).forEach(coverElement => {
                        coverArray.push("/storage/files/albums/" + coverElement.cover)
                    });




                    var player = document.getElementById("audioplayer"); // Get audio element
                    player.autoplay = true;

                    player.addEventListener("ended", playSong);

                    // function playSong() {
                    //     i++
                    //     localStorage.setItem("playlist-placement-i", i)
                    //     while (selection == lastSong) {
                    //         selection = i
                    //     };
                    //     lastSong = selection; // Remember the last song
                    //     if(playlist[selection] != undefined){
                    //         player.src = playlist[selection]; // Tell HTML the location of the new song
                    //     }
                    //     if(coverArray[selection]!= undefined){
                    //         coverDiv.src = coverArray[selection]; // Tell HTML the location of the new song
                    //     }

                    //     player.addEventListener("ended", function () {
                    //         if (playlist.length - 1 == selection) {
                    //             bottomSidebar.style.height = "70px"
                    //             localStorage.removeItem("playlist")
                    //             localStorage.removeItem("playlist-placement-i")
                    //         }
                    //     });
                    // }

                    /* Lecture d'un titre suivant */


                    // Pour jouer un son qui est cliqué:
                    // On va récupérer la clé du son correspondant dans le tableau playlist
                    // On enregistre et envoie cette variable en appelant la fonction playSong
                    // avec un paramètre qui sera la posoition du son


                    // let i = 0

                    // Je chercher a récupérer la clé de la playlist à partir de la valeur de la variable clickedSongPath

                    let clickedSongIndex = playlist.indexOf(clickedSongPath);

                    let playerNext = document.getElementById('playerNext')

                    localStorage.setItem("playlist-placement-i", clickedSongIndex);

                    playerNext.addEventListener('click', function () {
                        let currentStep = localStorage.getItem("playlist-placement-i")
                        currentStep++

                        playSong(currentStep)
                    })

                    function playSong(stepSong = null) {

                        while (selection == lastSong) {
                            selection = clickedSongIndex
                        };

                        if (typeof (stepSong) == 'number') {
                            selection = stepSong
                        }



                        // On reinitialise la variable stepSong pour continuer la lecture de la playlist
                        stepSong = null

                        localStorage.setItem("playlist-placement-i", clickedSongIndex)

                        lastSong = selection; // Remember the last song

                        if (playlist[selection] != undefined) {
                            player.src = playlist[selection];
                        }

                        if (coverArray[selection] != undefined) {
                            coverDiv.src = coverArray[selection];
                        }

                        clickedSongIndex++

                        player.addEventListener("ended", function () {
                            if (playlist.length == selection) {
                                bottomSidebar.style.height = "70px"
                                localStorage.removeItem("playlist")
                                localStorage.removeItem("playlist-placement-i")
                                player.removeAttribute('src', 'autoplay')
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
