$(document).ready(function($) {
        $('.nomVilleMasque').hide(0);
        $('.labelNomVilleMasque').hide(0);
        $('.codePostalMasque').hide(0);
        $('.labelCodePostalMasque').hide(0);
        $('.buttonSubmitMasque').hide(0);
        $('#button_ajouterVilleMasque').hide(0);


        $('#button_ajouterVille').click(function () {
                $('.nomVilleMasque').show('slow','linear').attr('required',true).prop('disabled',false);
                $('.labelNomVilleMasque').show('slow','linear');
                $('.codePostalMasque').show('slow','linear').attr('required',true).prop('disabled',false);
                $('.labelCodePostalMasque').show('slow','linear');
                $('.buttonSubmitMasque').show('slow','linear');
                $('#button_ajouterVille').hide('slow','linear');
                $('#button_ajouterVilleMasque').show('slow','linear');
                $('.buttonSubmitVilleSave').hide('slow','linear');
                $('.villeSave').hide('slow','linear');
                $('.labelVilleSave').hide('slow','linear');
        })

        $('#button_ajouterVilleMasque').click(function(){
                $('.nomVilleMasque').hide('slow','linear').attr('required',false).prop('disabled',true);
                $('.labelNomVilleMasque').hide('slow','linear');
                $('.codePostalMasque').hide('slow','linear').attr('required',false).prop('disabled',true);
                $('.labelCodePostalMasque').hide('slow','linear');
                $('.buttonSubmitMasque').hide('slow','linear');
                $('#button_ajouterVilleMasque').hide('slow','linear');
                $('#button_ajouterVille').show('slow','linear');
                $('.buttonSubmitVilleSave').show('slow','linear');
                $('.villeSave').show('slow','linear');
                $('.labelVilleSave').show('slow','linear');
        })




});