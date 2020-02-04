var url = localStorage.getItem('url');

var updateType = false;

$('document').ready(function () {


    $('#btn-modify').click(function () {
        $(this).hide();
        $('#name').removeAttr('readonly');
        $('#rate').removeAttr('readonly');
        $('#rate_ut').removeAttr('readonly');
        $('#btn-update').removeClass('hide');
    });


    $('#updateType').on('submit', function (e) {
        e.preventDefault();

        swal({
            icon: "info",
            title: "Actualizar Tipo De Vehiculo",
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
            if (confirm) {
                $.ajax({
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: url + "type-vehicles/update",
                    data: new FormData(this),
                    dataType: false,

                    beforeSend: function () {
                        $('#name').attr('readonly', 'readonly');
                        $('#rate').attr('readonly', 'readonly');
                        $('#rate_ut').attr('readonly', 'readonly');
                    },
                    success: function (data) {
                        if (data['update'] == true) {
                            swal({
                                title: "¡Bien Hecho!",
                                text: "Se actualizo los datos de tipo de vehiculos con éxito",
                                icon: "success",
                                button: "Ok",
                            }).then(function () {
                                location.reload();
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
                updateType = false;
            }
        });

    });


    $('#register').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
            url: url + "type-vehicles/save",
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
                swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha registrado el tipo de vehiculo exitosamente.",
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "type-vehicles/read";
                });
            },
            error: function (err) {
                console.log(err);
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



    });


});




