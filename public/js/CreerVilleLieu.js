$(document).ready(function($) {
        $('.nomVilleMasque').hide(0);
        $('.labelNomVilleMasque').hide(0);
        $('.codePostalMasque').hide(0);
        $('.labelCodePostalMasque').hide(0);
        $('.buttonSubmitMasque').hide(0);
        $('#button_ajouterVilleMasque').hide(0);


        $('#button_ajouterVille').click(function () {
                $('.nomVilleMasque').show().attr('required',true).prop('disabled',false);
                $('.labelNomVilleMasque').show();
                $('.codePostalMasque').show().attr('required',true).prop('disabled',false);
                $('.labelCodePostalMasque').show();
                $('.buttonSubmitMasque').show();
                $('#button_ajouterVille').hide();
                $('#button_ajouterVilleMasque').show();
                $('.buttonSubmitVilleSave').hide();
                $('.villeSave').hide();
                $('.labelVilleSave').hide();
        })

        $('#button_ajouterVilleMasque').click(function(){
                $('.nomVilleMasque').hide().attr('required',false).prop('disabled',true);
                $('.labelNomVilleMasque').hide();
                $('.codePostalMasque').hide().attr('required',false).prop('disabled',true);
                $('.labelCodePostalMasque').hide();
                $('.buttonSubmitMasque').hide();
                $('#button_ajouterVilleMasque').hide();
                $('#button_ajouterVille').show();
                $('.buttonSubmitVilleSave').show();
                $('.villeSave').show();
                $('.labelVilleSave').show();
        })




});