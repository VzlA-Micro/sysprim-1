var url = localStorage.getItem('url');
$('document').ready(function () {

    $('#delete-temp').click(function () {
        swal({
            icon: "info",
            title: "Eliminar Archivos Temporales",
            text: "¿Desea eliminar archivos temporales de la base de datos?",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey",
                    closeModal: true
                },
                confirm: {
                    text: "Aceptar",
                    value: true,
                    visible: true,
                    className: "blue",
                },
            }

        }).then(function (value) {
            if (value){
                $.ajax({
                    type: "GET",
                    url: url + "delete-temp",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (data) {
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        console.log(data);
                        if (data) {
                            swal({
                                title: "¡Bien Hecho!",
                                text: "Se han eliminado los archivos temporales con exito",
                                icon: "success",
                                button: "Ok",
                            });
                        }
                    },
                    error: function (e) {
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
            }
        })
    });
});