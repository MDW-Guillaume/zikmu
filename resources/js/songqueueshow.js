// if(document.getElementById("songQueuePage")) {
//     let token = document.getElementById('csrfToken').value

//     let actualPlaylist = localStorage.getItem('playlist')

//     // découpe la chaîne de caractères en un tableau de chaînes
//     var dataArray = actualPlaylist.split(',');

//     // crée un objet avec le tableau de données
//     var jsonData = {
//         data: dataArray,
//         csrf_token: token
//     };

//     // convertit l'objet en chaîne JSON
//     var jsonString = JSON.stringify(jsonData);

//     // envoie les données en ajax
//     $.ajax({
//     type: 'POST',
//     url: '/waiting-list',
//     headers: {
//         'X-CSRF-Token': token
//       },
//     data: jsonString,
//     contentType: 'application/json',
//     dataType: 'json',
//     success: function(response) {
//         console.log(response)
//         let songQueueArray = response.request
//         let waitingTitleLength = songQueueArray.length
//         let waitingTimeLength = 0

//         // Ajout du nombre de titres dans la file d'attente
//         let songQueueTitles = document.getElementById('songQueueTitles')

//         songQueueTitles.innerHTML = waitingTitleLength

//         // Ajout du temps restant dans la file d'attente
//         let songQueueTime = document.getElementById('songQueueLength')

//         songQueueArray.forEach(element => {
//             waitingTimeLength = waitingTimeLength + element.length
//             console.log(element.length)
//         });



//         console.log(waitingTimeLength)
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//         // traitement en cas d'erreur
//     }
//     });


//     console.log(actualPlaylist)

// }
