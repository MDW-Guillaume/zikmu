// var url =

console.log($('.actionFavorite'))
var form = $('.actionFavorite')
for (let i = 0; i < form.length - 1; i++) {
    $(document).ready(function () {
        form[i].addEventListener('submit', function (e) {
            e.preventDefault(); // Empêcher l'envoi par défaut du formulaire
            console.log(form[i][3])
            var formData = $(form[i]).serialize(); // Récupérer les données du formulaire
            console.log(formData)
            $.ajax({
                url: '/album',
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
