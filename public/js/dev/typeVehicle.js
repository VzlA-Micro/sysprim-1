var url = "http://sysprim.com.devel/";
var updateType = false;

$('document').ready(function () {

    $('#updateType').on('submit', function (e) {
        e.preventDefault();
        if (updateType == false) {
            //console.log('estoy en el if');
            $('#name').removeAttr('readonly');
            $('#rate').removeAttr('readonly');
            $('#rate_ut').removeAttr('readonly');
            updateType = true;
        }
        //
        else {

            console.log(updateType);
            console.log('else');
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
                if(confirm) {
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
                                    text: "Has Actualizado Los datos de tipo de vehiculos Con Exito",
                                    icon: "success",
                                    button: "Ok",
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
        }
    });


});




