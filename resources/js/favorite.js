// console.log($('.actionFavorite'))
// var form = $('.actionFavorite')
// for (let i = 0; i < form.length - 1; i++) {
//     $(document).ready(function () {
//         form[i].addEventListener('submit', function (e) {
//             e.preventDefault(); // Empêcher l'envoi par défaut du formulaire
//             console.log(form[i][3])
//             var formData = $(form[i]).serialize(); // Récupérer les données du formulaire
//             console.log(formData)
//             $.ajax({
//                 url: '/favorite',
//                 type: 'POST',
//                 data: formData,
//                 dataType: 'json',
//                 success: function (response) {
//                     if (response.success) {
//                         // Mettre à jour la page sans la recharger
//                         // Par exemple, ajouter le nouveau champ à un tableau existant
//                         if (form[i][3].classList.contains('is-favorite')) {
//                             $(form[i][3]).removeClass('is-favorite')
//                             console.log(document.getElementById('displayMessage'))
//                             document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
//                             document.getElementById('displayMessageContainer').classList.add('show');
//                             setTimeout(function() {document.getElementById('displayMessageContainer').classList.remove('show')}, 4000);
//                         } else {
//                             $(form[i][3]).addClass('is-favorite')
//                             document.getElementById('displayMessage').innerHTML = 'La titre a été ajouté de vos Coups de coeur';
//                             document.getElementById('displayMessageContainer').classList.add('show');
//                             setTimeout(function() {document.getElementById('displayMessageContainer').classList.remove('show')}, 4000);
//                         }
//                     } else {
//                         alert('Une erreur est survenue : ' + response.error);
//                     }
//                 }
//             });
//         });
//     });
// }




var deleteDiv = document.querySelectorAll('.favorite-delete')
console.log(deleteDiv)
// var form = $('.actionFavorite')
$(document).ready(function () {
    for (let i = 0; i < deleteDiv.length; i++) {
        var lebtn = $(deleteDiv[i]).find('.favorite-button')[0];
        console.log(lebtn)
        //  var csrf = $(this).siblings('input[name="csrf"]').val();
        var csrf = $('input[name="csrf"]').val();
        $(deleteDiv[i]).on('click', '.favorite-button', function (e) {
            e.preventDefault(); // Empêcher l'envoi par défaut du formulaire
            // console.log(form[i][3])
            console.log(e.target.closest('button').getAttribute('data-id'))
            console.log(csrf)

            var formData = {
                title: e.target.closest('button').getAttribute('data-id')
            } // Récupérer les données du formulaire


            console.log(formData)
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
                            console.log('la')
                            // Mettre à jour la page sans la recharger
                            // Par exemple, ajouter le nouveau champ à un tableau existant
                            if (form[i][3].classList.contains('is-favorite')) {
                                $(form[i][3]).removeClass('is-favorite')
                                console.log(document.getElementById('displayMessage'))
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
                            var formId = e.target.closest('button').getAttribute('data-id')
                            var form = $('form[data-id="' + formId + '"]');
                            form.css('display', 'none');
                            document.getElementById('displayMessage').innerHTML = 'La titre a été supprimé de vos Coups de coeur';
                            document.getElementById('displayMessageContainer').classList.add('show');
                            setTimeout(function () { document.getElementById('displayMessageContainer').classList.remove('show') }, 4000);
                            console.log(formId)
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
});
