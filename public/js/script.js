$(document).ready(function(){
    /*
     * Tootips
     */
    $('[data-toggle="tooltip"]').tooltip();

    /*
     * Modal
     */
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
});