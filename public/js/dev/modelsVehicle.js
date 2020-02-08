
var url = localStorage.getItem('url');

var updateType = false;

$('document').ready(function () {

    $('#btn-modify').click(function() {
        $(this).hide();
        $('#name').removeAttr('readonly');
        $('#brand_id').removeAttr('disabled');
        $('select').formSelect();
            swal({
                title: "Información",
                text: "Puedes elegir los campos a modificar",
                icon: "info",
                button: "Ok",
            });
        $('#btn-update').removeClass('hide');
    });


    $('#updateType').on('submit', function (e) {
        e.preventDefault();
            swal({
                icon: "info",
                title: "Actualizar Modelo De Vehiculo",
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
                        url: url + "vehicles-models/update",
                        data: new FormData(this),
                        dataType: false,

                        beforeSend: function () {
                            $('#name').attr('readonly', 'readonly');
                            //$('#rate_ut').attr('readonly', 'readonly');
                        },
                        success: function (data) {
                            if (data['update'] == true) {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Has Actualizado Los datos de modelo del vehicul Con Exito",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                    updateType = false;
                }
            });
    });



    $('#register').submit(function(e) {
        e.preventDefault();
        if($('#brand').val()!==null) {

            var formData = new FormData(this);
            $.ajax({
                url: url + "vehicles-models/save",
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
                        text: "Se ha registrado el modelo de vehiculo exitosamente.",
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + "vehicles-models/read";
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
        }else{
            swal({
                title: "Información",
                text: "Debe selecionar una marca valida para completar el registro.",
                icon: "info",
                button: "Ok",
            });
        }
    });










});




