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


$('#nom').on('keyup', function (e) {

    console.log(" ");
    console.log("---------------------");
    console.log(" ");
    console.log("site : " + $('#site').val());
    console.log("nom : " + $(this).val());
    console.log("date-debut : " + $('#date-debut').val());
    console.log("date-fin : " + $('#date-fin').val());
    console.log("organisateur : " + $('#organisateur:checked').val());
    console.log("inscrit : " + $('#inscrit:checked').val());
    console.log("non-inscrit : " + $('#non-inscrit:checked').val());
    console.log("sorties-passees : " + $('#sorties-passees:checked').val());
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
        // console.log(data);
        // console.log(data['sorties']);
        // lire un tableau

        // $.each(data, function (key, val) {
        //     $('#tbody').append(
        //         '<tr><td>' + val['nom'] + '</td><td> : </td><td>' +
        //         val['deux']['numero'] +
        //         '</td></tr>'
        //     );
        //
        //     console.log(key + " : " + val['id']);
        // });
        // $.each(data['sorties'], function (key, val) {
        //     var $id = data['id'];
        //     var $present = '';
        //     var $pathProfil = "/utilisateur/afficherProfil/" + val['noOrganisateur']['id'];
        //     var $dateCloture = new Date(val['dateCloture']);
        //     var $outputCloture = $dateCloture.toLocaleString('en-GB', {
        //         year: 'numeric',
        //         month: '2-digit',
        //         day: '2-digit'
        //     });
        //     var $dateDebut = new Date(val['dateDebut']);
        //     var $outputDebut = $dateDebut.toLocaleString('en-GB', {
        //         year: 'numeric',
        //         month: '2-digit',
        //         day: '2-digit',
        //         hour: '2-digit',
        //         minute: '2-digit'
        //     });
        //     var $compteur = 0;
        //     var $action = '';
        //
        //     $.each(val['noInscriptions'], function (k, v) {
        //         if ($id === v['noUser']['id']) {
        //             $present = "Oui";
        //         }
        //     });
        //
        //     if (val['noEtat']['libelle'] === 'En création') {
        //         $action = '<a href="#">Modifier</a> - <a href="#">Publier</a>'
        //     } else if (val['noEtat']['libelle'] === 'En cours') {
        //         $action = '<a href="#">Afficher</a>'
        //     } else {
        //         $action = '<a href="#">Afficher</a>'
        //         if (val['noEtat']['libelle'] === 'Fermé') {
        //             if ($present === "Oui") {
        //                 $action = $action + ' - ' + '<a href="#">Se désister</a>'
        //             }
        //         } else {
        //             if (val['noInscriptions'].length === 0) {
        //                 $action = $action + ' - ' + '<a href=#">S\'inscrire</a>'
        //                 if (val['noOrganisateur']['id'] === $id) {
        //                     $action = $action + ' - ' + '<a href=#">Annuler</a>'
        //                 }
        //             } else if ($present === "Oui") {
        //                 $action = $action + ' - ' + '<a href="#">Se désister</a>'
        //                 if (val['noOrganisateur']['id'] === $id) {
        //                     $action = $action + ' - ' + '<a href=#">Annuler</a>'
        //                 }
        //             } else {
        //                 $action = $action + ' - ' + '<a href="#">S\'inscrire</a>'
        //                 if (val['noOrganisateur']['id'] === $id) {
        //                     $action = $action + ' - ' + '<a href=#">Annuler</a>'
        //                 }
        //             }
        //         }
        //     }
        //
        //
        //     //     {% set test = 0 %}
        //     //
        //     //     <!-- En création -->
        //     //     {% if sortie.noEtat.libelle is same as ("En création") %}
        //     // <a href="#">Modifier</a> - <a href="#">Publier</a>
        //     //
        //     //     <!-- En cours -->
        //     //     {% elseif  sortie.noEtat.libelle is same as ("En cours") %}
        //     // <a href="{{ path('sortie_afficherSortie',{'id':sortie.id}) }}">Afficher</a>
        //     //
        //     //     <!-- cas ouvert et fermé -->
        //     //     {% else %}
        //     // <a href="{{ path('sortie_afficherSortie',{'id':sortie.id}) }}">Afficher</a>
        //     //
        //     //
        //     //     <!-- cas fermé -->
        //     //     {% if sortie.noEtat.libelle is same as ('Fermé') %}
        //     //
        //
        //
        //     //     {% for inscrit in sortie.noInscriptions %}
        //     //
        //     //     <!-- fermé et inscrit -->
        //     //     {% if inscrit.noUser.id is same as (app.user.id) %}
        //     //     - <a href="#">Se désister</a>
        //     //     {% endif %}
        //     //
        //
        //     //     <!-- fermé et non inscrit (se passe rien) -->
        //     //
        //     //     {% endfor %}
        //     //     <!-- cas ouvert -->
        //     //     {% elseif sortie.noEtat.libelle is same as ('Ouvert') %}
        //     //
        //     //     {% if sortie.noInscriptions.count is same as (0) %}
        //     //     - <a href="{{ path('inscription',{'id':sortie.id}) }}">S'inscrire</a>
        //     //     {% if sortie.noOrganisateur.id is same as (app.user.id) %}
        //     //     - <a href="#">Annuler</a>
        //     //     {% endif %}
        //     //     {% else %}
        //     //
        //     //     {% for inscrit in sortie.noInscriptions %}
        //     //
        //     //     {% if inscrit.noUser.id != app.user.id %}
        //     //
        //     //     {% set test = test + 1 %}
        //     //
        //     //     {% endif %}
        //     //     {% endfor %}
        //     //
        //     //     {% if test == sortie.noInscriptions.count %}
        //     //     <!-- ouvert et non inscrit -->
        //     //
        //     //     - <a href="{{ path('inscription',{'id':sortie.id}) }}">S'inscrire</a>
        //     //
        //     //     <!-- ouvert, non inscrit et organisateur -->
        //     //     {% if sortie.noOrganisateur.id is same as (app.user.id) %}
        //     //     - <a href="#">Annuler</a>
        //     //     {% endif %}
        //     //     {% else %}
        //     //     <!-- ouvert et inscrit -->
        //     //     - <a href="#">Se désister</a>
        //     //
        //     //     <!-- ouvert, inscrit et organisateur -->
        //     //     {% if sortie.noOrganisateur.id is same as (app.user.id) %}
        //     //     - <a href="#">Annuler</a>
        //     //     {% endif %}
        //     //     {% endif %}
        //     //     {% endif %}
        //     //     {% endif %}
        //     //     {% endif %}
        //
        //     $('#tbody').append(
        //         '<tr><td>' + val['nom'] + '</td>' +
        //         '<td>' + $outputDebut + '</td>' +
        //         // '<td>' + new Date(val['dateCloture']) + '</td>' +
        //         '<td>' + $outputCloture + '</td>' +
        //         '<td>' + val['noInscriptions'].length + ' / ' + val['nbInscriptionMax'] + '</td>' +
        //         '<td>' + val['noEtat']['libelle'] + '</td>' +
        //         '<td>' + $present + '</td>' +
        //         '<td><a href=' + $pathProfil + '>'
        //         + val['noOrganisateur']['pseudo']
        //         + '</a></td>' +
        //         '<td>' + $action + '</td>' +
        //         '</tr>'
        //     );
        // });
    });
});


// $('#nom2').on('keyup', function (e) {
//
//     $('#tbody').empty();
//
//     currentRequest = $.ajax({
//         type: 'POST',
//         url: '/test/recherche',
//         data: {
//             "site": null,
//             "nom": $(this).val()
//         },
//         beforeSend: function () {
//             if (currentRequest != null) {
//                 currentRequest.abort();
//             }
//         }
//
//     }).done(function (data) {
//         console.log(data);
//         // console.log(data['0']);
//         // console.log(data['0']['id']);
//         // console.log(data['1']);
//         // console.log(data['sorties']);
//         // lire un tableau
//
//         $.each(data, function (key, val) {
//             $('#tbody').append(
//                 '<tr><td>' + val['nom'] + '</td><td> : </td><td>' +
//                 val['deux']['numero'] +
//                 '</td></tr>'
//             );
//
//             console.log(key + " : " + val['id']);
//         });
//     });
// });

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