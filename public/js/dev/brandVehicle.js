var url = localStorage.getItem('url');


var updateType = false;

$('document').ready(function () {

    $('#brand').blur(function () {
        var brand = $('#brand').val(); 


        $.ajax({
            url: url + "vehicles-brand/verifyBrand",
            data: {brand: brand },
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    //$("#preloader").close();
                    swal({
                        title: "¡Marca Registrada!",
                        text: response.message,
                        icon: "warning",
                        button: {
                            text: "Aceptar",
                            className: "orange-gradient"
                        },
                    });
                    $('#brandRegister').prop('disabled', true);
                    $('#brand').val(); 
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                } else {
                    $('#brandRegister').prop('disabled', false);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                }
            },
            error: function (e) {
                console.log(e);
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }
        });
    });



    $('#register').on('submit', function (e) {
        e.preventDefault();
        var name = $('#brand').val(); 

        $.ajax({
            url: url + "vehicles-brand/save",
            data: {name: name},
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                console.log(data);
                if (data) {
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Marca de vehiculo, registrada con exito!",
                        icon: "success",
                        button: {
                            text: "Aceptar",
                            className: "green-gradient"
                        },
                    }).then(redirect => {
                        location.href = url + 'vehicles-brand/read';
                    });
                }
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            },
            error: function (e) {
                console.log(e);
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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
                            // $('#name').attr('readonly', 'readonly');
                            $("#preloader").fadeIn('fast');
                            $("#preloader-overlay").fadeIn('fast');
                        },
                        success: function (response) {
                            var id = response.id;
                            console.log(response);
                            if (response.status == 'success') {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: response.message,
                                    icon: "success",
                                    button: "Ok",
                                }).then(function (redirect) {
                                    location.href = url + 'vehicles-brand/details/' + id;
                                });
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            swal({
                                title: "¡Oh no!",
                                text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                                icon: "error",
                                button:{
                                    text: "Entendido",
                                    className: "red-gradient"
                                },
                            });
                            $("#preloader").fadeOut('fast');
                            $("#preloader-overlay").fadeOut('fast');
                        }
                    });
                    // updateType = false;
                }
            });
    });
});




