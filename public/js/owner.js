$(document).ready(function() {
    $(".dropdown-trigger").dropdown({
        coverTrigger: false,
        constrainWidth: false,
        alignment: 'right'
    });
    $('.sidenav').sidenav();
    $('select').formSelect();
});