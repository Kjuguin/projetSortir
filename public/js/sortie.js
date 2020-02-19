var currentRequest = null;

$lieuAjax = function () {

    console.log($('#creation_sortie_noLieu').val());

    currentRequest = $.ajax({
        type: 'POST',
        url: '/creerSortie/lieu/' + $('#creation_sortie_noLieu').val(),

        beforeSend: function () {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        }
    }).done(function (data) {
        // $recherche(data);
        console.log(data);
        console.log(data['lieu']);
        console.log(data['lieu']['noVille']['nomVille']);

        $('#ville').html(data['lieu']['noVille']['nomVille']);
        $('#rue').html(data['lieu']['rue']);
        $('#cp').html(data['lieu']['noVille']['codePostal']);
        $('#lat').html(data['lieu']['latitude']);
        $('#long').html(data['lieu']['longitude']);


    });
};

$('#creation_sortie_noLieu').on('change', function (e) {
    $lieuAjax();
});
