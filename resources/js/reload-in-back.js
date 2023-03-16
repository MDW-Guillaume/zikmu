$(document).ready(function () {
        // Interceptez tous les clics sur les liens
        $('a').click(function (event) {
            // Empêchez la navigation par défaut
            event.preventDefault();

            // Chargez la nouvelle page en arrière-plan
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    console.log(data)
                    // $('#content').html($(data).find('#content').html());
                    $('#content').html($(data).find('#content').textContent);
                }
            });
        });
});