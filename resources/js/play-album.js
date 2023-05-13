// if ($('.play-album')[0] != 'undefined') {
//     var playAlbumCover = document.querySelectorAll('.play-album')
// }
// console.log( playAlbumCover)
// // Faire une boule for pour capter celui qui est envoyé.
// for (let i = 0; i < playAlbumCover.length; i++) {

//     playAlbumCover[i].addEventListener('submit', function (e) {
//         console.log( playAlbumCover)

//         e.preventDefault();

//         var formData = $(playAlbumCover[i]).serialize();

//         console.log(formData)
//         if(playAlbumCover.classList.contains('favorite-unique-song-form')){
//             var url = '/play-form-favorite'
//             console.log('ici')
//         }else{
//             var url = '/play-album'
//             console.log('la')
//         }

//         $.ajax({
//             url: url,
//             type: 'post',
//             processData: false,
//             data: formData,
//             dataType: 'json',
//             success: function (response) {
//                 if (response.request != null) {
//                     var songArray = response.request
//                     var lastSong = null;
//                     var selection = null;
//                     var playlist = []; // List of songs
//                     let i = -1


//                     songArray.forEach(sentSong => {
//                         // playlist.push("music/music/" + sentSong) // Fonctionne pour les noms de fichiers en dur
//                         playlist.push("/storage/files/music/" + sentSong)
//                     });
//                     console.log('playlist : ' + playlist)

//                     var player = document.getElementById("audioplayer"); // Get audio element
//                     player.autoplay = true;

//                     player.addEventListener("ended", playSong);

//                     function playSong() {
//                         i++
//                         while (selection == lastSong) {
//                             selection = i
//                         };
//                         lastSong = selection; // Remember the last song
//                         player.src = playlist[selection]; // Tell HTML the location of the new song
//                     }

//                     playSong();

//                     player.play(); // Start song
//                 }
//             }
//         })
//     })
// }
