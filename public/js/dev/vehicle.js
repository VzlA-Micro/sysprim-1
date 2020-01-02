//var url="https://sysprim.com/";
    var url = "http://172.19.50.253/";
    // var url="http://sysprim.com.devel/";

var updateType = false;

$('document').ready(function () {

    $('#model').prop('disabled', true);
    $('select').formSelect();

    $('#brand').change(function () {
        var brand = $(this).val();
        console.log(brand);
        $.ajax({
            type: "POST",
            url: url + "vehicles/searchBrand",
            data: {
                brand: brand,
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data) {
                    $('#model').prop('disabled', false);
                    $('select').formSelect();

                    $('select').formSelect();
                    $('#model').html('');


                    var i = 0;
                    for (i; i < data[1]; i++) {
                        console.log(data[0][i]['name']);
                        var template = `<option value="${data[0][i]['id']}">${data[0][i]['name']}</option>`;
                        $('select').formSelect();
                        $('#model').append(template);
                    }
                }

            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#license_plate').blur(function () {
        var license = $(this).val();
        console.log(license);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyLicense",
            data: {
                license: license,
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data) {
                    swal({
                        title: "¡Placa Registrada!",
                        text: "No puedes registrar este vehiculo",
                        icon: "info",
                        button: "Ok",
                    });
                    $(this).text('');
                    $('#button-vehicle').prop('disabled', true);
                } else {
                    $('#button-vehicle').prop('disabled', false);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#bodySerial').blur(function () {
        var bodySerial = $(this).val();
        console.log(bodySerial);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyBodySerial",
            data: {
                bodySerial: bodySerial,
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data) {
                    swal({
                        title: "¡Serial de Carroceria Registrado!",
                        text: "No puedes registrar este vehiculo",
                        icon: "info",
                        button: "Ok",
                    });
                    $(this).text('');
                    $('#button-vehicle').prop('disabled', true);
                } else {
                    $('#button-vehicle').prop('disabled', false);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#serialEngine').blur(function () {
        var serialEngine = $(this).val();
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifySerialEngine",
            data: {
                serialEngine: serialEngine,
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data) {
                    swal({
                        title: "¡Serial del Motor Registrado!",
                        text: "No puedes registrar este vehiculo",
                        icon: "info",
                        button: "Ok",
                    });
                    $(this).text('');
                    $('#button-vehicle').prop('disabled', true);
                } else {
                    $('#button-vehicle').prop('disabled', false);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#vehicle').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: url + "vehicles/save",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',

            beforeSend: function () {
                $('#button-vehicle').prop('disabled', true);
            },
            success: function () {
                swal({
                    title: "¡Bien Hecho!",
                    text: "Has Actualizado Los datos de tipo de vehiculos Con Exito",
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    window.location.href = url+"vehicles/read";
                });
            },
            error: function (e) {
                console.log(e);
            }
        });
        updateType = false;
    });


    $('#updateType').on('submit', function (e) {
        e.preventDefault();
        if (updateType == false) {
            $('#name').removeAttr('readonly');
            $('#rate').removeAttr('readonly');
            $('#rate_ut').removeAttr('readonly');
            updateType = true;
        }
        else {

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




