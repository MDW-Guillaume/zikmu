if ($('.unique-song-form')[0] != 'undefined') {
    var playSongForm = $('.unique-song-form')
}

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

                    if (response.songs.hasOwnProperty('clickedSong')) {
                        var clickedSong = response.songs['clickedSong']
                        var selection = null;
                    }


                    var lastSong = null;
                    var playlist = []; // List of songs
                    var clickedSongPath = '';

                    let coverSongArray = response.songs
                    let coverArray = []
                    let responseSongNameArray = response.songs
                    let songNameArray = []
                    let responseArtistNameArray = response.songs
                    let artistNameArray = []
                    let responseAlbumNameArray = response.songs
                    let albumNameArray = []
                    let coverDiv = document.getElementById('coverSong')
                    let playerInfoArtist = document.getElementById('playerInfoArtist')
                    let playerInfoAlbum = document.getElementById('playerInfoAlbum')
                    let playerInfoSong = document.getElementById('playerInfoName')
                    let bottomSidebar = document.getElementById('bottomSidebar');


                    Object.entries(songsArray).forEach(([key, songArray]) => {
                        if (key != 'clickedSong') {
                            playlist.push(songArray.song)
                        } else {
                            clickedSongPath = songArray.song
                        }
                    });
                    console.log(playlist)
                    if(localStorage.getItem('playlist')){
                        localStorage.removeItem("playlist")
                    }

                    if(localStorage.getItem('playlist-placement-i')){
                        localStorage.removeItem("playlist-placement-i")
                    }

                    localStorage.setItem("playlist", playlist);

                    Object.values(songsArray).forEach(coverElement => {
                        coverArray.push(coverElement.cover)
                    });

                    Object.values(songsArray).forEach(songNameElement => {
                        songNameArray.push(songNameElement.songName)
                    });

                    Object.values(songsArray).forEach(artistNameElement => {
                        artistNameArray.push(artistNameElement.artist)
                    });
                    Object.values(songsArray).forEach(albumNameElement => {
                        albumNameArray.push(albumNameElement.album)
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

                    let pauseBtn = document.getElementById('playerPause')
                    let resumeBtn = document.getElementById('playerPlay')
                    let playerNext = document.getElementById('playerNext')
                    let playerPrev = document.getElementById('playerPrevious')
                    let randomBtn = document.getElementById('randomBtn')
                    if(randomBtn.hasAttribute('data-active')){
                        randomBtn.removeAttribute('data-active')
                    }

                    localStorage.setItem("playlist-placement-i", clickedSongIndex);

                    let audioDuration = 0;

                    player.addEventListener('timeupdate', function () {
                        audioDuration = player.currentTime;
                    });

                    playerNext.addEventListener('click', function () {
                        console.log('je joue le suivant')
                        if (audioDuration > 1) {
                            player.pause()
                            // setTimeout(function () {
                            let currentStep = localStorage.getItem("playlist-placement-i")
                            let nextStep = parseInt(currentStep) + 1

                            if (parseInt(currentStep) + 1 != playlist.length) {
                                currentStep = parseInt(currentStep) + 1
                                localStorage.setItem('playlist-placement-i', currentStep)
                                playSong(currentStep)
                            }

                            // }, 1000);
                        }
                    })

                    playerPrev.addEventListener('click', function () {
                        console.log('Je joue le précédent')
                        let currentStep = localStorage.getItem("playlist-placement-i")
                        // Verification si il existe un titre avant, sinon bouton désactivé.
                        if (currentStep - 1 >= 0) {
                            currentStep--
                            localStorage.setItem('playlist-placement-i', currentStep)
                            playSong(currentStep)
                        } else {
                            playSong(Number(currentStep))
                        }

                    })

                    randomBtn.addEventListener('mousedown', function () {
                        let currentIndex = localStorage.getItem('playlist-placement-i')
                        if (randomBtn.getAttribute('data-active') !== 'active') {
                            randomBtn.setAttribute('data-active', 'active')
                            // let currentTrackIndex = playlist.indexOf(playlist[currentIndex]);
                            // console.log(playlist[currentIndex], currentTrackIndex)
                            // let currentTrack = playlist[currentTrackIndex];
                            // console.log(currentTrack)

                            // function shuffleArray(array) {
                            //     for (let i = array.length - 1; i > 0; i--) {
                            //         let j = Math.floor(Math.random() * (i));
                            //         // console.log(j);
                            //         // console.log(i);
                            //         [array[i], array[j]] = [array[j], array[i]];
                            //         console.log(array);
                            //     }
                            // }

                            // On séléctionne au hasard un titre en dehors de celui joué actuellement pour les placer à la suite du titre actuellement joué
                            // Par la même occasion on change l'ordre d'affichage des covers, titres, artiste et albums
                            function shuffleArray(array) {
                                let randomPlaylist = [];
                                let randomCover = []
                                let randomArtist = []
                                let randomAlbum = []
                                let randomSongName = []
                                let playerAudioSrcIndex = ''
                                console.log(coverArray)
                                if (player.hasAttribute("src") && player.getAttribute("src") !== "") {
                                    let audioSrc = player.getAttribute("src");
                                    playerAudioSrcIndex = array.indexOf(audioSrc);
                                    randomPlaylist.push(array[playerAudioSrcIndex])
                                    randomCover.push(coverArray[playerAudioSrcIndex])
                                    randomArtist.push(artistNameArray[playerAudioSrcIndex])
                                    randomAlbum.push(albumNameArray[playerAudioSrcIndex])
                                    randomSongName.push(songNameArray[playerAudioSrcIndex])
                                    array.splice(playerAudioSrcIndex, 1)
                                    coverArray.splice(playerAudioSrcIndex, 1)
                                    artistNameArray.splice(playerAudioSrcIndex, 1)
                                    albumNameArray.splice(playerAudioSrcIndex, 1)
                                    songNameArray.splice(playerAudioSrcIndex, 1)
                                }

                                while ( array.length != 0) {
                                    let randomIndex = Math.floor(Math.random() * array.length);
                                    randomPlaylist.push(array[randomIndex])
                                    randomCover.push(coverArray[randomIndex])
                                    randomArtist.push(artistNameArray[randomIndex])
                                    randomAlbum.push(albumNameArray[randomIndex])
                                    randomSongName.push(songNameArray[randomIndex])
                                    playerAudioSrcIndex = array.indexOf(array[randomIndex]);
                                    array.splice(playerAudioSrcIndex, 1)
                                    coverArray.splice(playerAudioSrcIndex, 1)
                                    artistNameArray.splice(playerAudioSrcIndex, 1)
                                    albumNameArray.splice(playerAudioSrcIndex, 1)
                                    songNameArray.splice(playerAudioSrcIndex, 1)
                                }
                                // for (let i = 0; i < array.length; i++) {
                                //     let randomIndex = Math.floor(Math.random() * array.length);
                                //     console.log(randomIndex)
                                //     console.log("i : " + i)
                                // }

                                let returnArray = {
                                    playlist: randomPlaylist,
                                    cover: randomCover,
                                    artist: randomArtist,
                                    album: randomAlbum,
                                    songName: randomSongName
                                }

                                return returnArray
                            }

                            let shuffledArray = shuffleArray(playlist)
                            playlist = shuffledArray.playlist
                            localStorage.setItem('playlist', playlist)
                            coverArray = shuffledArray.cover
                            artistNameArray = shuffledArray.artist
                            albumNameArray = shuffledArray.album
                            songNameArray = shuffledArray.songName
                            console.log(shuffledArray.playlist);

                            // if (currentTrackIndex !== -1) {
                            //     playlist.splice(currentTrackIndex, 1);
                            //     playlist.unshift(currentTrack);
                            // }
                            // console.log(playlist);
                            localStorage.setItem('playlist-placement-i', 0)
                            // clickedSongIndex = 0
                        } else {
                            randomBtn.removeAttribute('data-active')
                            let currentTrackIndex = playlist.indexOf(playlist[currentIndex]);
                            console.log('currentIndex', currentTrackIndex)
                            Object.entries(songsArray).forEach(([key, songArray]) => {
                                playlist = []
                                if (key != 'clickedSong') {
                                    playlist.push(songArray.song)
                                }
                            });
                        }
                    })

                    function playSong(stepSong = null) {
                        console.log(coverArray)

                        while (selection == lastSong) {
                            selection = clickedSongIndex
                        };

                        if (typeof (stepSong) == 'number') {
                            selection = stepSong
                        }
                        // On reinitialise la variable stepSong pour continuer la lecture de la playlist
                        stepSong = null
                        console.log(clickedSongIndex)
                        console.log(selection)
                        localStorage.setItem("playlist-placement-i", selection)

                        lastSong = selection; // Remember the last song

                        if (playlist[selection] != undefined) {
                            player.src = playlist[selection];
                        }

                        if (coverArray[selection] != undefined) {
                            coverDiv.src = coverArray[selection];
                        }

                        if (responseSongNameArray[selection] != undefined) {
                            playerInfoSong.textContent = songNameArray[selection];
                        }

                        if (responseArtistNameArray[selection] != undefined) {
                            playerInfoArtist.textContent = artistNameArray[selection];
                        }

                        if (responseAlbumNameArray[selection] != undefined) {
                            playerInfoAlbum.textContent = albumNameArray[selection];
                        }

                        if (resumeBtn.style.display = 'block') {
                            pauseBtn.style.display = 'block'
                            resumeBtn.style.display = 'none'
                        }

                        clickedSongIndex++

                        player.addEventListener("ended", function () {
                            if (playlist.length == selection) {
                                localStorage.removeItem("playlist")
                                localStorage.removeItem("playlist-placement-i")
                                player.removeAttribute('src', 'autoplay')
                                bottomSidebar.style.height = "70px"
                                console.log('unique-song-play / player ended')
                            }
                        });
                    }

                    // LAUNCH

                    playSong();

                    player.load()
                    player.play(); // Start song
                }
            })
        })
    }
}
