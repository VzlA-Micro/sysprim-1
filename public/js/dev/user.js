$(document).ready(function () {
    $('#ci').blur(function () {
        if($('#ci').val()!==''){
            var ci=$('#ci').val();
            $.ajax({
                method: "GET",
                url: "http://sysprim.com.devel/users/verify-ci/"+ci,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if(response.status==='error'){
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
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
                        button: "Ok",
                    });
                }
            });
        }
    });



    $('#email').blur(function () {
        if($('#email').val()!==''){
            var email=$('#email').val();
            $.ajax({
                method: "GET",
                url: "http://sysprim.com.devel/users/verify-email/"+email,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if(response.status==='error'){
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
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
                        button: "Ok",
                    });
                }
            });
        }
    });
});