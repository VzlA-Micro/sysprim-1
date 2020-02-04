$('document').ready(function () {
    var url = "http://sysprim.com.devel/";
    //var url = "https://sysprim.com/";
   // var url = "https://sysprim.com/";

    $('#groupCiiu').on('submit',function (e) {
        e.preventDefault();
        $.ajax({
            url: url+"ciu-group/save",
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
                    text: "CIIU registrado con éxito",
                    icon: "success",
                    button:{
                        text: "Esta bien",        
                        className: "green-gradient"
                    },
                }).then(function (accept) {
                    window.location.href=url+"ciu-group/read";
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