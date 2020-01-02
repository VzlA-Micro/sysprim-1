//var url="https://sysprim.com/";
    //var url = "http://172.19.50.253/";

     var url="https://sysprim.com/";

var updateType = false;

$('document').ready(function () {

    $('#updateType').on('submit', function (e) {
        e.preventDefault();
        if (updateType == false) {
            //console.log('estoy en el if');
            $('#name').removeAttr('readonly');
            $('#year').removeAttr('readonly');
            //$('#brand').removeAttr('readonly');
            updateType = true;
            swal({
                title: "¡Actualizar!",
                text: "Puedes elegir los campos a modificar",
                icon: "info",
                button: "Ok",
            });
        }
        //
        else {

            console.log(updateType);
            console.log('else');
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
                            $('#year').attr('readonly', 'readonly');
                            //$('#rate_ut').attr('readonly', 'readonly');
                        },
                        success: function (data) {
                            if (data['update'] == true) {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Has Actualizado Los datos de modelo del vehicul Con Exito",
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




