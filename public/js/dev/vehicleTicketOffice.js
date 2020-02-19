var url = localStorage.getItem('url');

var updateType = true;
var period = null;
$('document').ready(function () {

    $('#model').prop('disabled', true);
    $('select').formSelect();

    $('#update-vehicle').on('click', function () {
        var model = $('#model').val();

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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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

        $(this).hide();
        $('#update-vehicle-save').removeClass('hide');


    });
    $('#update-vehicle-save').on('click', function () {
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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
                $(this).prop('disabled', true);
            },
            success: function () {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Bien Hecho!",
                    text: "Has Actualizado Los datos del vehiculo Con Exito",
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    location.reload();
                });

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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                console.log(data);
                if (data) {
                    $('#model').prop('disabled', false);
                    $('select').formSelect();

                    $('select').formSelect();
                    $('#model').html('');


                    var i = 0;
                    console.log(model);
                    for (i; i < data[1]; i++) {
                        console.log(data[0][i]['name']);
                        var template = `<option value="${data[0][i]['id']}">${data[0][i]['name']}</option>`;
                        $('select').formSelect();
                        $('#model').append(template);
                    }

                }

            }
            ,
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
    });

    $('#license_plates').change(function () {
        var license = $(this).val();
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyLicense",
            data: {
                license: license
            },

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

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
                    swal({
                        title: data['message'],
                        icon: "success",
                        button: "Ok",
                    });
                    $('#button-vehicle').prop('disabled', false);
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
    });

    $('#license_plate').change(function () {
        var license = $(this).val();
        var id = $('#id').val();

        console.log(id);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyLicense",
            data: {
                license: license,
                id: id
            },

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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
                    swal({
                        title: data['message'],
                        icon: "success",
                        button: "Ok",
                    });
                    $('#button-vehicle').prop('disabled', false);
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
    });

    $('#bodySerials').change(function () {
        var bodySerial = $(this).val();
        console.log(bodySerial);
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifyBodySerial",
            data: {
                bodySerial: bodySerial
            },

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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

    $('#bodySerial').change(function () {
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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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

    $('#serialEngines').change(function () {
        var serialEngine = $(this).val();
        $.ajax({
            type: "POST",
            url: url + "vehicles/verifySerialEngine",
            data: {
                serialEngine: serialEngine
            },

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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

    $('#serialEngine').change(function () {
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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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

    $('#vehicle-status').on('click', function () {

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
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
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
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
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
        }

    });

    $('#licensePlate').change(function () {
        var license = $(this).val();
        if (license == '') {

        } else if (license.length < 7) {
            swal({
                title: "Información",
                text: "Ingrese una placa válida.",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "red-gradient"
                },
            });
        }
        else {
            $.ajax({
                type: "get",
                url: url + "/ticketOffice/vehicle/search-license/" + license,

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
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
                        $('#fiscal_period').prop('disabled', true);

                    }
                    else {


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


                        $('#fiscal_period').prop('disabled', false);
                        $('select').formSelect();
                        /*swal({
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
                            } M.updateTextFields();

                        }).then(function (options) {

                            if (options) {
                                period = 'true';
                            } else {
                                period = 'false';
                            }

                            $.ajax({
                                type: "get",
                                url: url + "/ticketOffice/vehicle/period-fiscal/" + period,
                                beforeSend: function () {
                                },
                                success: function (data) {
                                    $("#preloader").fadeOut('fast');
                                    $("#preloader-overlay").fadeOut('fast');
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
                        })*/
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

        }
    });


    $('#document').keyup(function () {
        if ($('#type_document').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar el tipo de documento, antes de ingresar el número de documento.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#document').val('')
        }

    });


    $('#document').change(function () {
        findDocument();
    });


    $('#type_document').change(function () {
        findDocument();
    });

    $('#data-next').click(function () {
        band = true;


        $('.rate').each(function () {
            if (($(this).val() === '' || $(this).val() === null) && $('#type_company').val() != 'company' && $(this).attr('data-validate') != 'email') {
                swal({
                    title: "Información",
                    text: "Complete el campo " + $(this).attr('data-validate') + " para continuar con el registro.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

                band = false;
            }
        });


        if (band) {
            if ($('#id').val() == '') {
                var type = $('#type').val();
                var name;
                if (type == 'user') {
                    name = $('#user_name').val();
                } else {
                    name = $('#name').val();
                }

                var type_document = $('#type_document').val();
                var document = $('#document').val();
                var address = $('#address').val();
                var surname = $('#surname').val();
                var email = $('#email').val();

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        surname: surname,
                        email: email,
                        type_document: type_document,
                        document: document,
                        address: address,
                        type: type,
                        user: user,

                    },
                    url: url + 'rate/taxpayers/company-user/register',

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        $('#id').val(response.id);

                        $('#two').removeClass('disabled');
                        $('#one').addClass('disabled');
                        $('ul.tabs').tabs("select", "rate-tab");
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    },
                    error: function (err) {

                        swal({
                            title: "¡Oh no!",
                            text: "Ha ocurrido un error inesperado, refresca la página e intentalo de nuevo.",
                            icon: "error",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            }
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    }
                });
            } else {
                $('#two').removeClass('disabled');
                $('#one').addClass('disabled');
                $('ul.tabs').tabs("select", "rate-tab");
            }
        }


    });

    function findDocument() {
        var type_document = $('#type_document').val();
        var document = $('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');


        if (document !== '') {
            $.ajax({
                method: "GET",
                url: url + "rate/taxpayers/find/" + type_document + "/" + document,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if (response.type == 'not-user') {
                        var user = response.user.response;
                        $('#name').val(user.nombres + ' ' + user.apellidos);
                        $('#name').attr('readonly');
                        $('#surname').val(user.apellidos);
                        $('#user_name').val(user.nombres);
                        $('#type').val('user');
                        $('#id').val(user.id);

                    } else if (response.type == 'user') {

                        var user = response.user;
                        $('#name').val(user.name + ' ' + user.surname);
                        $('#name').attr('readonly');
                        $('#surname').val(user.surname);
                        $('#id').val(user.id);
                        $('#address').val(user.address);
                        $('#email').val(user.email);


                        $('#type').val('user');

                        $('#address').attr('readonly', '');
                        $('#email').attr('readonly', '');
                        $('#statusTicketOffice').show();

                    } else if (response.type == 'company') {
                        var company = response.company;
                        $('#name').val(company.name);
                        $('#address').val(company.address);
                        $('#name').attr('readonly');
                        $('#address').attr('disabled');
                        $('#id').val(company.id);
                        $('#type').val('company');
                        $('#address').attr('readonly', '');
                        $('#email').attr('readonly', '');
                        $('#statusTicketOffice').hide();

                    } else if (response.type == 'not-company') {
                        swal({
                            title: "Información",
                            text: "La empresa no esta registrada en el sistema, debes ingresar un empresa valida.",
                            icon: "info",
                            buttons: {
                                confirm: {
                                    text: "Registrarla",
                                    value: true,
                                    visible: true,
                                    className: "green-gradient"

                                },
                                cancel: {
                                    text: "Cancelar",
                                    value: false,
                                    visible: true,
                                    className: "grey lighten-2"
                                }
                            }
                        }).then(function (aceptar) {
                            if (aceptar) {
                                window.location.href = url + "ticketOffice/company/register";
                            }
                        });


                        $('#document').val('');
                    }

                    M.updateTextFields();
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
                        button: "Ok",
                    });
                }
            });
        }
    }


    $('#general-next').click(function (e) {
        e.preventDefault();
        var fiscalP = $('#fiscal_period').val();
        console.log(fiscalP);
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
        } else if (fiscalP == 'null') {
            swal({
                title: "Información",
                text: 'Debe seleccionar un periodo fiscal,  para poder continuar.',
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
            var year = $('#fiscal_period').val();
            $.ajax({
                type: "get",
                url: url + "ticketOffice/vehicle/generatedPlanilla/" + id + "-" + true + "/" + year,

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    console.log(data);
                    if (data['process']) {
                        swal({
                            title: "Información",
                            text: data['message'],
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient",
                                value: true,
                                visible: true,
                                closeModal: true
                            }
                        }).then(function (option) {
                            if (option) {
                                location.reload();
                            }
                        });

                        /*$('#base').prop('disabled', true);

                        $('#tasa').prop('disabled', true);

                        $('#discount').prop('disabled', true);

                        $('#recharge').prop('disabled', true);

                        $('#rechargeMora').prop('disabled', true);

                        $('#fiscal_credits').prop('disabled', true);

                        $('#total').prop('disabled', true);*/


                    } else {
                        $('#base').val(data['grossTaxes']);
                        M.updateTextFields();
                        $('#tasa').val(data['previousDebt']);
                        M.updateTextFields();
                        $('#discount').val(data['valueDiscount']);
                        M.updateTextFields();
                        $('#recharge').val(data['recharge']);
                        M.updateTextFields();
                        $('#rechargeMora').val(data['valueMora']);
                        M.updateTextFields();
                        $('#total').val(data['total']);
                        M.updateTextFields();
                        $('#totalAux').val(data['totalAux']);
                        $('#taxesId').val(data['taxeId']);
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
        }


    });
    $('#details-next').on('click', function () {

        var base = $('#base').val();
        var previous = $('#tasa').val();
        var discount = $('#discount').val();
        var recharge = $('#recharge').val();
        var rechargeMora = $('#rechargeMora').val();
        var total = $('#total').val();
        var fiscalCredits = $('#fiscal_credits').val();
        var taxeId = $('#taxesId').val();

        swal({
            title: "Información",
            text: 'Recuerde verificar al monto antes de realizar el pago, una vez confirmado, no podrá revertir los cambios.',
            icon: "info",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey",
                    closeModal: true
                },
                confirm: {
                    text: "Confirmar",
                    value: true,
                    visible: true,
                    className: "red",
                    closeModal: true
                }
            }
        }).then(function (options) {

            if (options) {
                $.ajax({
                    type: "post",
                    url: url + "ticketOffice/vehicle/save-payroll",
                    data: {
                        base: base,
                        previous: previous,
                        discount: discount,
                        recharge: recharge,
                        rechargeMora: rechargeMora,
                        total: total,
                        fiscalCredits: fiscalCredits,
                        taxeId: taxeId
                    },
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (data) {
                        console.log(data);
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        if (data['status'] === "success") {
                            swal({
                                title: "Información",
                                text: 'Planilla registrada con exito. ¿Desea registrar otra planilla?',
                                icon: "info",
                                buttons: {
                                    cancel: {
                                        text: "No",
                                        value: false,
                                        visible: true,
                                        className: "grey",
                                        closeModal: true
                                    },
                                    confirm: {
                                        text: "Si",
                                        value: true,
                                        visible: true,
                                        className: "red",
                                        closeModal: true
                                    }
                                }
                            }).then(function (options) {
                                if (options) {
                                    location.reload();
                                } else {
                                    window.location = url + "ticketOffice/vehicle/taxes/";
                                }
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

            }
        });
    });

    $('#fiscal_period').change(function () {
        var fiscalPeriod = $(this).val();
        var id = $('#vehicle_id').val();

        $.ajax({
            type: "get",
            url: url + "ticketOffice/vehicle/fiscal-period/" + id + "/" + fiscalPeriod,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                console.log(data);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                if (data) {
                    swal({
                        title: "Información",
                        text: 'Ya tiene un pago declarado para este periodo fiscal',
                        icon: "info",
                    });

                    $("#general-next").attr('disabled', 'disabled');
                } else {
                    $("#general-next").removeAttr('disabled', '');
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
    });

    var vehicle_id = '';
    var type_taxes = '';


    $('.payroll').change(function () {


        if (vehicle_id !== '') {
            console.log('if');

            if ($(this).is(":checked") && $(this).attr('data-vehicle') == vehicle_id) {
                console.log('lleno');
                //vehicle_id = $(this).attr('data-vehicle');
            } else if ($(this).attr('data-vehicle') != vehicle_id) {
                swal({
                    title: "Información",
                    text: "La planilla selecionada no pertenece al mismo vehículo .",
                    icon: "info",
                    button: "Ok",
                }).then(function () {
                    location.reload();
                });
                $(this).prop('checked', false);
                console.log('no coincide');
            }
            else if (!$(this).is(":checked")) {
                console.log('limpio');
                vehicle_id = '';
            }
        } else {
            console.log('else');
            vehicle_id = $(this).attr('data-vehicle');
        }


        /*if (type_taxes !== '') {
            if ($(this).is(":checked") && $(this).attr('data-company') == type_taxes) {
                type_taxes = $(this).attr('data-taxes');
            } else if ($(this).attr('data-taxes') != type_taxes) {
                swal({
                    title: "Información",
                    text: "Las planillas selecionadas deben ser del mismo tipo.",
                    icon: "info",
                    button: "Ok",
                }).then(function () {

                    location.reload();
                });


                $(this).prop('checked', false);
            }
        } else {
            type_taxes = $(this).attr('data-taxes');
        }*/

    });


    /*$('#select-next').click(function () {
        var acum = '';
        var band=false;


        $('input.payroll:checked').each(function () {
            band=true;
            acum += $(this).val() + '-';
        });

        if(band){
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "payment-tab");
            $.ajax({
                method: "GET",
                url: url + "ticket-office/taxes/calculate/" + acum,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {



                    if(response.status==='success'){
                        $('.taxes_id').each(function () {
                            $(this).val(acum);
                        });

                        $('.amount').each(function(){
                            $(this).val(response.amount);
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                        $('#amount_total_depo').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        $('#amount_total').val(function (index, value) {
                            return number_format(value, 2);
                        });
                        $('#amount_total_tr').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        M.updateTextFields();

                    }else{
                        swal({
                            title: "!Bien Hecho",
                            text: "La planilla ingresada se ha verificada con éxito, ya que el dinero a pagar es igual a 0.",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            window.open(url + 'ticket-office/generate-receipt/' +acum, "RECIBO DE PAGO", "width=500, height=600");

                            location.reload();
                        });
                    }
                },

                error: function (err) {
                    console.log(err);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }else{
            swal({
                title: "Información",
                text: "Debes selecionar una planilla válida.",
                icon: "info",
                button: "Ok",
            });
        }

    });

*/


    $('#select-next').click(function () {
        var acum = '';
        var band = false;

        $('input.payroll:checked').each(function () {
            band = true;
            acum += $(this).val() + '-';
        });

        if (band) {
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "payment-tab");
            $.ajax({
                method: "GET",
                url: url + "ticket-office/taxes/calculate/" + acum,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if (response.status === 'success') {
                        $('.taxes_id').each(function () {
                            $(this).val(acum);
                        });

                        $('.amount').each(function () {
                            $(this).val(response.amount);
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                        $('#amount_total_depo').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        $('#amount_total').val(function (index, value) {
                            return number_format(value, 2);
                        });
                        $('#amount_total_tr').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        M.updateTextFields();

                    } else {
                        swal({
                            title: "!Bien Hecho",
                            text: "La planilla ingresada se ha verificada con éxito, ya que el dinero a pagar es igual a 0.",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            window.open(url + '/ticketOffice/vehicle/generate-receipt/' + acum, "RECIBO DE PAGO", "width=500, height=600");

                            location.reload();
                        });
                    }
                },

                error: function (err) {
                    console.log(err);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        } else {
            swal({
                title: "Información",
                text: "Debes selecionar una planilla válida.",
                icon: "info",
                button: "Ok",
            });
        }

    });


    /*
            $.ajax({
                method: "GET",
                url: url + "ticket-office/fin" + fiscal_period + "/" + company,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {


                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: 'La empresa ' + $('#name_company').val() + 'ya declaro el periodo de ' + $('#fiscal_period').val() + ', seleccione un periodo fiscal valido',
                            icon: "info",
                            button: "Ok",
                        });
                        $('#fiscal_period').val(' ')
                    }

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                }, error: function (err) {
                    $('#license').val('');
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });


    */


    function formatMoney() {
        $('input[type="text"].money').each(function () {
            $(this).val(function (index, value) {
                return number_format(value, 2);
            });
        });

        $('#amount').text(function (index, value) {
            return number_format(value, 2);
        });


    }

    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

        return amount_parts.join(',');
    }

    $('#register-payment').submit(function (e) {
        e.preventDefault();
        var amount = $('#amount_total').val();
        var amount_pay = $('#amount').val();

        amount = amount.replace(/\./g, '');
        amount_pay = amount_pay.replace(/\./g, '');


        amount = amount.replace(/,/g, "");
        amount_pay = amount_pay.replace(/,/g, "");


        if (parseInt(amount_pay) > parseInt(amount)) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button: "Ok",
            });

        } else {
            $.ajax({
                url: url + "ticket-office/payment/save",
                contentType: false,
                processData: false,
                data: new FormData(this),
                method: "POST",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    console.log(response);
                    if (response.status === 'process') {
                        $('#amount_total').val(response.payment);
                        $('#amount_total').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        swal({
                            title: "Información",
                            text: "Para conciliar esta planilla " +
                            "el monto debe ser cancelado en su totalidad.Debe cancelar el dinero restante:" + $('#amount_total').val() + "Bs",
                            icon: "info",
                            button: "Ok",
                        });


                    } else {
                        swal({
                            title: "¡Bien hecho!",
                            text: "Planillas ingresa y conciliada con éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            if (accept || !accept) {
                                generateReceipt();
                                location.reload();
                            }
                        });


                    }
                    $('#ref').val('');
                    $('#amount').val('');

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
                        button: "Ok",
                    });
                }
            });

        }
    });

    $('input[type="text"].money_keyup').on('keyup', function (event) {
        var total = $(this).val();

        if ($(this).val() == 0 && $(this).val().toString().length >= 2) {
            $(this).val('');
        } else if ($(this).val().toString().length >= 2 && total[0] == 0) {
            $(this).val('');
        } else {
            $(event.target).val(function (index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1,$2')
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    });

    function generateReceipt() {
        var taxes_id = $('.taxes_id').val();
        window.open(url + '/ticketOffice/vehicle/generate-receipt/' + taxes_id, "RECIBO DE PAGO", "width=500, height=600");
    }


    $('#search').change(function () {
        if ($('#search').val() !== '') {
            var search = $('#search').val();
            $.ajax({
                method: "GET",
                url: url + "ticketOffice/vehicle/cashier/" + search,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'error') {
                        swal({
                            title: "Error",
                            text: "El código de planilla ingresado no es validado, por favor ingrese  una planilla valida.",
                            icon: "error",
                            button: "Ok",
                        });


                        $('#search').val('');
                    } else if (response.status === 'verified') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya fue conciliada, por favor ingrese un código de  planilla valido.",
                            icon: "info",
                            button: "Ok",
                        });
                        $('#search').val('');

                    } else if (response.status === 'cancel') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada esta cancelada, por favor ingrese un código de  planilla valido.",
                            icon: "warning",
                            button: "Ok",
                        });
                        $('#search').val('');
                    } else if (response.status === 'old') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya expiró, por favor ingrese un código de  planilla valido.",
                            icon: "warning",
                            button: "Ok",
                        }).then(response => function () {
                            location.reload();
                        });
                        $('#search').val('');

                    } else {

                        var taxe = response.taxe[0];
                        var vehicle = response.taxe[0]['vehicle_taxes'][0].license_plate;
                        var vehicleId = response.taxe[0]['vehicle_taxes'][0].id;
                        swal({
                            title: "¡Bien hecho!",
                            text: "Escaneo de QR realizado correctamente.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            var link;

                            link = '<a href=' + url + 'rate/ticket-office/details/' + taxe.id + '"' +
                                '\nclass="btn indigo waves-effect waves-light"><i\n' +
                                'class="icon-pageview left"></i>Detalles</a>';


                            $('#receipt-body').append('' +
                                '<tr>' +
                                '<td>' + vehicle + '</td>' +
                                '<td><i class="icon-check text-green"></i>' + taxe.created_at + '</td>' +
                                '<td>' + taxe.code + '</td>' +
                                '<td>' + taxe.branch + '</td>' +
                                '<td>' + taxe.amountFormat + '</td>' +
                                '<td>' + '<p>' +
                                '  <label>\n' +
                                '           <input type="checkbox" name="payroll" class="payroll"\n' +
                                '                       value="' + taxe.id + '"' +
                                'data-vehicle="' + vehicleId +
                                '"/>\n' +
                                '                         <span></span>\n' +
                                '                                  </label>\n' +
                                '</p>' +
                                '</td>' +
                                '<td>' + link + '</td>' +
                                '</tr>'
                            );
                            var vehicle_id = '';
                            $('.payroll').change(function () {
                                if (vehicle_id !== '') {
                                    if (!$(this).is(":checked")) {
                                        vehicle_id = '';
                                    }
                                    else if ($(this).is(":checked") && $(this).attr('data-vehicle') == vehicle_id) {
                                        vehicle_id = $(this).attr('data-vehicle');
                                    } else if ($(this).attr('data-vehicle') != vehicle_id) {
                                        swal({
                                            title: "Información",
                                            text: "La planilla selecionada no pertenece al mismo vehículo .",
                                            icon: "info",
                                            button: "Ok",
                                        }).then(function () {
                                            location.reload();
                                        });
                                        $(this).prop('checked', false);
                                    } else if (!$(this).is(":checked")) {
                                        vehicle_id = '';
                                    }
                                } else {
                                    console.log(vehicle_id);
                                    console.log('else');
                                    vehicle_id = $(this).attr('data-vehicle');
                                }


                                /*if (type_taxes !== '') {
                                    if ($(this).is(":checked") && $(this).attr('data-company') == type_taxes) {
                                        type_taxes = $(this).attr('data-taxes');
                                    } else if ($(this).attr('data-taxes') != type_taxes) {
                                        swal({
                                            title: "Información",
                                            text: "Las planillas selecionadas deben ser del mismo tipo.",
                                            icon: "info",
                                            button: "Ok",
                                        }).then(function () {

                                            location.reload();
                                        });


                                        $(this).prop('checked', false);
                                    }
                                } else {
                                    type_taxes = $(this).attr('data-taxes');
                                }*/

                            });

                            $(this).val();
                            M.updateTextFields();
                        });


                    }
                    formatMoney();
                    M.updateTextFields();
                    $('#search').val('');


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                }, error: function (err) {
                    $('#license').val('');
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }
    });

    $('#register-payment-depo').submit(function (e) {
        e.preventDefault();

        if ($('input:radio:checked.check-payment').val() !== undefined && $('input:radio:checked.bank-div').val() !== undefined) {
            $.ajax({
                url: url + "ticket-office/payment/save",
                contentType: false,
                processData: false,
                data: new FormData(this),
                method: "POST",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    var taxes_id = $('.taxes_id').val();
                    swal({
                        title: "¡Bien hecho!",
                        text: "Planilla ingresa y registrada con éxito.",
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        $('#amount_total_tr').val('');
                        if ($('#company_id').val() !== '') {
                            window.open(url + '/ticketOffice/vehicle/generate-receipt/' + taxes_id, "RECIBO DE PAGO", "width=500, height=600");
                            location.reload();
                        }

                    });
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
                        button: "Ok",
                    });
                }
            });

        } else {
            if ($('input:radio:checked.check-payment').val() === undefined) {
                swal({
                    title: "Información",
                    text: "Debes de selecionar la forma de pago en que se va hacer el deposito.",
                    icon: "warning",
                    button: "Ok",
                });
            } else if ($('input:radio:checked.bank-div').val() === undefined) {
                swal({
                    title: "Información",
                    text: "Debes de selecionar el banco en el cual se va realizar el deposito.",
                    icon: "warning",
                    button: "Ok",
                });
            }


        }

    });


    $('#register-payment-tr').submit(function (e) {
        e.preventDefault();
        var amount = $('#amount_total_tr').val();
        var amount_pay = $('#amount_tr').val();

        amount = amount.replace(/\./g, '');
        amount_pay = amount_pay.replace(/\./g, '');


        amount = amount.replace(/,/g, "");
        amount_pay = amount_pay.replace(/,/g, "");


        if (parseInt(amount_pay) > parseInt(amount)) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button: "Ok",
            });

        } else {

            if ($('#bank_destinations_tr').val() != null && $('#bank_tr').val() != null) {
                $.ajax({
                    url: url + "ticket-office/payment/save",
                    contentType: false,
                    processData: false,
                    data: new FormData(this),
                    method: "POST",

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        var taxes_id = $('.taxes_id').val();

                        console.log(response);
                        if (response.status === 'process') {
                            $('#amount_total_tr').val(response.payment);

                            $('#amount_total_tr').val(function (index, value) {
                                return number_format(value, 2);
                            });
                            swal({
                                title: "Información",
                                text: "Para conciliar esta planilla " +
                                "el monto debe ser cancelado en su totalidad.Debe cancelar el dinero restante:" + $('#amount_total_tr').val() + "Bs",
                                icon: "info",
                                button: "Ok",
                            });

                        } else {
                            swal({
                                title: "¡Bien hecho!",
                                text: "Planilla ingresa, una vez se verifique el pago se enviara la planilla, al correo afiliado a esta empresa.",
                                icon: "success",
                                button: "Ok",
                            }).then(function (accept) {
                                location.reload();
                            });

                        }
                        $('#ref_tr').val('');
                        $('#amount_tr').val('');
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
                            button: "Ok",
                        });
                    }
                });

            } else {
                if ($('#bank_destinations_tr').val() === null) {
                    swal({
                        title: "Información",
                        text: "Debe selecionar el banco donde el dinero va ingresar.",
                        icon: "info",
                        button: "Ok",
                    });
                } else if ($('#bank_tr').val() === null) {
                    swal({
                        title: "Información",
                        text: "Debe selecionar el banco de donde se realizara la transferencia.",
                        icon: "info",
                        button: "Ok",
                    });
                }
            }


        }

    });

    $('.check-payment').click(function () {
        if ($(this).val() === 'PPC') {
            $('#ref_depo').removeAttr('readonly');
        } else {
            $('#ref_depo').attr('readonly', 'readonly');
            $('#ref_depo').val('');
        }
        $('#payments_type_depo').val($(this).val());
    });


    $('#email').blur(function () {


        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: url + "rate/ticket-office/verify-email/" + email,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        $('#email').val('');
                    }
                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: {
                            text: "Entendido",
                            className: "blue-gradient"
                        },
                    });
                    $('#email').val('');
                }
            });
        }

    });


    $('#change-users').click(function () {
        var template = `
        <h5 class="center">Cambiar Usuario</h5>
        <div class="input-field col s6 tooltipped" data-tooltip="V: Venezolano; E: Extranjero">
            <i class="icon-public prefix"></i>
            <select name="typeDocument" id="typeDocument" required>
                <option value="J" selected>J</option>
                <option value="E" >E</option>
                <option value="G" >G</option>
                <option value="V" >V</option>
            </select>
            <label for="typeDocument">Tipo de documento</label>
        </div>
        <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                <i class="icon-person prefix"></i>
                <input id="document" type="text" name="document" class="validate number-date" pattern="[0-9]+"
                    title="Solo puede escribir números." required
                    value="">
                <label for="document">Documento</label>
        </div>`;

        $('#change').html(template);
        $('.validate.number-date').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
        $('select').formSelect();
        $('#Document').focus();
        $(this).hide();
        $('#save-change').removeClass('hide');

    });

    $('#save-change').click(function () {
        var type = $('#typeDocument').val();
        var document = $('#document').val();
        var id = $('#id').val();

        var nationality = $('#nationality').val();
        var documentOld = $('#ci').val();


        if (document == '' || document.length < 7) {
            swal({
                title: "Información",
                text: "Verifica los datos en campo de cedula," +
                "para poder procesar tu solicitud",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "blue-gradient",
                    value: true
                },
            })
        } else if ((type == nationality) && (document == documentOld)) {
            swal({
                title: "Información",
                text: 'El documento que introdujo, es igual al del propietario',
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "blue-gradient",
                    value: true
                },
            });

            $('#document').focus();
        }
        else {
            $.ajax({
                type: "get",
                url: url + "vehicle/change-user/" + type + "/" + document + "/" + id,

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    console.log(data);

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (data['status'] === "success") {
                        swal({
                            title: "Cambio de Usuario",
                            text: 'Ha sido exitoso',
                            icon: "success",
                            button: {
                                text: "Entendido",
                                className: "blue-gradient",
                                value: true
                            },

                        }).then(function (options) {
                            if (options) {
                                location.reload();
                            }
                        });
                    } else {
                        swal({
                            title: "Cambio de Usuario",
                            text: 'Usuario no encontrado, Verifica los datos por favor',
                            icon: "info",
                            button: {
                                text: "Entendido",
                                className: "blue-gradient",
                                value: true
                            },

                        })
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

        }
    });

    $('#changeUW').click(function () {
        var template = `
        <h5 class="center">Cambiar Usuario Web</h5>
        <div class="input-field col s6 tooltipped" data-tooltip="V: Venezolano; E: Extranjero">
            <i class="icon-public prefix"></i>
            <select name="typeDocument" id="typeDocument" required>
                <option value="E" >E</option>
                <option value="V"selected >V</option>
            </select>
            <label for="typeDocument">Tipo de documento</label>
        </div>
        <div class="input-field col s6 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                <i class="icon-person prefix"></i>
                <input id="Document" type="text" name="Document" class="validate number-date" pattern="[0-9]+"
                    title="Solo puede escribir números." required
                    value="">
                <label for="Document">Documento</label>
        </div>`;

        $('#changeUserWeb').html(template);
        $('.validate.number-date').keyup(function () {
            this.value = (this.value + '').replace(/[^0-9]/g, '');
        });
        $('select').formSelect();
        $('#Document').focus();
        $(this).hide();
        $('#saveUW').removeClass('hide');
    });

    $('#saveUW').click(function () {
        var type = $('#typeDocument').val();
        var document = $('#Document').val();
        var nationalitys = $('#nationalitys').val();
        var documentOld = $('#ci').val();
        var id = $('#id').val();

        if (document == '' || document.length < 7) {
            swal({
                title: "Información",
                text: "Verifica los datos en campo de cedula," +
                "para poder procesar tu solicitud",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "blue-gradient",
                    value: true
                },
            })
        } else if ((type == nationalitys) && (document == documentOld)) {
            swal({
                title: "Información",
                text: 'El documento que introdujo, es igual al del usuario web',
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "blue-gradient",
                    value: true
                },
            });

            $('#Document').focus();
        } else {

            $.ajax({
                type: "get",
                url: url + "vehicle/change-user-web/" + type + "/" + document + "/" + id,

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    console.log(data);

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (data['status'] === "success") {
                        swal({
                            title: "Cambio de Usuario",
                            text: 'Ha sido exitoso',
                            icon: "success",
                            button: {
                                text: "Entendido",
                                className: "blue-gradient",
                                value: true
                            },

                        }).then(function (options) {
                            if (options) {
                                location.reload();
                            }
                        });
                    } else {
                        swal({
                            title: "Cambio de Usuario",
                            text: 'Usuario no encontrado, Verifica los datos por favor',
                            icon: "info",
                            button: {
                                text: "Entendido",
                                className: "blue-gradient",
                                value: true
                            },

                        })
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
        }
    });


});

