$(document).ready(function () {
    var url = localStorage.getItem('url');
    $('.datepicker').datepicker({
        maxDate: null,
        // defaultDate: date,
        format: 'yyyy-mm-dd', // Configure the date format
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


    $('#register').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url + "ciu-branch/time-line/store",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            method: "POST",
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(response) {


                console.log(response);


                if(response.status==='success'){
                    swal({
                        title: "¡Bien Hecho!",
                        text: response.message,
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        //window.location.href = url + "accessories/manage";
                    });

                }else if(response.status==='error'){
                    swal({
                        title: "¡Error!",
                        text: response.message,
                        icon: "error",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    })
                }

            },
            error: function(err) {
                console.log(err);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
            }
        });
    });
});