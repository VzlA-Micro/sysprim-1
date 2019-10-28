$('documents').ready(function () {
    var url="http://sysprim.com.devel/";
    $('#verifyPaymentsBank').on('submit',function (e) {
        e.preventDefault();
            $.ajax({
                url: url+"fileBank/save" ,
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
                        text: "Pagos Verificados.",
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        window.location.href=url+"verified/payments";
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