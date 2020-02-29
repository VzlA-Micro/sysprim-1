$('document').ready(function () {
    var url = localStorage.getItem('url');


    $('#register').submit(function (e) {
        e.preventDefault();
        var type=$('#type').val();
        var status=$('#status').val();



        if(type!=null&&status!=null) {
            var formData = new FormData(this);
            $.ajax({
                url: url + "rate/save",
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


                    if (response.status === 'success') {
                        swal({
                            title: "¡Bien Hecho!",
                            text: response.message,
                            icon: "success",
                            button: {
                                text: "Esta bien",
                                className: "green-gradient"
                            }
                        }).then(function (accept) {
                            window.location.href = url + "rate/manager";
                        });
                    } else {

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
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });
        }else{


            if(type==null){
                swal({
                    title: "Información",
                    text: "Debe selecionar el ramo que pertenece la tasa.",
                    icon: "info",
                    button: "Ok",
                });
            }else if(status==null){
                swal({
                    title: "Información",
                    text: "Debe selecionar el Estado de la tasa.",
                    icon: "info",
                    button: "Ok",
                });
            }
        }




    });

    $('#code').blur(function () {
        var code=$(this).val();
        var rate_id=$('#rate_id').val();

        if(rate_id===''||rate_id===undefined){
            rate_id='';
        }else{
            rate_id='/'+rate_id;
        }


        if(code!=='') {
            $.ajax({
                method: "GET",
                url: url + "rate/verify-code/" + code+rate_id,
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
                        $('#code').val('');
                        $('#code').addClass('invalid');
                    }

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
    });

    $('#modify-btn').click(function() {
        $(this).hide();
        $('#update-btn').removeClass('hide');
        $('input').removeAttr('readonly');
        $('#status').prop("disabled",false);
        $('#type').prop("disabled",false);
        $('select').formSelect();
        swal({
            title: "Información",
            text: 'Campos Deshabilitado,Realice los cambios y guarde los resultados.',
            icon: "info",
            button: "Ok",
        });


    });

    $('#update').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url + "rate/update",
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
                    text: "Se ha actualizado la tasa exitosamente.",
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "rate";
                });
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

    $('#email').change(function () {
        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: url+"rate/ticket-office/verify-email/"+email,
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
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
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
                        button:{
                            text: "Entendido",
                            className: "blue-gradient"
                        },
                    });
                    $('#email').val('');
                }
            });
        }
    });
});