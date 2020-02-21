var currentRequest = null;

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

    $('.loader-bloc').css("display","block");
    $('.table-responsive-sm').css("display","none");

    $.ajax({
        type: 'POST',
        url: '/recherche',
    }).done(function (data) {
        $('#tbody').empty();
        $('.loader-bloc').css("display","none");
        $('.table-responsive-sm').css("display","block");
        $recherche(data);

    });
}

$debutAjax = function () {
    $('#tbody').empty();

    $('.loader-bloc').css("display","block");
    $('.table-responsive-sm').css("display","none");

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
        $('.loader-bloc').css("display","none");
        $('.table-responsive-sm').css("display","block");
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
