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
function afficheAlbumAvecFavoris() {
    var form = $('.actionFavorite')
    for (let i = 0; i < form.length - 1; i++) {
        $(document).ready(function () {
            form[i].addEventListener('submit', function (e) {
                e.preventDefault(); // Empêcher l'envoi par défaut du formulaire
                console.log(form[i][3])
                var formData = $(form[i]).serialize(); // Récupérer les données du formulaire
                console.log(formData)
                $.ajax({
                    url: '/favorite',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Mettre à jour la page sans la recharger
                            // Par exemple, ajouter le nouveau champ à un tableau existant
                            if (form[i][3].classList.contains('is-favorite')) {
                                $(form[i][3]).removeClass('is-favorite')
                                console.log(document.getElementById('displayMessage'))
                                document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function() {document.getElementById('displayMessageContainer').classList.remove('show')}, 4000);
                            } else {
                                $(form[i][3]).addClass('is-favorite')
                                document.getElementById('displayMessage').innerHTML = 'La titre a été ajouté de vos Coups de coeur';
                                document.getElementById('displayMessageContainer').classList.add('show');
                                setTimeout(function() {document.getElementById('displayMessageContainer').classList.remove('show')}, 4000);
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

$(document).ready(function () {
    $(document).on('click', 'a', function (event) {
        event.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#content').html($(data).find('#content').html());
                afficheAlbumAvecFavoris();
                // reloadScript();
                // index = 0;
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

/*
var scripts = ['unique-song-play.js', 'multiple-song-play.js', 'favorite.js', 'play-album.js', 'audio-event.js', 'song-controller.js', 'waitinglistshow.js'];
var index = 0;
var endScript = 0;

// Supprimez l'ancien élément script et ajoutez un nouvel élément avec le même src
function reloadScript() {
    // Incrémentez l'index et rechargez le script suivant (de manière récursive)
    index++;
    if (index - 1 < scripts.length) {
        var oldScript = document.querySelector('head script[src="http://[::1]:5174/resources/js/' + scripts[index - 1] + '"]');
        var newScript = document.createElement('script');
        newScript.src = 'http://[::1]:5174/resources/js/' + scripts[index - 1];
        oldScript.parentNode.replaceChild(newScript, oldScript);

        reloadScript();
    }else{
        endScript++;
    }
}
*/

