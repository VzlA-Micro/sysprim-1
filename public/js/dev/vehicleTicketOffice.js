//var url = "http://172.19.50.253/";
var url = "http://sysprim.com.devel/";

var updateType = true;
var period = null;
$('document').ready(function () {

    $('#model').prop('disabled', true);
    $('select').formSelect();

    $('#update-vehicle').on('click', function () {
        var model = $('#model').val();
        if (updateType) {
            $('#status').prop("disabled", false);
            $('select').formSelect();
            $('#license_plate').removeAttr('disabled');
            $('#type').prop("disabled", false);
            $('select').formSelect();
            $('#bodySerial').removeAttr('disabled');
            $('#color').removeAttr('disabled');
            $('#serialEngine').removeAttr('disabled');
            $('#year').removeAttr('disabled');
            $('#brand').prop("disabled", false);
            $('select').formSelect();
            $('#model').prop("disabled", false);
            $('select').formSelect();

            var brand = $('#brand').val();

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
                            if (data[0][i]['id'] == model) {
                                var template = `<option value="${data[0][i]['id']}" selected>${data[0][i]['name']}</option>`;
                            } else {
                                var template = `<option value="${data[0][i]['id']}">${data[0][i]['name']}</option>`;
                            }
                            //var template = `<option value="${data[0][i]['id']}">${data[0][i]['name']}</option>`;

                            $('select').formSelect();
                            $('#model').append(template);
                        }
                    }

                },
                error: function (e) {
                    console.log(e);
                }
            });

            updateType = false;
        } else {
            var id = $('#id').val();
            var status = $('#status').val();
            var licensePlate = $('#license_plate').val();
            var type = $('#type').val();
            var bodySerial = $('#bodySerial').val();
            var color = $('#color').val();
            var serialEngine = $('#serialEngine').val();
            var year = $('#year').val();
            var model = $('#model').val();

            console.log(id);
            $.ajax({
                type: "POST",
                url: url + "/ticketOffice/vehicle/update",
                data: {
                    id: id,
                    status: status,
                    license: licensePlate,
                    type: type,
                    bodySerial: bodySerial,
                    color: color,
                    serialEngine: serialEngine,
                    year: year,
                    model: model
                },
                dataType: 'json',

                beforeSend: function () {
                    $(this).prop('disabled', true);
                },
                success: function () {
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Has Actualizado Los datos del vehiculo Con Exito",
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        $('#status').prop("disabled", true);
                        $('select').formSelect();
                        $('#license_plate').prop("disabled", true);
                        $('#type').prop("disabled", true);
                        $('select').formSelect();
                        $('#bodySerial').prop("disabled", true);
                        $('#color').prop("disabled", true);
                        $('#serialEngine').prop("disabled", true);
                        $('#year').prop("disabled", true);
                        $('#brand').prop("disabled", true);
                        $('select').formSelect();
                        $('#model').prop("disabled", true);
                        $('select').formSelect();
                    });
                    updateType = true;
                },
                error: function (e) {
                    console.log(e);
                }
            });

            console.log(updateType);
        }

    });

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
                    console.log(model);
                    for (i; i < data[1]; i++) {


                        if (data[0][i]['id'] == model) {
                            console.log('este es igual al id');
                            var template = `<option value="${data[0][i]['id']}" selected>${data[0][i]['name']}</option>`;
                        } else {
                            var template = `<option value="${data[0][i]['id']}">${data[0][i]['name']}</option>`;
                        }
                    }

                    $('select').formSelect();
                    $('#model').append(template);

                }

            }
            ,
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#license_plate').blur(function () {
        var license = $(this).val();
        var id = $('#id').val();
        console.log(license);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyLicense",
            data: {
                license: license,
                id: id
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == "error") {
                    swal({
                        title: "¡Placa Registrada!",
                        text: data['message'],
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
        var id = $('#id').val();
        console.log(bodySerial);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyBodySerial",
            data: {
                bodySerial: bodySerial,
                id: id
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == "error") {
                    swal({
                        title: "¡Serial de Carroceria Registrado!",
                        text: data['message'],
                        icon: "info",
                        button: "Ok",
                    });
                    $(this).text('');
                    $('#button-vehicle').prop('disabled', true);
                } else {
                    swal({
                        title: data['message'],
                        icon: "success",
                        button: "Ok",
                    });
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
        var id = $('#id').val();
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifySerialEngine",
            data: {
                serialEngine: serialEngine,
                id: id
            },

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == "error") {
                    swal({
                        title: "¡Serial del Motor Registrado!",
                        text: data['message'],
                        icon: "info",
                        button: "Ok",
                    });
                    $(this).text('');
                    $('#button-vehicle').prop('disabled', true);
                } else {
                    swal({
                        title: data['message'],
                        icon: "success",
                        button: "Ok",
                    });
                    $('#button-vehicle').prop('disabled', false);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#vehicle-status').on('click', function () {
        console.log('hola');
        var vehicleStatus = 0;
        vehicleStatus = $(this).val();
        console.log(vehicleStatus);
        var id = $('#id').val();
        var status = null;

        if (vehicleStatus == 'disabled') {
            var status = 'true';

            $.ajax({
                type: "post",
                url: url + "/ticketOffice/vehicle/status",
                data: {
                    status: status,
                    id: id
                },

                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data['status'] == "disabled") {
                        swal({
                            title: "Vehículo",
                            text: data['message'],
                            icon: "success",
                            button: "Ok",
                        });
                        location.reload();
                        /*
                        var templates = `<a href="#" class="btn btn-large waves-effect waves-light red col s12 btn-rounded ">deshabilitado
                             <i class="icon-check right"></i>
                            </a>`;
                        $('#estado').html(templates);

                        var template = `<button type="button"
                                                    class="btn btn-large waves-effect waves-light green col s12 "
                                                    id="vehicle-status" value="enabled">
                                                Activar Vehículo
                                                <i class="icon-check right"></i>
                                            </button>`;

                        $('#button-status').html(template);*/

                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });

        } else {
            var status = 'false';
            $.ajax({
                type: "POST",
                url: url + "/ticketOffice/vehicle/status",
                data: {
                    status: status,
                    id: id
                },

                beforeSend: function () {
                },
                success: function (data) {
                    console.log(data.status);
                    if (data['status'] == "enabled") {
                        swal({
                            title: "Vehículo",
                            text: data['message'],
                            icon: "success",
                            button: "Ok",
                        }).then((aceptar) => {
                            location.reload();
                        })
                        ;

                        /*
                                                var templates = `<a href="#" class="btn btn-large waves-effect waves-light green col s12 btn-rounded ">Habilitado
                                                    <i class="icon-check right"></i>
                                                    </a>`;

                                                $('#estado').html(templates);
                                                var template = `<button type="button"
                                                                            class="btn btn-large waves-effect waves-light red col s12 "
                                                                            id="vehicle-status" value="disabled">
                                                                        Deshabilitar Vehículo
                                                                        <i class="icon-sync_disabled right"></i>
                                                                    </button>`;
                                                $('#button-status').html(template);*/

                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

    });

    $('#licensePlate').blur(function () {
        var license = $(this).val();
        $.ajax({
            type: "get",
            url: url + "/ticketOffice/vehicle/search-license/" + license,

            beforeSend: function () {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == "empty") {
                    swal({
                        title: data['message'],
                        icon: "info",
                        button: "Ok"
                    });
                    $('#brandTo').prop('disabled', true);
                    $('#modelTo').prop('disabled', true);
                    $('#colorTo').prop('disabled', true);
                    $('#personTo').prop('disabled', true);
                    $('#fiscal_periodTo').prop('disabled', true);

                } else {

                    $('#brandTo').prop('disabled', false);
                    $('#modelTo').prop('disabled', false);
                    $('#colorTo').prop('disabled', false);
                    $('#personTo').prop('disabled', false);
                    $('#fiscal_periodTo').prop('disabled', false);

                    $('#vehicle_id').val(data['vehicle'][0].id);
                    M.updateTextFields();
                    $('#brandTo').val(data['modelVehicle']);
                    M.updateTextFields();
                    $('#modelTo').val(data['vehicle'][0]['model'].name);
                    M.updateTextFields();
                    $('#colorTo').val(data['vehicle'][0].color);
                    M.updateTextFields();
                    $('#personTo').val(data['userVehicle'][0].name);
                    M.updateTextFields();

                    swal({
                        title: "Periodo Fiscal",
                        text: "Elija entre los siguientes periodo",
                        icon: "info",
                        buttons: {
                            cancel: {
                                text: "Anual",
                                value: false,
                                visible: true,
                                className: "green",
                                closeModal: true
                            },
                            confirm: {
                                text: "Trimestral",
                                value: true,
                                visible: true,
                                className: "blue",
                                closeModal: true
                            }
                        }
                    }).then(function (options) {

                        if (options) {
                            period = 1;
                        } else {
                            period = 0;
                        }

                        $.ajax({
                            type: "get",
                            url: url + "/ticketOffice/vehicle/period-fiscal/" + period,
                            beforeSend: function () {
                            },
                            success: function (data) {
                                console.log(data);
                                if (data['status'] == "trimestre") {
                                    $('#fiscal_periodTo').val(data['trimestre']);
                                    M.updateTextFields();
                                } else {
                                    $('#fiscal_periodTo').val(data['year']);
                                    M.updateTextFields();
                                }

                            },
                            error: function (e) {
                                console.log(e);
                            }
                        });
                    })
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    $('#general-next').click(function () {

        if ($('#vehicle_id').val() === '') {
            swal({
                title: "Información",
                text: 'Debe ingresar una placa de vehículo,  para continuar con el registro.',
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else {
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "details-tab");
            var id = $('#vehicle_id').val();
            console.log(period);
            $.ajax({
                type: "get",
                url: url + "ticketOffice/vehicle/generatedPlanilla/" + id + "-" + period,
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);

                    $('#base').val(data['grossTaxes']);
                    M.updateTextFields();
                    $('#tasa').val(data['previousDebt']);
                    M.updateTextFields();
                    $('#discount').val(' - ' + data['valueDiscount']);
                    M.updateTextFields();
                    $('#recharge').val(data['recharge']);
                    M.updateTextFields();
                    $('#rechargeMora').val(data['valueMora']);
                    M.updateTextFields();
                    $('#total').val(data['total']);
                    M.updateTextFields();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }


    });
});
