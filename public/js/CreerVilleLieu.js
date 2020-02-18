jQuery(document).ready(function($) {

$('#button_ajouterVille').click(
    function () {

        $('.nomVilleMasque').fadeToggle();
        $('.labelNomVilleMasque').fadeToggle();
        $('.codePostalMasque').fadeToggle();
        $('.labelCodePostalMasque').fadeToggle();
        $('.buttonSubmitMasque').fadeToggle();

    });

});