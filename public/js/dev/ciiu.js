$('document').ready(function () {

    var url = localStorage.getItem('url');

    $('#alicuota').change(function () {
        if($(this).val()<1){
            swal({
                title: "Información",
                text: "La alicuota tiene que se mayor o igual 1.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "amber-gradient"
                },
            });
            $(this).val('');
        }

    });

    $('#mTM').change(function () {
        if($(this).val()<1){
            swal({
                title: "Información",
                text: "El minimo tributable tiene que se mayor o igual 1.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "amber-gradient"
                },
            });
            $(this).val('');
        }
    });


    $('#ciuu').on('submit',function (e) {
        e.preventDefault();


        if($('#idGroupCiiu').val()!==null) {

            $.ajax({

                url: url + "ciu-branch/save",
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


                    console.log(response);
                    swal({
                        title: "¡Bien Hecho!",
                        text: "CIIU registrado con exito",
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        },
                    }).then(function (accept) {
                        window.location.href = url + "ciu-branch/read";
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
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });

        }else{
            swal({
                title: "Información",
                text: "Debes seleccionar el ramo, al que estara asociado el CIIU.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }


    });

    $('#btn-edit').click(function () {
        $(this).hide();
        $('#name').removeAttr('readonly','');
        $('#code').removeAttr('readonly','');
        $('#alicuota').removeAttr('readonly','');
        $('#mTM').removeAttr('readonly','');
        $('#idGroupCiiu').prop('disabled','');
        $('select').formSelect();
        $('#btn-update').show();
    });



    $('#ciiu-details').on('submit',function (e) {
        e.preventDefault();

        $.ajax({
            url: url+"ciu-branch/update",
            cache:false,
            contentType:false,
            processData:false,
            data:new FormData(this),
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {

                swal({
                    title: "¡Bien Hecho!",
                    text: "CIIU actualizaco con éxito.",
                    icon: "success",
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
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
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
            }
        });
    });


    $('#code').change(function () {
        var code=$(this).val();

        if(code!='') {
            $.ajax({
                method: "GET",
                url: url + "ciu-branch/verify-code/" + code,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });

                        $('#code').val('');
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
                            className: "blue-gradient"
                        },
                    });
                }
            });

        }
    });






});

