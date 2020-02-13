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