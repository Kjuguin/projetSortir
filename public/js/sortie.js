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

$test = function () {
    // alert('test');
    console.log($('#creation_sortie_nom').val());
    console.log($('#creation_sortie_dateDebut').val());

    $data = $('#creation_sortie_nom').val()
        + ","
        + $('#creation_sortie_dateDebut').val()
        + ","
        + $('#creation_sortie_dateCloture').val()
        + ","
        + $('#creation_sortie_nbInscriptionMax').val()
        + ","
        + $('#creation_sortie_duree').val()
        + ","
        + $('#creation_sortie_descriptionInfos').val()
    ;


$data = btoa($data);






// console.log(atob($test3));
//     document.location.href="http://127.0.0.1:8000/ajoutLieuVille?token="+$data;
//     document.location.href="http://127.0.0.1:8000/ajoutLieuVille/"+$data;
    document.location.href="/ajoutLieuVille/"+$data;

};

