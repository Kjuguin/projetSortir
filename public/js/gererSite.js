$(document).ready(function ($) {


    $('#labelAjoutSite').hide(0);
    $('#ajout_site_nomSite').hide(0);
    $('#valider').hide(0);

    $('#ajout_site_nomSite').empty();
});


$ajouterSite = function () {
    $('#valider').toggle();
    $('#labelAjoutSite').toggle();
    $('#ajout_site_nomSite').toggle();
}


$('#nom').on('keyup', function (e) {
    // $rechercheSite();
    $('#tbody').empty();
    // $('.loader-bloc').css("display","block");
    // $('.table-responsive-sm').css("display","none");
    currentRequest = $.ajax({
        type: 'POST',
        url: '/gererSite/recherche',
        data: {"nom": $('#nom').val()},
        beforeSend: function () {
            if (currentRequest != null) {
                currentRequest.abort();
            }
        }
    }).done(function (data) {
        // $('.loader-bloc').css("display","none");
        // $('.table-responsive-sm').css("display","block");
        console.log(data);
        console.log(data['sites']);
        var imgCan = "{{ asset('img/cancel.png') }}";
        $.each(data['sites'], function (key, val) {
            $('#tbody').append(
                '<tr><td> ' + val['nomSite'] + '</td>' +
                '<td>' + imgCan + '</td></tr>'
            );
        })
    });
})
;