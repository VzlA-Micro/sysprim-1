$('document').ready(function () {
<<<<<<< HEAD
    //var url="https://sysprim.com/";
    var url="http://172.19.50.253/";
=======

    var url="https://sysprim.com/";
    //var url="http://172.19.50.253/";
>>>>>>> 8f0d152d0932981cfb9c5aeb842378ea47cd9c84
    // var url="http://sysprim.com.devel/";

    $('#ciuu').on('submit',function (e) {
        e.preventDefault();

        $.ajax({

            url: url+"ciuBranch/save",
            //cache:false,
            //contentType:false,
            //processData:false,
            data:new FormData(this),
            dataType:json,
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
                cosole.log(response);
                swal({
                    title: "¡Bien Hecho!",
                    text: "CIIU registrado con exito",
                    icon: "success",
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
                }).then(function (accept) {
                    window.location.href=url+"ciu-branch/read";
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


                console.log(response);
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

