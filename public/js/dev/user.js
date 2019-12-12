$(document).ready(function () {
    var url = "https://sysprim.com/";

    $('#ci').blur(function () {
        if($('#ci').val()!==''&&$('#nationality').val()!==null&&$('#company-tab').val()===undefined){
            CheckCedula();
        }else{

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
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button: "Ok",
                        });

                        $('#ci').addClass('invalid');
                        $('#ci').val('');
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    } else {
                        findUser(nationality, ci);
                    }

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
        }
    }

    $('#email').blur(function () {
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
                    $('#email').val('');
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
                        $('#name_user').attr('readonly','readonly')
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


    $('#gestionUser').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this); // Creating FormData object.
        $.ajax({
            url: url + "users/save",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
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
                    window.location.href = url + "users/manage";
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

    $('#btn-reset-password').click(function() {
        var id = $('#id').val();
        var ci = $('#ci').val();
        swal({
            icon: "info",
            title: "Resetear Contraseña",
            text: "¿Está seguro que desea resetear la contraseña? Si lo hace, no podrá revertir los cambios.",
            buttons: {
                confirm: {
                    text: "Resetear",
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
                    url: url + "users/reset-password",
                    beforeSend: function() {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (resp) {
                        console.log(resp);
                        swal({
                            title: "Reseteo Exitoso",
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
                            location.href = url + 'users/manage';
                        });
                    },
                    error: function (err) {
                        console.log(err);
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

    var statusBoton = false;
        $('#userUpdate').on('submit', function (e) {

            e.preventDefault();
            console.log("epa");
            if (statusBoton==true){
                $.ajax({
                    url: url + "users/update",
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
                            window.location.href = url + "users/manage";
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
            }

            if (statusBoton == false) {
                $('#phone_user').removeAttr('readonly');
                $('#email').removeAttr('readonly');
                $('#name').removeAttr('readonly');
                $('#surname').removeAttr('readonly');
                $('#ci').removeAttr('readonly');


                $('#rol').attr('readonly','disabled');
                statusBoton=true;
            }

        });


    function online() {
      $.ajax({
            async: false,
            method: "GET",
            url: url+"online",
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
              return   online=true;
            },
            error: function (err) {
               return  online = false;
            }
        });


       return online;
    }



 $('#button-enable').click(function () {
        var user_id=$('#id').val();
        var value=$(this).val();

        swal({
            icon: "info",
            title: "Activar Cuenta",
            text: "¿Está seguro de habilitar esta cuenta? Si lo hace, no podrá revertir los cambios.",
            buttons: {
                confirm: {
                    text: "Habilitar",
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
        }).then(function (accept) {

            if(accept){
                $.ajax({
                    method: "GET",
                    url: url+"users/account/"+user_id+"/"+value,

                    success: function (response) {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "La cuenta fue habilitada con éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            location.reload();
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');


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
    });



});
