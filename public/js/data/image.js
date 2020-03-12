$(document).ready(function(){
    var url = localStorage.getItem('url');

    $('#register').submit(function(e) {
        e.preventDefault();

        if($('#image').val()!==null) {

            var formData = new FormData(this);

            $.ajax({
                url: url + "image/save",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                method: "POST",
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (resp) {

                    console.log(resp);
                    swal({
                        title: "¡Bien Hecho!",
                        text: resp.message,
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                            window.location.href = url + "image/read";
                    });
                },
                error: function (err) {
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
        }else {
            if ($('#image').val() === null) {
                swal({
                    title: "Información",
                    text: "Debes selecionar la imagen para poder registrarla.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

            }
        }
    });

    $('#delete').click(function () {

        var id = $(this).data("image");
        console.log(id);

        //     swal({
        //         title: "¿Quiere eliminar la imagen?",
        //         text: "¿Esta seguro que desea eliminar esta imagen? Si lo hace, no podrá revertir los cambios.",
        //         icon: "warning",
        //         buttons: {
        //             confirm: {
        //                 text: "Eliminar",
        //                 value: true,
        //                 visible: true,
        //                 className: "red"
        //
        //             },
        //             cancel: {
        //                 text: "Cancelar",
        //                 value: false,
        //                 visible: true,
        //                 className: "grey lighten-2"
        //             }
        //         }
        //     }).then(function(value){
        //         if(value){
        //             $.ajax({
        //                 method: "GET",
        //                 datatype: "JSON",
        //                 url: url + "image/delete/"+id
        //             });
        //
        //             swal({
        //                 text: "Se ha eliminado la imagen exitosamente.",
        //                 icon: "success",
        //                 button: {
        //                     text: "Entendido",
        //                     className: "green"
        //                 },
        //                 timer: 3000
        //             }).then(redirect => {
        //                 location.href = url + "image/read";
        //         });
        //         }else {
        //             swal({
        //                 text: "La imagen no ha sido eliminado",
        //                 icon: "info",
        //                 button: {
        //                     text: "Aceptar",
        //                     className: "green"
        //                 }
        //             });
        //         }
        //     });
        // });
    });
});