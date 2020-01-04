$('document').ready(function () {
    var url = "http://172.19.50.253/";


    $('#register').on('submit',function (e) {
        e.preventDefault();

        $.ajax({

            url: url+"fines/save",
            //cache:false,
            //contentType:false,
            //processData:false,
            data:new FormData(this),
            dataType:"json",
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
                cosole.log(response);
                swal({
                    title: "¡Bien Hecho!",
                    text: "Multa, registrada con exito",
                    icon: "success",
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
                }).then(function (accept) {
                    window.location.href=url+"fines/read";
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
});

