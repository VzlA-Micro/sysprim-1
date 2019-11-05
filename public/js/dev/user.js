$(document).ready(function () {
    $('#ci').blur(function () {
        if($('#ci').val()!==''&&$('#document_type').val()===null){
            CheckCedula();
        }
    });


    $('#nationality').change(function () {
        if($('#ci').val()!==''&&$('#document_type').val()===null){
            CheckCedula();
        }
    });


    function CheckCedula() {
        if ($('#ci').val() !== '') {
            var ci = $('#ci').val();
            var nationality = $('#nationality').val();
            $.ajax({
                method: "GET",
                url: "https://sysprim.com/users/verify-ci/"+nationality+ci,
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
        }
    }

    $('#email').blur(function () {
        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: "https://sysprim.com/users/verify-email/"+email,
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


    function findUser(nationality, ci) {
        $.ajax({
            method: "GET",
            url: "http://sysprim.com.devel/users/find/"+nationality+"/"+ci,
            success: function (response) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

                if (response.status !== 'error') {
                    $('#name').val(response.response.nombres);

                    if($('#name_user').val()!==undefined){
                        $('#name_user').val(response.response.nombres);
                    }
                    $('#surname').val(response.response.apellidos);
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

    var url = "https://sysprim.com/";
    $('#gestionUser').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "user/save",
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
                ;

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


    var statusBoton = false;

        $('#userUpdate').on('submit', function (e) {
            e.preventDefault();
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
                        ;

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
                $('#phone').removeAttr('readonly');
                $('#emailEdit').removeAttr('readonly');
                $('#passwordEdit').removeAttr('readonly');
                $('#rol').attr('readonly','disabled');
                statusBoton=true;
            }

        });


});
