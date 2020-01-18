//var url = "http://172.19.50.253/";
var url = "http://sysprim.com.devel/";

var updateType = false;
var buttonBrand = true;
var controlButtonBrand = true;

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
                    window.location.href = url + "vehicles/read";
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

    $('#button-brand').on('click', function (e) {
        e.preventDefault();
        console.log('hola');
        console.log(buttonBrand);
        if (buttonBrand) {
            if (controlButtonBrand) {
                $('#group-MB').hide();
                var html =
                    `<div class="input-field col s6">
                        <i class="icon-directions_car prefix"></i>
                        <input type="text" name="brand-n" id="brand-n">
                         <label for="brand-n">Marca</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="icon-local_shipping prefix"></i>
                        <input type="text" name="model-n" id="model-n">
                        <label for="model-n">Módelo</label>
                    </div>`;
                $('#group-new-MB').html(html);
                console.log(buttonBrand);
                buttonBrand = false;
                controlButtonBrand = false;
            } else {
                $('#group-MB').hide();
                $('#group-new-MB').show();
            }

        } else {
            $('#group-new-MB').hide();
            $('#group-MB').show();
            console.log(buttonBrand);
            buttonBrand = true;
        }


    });


    //tab ticktffice
    $('#user-next').click(function () {

        if ($('#ci').val() === '' || $('#name_user').val() === '') {
            swal({
                title: "Información",
                text: "Debes ingresar la cedula de un contribuyente, para continuar con el registros.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else {


            $('#vehicle-tab-two').removeClass('disabled');
            $('ul.tabs').tabs();
            $('ul.tabs').tabs("select", "company-tab");

        }

    });


    $('#company-next').click(function () {
        var band = true;

        $('.company-validate').each(function () {
            if ($(this).val() === '' || $(this).val() === null) {
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
            } else if ($('#ciu').val() === undefined) {
                swal({
                    title: "Información",
                    text: "Debe agregar al menos un CIIU valido para registrar la empresa.",
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
            $('#map-tab-three').removeClass('disabled');
            $('ul.tabs').tabs();
            $('ul.tabs').tabs("select", "map-tab");
        }

    });


    $('#company-previous').click(function () {
        $('ul.tabs').tabs();
        $('ul.tabs').tabs("select", "user-tab");
    });

    $('#vehicle-register-ticket').submit(function (e) {
        e.preventDefault();


        $('#button-company').attr('disabled', 'disabled');

        $.ajax({
            url: url + "ticketOffice/vehicle/save",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
                swal({
                    title: "¡Bien Hecho!",
                    text: "El vehiculo ha sido registrado con éxito.",
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    },
                }).then(function (accept) {
                    if (accept) {
                        window.location.href = url + "ticketOffice/companies/all";
                    }
                });

                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

            },
            error: function (err) {
                $('#button-company').removeAttr('disabled', '');
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




