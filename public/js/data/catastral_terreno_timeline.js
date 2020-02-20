$(document).ready(function() {
    var url = localStorage.getItem('url');
    var date = new Date();
    $('#since').datepicker({
        maxDate:  date,
        format: 'yyyy-mm-dd', // Configure the date format
        // yearRange: [1900,date.getFullYear()],
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
    $('#to').datepicker({
        maxDate:  null,
        format: 'yyyy-mm-dd', // Configure the date format
        minDate: date,
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


    $('#register').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            method: 'POST',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            url: url + 'catastral-construction/timeline/store',
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (resp) {
                swal({
                    title: "¡Bien Hecho!",
                    text: resp.message,
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    }
                }).then(accept => {
                    // window.location.href = url + 'catastral-construction/timeline/read';
                });
            }, error: function (err) {
                console.log(err);
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: {
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }
        });
    });

    $('#btn-modify').click(function() {
        $(this).hide();
        $('#btn-update').removeClass('hide');
        $('#name').removeAttr('disabled');
        $('#since').removeAttr('disabled');
        $('#to').removeAttr('disabled');
        $('#value_built_terrain').removeAttr('disabled');
        $('#value_empty_terrain').removeAttr('disabled');

    });

    $('#update').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url + "catastral-terreno/timeline/update",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            method: "POST",
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
                swal({
                    title: "¡Bien Hecho!",
                    text: resp.message,
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    }
                }).then(accept => {
                    window.location.href = url + 'catastral-terreno/timeline/details/' + resp.id;
                });
            },
            error: function(err) {
                console.log(err);
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }
        });
    });
});