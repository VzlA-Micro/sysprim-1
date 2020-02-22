$(document).ready(function() {
    var url = localStorage.getItem('url');



    $('#register').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        if($('#value_catastral_terreno_id').val()!==null && $('#since').val()!==null) {

            $.ajax({
                method: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                url: url + 'catastral-terreno/timeline/store',
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (resp) {
                    if (resp.status === 'success') {
                        swal({
                            title: "¡Bien Hecho!",
                            text: resp.message,
                            icon: "success",
                            button: {
                                text: "Esta bien",
                                className: "green-gradient"
                            }
                        }).then(function (accept) {
                            window.location.href = url + 'catastral-terreno/timeline/read';
                        });
                    }
                    else if (resp.status === 'error') {
                        swal({
                            title: "¡Error!",
                            text: resp.message,
                            icon: "error",
                            button: {
                                text: "Esta bien",
                                className: "red-gradient"
                            }
                        });
                    }
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
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
        }else{
            if($('#since').val()==null){
                swal({
                    title: "Información",
                    text: "Debes seleccionar el año al que estara asociado este valor de terreno.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }else if($('#value_catastral_terreno_id').val()===null){

                swal({
                    title: "Información",
                    text: "Debes seleccionar la valor del terreno al que estara asociado la linea de tiempo.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

            }
        }
    });

    $('#btn-modify').click(function() {
        $(this).hide();
        $('#btn-update').removeClass('hide');
        $('#name').removeAttr('disabled');
        $('#since').removeAttr('disabled');
        // $('#to').removeAttr('disabled');
        $('#value_built_terrain').removeAttr('disabled');
        $('#value_empty_terrain').removeAttr('disabled');
        $('select').formSelect();
    });

    $('#update').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        if($('#value_catastral_terreno_id').val()!==null && $('#since').val()!==null) {

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
                if(resp.status === 'success') {
                    swal({
                        title: "¡Bien Hecho!",
                        text: resp.message,
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + 'catastral-terreno/timeline/details/' + resp.id;
                    });
                }
                else if(resp.status === 'error'){
                    swal({
                        title: "¡Error!",
                        text: resp.message,
                        icon: "error",
                        button: {
                            text: "Esta bien",
                            className: "red-gradient"
                        }
                    });
                }
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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
        }else{
            if($('#since').val()==null){
                swal({
                    title: "Información",
                    text: "Debes seleccionar el año al que estara asociado este valor de terreno.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }else if($('#value_catastral_terreno_id').val()===null){

                swal({
                    title: "Información",
                    text: "Debes seleccionar la valor del terreno al que estara asociado la linea de tiempo.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

            }
        }
    });
});