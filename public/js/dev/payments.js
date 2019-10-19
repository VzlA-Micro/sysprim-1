$('document').ready(function () {
    var url="http://sysprim.com.devel/";
    $('#payments').on('submit',function (e) {
        e.preventDefault();
            $.ajax({
                url: url+"paymentsTaxes/save",
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
                        text: response.message,
                        icon: "success",
                        button: "Ok",
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

