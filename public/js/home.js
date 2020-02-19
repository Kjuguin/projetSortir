$(document).ready(function() {

    /**
     * Activation du tri sur toutes les colonnes du tableau
     */
    $('#table-sortie').DataTable({
        columnDefs: [{
            orderable: true,
            targets: "_all",
        }],
        "searching": false
    });
    $('.dataTables_length').addClass('bs-select');
});


window.onload = function () {


    $.ajax({
        type: 'POST',
        url: '/home/recherche',
    }).done(function (data) {
        $('#tbody').empty();
        $recherche(data);

    });
}

$debutAjax = function () {
    $('#tbody').empty();

    console.log("" );
    console.log("-----------");
    console.log(" " );
    console.log("site : " + $('#site').val());
    console.log("nom : " + $('#nom').val());
    console.log("date debut : " + $('#date-debut').val());
    console.log("date fin : " + $('#date-fin').val());
    console.log("organisateur : " + $('#organisateur:checked').val());
    console.log("inscrit : " + $('#inscrit:checked').val());
    console.log("non inscrit : " + $('#non-inscrit:checked').val());
    console.log("sorties passees : " + $('#sorties-passees:checked').val());

    currentRequest = $.ajax({
        type: 'POST',
        url: '/recherche',
        data: {
            "site": $('#site').val(),
            "nom": $('#nom').val(),
            "dateDebut": $('#date-debut').val(),
            "dateFin": $('#date-fin').val(),
            "organisateur": $('#organisateur:checked').val(),
            "inscrit": $('#inscrit:checked').val(),
            "notInscrit": $('#non-inscrit:checked').val(),
            "passee": $('#sorties-passees:checked').val()
        },
        beforeSend: function () {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        }

    }).done(function (data) {
        $recherche(data);

    });
}

$('#site').on('change', function (e) {
    $debutAjax();
});

$('#nom').on('keyup', function (e) {
    $debutAjax();
});

$('#date-debut').on('change', function (e) {
    $debutAjax();
});

$('#date-fin').on('change', function (e) {
    $debutAjax();
});
