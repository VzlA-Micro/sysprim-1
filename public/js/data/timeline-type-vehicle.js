$(document).ready(function () {

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

    var url = localStorage.getItem('url');

///////////////////////////////////////////////////////////////
    $('#register').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "type-vehicles/timeline/save",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                console.log(data);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                if (data.status == true) {
                    swal({
                        title: "¡Bien Hecho!",
                        text: data.message,
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        window.location.href = url + "type-vehicles/timeline/read";
                    });
                } else if (data.status == "validation-failed") {
                    swal({
                        title: "Información",
                        text: data.message,
                        icon: "info",
                        button: "Ok",
                    })
                } else {
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            },
            error: function (err) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: {
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
            }
        });
    });


    $('#btn-modify').click(function () {
        $(this).hide();
        $('#rate').prop('disabled', false);
        $('#rate_ut').prop('disabled', false);
        $('#dateStart').prop('disabled', false);
        //$('#dateEnd').prop('disabled', false);
        $('#btn-update').removeClass('hide');
    });

    $('#update-timeline').on('submit', function (e) {
        e.preventDefault();

        swal({
            icon: "info",
            title: "Actualizar Linea De Tiempo",
            text: "¿Está seguro que desea modificar los datos?, Si lo hace, no podrá revertir los cambios.",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey",
                    closeModal: true
                },
                confirm: {
                    text: "Aceptar",
                    value: true,
                    visible: true,
                    className: "blue",
                },
            }

        }).then(confirm => {
            if (confirm) {
                if ($('#rate').val() == '') {
                    swal({
                        title: "Información",
                        text: "No puede dejar el campo 'Tarifa menor a 3 años(U.T)' vacio.",
                        icon: "info",
                        button: "Ok",
                    });
                } else if ($('#rate_UT').val() == '') {
                    swal({
                        title: "Información",
                        text: "No puede dejar el campo 'Tarifa mayor a 3 años(U.T)' vacio.",
                        icon: "info",
                        button: "Ok",
                    });
                } else {
                    $.ajax({
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            url: url + "/type-vehicles/timeline/update",
                            data: new FormData(this),
                            dataType: false,

                            beforeSend: function () {
                                $('#name').attr('readonly', 'readonly');
                                $('#rate').attr('readonly', 'readonly');
                                $('#rate_ut').attr('readonly', 'readonly');
                            },
                            success: function (data) {
                                console.log(data)
                                if (data.status == true) {
                                    swal({
                                        title: "¡Bien Hecho!",
                                        text: data.message,
                                        icon: "success",
                                        button: "Ok",
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else if (data.status == "validation-failed") {
                                    swal({
                                        title: "Información",
                                        text: data.message,
                                        icon: "info",
                                        button: "Ok",
                                    })
                                } else {
                                    swal({
                                        title: "Información",
                                        text: data.message,
                                        icon: "info",
                                        button: "Ok",
                                    })
                                }
                            },
                            error: function (e) {
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                                swal({
                                    title: "¡Oh no!",
                                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                                    icon: "error",
                                    button: {
                                        text: "Entendido",
                                        className: "red-gradient"
                                    },
                                });
                            }
                        }
                    );
                }
                updateType = false;
            }
        });
    });
});




