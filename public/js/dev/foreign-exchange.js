$(document).ready(function () {
    var url = localStorage.getItem('url');
    //var url = "https://sysprim.com/";
   // var url = "https://sysprim.com/";

    $('#register').on('submit',function (e) {
        e.preventDefault();
        if($('#name').val()!==null) {
        
        $.ajax({
            url: url+"foreign-exchange/save",
            cache:false,
            contentType:false,
            processData:false,
            data:new FormData(this),
            method: "POST",

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
                        window.location.href = url + "foreign-exchange/read";
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

        }else{
            swal({
                title: "Información",
                text: "Debe selecionar una moneda para completar el registro.",
                icon: "info",
                button: "Ok",
            });
        }
    });



    $('#btn-modify').click(function() {
        $(this).hide();
        $('#name').removeAttr('readonly');
        $('#value').removeAttr('readonly');
        $('#btn-update').removeClass('hide');
        swal({
            title: "¡Actualizar!",
            text: "Puedes elegir los campos a modificar",
            icon: "info",
            button: "Ok",
        });
    });



    $('#update').on('submit', function (e) {
            e.preventDefault();
           
            swal({
                icon: "info",
                title: "Actualizar la moneda",
                text: "¿Está seguro que desea modificar los datos?, Si lo hace, no podrá revertir los cambios.",
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

            }).then(confirm => {
                if(confirm) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        url: url + "foreign-exchange/update",
                        data: new FormData(this),
                        dataType: false,

                        beforeSend: function () {
                            $('#name').attr('readonly', 'readonly');
                        },
                        success: function (data) {
                            if (data['update'] == true) {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Has Actualizado Los datos de la moneda, Con Exito",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        },
                        error: function (e) {
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
                    updateType = false;
                }
            });
    });



});