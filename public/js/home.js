var currentRequest = null;

$(document).ready(function () {

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

$('#nom').on('keyup', function (e) {

    $('#tbody').empty();

    currentRequest = $.ajax({
        type: 'POST',
        url: '/home/recherche',
        data: {
            "site": $('#site').val(),
            "nom": $(this).val(),
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
});