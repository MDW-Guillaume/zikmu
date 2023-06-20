// $(document).ready(function () {
//         // Interceptez tous les clics sur les liens
//         $('a').click(function (event) {
//             // Empêchez la navigation par défaut
//             event.preventDefault();
//             // Chargez la nouvelle page en arrière-plan
//             let url = $(this).attr('href');
//             $.ajax({
//                 url: url,
//                 type: 'GET',
//                 success: function (data) {
//                     //
//                     $('#content').html($(data).find('#content').html());
//                     // $('#content').html($(data).find('#content'));
//                 }
//             });
//         });
// });
// $( "#content" ).bind("DOMNodeInserted DOMNodeRemoved", function( objEvent ) {
// function affichePlayer() {
//     if ($('.unique-song-form')[0] != 'undefined') {
//         let playSongForm = $('.unique-song-form')
//     }
//     if (typeof (playSongForm) != 'undefined') {
//         for (let i = 0; i < playSongForm.length; i++) {
//             playSongForm[i].addEventListener('submit', function (e) {
//                 e.preventDefault();
//                 let formData = $(playSongForm[i]).serialize();

//                 if (playSongForm[i].classList.contains('favorite-unique-song-form')) {
//                     // SI le clic vient de la page Favoris
//                     let url = '/play-form-favorite'
//                 } else {
//                     // SI le clic vient d'ailleurs
//                     let url = '/play-unique-song'
//                 }

//                 $.ajax({
//                     url: url,
//                     type: 'post',
//                     processData: false,
//                     data: formData,
//                     dataType: 'json',
//                     success: function (response) {
//                         // LECTURE DU SON
//                         let songsArray = response.songs

//                         if (response.songs.hasOwnProperty('clickedSong')) {
//                             let clickedSong = response.songs['clickedSong']
//                             let selection = null;
//                         }

//
//                         let lastSong = null;
//                         let playlist = []; // List of songs
//                         let clickedSongPath = '';
//                         let currentStep = null

//                         let coverSongArray = response.songs
//                         let coverArray = []
//                         let responseSongNameArray = response.songs
//                         let songNameArray = []
//                         let responseArtistNameArray = response.songs
//                         let artistNameArray = []
//                         let responseAlbumNameArray = response.songs
//                         let albumNameArray = []
//                         let coverDiv = document.getElementById('coverSong')
//                         let playerInfoArtist = document.getElementById('playerInfoArtist')
//                         let playerInfoAlbum = document.getElementById('playerInfoAlbum')
//                         let playerInfoSong = document.getElementById('playerInfoName')
//                         let bottomSidebar = document.getElementById('bottomSidebar');


//                         Object.entries(songsArray).forEach(([key, songArray]) => {
//                             if (key != 'clickedSong') {
//                                 playlist.push(songArray.song)
//                             } else {
//                                 clickedSongPath = songArray.song
//                             }
//                         });
//                         if(localStorage.getItem('playlist')){
//                             localStorage.removeItem("playlist")
//                         }

//                         if(localStorage.getItem('playlist-placement-i')){
//                             localStorage.removeItem("playlist-placement-i")
//                         }

//                         localStorage.setItem("playlist", playlist);

//                         Object.values(songsArray).forEach(coverElement => {
//                             coverArray.push(coverElement.cover)
//                         });

//                         Object.values(songsArray).forEach(songNameElement => {
//                             songNameArray.push(songNameElement.songName)
//                         });

//                         Object.values(songsArray).forEach(artistNameElement => {
//                             artistNameArray.push(artistNameElement.artist)
//                         });
//                         Object.values(songsArray).forEach(albumNameElement => {
//                             albumNameArray.push(albumNameElement.album)
//                         });


//                         let player = document.getElementById("audioplayer"); // Get audio element
//                         player.autoplay = true;

//                         player.addEventListener("ended", playSong);

//                         // function playSong() {
//                         //     i++
//                         //     localStorage.setItem("playlist-placement-i", i)
//                         //     while (selection == lastSong) {
//                         //         selection = i
//                         //     };
//                         //     lastSong = selection; // Remember the last song
//                         //     if(playlist[selection] != undefined){
//                         //         player.src = playlist[selection]; // Tell HTML the location of the new song
//                         //     }
//                         //     if(coverArray[selection]!= undefined){
//                         //         coverDiv.src = coverArray[selection]; // Tell HTML the location of the new song
//                         //     }

//                         //     player.addEventListener("ended", function () {
//                         //         if (playlist.length - 1 == selection) {
//                         //             bottomSidebar.style.height = "70px"
//                         //             localStorage.removeItem("playlist")
//                         //             localStorage.removeItem("playlist-placement-i")
//                         //         }
//                         //     });
//                         // }

//                         /* Lecture d'un titre suivant */


//                         // Pour jouer un son qui est cliqué:
//                         // On va récupérer la clé du son correspondant dans le tableau playlist
//                         // On enregistre et envoie cette letiable en appelant la fonction playSong
//                         // avec un paramètre qui sera la posoition du son


//                         // let i = 0

//                         // Je chercher a récupérer la clé de la playlist à partir de la valeur de la letiable clickedSongPath

//                         let clickedSongIndex = playlist.indexOf(clickedSongPath);

//                         let pauseBtn = document.getElementById('playerPause')
//                         let resumeBtn = document.getElementById('playerPlay')
//                         let playerNext = document.getElementById('playerNext')
//                         let playerPrev = document.getElementById('playerPrevious')
//                         let randomBtn = document.getElementById('randomBtn')
//                         if(randomBtn.hasAttribute('data-active')){
//                             randomBtn.removeAttribute('data-active')
//                         }

//                         localStorage.setItem("playlist-placement-i", clickedSongIndex);

//                         let audioDuration = 0;

//                         player.addEventListener('timeupdate', function () {
//                             audioDuration = player.currentTime;
//                         });

//                         // https://www.educative.io/answers/how-to-ensure-an-event-listener-is-only-fired-once-in-javascript

//                         // function oneTimeListener(node, type, callback) {
//                         //     // create event
//                         //     node.addEventListener(type, function listener(e) {

//                         //       // remove event listener
//                         //       e.target.removeEventListener(e.type, listener);

//                         //       // call handler with original context
//                         //       return callback.call(this, e);

//                         //     });
//                         //   }

//                         //   oneTimeListener(playerNext, 'click', playNext);
//                         playerNext.addEventListener('click', playNext);

//                         function playNext() {
//
//                             if (audioDuration > 1) {
//                                 currentStep = localStorage.getItem("playlist-placement-i");
//                                 //
//                                 let nextStep = parseInt(currentStep) + 1;
//                                 //
//                                 //
//                             if (nextStep != playlist.length) {
//                                 player.pause();
//                                 currentStep = nextStep;
//                                 localStorage.setItem('playlist-placement-i', currentStep);
//                                 playSong(currentStep);
//                             }
//                             audioDuration = 0
//
//                             }
//                         }

//                         playerPrev.addEventListener('click', function () {
//                             let currentStep = localStorage.getItem("playlist-placement-i")
//                             // Verification si il existe un titre avant, sinon bouton désactivé.
//                             if (currentStep - 1 >= 0) {
//                                 currentStep--
//                                 localStorage.setItem('playlist-placement-i', currentStep)
//                                 playSong(currentStep)
//                             } else {
//                                 playSong(Number(currentStep))
//                             }

//                         })

//                         randomBtn.addEventListener('mousedown', function () {
//                             let currentIndex = localStorage.getItem('playlist-placement-i')
//                             if (randomBtn.getAttribute('data-active') !== 'active') {
//                                 randomBtn.setAttribute('data-active', 'active')
//                                 // let currentTrackIndex = playlist.indexOf(playlist[currentIndex]);
//                                 //
//                                 // let currentTrack = playlist[currentTrackIndex];
//                                 //

//                                 // function shuffleArray(array) {
//                                 //     for (let i = array.length - 1; i > 0; i--) {
//                                 //         let j = Math.floor(Math.random() * (i));
//                                 //         //
//                                 //         //
//                                 //         [array[i], array[j]] = [array[j], array[i]];
//                                 //
//                                 //     }
//                                 // }

//                                 // On séléctionne au hasard un titre en dehors de celui joué actuellement pour les placer à la suite du titre actuellement joué
//                                 // Par la même occasion on change l'ordre d'affichage des covers, titres, artiste et albums
//                                 function shuffleArray(array) {
//                                     let randomPlaylist = [];
//                                     let randomCover = []
//                                     let randomArtist = []
//                                     let randomAlbum = []
//                                     let randomSongName = []
//                                     let playerAudioSrcIndex = ''
//
//                                     if (player.hasAttribute("src") && player.getAttribute("src") !== "") {
//                                         let audioSrc = player.getAttribute("src");
//                                         playerAudioSrcIndex = array.indexOf(audioSrc);
//                                         randomPlaylist.push(array[playerAudioSrcIndex])
//                                         randomCover.push(coverArray[playerAudioSrcIndex])
//                                         randomArtist.push(artistNameArray[playerAudioSrcIndex])
//                                         randomAlbum.push(albumNameArray[playerAudioSrcIndex])
//                                         randomSongName.push(songNameArray[playerAudioSrcIndex])
//                                         array.splice(playerAudioSrcIndex, 1)
//                                         coverArray.splice(playerAudioSrcIndex, 1)
//                                         artistNameArray.splice(playerAudioSrcIndex, 1)
//                                         albumNameArray.splice(playerAudioSrcIndex, 1)
//                                         songNameArray.splice(playerAudioSrcIndex, 1)
//                                     }

//                                     while ( array.length != 0) {
//                                         let randomIndex = Math.floor(Math.random() * array.length);
//                                         randomPlaylist.push(array[randomIndex])
//                                         randomCover.push(coverArray[randomIndex])
//                                         randomArtist.push(artistNameArray[randomIndex])
//                                         randomAlbum.push(albumNameArray[randomIndex])
//                                         randomSongName.push(songNameArray[randomIndex])
//                                         playerAudioSrcIndex = array.indexOf(array[randomIndex]);
//                                         array.splice(playerAudioSrcIndex, 1)
//                                         coverArray.splice(playerAudioSrcIndex, 1)
//                                         artistNameArray.splice(playerAudioSrcIndex, 1)
//                                         albumNameArray.splice(playerAudioSrcIndex, 1)
//                                         songNameArray.splice(playerAudioSrcIndex, 1)
//                                     }

//                                     let returnArray = {
//                                         playlist: randomPlaylist,
//                                         cover: randomCover,
//                                         artist: randomArtist,
//                                         album: randomAlbum,
//                                         songName: randomSongName
//                                     }

//                                     return returnArray
//                                 }

//                                 let shuffledArray = shuffleArray(playlist)
//                                 playlist = shuffledArray.playlist
//                                 localStorage.setItem('playlist', playlist)
//                                 coverArray = shuffledArray.cover
//                                 artistNameArray = shuffledArray.artist
//                                 albumNameArray = shuffledArray.album
//                                 songNameArray = shuffledArray.songName

//                                 // if (currentTrackIndex !== -1) {
//                                 //     playlist.splice(currentTrackIndex, 1);
//                                 //     playlist.unshift(currentTrack);
//                                 // }

//                                 localStorage.setItem('playlist-placement-i', 0)

//                                 // clickedSongIndex = 0
//                             } else {
//                                 randomBtn.removeAttribute('data-active')
//                                 let currentTrackIndex = playlist.indexOf(playlist[currentIndex]);

//

//                                 // Object.entries(songsArray).forEach(([key, songArray]) => {
//                                 //     playlist = []
//                                 //     if (key != 'clickedSong') {
//                                 //         playlist.push(songArray.song)
//                                 //     }
//                                 // });
//                             }
//                         })

//                         function playSong(stepSong = null) {
//                             while (selection == lastSong) {
//                                 selection = clickedSongIndex
//                             };

//                             // selection = getItem("playlist-placement-i")
//                             if (typeof (stepSong) == 'number') {
//                                 clickedSongIndex = stepSong
//                                 selection = stepSong
//                             }
//                             // On reinitialise la letiable stepSong pour continuer la lecture de la playlist
//                             stepSong = null
//
//
//                             localStorage.setItem("playlist-placement-i", selection)

//                             lastSong = selection; // Remember the last song

//                             if (playlist[selection] != undefined) {
//                                 player.src = playlist[selection];
//                             }

//                             if (coverArray[selection] != undefined) {
//                                 coverDiv.src = coverArray[selection];
//                             }

//                             if (responseSongNameArray[selection] != undefined) {
//                                 playerInfoSong.textContent = songNameArray[selection];
//                             }

//                             if (responseArtistNameArray[selection] != undefined) {
//                                 playerInfoArtist.textContent = artistNameArray[selection];
//                             }

//                             if (responseAlbumNameArray[selection] != undefined) {
//                                 playerInfoAlbum.textContent = albumNameArray[selection];
//                             }

//                             if (resumeBtn.style.display = 'block') {
//                                 pauseBtn.style.display = 'block'
//                                 resumeBtn.style.display = 'none'
//                             }

//                             clickedSongIndex++

//                             player.addEventListener("ended", function () {
//                                 if (playlist.length == selection) {
//                                     localStorage.removeItem("playlist")
//                                     localStorage.removeItem("playlist-placement-i")
//                                     player.removeAttribute('src', 'autoplay')
//                                     bottomSidebar.style.height = "70px"
//
//                                 }
//                             });
//                         }

//                         // LAUNCH

//                         playSong();

//                         player.load()
//                         player.play(); // Start song
//                     }
//                 })
//             })
//         }
//     }
// // });
// }

let player = document.getElementById("audioplayer");
let playerPosition = null;
let playerCover = document.getElementById('coverSong');
let playerSongName = document.getElementById('playerInfoName');
let playerArtistName = document.getElementById('playerInfoArtist');
let playerAlbumName = document.getElementById('playerInfoAlbum');
let playerArtistSlug = document.getElementById('playerInfoArtistSlug');
let playerAlbumSlug = document.getElementById('playerInfoAlbumSlug');
let bottomSidebar = document.querySelector('.bottom-sidebar');
let mobileMinPlayer = document.getElementById('mobileMinPlayer')
let pauseBtn = document.querySelectorAll('.playerPause')
let resumeBtn = document.querySelectorAll('.playerPlay')
let randomBtn = document.getElementById('randomBtn')
let randomPlaylistAction = document.getElementById('randomPlaylistAction')
let lastPage;



// Affichage de la file d'attente
function showSongQueue(status = null) {

    let songQueuePage = document.getElementById('songQueuePage')
    if (songQueuePage) {
        let token = document.getElementById('csrfToken').value
        let playerPosition = player.getAttribute('position')

        // crée un objet avec le tableau de données
        let jsonData = {
            position: playerPosition,
            csrf_token: token,
            status: status
        };

        // convertit l'objet en chaîne JSON
        let jsonString = JSON.stringify(jsonData);

        // envoie les données en ajax
        $.ajax({
            type: 'POST',
            url: '/waiting-list',
            headers: {
                'X-CSRF-Token': token
            },
            data: jsonString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                if (1 == response.redirect) {

                    let url = response.url;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (data) {
                            $('#content').html($(data).find('#content').html());
                            history.replaceState(null, '', url);
                        }
                    })
                } else {
                    let playerPosition = player.getAttribute('position')
                    let request = response.request

                    // Modification de l'affichage du titre en cours de lecture
                    let coverSongPlayed = document.getElementById('coverSongPlayed')
                    let NameSongPlayed = document.getElementById('NameSongPlayed')
                    let NameAlbumPlayed = document.getElementById('NameAlbumPlayed')
                    let NameArtistPlayed = document.getElementById('NameArtistPlayed')
                    NameAlbumPlayed.innerHTML = request[playerPosition - 1].album_name
                    NameArtistPlayed.innerHTML = request[playerPosition - 1].artist_name
                    NameSongPlayed.innerHTML = request[playerPosition - 1].song_name
                    coverSongPlayed.src = request[playerPosition - 1].cover_url;

                    // Modifications du nombre de titres et du temps total de la file d'attente
                    let songQueueTitles = document.getElementById('songQueueTitles')
                    let songQueueLength = document.getElementById('songQueueLength')
                    let waitingLength = 0
                    // Le nombre de titres dans la file d'attente - la position du la file d'attente + le son joué
                    //
                    songQueueTitles.innerHTML = parseInt(request.length)

                    for (let i = 0; i < request.length; i++) {
                        let element = request[i];

                        waitingLength = waitingLength + parseInt(element.song_length)
                    }

                    let minutes = Math.floor(waitingLength / 60); // On divise par 60 et on arrondit à l'entier inférieur
                    let remainingSeconds = waitingLength % 60;

                    if (minutes >= 1) {
                        songQueueLength.innerHTML = minutes + ' min ' + remainingSeconds + ' sec'
                    } else {
                        songQueueLength.innerHTML = waitingLength + ' sec'
                    }

                    // Création de la file d'attente dans un container

                    // Sélection de l'élément HTML dans lequel insérer la liste
                    let container = document.getElementById('songQueueContainer');
                    if (document.querySelector('.title-list-element') || document.querySelector('.empty-queue-container')) {
                        container.innerHTML = '';

                    }
                    if (request.length == 1) {
                        let emptyQueueContainer = document.createElement('div');
                        emptyQueueContainer.classList.add('empty-queue-container');
                        container.appendChild(emptyQueueContainer);

                        let emptyQueueMessage = document.createElement('p');
                        emptyQueueMessage.classList.add('empty-queue-message');
                        emptyQueueMessage.innerHTML = 'La file d\'attente est vide... <br> Et vous, qu\'attendez vous pour la remplir ?';
                        emptyQueueContainer.appendChild(emptyQueueMessage);

                    } else {
                        // Boucle pour générer la liste
                        for (let i = 0; i <= request.length - 1; i++) {

                            // Création d'un formulaire avec les informations de chaque titre
                            let formContainer = document.createElement('div')
                            formContainer.classList.add('title-list-element')

                            let form = document.createElement('form');
                            form.setAttribute('action', '/play-queued-element');
                            form.setAttribute('method', 'post');
                            form.classList.add('waitingSong');
                            formContainer.appendChild(form);

                            let csrfInput = document.createElement('input');
                            csrfInput.setAttribute('type', 'hidden');
                            csrfInput.setAttribute('name', '_token');
                            csrfInput.setAttribute('value', token);
                            form.appendChild(csrfInput);

                            let titleElement = document.createElement('div');
                            titleElement.classList.add('title-element');

                            let titlePosition = document.createElement('div');
                            titlePosition.classList.add('title-position');
                            let titlePositionSpan = document.createElement('span');
                            titlePositionSpan.classList.add('title-position-span');
                            titlePositionSpan.style.color = '#fff';
                            // titlePositionSpan.innerText = parseInt(playerPosition) + i;
                            titlePositionSpan.innerText = request[i].song_position;
                            titlePosition.appendChild(titlePositionSpan);
                            titleElement.appendChild(titlePosition);

                            let titleName = document.createElement('div');
                            titleName.classList.add('title-name');
                            titleName.innerText = request[i].song_name;
                            titleElement.appendChild(titleName);

                            let titleFavorite = document.createElement('div');
                            titleFavorite.classList.add('title-favorite');
                            titleElement.appendChild(titleFavorite);

                            let submitInput = document.createElement('input');
                            submitInput.setAttribute('type', 'submit');
                            submitInput.classList.add('play-song-submit');
                            submitInput.setAttribute('value', '');
                            titleElement.appendChild(submitInput);

                            let songIdInput = document.createElement('input');
                            songIdInput.setAttribute('type', 'hidden');
                            songIdInput.setAttribute('name', 'song_id');
                            // songIdInput.setAttribute('value', i);
                            songIdInput.setAttribute('value', request[i].song_id);
                            titleElement.appendChild(songIdInput);

                            let positionInput = document.createElement('input');
                            positionInput.setAttribute('type', 'hidden');
                            positionInput.setAttribute('name', 'position');
                            positionInput.setAttribute('value', request[i].song_position);
                            titleElement.appendChild(positionInput);

                            form.appendChild(titleElement);



                            let addFavorite = document.createElement('form');
                            addFavorite.setAttribute('action', '/favorite');
                            addFavorite.classList.add('actionFavorite');
                            addFavorite.classList.add('favorite-delete');
                            addFavorite.setAttribute('method', 'post');

                            let inputCsrf = document.createElement('input')
                            inputCsrf.setAttribute('name', "_token")
                            inputCsrf.setAttribute('value', token)
                            inputCsrf.setAttribute('type', 'hidden')
                            addFavorite.appendChild(inputCsrf)

                            let inputSongId = document.createElement('input')
                            inputSongId.setAttribute('name', "title")
                            inputSongId.setAttribute('value', request[i].song_id)
                            inputSongId.setAttribute('type', 'hidden')
                            addFavorite.appendChild(inputSongId)

                            let submitBtn = document.createElement('button')
                            submitBtn.setAttribute('type', 'submit')
                            submitBtn.setAttribute('id', 'favoriteButton')
                            submitBtn.classList.add('favorite-button')
                            if (request[i].is_favorite) {
                                submitBtn.classList.add('is-favorite')
                            }
                            addFavorite.appendChild(submitBtn)

                            let noFavImg = document.createElement('img')
                            noFavImg.src = '/img/fav-not-fill.svg'
                            noFavImg.setAttribute('alt', 'Ajouter aux favoris')
                            noFavImg.setAttribute('title', 'Ajouter aux favoris')
                            noFavImg.classList.add('no-favorite-img')
                            submitBtn.appendChild(noFavImg)

                            let FavImg = document.createElement('img')
                            FavImg.src = '/img/fav-fill.svg'
                            FavImg.setAttribute('alt', 'Supprimer aux favoris')
                            FavImg.setAttribute('title', 'Supprimer aux favoris')
                            FavImg.classList.add('favorite-img')
                            submitBtn.appendChild(FavImg)

                            formContainer.appendChild(addFavorite);

                            container.appendChild(formContainer);
                        }
                    }
                }
                playWaitingSong()
                afficheAlbumAvecFavoris()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // traitement en cas d'erreur
            }
        });

    }
}
function playWaitingSong() {
    let waitingSongForms = document.querySelectorAll('.waitingSong');
    if (waitingSongForms) {
        for (let i = 0; i < waitingSongForms.length; i++) {
            let waitingSongForm = waitingSongForms[i];
            waitingSongForm.addEventListener('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(waitingSongForm);
                let url = '/play-queued-element';
                let status = randomBtn.classList.contains('active') ? 'random' : 'normal';

                formData.append('status', status);

                $.ajax({
                    url: url,
                    type: 'post',
                    processData: false,
                    contentType: false, // Ajout de cette ligne pour éviter le traitement automatique du contenu
                    data: formData,
                    dataType: 'json',
                    success: function (response) {


                        let playerInformations = []
                        playerInformations['cover'] = response.cover_url
                        playerInformations['artist'] = response.artist_name
                        playerInformations['album'] = response.album_name
                        playerInformations['artist_slug'] = response.artist_slug
                        playerInformations['album_slug'] = response.album_slug
                        playerInformations['song'] = response.song_name
                        // Je lance la lecture du premier titre.
                        playSentSong(response.song_url, response.position, playerInformations);
                        showSongQueue(status)
                    }
                })
            })
        }
    }
}

function randomFromWaitingPageEvent() {
    let randomPlaylistAction = document.getElementById('randomPlaylistAction')
    if (randomPlaylistAction) {
        if (randomBtn.classList.contains('active')) {
            randomPlaylistAction.classList.add('active')
        } else {
            if (randomPlaylistAction.classList.contains('active')) {
                randomPlaylistAction.classList.remove('active')
            }
        }

    }
}
function randomFromWaitingPage() {
    let randomPlaylistAction = document.getElementById('randomPlaylistAction')

    if (randomPlaylistAction) {

        randomPlaylistAction.addEventListener('click', function () {

            randomBtnEvent()
        })
    }
}

function playSentSong(url, position, informations) {
    mobileMinPlayer.classList.add('active')
    controlsDisplay()
    console.log(informations)
    if (bottomSidebar.classList.contains('reduce')) {
        bottomSidebar.classList.remove('reduce')
    }
    player.pause();
    player.src = url;
    player.load();
    playerCover.src = informations['cover']
    playerSongName.innerHTML = informations['song']
    playerArtistName.innerHTML = informations['artist']
    playerAlbumName.innerHTML = informations['album']
    playerArtistSlug.href = "/artist/" + informations['artist_slug']
    playerAlbumSlug.href = "/album/" + informations['album_slug']
    player.play();
    player.setAttribute("position", position)

    player.addEventListener('loadedmetadata', function () {
        // J'attend que le média soit chargé pour mettre un écouteur sur la fin d'un son
        player.addEventListener('ended', playNextQueuedSong);
    });
}
function playNextQueuedSong() {
    let nextSong
    if (player.hasAttribute('src')) {
        if (player.hasAttribute('replay') && player.getAttribute('replay') == 'one') {
            nextSong = player.getAttribute('position')
        } else {
            playerPosition = player.getAttribute('position')

            nextSong = parseInt(playerPosition) + 1
        }
        let url = '/play-next-song'

        let playerrandom;

        if (randomBtn.classList.contains('active')) {
            playerrandom = 'random'
        } else {
            playerrandom = 'normal'
        }

        let formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            position: nextSong,
            status: playerrandom
        }

        let jsonData = JSON.stringify(formData);

        $.ajax({
            url: url,
            type: 'post',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            data: formData,
            dataType: 'json',
            cache: false,
            success: function (response) {

                if (response.success) {
                    //
                    // Regroupement des informations visuelles du lecteur
                    let playerInformations = []
                    playerInformations['cover'] = response.cover_url
                    playerInformations['artist'] = response.artist_name
                    playerInformations['album'] = response.album_name
                    playerInformations['artist_slug'] = response.artist_slug
                    playerInformations['album_slug'] = response.album_slug
                    playerInformations['song'] = response.song_name
                    // Je lance la lecture du premier titre.
                    playSentSong(response.song_url, response.position, playerInformations);
                    showSongQueue(playerrandom)
                } else {
                    if (player.hasAttribute('replay') && player.getAttribute('replay') == 'all') {
                        // On met la position à 0 pour relancer la fonction et passer la position de 0 à 1
                        // pour récupérer les informations du premier titre.
                        player.setAttribute('position', 0)
                        playNextQueuedSong();
                    } else if (!player.hasAttribute('replay')) {
                        if (player.duration == player.currentTime) {

                            pauseBtn.forEach(pause => {
                                pause.style.display = 'none'
                            })
                            resumeBtn.forEach(resume => {
                                resume.style.display = 'block';
                            })
                            mobileMinPlayer.classList.remove('active')
                        }
                    }
                }
            }
        })
    }
}
function playPreviousQueuedSong() {
    if (player.hasAttribute('src')) {
        let previousSong
        if (player.hasAttribute('replay') && player.getAttribute('replay') == 'one') {
            previousSong = player.getAttribute('position')
        } else {
            playerPosition = player.getAttribute('position')

            previousSong = parseInt(playerPosition) - 1
        }
        let url = '/play-previous-song'

        let playerrandom;

        if (randomBtn.classList.contains('active')) {
            playerrandom = 'random'
        } else {
            playerrandom = 'normal'
        }

        // Je me sers du cookie XSRF-TOKEN pour eviter d'obtenir une erreur 419
        let csrfToken = Cookies.get('XSRF-TOKEN');

        let formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            position: previousSong,
            status: playerrandom
        }

        let jsonData = JSON.stringify(formData);

        $.ajax({
            url: url,
            type: 'post',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            data: formData,
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (response.success) {
                    //
                    // Regroupement des informations visuelles du lecteur
                    let playerInformations = []
                    playerInformations['cover'] = response.cover_url
                    playerInformations['artist'] = response.artist_name
                    playerInformations['album'] = response.album_name
                    playerInformations['artist_slug'] = response.artist_slug
                    playerInformations['album_slug'] = response.album_slug
                    playerInformations['song'] = response.song_name
                    // Je lance la lecture du premier titre.
                    playSentSong(response.song_url, response.position, playerInformations);
                    showSongQueue(playerrandom)
                } else {
                    if (player.hasAttribute('replay') && player.getAttribute('replay') == 'all') {
                        // On récupère la position du titre précédent + 1 grâce à response.position pour relancer la fonction et passer la position de x à x-1
                        player.setAttribute('position', parseInt(response.position) + 1)
                        playPreviousQueuedSong();
                    }
                }
            }
        })
    }
}
function randomizeQueuedSong(status = null) {
    playerPosition = player.getAttribute('position')
    let url = '/randomize-queued-songs'

    // Je me sers du cookie XSRF-TOKEN pour eviter d'obtenir une erreur 419
    let csrfToken = Cookies.get('XSRF-TOKEN');

    let formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        position: playerPosition,
        status: status
    }

    let jsonData = JSON.stringify(formData);

    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        data: formData,
        dataType: 'json',
        cache: false,
        success: function (response) {

            player.setAttribute('position', response.position)

            showSongQueue(status);
        }
    })
}
function loopQueuedSong(status) {

    if (status == 'loop') {
        player.setAttribute('replay', 'all')
    } else if (status == 'loopOnce') {
        player.setAttribute('replay', 'one')
    } else if (status == 'initial') {
        player.removeAttribute('replay')
    }
}
function playAlbumFromTitle() {
    let cliquedSongForm = document.querySelectorAll('.unique-song-form')
    if (cliquedSongForm) {
        cliquedSongForm.forEach(clickedSong => {
            clickedSong.addEventListener('submit', function (e) {
                e.preventDefault()

                let formData = $(clickedSong).serialize();
                let url = '/play-album-element'

                $.ajax({
                    url: url,
                    type: 'post',
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        // Regroupement des informations visuelles du lecteur
                        let playerInformations = []
                        playerInformations['cover'] = response.cover_url
                        playerInformations['artist'] = response.artist_name
                        playerInformations['album'] = response.album_name
                        playerInformations['artist_slug'] = response.artist_slug
                        playerInformations['album_slug'] = response.album_slug
                        playerInformations['song'] = response.song_name
                        // Je lance la lecture du premier titre.
                        playSentSong(response.song_url, response.position, playerInformations)
                        randomBtn.classList.remove('active')
                    }
                })
            })
        })
    }
}
function fastPlayAlbum() {
    let fastPlayAlbumForm = document.querySelectorAll('.fast-play-album')

    if (fastPlayAlbumForm) {

        fastPlayAlbumForm.forEach(fastPlayAlbumElement => {
            fastPlayAlbumElement.addEventListener('submit', function (e) {
                e.preventDefault()

                let formData = $(fastPlayAlbumElement).serialize();
                let url = '/fast-play-album'


                $.ajax({
                    url: url,
                    type: 'post',
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        // Regroupement des informations visuelles du lecteur
                        let playerInformations = []
                        playerInformations['cover'] = response.cover_url
                        playerInformations['artist'] = response.artist_name
                        playerInformations['album'] = response.album_name
                        playerInformations['artist_slug'] = response.artist_slug
                        playerInformations['album_slug'] = response.album_slug
                        playerInformations['song'] = response.song_name
                        // Je lance la lecture du premier titre.
                        playSentSong(response.song_url, response.position, playerInformations)
                        randomBtn.classList.remove('active')
                    }
                })

            })

            // Quand le son se termine on crée une fonction qui récupère la position actuelle et ajoute +1
        });
    }
}
function playFavoriteFromTitle() {
    let cliquedSongForm = document.querySelectorAll('.favorite-unique-song-form')
    if (cliquedSongForm) {
        cliquedSongForm.forEach(clickedSong => {
            clickedSong.addEventListener('submit', function (e) {
                e.preventDefault()

                let formData = $(clickedSong).serialize();
                let url = '/play-favorite-element'

                $.ajax({
                    url: url,
                    type: 'post',
                    processData: false,
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        // Regroupement des informations visuelles du lecteur
                        let playerInformations = []
                        playerInformations['cover'] = response.cover_url
                        playerInformations['artist'] = response.artist_name
                        playerInformations['album'] = response.album_name
                        playerInformations['artist_slug'] = response.artist_slug
                        playerInformations['album_slug'] = response.album_slug
                        playerInformations['song'] = response.song_name
                        // Je lance la lecture du premier titre.
                        playSentSong(response.song_url, response.position, playerInformations)
                        randomBtn.classList.remove('active')
                    }
                })
            })
        })
    }
}
function fastPlayFavorite() {
    let playFavoriteForm = document.getElementById('playFavoriteBtn')

    if (playFavoriteForm) {
        playFavoriteForm.addEventListener('submit', function (e) {
            e.preventDefault()

            let formData = $(playFavoriteForm).serialize();
            let url = '/fast-play-favorite'


            $.ajax({
                url: url,
                type: 'post',
                processData: false,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    // Regroupement des informations visuelles du lecteur
                    let playerInformations = []
                    playerInformations['cover'] = response.cover_url
                    playerInformations['artist'] = response.artist_name
                    playerInformations['album'] = response.album_name
                    playerInformations['artist_slug'] = response.artist_slug
                    playerInformations['album_slug'] = response.album_slug
                    playerInformations['song'] = response.song_name
                    // Je lance la lecture du premier titre.
                    playSentSong(response.song_url, response.position, playerInformations)
                    randomBtn.classList.remove('active')
                }
            })

        })
    }
}
function randomPlayFavorite() {
    let playRandomFavorite = document.getElementById('playRandomFavorite')
    if (playRandomFavorite) {
        playRandomFavorite.addEventListener('submit', function (e) {
            e.preventDefault()

            let formData = $(playRandomFavorite).serialize();
            let url = '/random-play-favorite'


            $.ajax({
                url: url,
                type: 'post',
                processData: false,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    randomizeQueuedSong('random')
                    // Regroupement des informations visuelles du lecteur
                    let playerInformations = []
                    playerInformations['cover'] = response.cover_url
                    playerInformations['artist'] = response.artist_name
                    playerInformations['album'] = response.album_name
                    playerInformations['artist_slug'] = response.artist_slug
                    playerInformations['album_slug'] = response.album_slug
                    playerInformations['song'] = response.song_name
                    // Je lance la lecture du premier titre.
                    playSentSong(response.song_url, response.position, playerInformations)
                    randomBtn.classList.add('active')
                }
            })
        })
    }
}
function afficheAlbumAvecFavoris() {
    let form = $('.actionFavorite')
    if (form) {
        for (let i = 0; i < form.length - 1; i++) {
            $(document).ready(function () {
                form[i].addEventListener('submit', function (e) {

                    e.preventDefault(); // Empêcher l'envoi par défaut du formulaire
                    let formData = $(form[i]).serialize(); // Récupérer les données du formulaire
                    $.ajax({
                        url: '/favorite',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                // Mettre à jour la page sans la recharger
                                if (form[i][2].classList.contains('is-favorite')) {
                                    $(form[i][2]).removeClass('is-favorite')
                                    document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
                                    document.getElementById('displayMessageContainer').classList.add('show');
                                    setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                                } else {
                                    $(form[i][2]).addClass('is-favorite')
                                    document.getElementById('displayMessage').innerHTML = 'La titre a été ajouté de vos Coups de coeur';
                                    document.getElementById('displayMessageContainer').classList.add('show');
                                    setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                                }
                            } else {
                                alert('Une erreur est survenue : ' + response.error);
                            }
                        }
                    });
                });
            });
        }
    }
}
function fastSongPlaySearch() {
    let fastSongPlay = document.querySelectorAll('.play-title')

    fastSongPlay.forEach(songPlay => {
        songPlay.addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = $(songPlay).serialize();
            let url = '/fast-play-song-search'

            $.ajax({
                url: url,
                type: 'post',
                processData: false,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    // Regroupement des informations visuelles du lecteur
                    let playerInformations = []
                    playerInformations['cover'] = response.cover_url
                    playerInformations['artist'] = response.artist_name
                    playerInformations['album'] = response.album_name
                    playerInformations['artist_slug'] = response.artist_slug
                    playerInformations['album_slug'] = response.album_slug
                    playerInformations['song'] = response.song_name
                    // Je lance la lecture du premier titre.
                    playSentSong(response.song_url, response.position, playerInformations)
                }
            })
        })
    });
}
function favoriteDelete() {
    let deleteDiv = document.querySelectorAll('.favorite-delete')
    // let form = $('.actionFavorite')

    for (let i = 0; i < deleteDiv.length; i++) {
        let lebtn = $(deleteDiv[i]).find('.favorite-button')[0];
        //  let csrf = $(this).siblings('input[name="csrf"]').val();
        let csrf = $('input[name="csrf"]').val();
        $(deleteDiv[i]).on('click', '.favorite-button', function (e) {
            e.preventDefault(); // Empêcher l'envoi par défaut du formulaire

            let formData = {
                title: e.target.closest('button').getAttribute('data-id')
            } // Récupérer les données du formulaire


            $.ajax({
                url: '/favorite',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        if (response.action == 'add') {
                            // Mettre à jour la page sans la recharger
                            // Par exemple, ajouter le nouveau champ à un tableau existant
                            if (form[i][3].classList.contains('is-favorite')) {
                                $(form[i][3]).removeClass('is-favorite')
                                document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                            } else {
                                $(form[i][3]).addClass('is-favorite')
                                document.getElementById('displayMessage').innerHTML = 'La titre a été ajouté de vos Coups de coeur';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                            }
                        } else {
                            let formId = e.target.closest('button').getAttribute('data-id')
                            let form = $('form[data-id="' + formId + '"]');
                            form.css('display', 'none');
                            document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
                            document.getElementById('displayMessageContainer').classList.add('show');
                            setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                        }
                    } else {
                        alert('Une erreur est survenue : ' + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    // gérer les erreurs de la requête
                }
            });
        });
    }
}
function favoriteArtistAddAndDelete() {
    let addArtistForm = document.getElementById('addArtistToFavorite')
    if (addArtistForm) {
        $(document).ready(function () {
            addArtistForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Empêcher l'envoi par défaut du formulaire

                let formData = $(addArtistForm).serialize();

                let favButton = document.getElementById('favButton')
                $.ajax({
                    url: '/my-artists',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Changement d'affichage du bouton "Ajouter"
                            if (response.action == 'add') {
                                favButton.classList.add('is_favorite')
                                document.getElementById('displayMessage').innerHTML = 'Cet artiste a été ajouté à vos artistes favoris';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                            } else {
                                favButton.classList.remove('is_favorite')
                                document.getElementById('displayMessage').innerHTML = 'Cet artiste a été supprimé de vos artistes favoris';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);

                            }

                        } else {
                            alert('Une erreur est survenue : ' + response.error);
                        }
                    }
                });
            })
        })
    }
}
function favoriteAlbumAddAndDelete() {
    let addAlbumForm = document.getElementById('addAlbumToFavorite')
    if (addAlbumForm) {
        $(document).ready(function () {
            addAlbumForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Empêcher l'envoi par défaut du formulaire

                let formData = $(addAlbumForm).serialize();

                let favButton = document.getElementById('favButton')
                $.ajax({
                    url: '/my-albums',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Changement d'affichage du bouton "Ajouter"
                            if (response.action == 'add') {
                                favButton.classList.add('is_favorite')
                                document.getElementById('displayMessage').innerHTML = 'Cet album a été ajouté à vos albums favoris';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                            } else {
                                favButton.classList.remove('is_favorite')
                                document.getElementById('displayMessage').innerHTML = 'Cet album a été supprimé de vos albums favoris';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);

                            }

                        } else {
                            alert('Une erreur est survenue : ' + response.error);
                        }
                    }
                });
            })
        })
    }
}

/* Player Controls */
function playerEvent() {
    let trackTime = document.getElementById('musicDuration');
    let timeSlider = document.getElementById('timeSlider');
    let trackCurrentTime = document.getElementById('musicCurrentTime');
    let reducePlayerIcon = document.getElementById('reducePlayer');
    let showPlayerIcon = document.getElementById('showPlayer');
    let sidebarMenu = document.getElementById('sidebarMenu');
    // let pauseBtn = document.getElementsByClassName('playerPause')
    // let resumeBtn = document.getElementById('playerPlay')
    // Créer une instance de MutationObserver avec une fonction de rappel
    let observer = new MutationObserver((mutationsList) => {
        for (let mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'src' && player.getAttribute('src')) {
                pauseBtn.forEach(pause => {
                    pause.style.display = 'block'
                });
                resumeBtn.forEach(resume => {
                    resume.style.display = 'none'
                });

                bottomSidebar.classList.add('active')
                sidebarMenu.classList.add('hide')

                reducePlayerIcon.addEventListener('click', function () {
                    sidebarMenu.classList.remove('hide')
                    bottomSidebar.classList.remove('active')
                    bottomSidebar.classList.add('reduce')
                })

                showPlayerIcon.addEventListener('click', function () {
                    sidebarMenu.classList.add('hide')
                    bottomSidebar.classList.add('active')
                    bottomSidebar.classList.remove('reduce')
                })

                // Crée un format de retour avec minutes et secondes.
                function buildDuration(duration) {
                    let minutes = Math.floor(duration / 60)
                    let reste = duration % 60
                    let secondes = Math.floor(reste)
                    secondes = String(secondes).padStart(2, "0")
                    return minutes + ":" + secondes
                }

                // Définit la position exacte de la lecture
                function setTrackCurrentTime() {
                    let trackMaxTime = buildDuration(player.currentTime)
                    trackCurrentTime.textContent = trackMaxTime
                }

                // Définit l'attribut max dans le slider du lecteur
                function setTrackMaxTime() {
                    trackTime.textContent = buildDuration(player.duration)
                    timeSlider.setAttribute('max', player.duration)
                }

                // Permet de faire glisser le slider du temps de la musique
                function updateSlider() {
                    let actualTime = player.currentTime
                    timeSlider.value = actualTime
                }

                // Joue le son à partir du temps séléctionné dans le slider
                function setSelectedTime() {
                    let selectedTime = parseFloat(timeSlider.value)
                    player.currentTime = selectedTime
                }

                player.addEventListener('loadeddata', function () {
                    setTrackMaxTime()
                    setInterval(updateSlider, 50);

                })

                player.addEventListener('timeupdate', function () {
                    setTrackCurrentTime()
                })

                timeSlider.addEventListener('change', function () {
                    player.pause()
                    setSelectedTime()
                    player.play()
                    player.addEventListener('timeupdate', function () {
                        setTrackCurrentTime()
                    })
                })
            }
        }
    });
    observer.observe(player, { attributes: true });
}
function playerPauseAndResume() {
    pauseBtn.forEach(pause => {

        pause.addEventListener('click', function () {
            player.pause()
            pause.style.display = 'none'
            resumeBtn.forEach(resume => {
                resume.style.display = 'block'
            })
        })
    })

    resumeBtn.forEach(resume => {
        resume.addEventListener('click', function () {
            player.play()
            pauseBtn.forEach(pause => {
                pause.style.display = 'block'
                resume.style.display = 'none'
            })
        })
    })
}
function controlsDisplay() {
    let playerPrevious = document.querySelectorAll('.playerPrevious')
    let playerNext = document.querySelectorAll('.playerNext')

    let url = '/get-queue-length'
    let formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
    }

    $.ajax({
        url: url,
        type: 'post',
        data: formData,
        dataType: 'json',
        cache: false,
        success: function (response) {
            playerPrevious.forEach(previous => {
                if (player.getAttribute('position') == 1) {
                    previous.style.filter = "brightness(0.5)";
                    previous.style.cursor = "default"
                } else {
                    previous.style.filter = "brightness(1)";
                    previous.style.cursor = "pointer"
                }
            })
            playerNext.forEach(next => {
                if (player.getAttribute('position') == response.length) {
                    next.style.filter = "brightness(0.5)";
                    next.style.cursor = "default"
                } else {
                    next.style.filter = "brightness(1)";
                    next.style.cursor = "pointer"
                }
            })
        }
    })
}
function playerNext() {
    let playerNext = document.querySelectorAll('.playerNext')

    if (playerNext) {
        playerNext.forEach(next => {
            next.addEventListener('click', function (e) {
                playNextQueuedSong()
            })
        })
    }
}
function playerPrevious() {
    let playerPrevious = document.querySelectorAll('.playerPrevious')

    if (playerPrevious) {
        playerPrevious.forEach(previous => {
            previous.addEventListener('click', function (e) {
                playPreviousQueuedSong()
            })
        })
    }
}
function playerRandom() {
    if (randomBtn) {
        randomBtn.addEventListener('click', function () {
            randomBtnEvent()
        })
    }
}
function randomBtnEvent() {

    if (randomBtn.classList.contains('active')) {
        randomBtn.classList.remove('active')
        if (randomPlaylistAction && randomPlaylistAction.classList.contains('active')) {
            randomPlaylistAction.classList.remove('active')
        }

        randomFromWaitingPageEvent()
        randomizeQueuedSong('normal')
    } else {
        randomBtn.classList.add('active')
        if (randomPlaylistAction && randomPlaylistAction.classList.contains('active')) {
            randomPlaylistAction.classList.add('active')
        }

        randomFromWaitingPageEvent()
        randomizeQueuedSong('random')

    }
}

// function playerLoop() {
//     let repeatButton = document.getElementById('repeat')
//     let repeatOnceButton = document.getElementById('repeatOnce')

//     repeatButton.addEventListener('click', function () {
//         if (repeatButton.classList.contains('active')) {
//             repeatButton.classList.remove('active')
//             repeatButton.classList.add('hide')
//             repeatOnceButton.classList.add('active')
//             loopQueuedSong('replayOne')
//         } else {
//             repeatButton.classList.add('active')
//             loopQueuedSong('replayPlaylist')
//         }
//     })

//     repeatOnceButton.addEventListener('click', function () {
//         repeatOnceButton.classList.remove('active')
//         repeatButton.classList.remove('hide')
//         loopQueuedSong('normalPlay')
//     })
// }

function playerLoop() {
    let repeatButton = document.getElementById('repeat')

    if (repeatButton) {
        repeatButton.addEventListener('click', function () {
            loopBtnEvent(repeatButton)
        })
    }
}

function loopBtnEvent(repeatButton) {
    let repeatButtonStatus = repeatButton.dataset.status

    switch (repeatButtonStatus) {
        case 'initial':
            repeatButton.dataset.status = 'loop'
            repeatButton.src = "/img/repeat.svg"
            break;
        case 'loop':
            repeatButton.dataset.status = 'loopOnce'
            repeatButton.src = "/img/repeatOnce.svg"
            break;
        case 'loopOnce':
            repeatButton.dataset.status = 'initial'
            repeatButton.src = "/img/repeat.svg"
            break;
        default:
            break;
    }
    loopQueuedSong(repeatButton.dataset.status)

}


/* Search Events */
function searchTogglePhone() {
    let searchMobile = document.getElementById('searchMobile')
    let searchBarForm = document.getElementById('searchbarMobileContainer')
    let searchBarInput = document.getElementsByClassName('mobile-sidebar-search')[0]

    document.addEventListener('click', function (e) {
        if (e.target !== searchMobile && e.target !== searchBarInput) {
            (searchBarForm.classList.contains('show')) ? searchBarForm.classList.remove('show') : null;
        }
    });

    searchMobile.addEventListener('click', function (e) {
        (searchBarForm.classList.contains('show')) ? searchBarForm.classList.remove('show') : searchBarForm.classList.add('show');
    })


}

function showAndHideSearchPage() {
    let searchBarForm = document.querySelectorAll('.searchbar-form')

    for (let i = 0; i < searchBarForm.length; i++) {
        let searchBarInput = searchBarForm[i].querySelectorAll('.sidebarSearch')[0]
        searchBarForm[i].addEventListener('submit', function (e) {
            e.preventDefault();
        })
        // for (let j = 0; j < searchBarInput.length; j++) {
        searchBarInput.addEventListener('keyup', function (e) {
            let letters = searchBarInput.value;
            let letterCount = searchBarInput.value.length;

            if (letterCount > 0) {
                searchIcon.style.display = "none"
                searchIconMobile.style.display = "none"
            } else {
                searchIcon.style.display = "block"
                searchIconMobile.style.display = "block"
            }

            if (letterCount > 2 && letters.trim() != '') {
                let url = '/search'
                // let searchTimeout;

                // clearTimeout(searchTimeout);
                // searchTimeout = setTimeout(function () {
                let formData = $(searchBarForm[i]).serialize();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#content').html($(response.data).find('#content').html());
                        if (window.location.href.split('/').pop() != 'search') {

                            lastPage = new URL(window.location.href).pathname;
                            history.replaceState(null, '', url);
                        }
                        let searchSpan = document.getElementById('searchRequested')
                        searchSpan.innerHTML = letters

                        fastSongPlaySearch()
                        fastPlayAlbum()
                    }
                });
                // }, 500); // Délai de 500 ms avan
            }
            else {
                if (lastPage) {
                    let url = lastPage;
                    let searchTimeout;

                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function () {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function (data) {
                                $('#content').html($(data).find('#content').html());
                                history.replaceState(null, '', url);
                            }
                        })
                    })
                    lastPage = null
                }

            }

            if (letterCount > 0) {
                searchBarInput.classList.add('typing')
            } else if (letterCount = 0 && searchBarInput.classList.contains('typing')) {
                searchBarInput.classList.remove('typing')
            }
        })
        // }
    }
}


$(document).ready(function () {
    $(document).on('click', 'a', function reloadOnPageChange(event) {
        event.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#content').html($(data).find('#content').html());
                history.replaceState(null, '', url);
                showSongQueue(randomBtn.classList.contains('active') ? 'random' : 'normal');
                randomFromWaitingPageEvent();
                randomFromWaitingPage();
                afficheAlbumAvecFavoris();
                favoriteDelete();
                playAlbumFromTitle();
                fastPlayAlbum();
                playFavoriteFromTitle();
                fastPlayFavorite();
                randomPlayFavorite();
                favoriteArtistAddAndDelete();
                favoriteAlbumAddAndDelete();
                playerEvent();
                playerPauseAndResume();
                playerNext();
                playerPrevious();
                showAndHideSearchPage();
                // searchTogglePhone();
            }
        });
    });
    showSongQueue();
    randomFromWaitingPageEvent();
    randomFromWaitingPage();
    afficheAlbumAvecFavoris();
    playAlbumFromTitle()
    favoriteDelete();
    fastPlayAlbum();
    playFavoriteFromTitle();
    fastPlayFavorite();
    randomPlayFavorite();
    favoriteArtistAddAndDelete();
    favoriteAlbumAddAndDelete();
    playerEvent();
    playerPauseAndResume();
    playerNext();
    playerPrevious();
    playerRandom();
    playerLoop();
    showAndHideSearchPage();
    searchTogglePhone();
});



/*

1ERE IDEE DE RECHARGEMENT DE FICHIERS JS AU CHANGEMENT DE PAGE


let scripts = ['unique-song-play.js', 'multiple-song-play.js', 'favorite.js', 'play-album.js', 'audio-event.js', 'song-controller.js', 'waitinglistshow.js'];
let index = 0;
let endScript = 0;

// Supprimez l'ancien élément script et ajoutez un nouvel élément avec le même src
function reloadScript() {
    // Incrémentez l'index et rechargez le script suivant (de manière récursive)
    index++;
    if (index - 1 < scripts.length) {
        let oldScript = document.querySelector('head script[src="http://[::1]:5174/resources/js/' + scripts[index - 1] + '"]');
        let newScript = document.createElement('script');
        newScript.src = 'http://[::1]:5174/resources/js/' + scripts[index - 1];
        oldScript.parentNode.replaceChild(newScript, oldScript);

        reloadScript();
    }else{
        endScript++;
    }
}
*/

