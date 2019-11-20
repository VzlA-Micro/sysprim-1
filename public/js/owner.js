$(window).on("load", function () {
    $("#preloader").fadeOut("fast");
    $("#preloader-overlay").fadeOut("fast");
});
$(document).ready(function() {
    $(".dropdown-trigger").dropdown({
        coverTrigger: false,
        constrainWidth: false,
        alignment: 'right',
    });
    $('.sidenav').sidenav();
    $('select').formSelect();
    $('.collapsible').collapsible();
    // Datepicker settings
    var date = new Date();
    // var year = date.getFullYear();
    // var month = date.getMonth();
    // var day = date.getDate();
    // var date = new Date(year - 1, month, day);

    $('.datepicker').datepicker({
        maxDate:  date,
        // defaultDate: date,
        format: 'yyyy-mm-dd', // Configure the date format
        yearRange: [1900,date.getFullYear()],
        showClearBtn: false,
        i18n: {
            cancel: 'Cerrar',
            clear: 'Reiniciar',
            done: 'Hecho',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    });
    M.textareaAutoResize($('#address'));
    $('.tooltipped').tooltip();
    // $('.parallax').parallax();
    $('.materialboxed').materialbox();
    $('.collapsible').collapsible();
    $('.fixed-action-btn').floatingActionButton();
 
    $('.tabs').tabs({
        // swipeable:true
    });
    $('#modal1').modal();

    $('.modal').modal();


});