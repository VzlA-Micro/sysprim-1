$(document).ready(function() {
    $(".dropdown-trigger").dropdown({
        coverTrigger: false,
        constrainWidth: false,
        alignment: 'right'
    });
    $('.sidenav').sidenav();
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });
    $('select').formSelect();
});