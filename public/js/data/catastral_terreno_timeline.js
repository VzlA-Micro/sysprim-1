$(document).ready(function() {
    var url = localStorage.getItem('url');



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
            url: url + 'catastral-terreno/timeline/store',
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (resp) {
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
                        window.location.href = url + 'catastral-terreno/timeline/read';
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
        // $('#to').removeAttr('disabled');
        $('#value_built_terrain').removeAttr('disabled');
        $('#value_empty_terrain').removeAttr('disabled');
        $('select').formSelect();
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
    });
});