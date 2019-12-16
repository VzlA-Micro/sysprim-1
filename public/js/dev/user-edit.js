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
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
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
        console.log('eje');
        console.log($('#country_code_user').val());
        if($('#country_code_user').val()===null){
            swal({
                title: "Información",
                text: "Debes seleccionar la operadora, antes de ingresar el número de teléfono.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
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
                    console.log(response);
                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });

                        $('#ci').addClass('invalid');
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    } else if(response.status==='update'&&response.user[0].id!=$('#user_id').val()) {

                        swal({
                            title: "Información",
                            text: "Esta cedula ya existe en el sistema. Por favor, ingresa una cedula valida.",
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        $('#ci').addClass('invalid');
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        $('#ci').val('');

                    }else if (response.user[0].id==$('#user_id').val()){
                        $('#ci').addClass('invalid');
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    }else if(response.status==='success'){
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
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
                            button:{
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
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
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
            }
        });
    }


    $('#gestionUser').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this); // Creating FormData object.
        $.ajax({
            url: url + "user/save",
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
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
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
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
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
                        button:{
                            text: "Esta bien",
                            className: "green-gradient"
                        },
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
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







});
