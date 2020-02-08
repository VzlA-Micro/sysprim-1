$(document).ready(function () {
   // var url = "https://sysprim.com/";
    var url = localStorage.getItem('url');

    $('#ci').change(function () {
        if($('#ci').val()!==''&&$('#nationality').val()!==null){
            CheckCedula();
        }
    });

    $('#ci').keyup(function () {
        if($('#nationality').val()===null){
            swal({
                title: "Información",
                text: "Debes seleccionar la nacionalidad, antes de ingresar el número de cedula.",
                icon: "info",
                button: "Ok",
            });

            $('#ci').val('')
        }

    });


    $('#nationality').change(function () {
        if($('#ci').val()!==''&&$('#nationality').val()!==null){
            CheckCedula();
        }
    });


    $('#phone_user').keyup(function () {

        console.log($('#country_code_user').val());
        if($('#country_code_user').val()===null){
            swal({
                title: "Información",
                text: "Debes seleccionar la operadora, antes de ingresar el número de teléfono.",
                icon: "info",
                button: "Ok",
            });

            $('#phone_user').val('');
        }
    });






    function CheckCedula() {
        if ($('#ci').val() !== '') {

            if ($('#ci').val().length >= 7) {
            var ci = $('#ci').val();
            var nationality = $('#nationality').val();
            $.ajax({
                method: "GET",
                url: url+"users/verify-ci/"+nationality+ci,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
                        });
                        $('#ci').val('');
                        $('#ci').addClass('invalid');
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    } else {
                        findUser(nationality, ci);
                    }

                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });

            }else{
                swal({
                    title: "Información",
                    text: "La logintud minima de la cedula debe ser 7, ingrese una cedula valida.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }
        }
    }

    $('#email').change(function () {
        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: url+"users/verify-email/"+email,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
                        });
                        $('#email').val('');
                    }
                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }
    });



    $('#email_edit').change(function () {
        if ($('#email_edit').val() !== '') {
            var email = $('#email_edit').val();
            var id = $('#id').val();
            $.ajax({
                method: "GET",
                url: url + "users/verify-email/" + email + '/' + id,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
                        });
                        $('#email_edit').val('');
                    }
                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                    $('#email_edit').val('');
                }
            });
        }
    });



    function findUser(nationality, ci) {
        $.ajax({
            method: "GET",
            url: url+"users/find/"+nationality+"/"+ci,
            success: function (response) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

                if (response.status !== 'error') {
                    $('#name').val(response.response.nombres);
                    $('#name').attr('readonly','readonly');
                    if($('#name_user').val()!==undefined){
                        $('#name_user').val(response.response.nombres);
                    }
                    $('#surname').val(response.response.apellidos);
                    $('#surname').attr('readonly','readonly');
                    console.log(response);
                    M.updateTextFields();

                }
            },
            error: function (err) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: "Ok",
                });
            }
        });
    }


    $('#register').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "taxpayers/save",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {

                swal({
                    title: "¡Bien Hecho!",
                    text: response.message,
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    window.location.href = url + "taxpayers/manage";
                });


                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

            },
            error: function (err) {
                console.log(err);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: "Ok",
                });
            }
        });
    });

    $('#btn-edit').click(function () {
        $(this).hide();
        $('#phone').removeAttr('readonly');
        $('#country_code').removeAttr('disabled','');
        $('select').formSelect();
        $('#email_edit').removeAttr('disabled');
        $('#address').removeAttr('disabled','');
        $('#btn-update').show();
    });

    $('#btn-reset-password').click(function() {
        var id = $('#id').val();
        var ci = $('#ci').val();
        swal({
            icon: "info",
            title: "Restablecer Contraseña",
            text: "¿Está seguro que desea restabler la contraseña? cambiara a :"+  $('#ci').val()  +" Si lo hace, no podrá revertir los cambios.",
            buttons: {
                confirm: {
                    text: "Restablecer",
                    value: true,
                    visible: true,
                    className: "red-gradient"
                },
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(confirm => {
            if(confirm) {
                $.ajax({
                    method: 'POST',
                    datType: 'json',
                    data: {
                        id: id,
                        ci: ci
                    },
                    url: url + "taxpayers/reset-password",
                    success: function (resp) {
                        swal({
                            title: "Bien hecho",
                            text: "Se ha reseteado la contraseña éxitosamente.",
                            icon: "success",
                            timer: 3000,
                            buttons: {
                                confirm: {
                                    text: "Aceptar",
                                    className: "green-gradient"
                                }
                            }
                        })
                        .then(exit => {
                            location.href = url + 'taxpayers/manage';
                        });
                    },
                    error: function (err) {
                        console.log(err);
                        swal({
                            text: "Acción cancelada.",
                            icon: "info",
                            buttons: {
                                confirm: {
                                    text: "Aceptar",
                                    className: "blue-gradient"
                                }
                            }
                        });
                    }
                });
            }
            else {
                swal({
                    text: "No se ha reseteado la contraseña",
                    icon: "info",
                    buttons: {
                        confirm: {
                            text: "Aceptar",
                            className: "blue-gradient"
                        }
                    }
                });
            }
        });
    });

        $('#update').submit(function (e) {

            e.preventDefault();
                $.ajax({
                    url: url + "taxpayers/update",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData(this),
                    method: "POST",

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {

                        swal({
                            title: "¡Bien Hecho!",
                            text: response.message,
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            window.location.href = url + "taxpayers/details/"+$('#id').val();
                        });


                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                    },
                    error: function (err) {
                        console.log(err);
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Oh no!",
                            text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                            icon: "error",
                            button: "Ok",
                        });
                    }
                });

        });





});
