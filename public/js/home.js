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


$('#nom').on('keyup', function (e) {

    $.ajax({
        type: 'POST',
        url: '/home/recherche',
        // url: "{{ path('home_recherche') }}",
        data: {"site" : null,
        "nom" : $(this).val(),
        "dateDebut" : null,
        "dateFin" : null,
        "organisateur" : null,
        "inscrit":null,
        "notInscrit":null,
        "passee" : null}
    }).done(function(sorties){

        sorties.forEach(function(donne) {
            console.log(donne);
        });
    });
});


// $('.delete').on('click', function (e) {
//
//     var id = this.id;
//
//     if (confirm("Voulez-vous supprimer le souhait?")) {
//
//         $.ajax({
//             url: '/idee/deleteT/' + id
//         }).done(function (data) {
//             window.location.href = data.redirect;
//
//         });
//     } else {
//         location.reload();
//     }
// });