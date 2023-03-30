// $(document).ready(function () {
//         // Interceptez tous les clics sur les liens

//         $('a').click(function (event) {
//             // Empêchez la navigation par défaut
//             event.preventDefault();

//             // Chargez la nouvelle page en arrière-plan
//             var url = $(this).attr('href');
//             $.ajax({
//                 url: url,
//                 type: 'GET',
//                 success: function (data) {
//                     // console.log(data)
//                     $('#content').html($(data).find('#content').html());
//                     // $('#content').html($(data).find('#content'));
//                 }
//             });
//         });
// });
$(document).ready(function () {
    $(document).on('click', 'a', function (event) {
        event.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#content').html($(data).find('#content').html());
                reloadScript();
                index = 0;
            }
        });
    });
    // Ajoutez un gestionnaire d'événements à la balise body pour l'événement DOMSubtreeModified
    // document.body.addEventListener('DOMSubtreeModified', function () {
    //     // Rechargez tous les fichiers JavaScript en appelant la fonction reloadScript
    //     if(endScript != 1){
    //         reloadScript();
    //     }
    // });
});


var scripts = ['unique-song-play.js', 'multiple-song-play.js', 'favorite.js', 'play-album.js', 'audio-event.js'];
var index = 0;
var endScript = 0;

// Supprimez l'ancien élément script et ajoutez un nouvel élément avec le même src
function reloadScript() {
    // Incrémentez l'index et rechargez le script suivant (de manière récursive)
    index++;
    if (index - 1 < scripts.length) {
        var oldScript = document.querySelector('head script[src="http://[::1]:5173/resources/js/' + scripts[index - 1] + '"]');
        var newScript = document.createElement('script');
        newScript.src = 'http://[::1]:5173/resources/js/' + scripts[index - 1];
        oldScript.parentNode.replaceChild(newScript, oldScript);

        reloadScript();
    }else{
        endScript++;
    }
}


