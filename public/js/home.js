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

$('.switch-input').change(function(e){
    var etat =$(this).is(":checked");
    var value= this.value;
    e.preventDefault();
    $.ajax({
        url: $('#urlModifierWs').val(),
        type: 'POST',
        data: 'value=' + value + '&etat=' + etat,
        success: function() {
        }
    });
});