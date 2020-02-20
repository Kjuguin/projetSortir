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

    console.log('test');
}

$('#nom').on('keyup', function (e) {
    $rechercheSite();
});