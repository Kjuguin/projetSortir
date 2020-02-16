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


// $('#nom').on('keyup', function (e) {
//
//     currentRequest = $.ajax({
//         type: 'POST',
//         url: '/home/recherche',
//         data: {
//             "site": null,
//             "nom": $(this).val(),
//             "dateDebut": null,
//             "dateFin": null,
//             "organisateur": null,
//             "inscrit": null,
//             "notInscrit": null,
//             "passee": null
//         },
//         beforeSend: function () {
//             if (currentRequest != null) {
//                 currentRequest.abort();
//             }
//         }
//     }).done(function (data) {
//         console.log(data);
//         console.log(data['param']);
//
//         // lire un tableau
//         $.each(data['param'], function (key, val) {
//             console.log(key + " : " + val);
//         });
//     });
// });

$('#nom2').on('keyup', function (e) {

    currentRequest = $.ajax({
        type: 'POST',
        url: '/test/recherche',
        data: {
            "site": null,
            "nom": $(this).val()
        },
        beforeSend: function () {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        }

    }).done(function (data) {
        console.log(data);
        console.log(data['param']);
        console.log(JSON.parse(data['sorties']));
        // console.log(data['sorties']);
        // lire un tableau
        // $.each(data['param'], function (key, val) {
        //     console.log(key + " : " + val);
        // });
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