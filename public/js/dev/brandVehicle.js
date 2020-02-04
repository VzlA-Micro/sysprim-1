var url = localStorage.getItem('url');


var updateType = false;

$('document').ready(function () {

    $('#brand').blur(function () {

        $.ajax({
            url: url + "vehicles-brand/verifyBrand",
            data: {brand: $('#brand').val()},
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                //$("#preloader").fadeIn('fast');
                //$("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                if (data) {
                    //$("#preloader").close();
                    swal({
                        title: "¡Marca Registrada!",
                        text: "No puedes registrar esta marca.",
                        icon: "warning",
                        button: {
                            text: "Aceptar",
                            className: "orange-gradient"
                        },
                    });
                    $('#brandRegister').prop('disabled', true);
                } else {
                    $('#brandRegister').prop('disabled', false);
                }

            },
            error: function (e) {
                console.log(e);
            }
        });
    });



    $('#register').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: url + "vehicles-brand/save",
            data: {name: $('#brand').val()},
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                //$("#preloader").fadeIn('fast');
                //$("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                if (data) {
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Marca de vehiculo, registrada con exito!",
                        icon: "info",
                        button: {
                            text: "Aceptar",
                            className: "green-gradient"
                        },
                    });
                    $('#brandRegister').prop('disabled', true);
                } else {
                    $('#brandRegister').prop('disabled', false);
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
    });


    $('#btn-modify').click(function() {
        $(this).hide();
        $('#name').removeAttr('readonly');
        $('#btn-update').removeClass('hide');
        swal({
            title: "¡Actualizar!",
            text: "Puedes elegir los campos a modificar",
            icon: "info",
            button: "Ok",
        });
    });



    $('#updateBrand').on('submit', function (e) {
            e.preventDefault();
            $('#name').removeAttr('readonly');


            swal({
                icon: "info",
                title: "Actualizar Marca Del Vehiculo",
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
                        url: url + "vehicles-brand/update",
                        data: new FormData(this),
                        dataType: false,

                        beforeSend: function () {
                            $('#name').attr('readonly', 'readonly');
                        },
                        success: function (data) {
                            if (data['update'] == true) {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Has Actualizado Los datos de marca de vehiculos, Con Exito",
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




