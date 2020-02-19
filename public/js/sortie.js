var currentRequest = null;

$debutAjax = function () {

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

$('#creation_sortie_noLieu').on('change', function (e) {
    alert('coucou');
});
