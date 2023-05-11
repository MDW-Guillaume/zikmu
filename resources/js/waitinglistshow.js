if( typeof(document.getElementById("waitingListPage")) !== 'undefined' ){
    let token = document.getElementById('csrfToken').value

    let actualPlaylist = localStorage.getItem('playlist')

    // découpe la chaîne de caractères en un tableau de chaînes
    var dataArray = actualPlaylist.split(',');

    // crée un objet avec le tableau de données
    var jsonData = {
        data: dataArray,
        csrf_token: token
    };

    // convertit l'objet en chaîne JSON
    var jsonString = JSON.stringify(jsonData);

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
    success: function(response) {
        let theResponse = response
        let waitingTitleLength = theResponse.length
        let waitingTimeLength = ''

        console.log(waitingTitleLength)
        theResponse.forEach(element => {

        });
        let waitingListTitles = document.getElementById('waitingListTitles')

        waitingListTitles.innerHTML = waitingTitleLength

        // traitement en cas de succès
    },
    error: function(jqXHR, textStatus, errorThrown) {
        // traitement en cas d'erreur
    }
    });


    console.log(actualPlaylist)

}
