var url = localStorage.getItem('url');


var user = $('#user').val();
var updateType = false;
var buttonBrand = true;
var controlButtonBrand = true;

$('document').ready(function () {

    $('#data-next').click(function () {
        var status = $('#status').val();
        var document = $('#document').val();
        console.log(status);
        if (status == null || status == '') {
            swal({
                title: "Información",
                text: "Debe seleccionar una condicion social para continuar con el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
        else if (status == 'propietario') {
            $('#two').removeClass('disabled');
            $('#one').addClass('disabled');
            $('ul.tabs').tabs("select", "vehicle-tab");
        } else if (document < 7) {
            $('#document').val('');

            swal({
                title: "Información",
                text: "Debe introducir una cedula valída para continuar con el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            }).then(response => function () {
                $('#document').focus();
            });

        } else {


            band = true;
            console.log('responsable');
            $('.rate').each(function () {
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
                }
            });

            console.log(band);
            if (band) {
                console.log($('#idUser').val());
                if ($('#idUser').val() == '') {
                    console.log(band);
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
                            type_document: type_document,
                            document: document,
                            address: address,
                            email: email,
                            type: type,
                            user: user
                        },
                        url: url + 'properties/taxpayers/company-user/register',

                        beforeSend: function () {
                            $("#preloader").fadeIn('fast');
                            $("#preloader-overlay").fadeIn('fast');
                        },
                        success: function (response) {
                            console.log(response);
                            $('#idUser').val(response.id);
                            $('#two').removeClass('disabled');
                            $('#one').addClass('disabled');
                            $('ul.tabs').tabs("select", "vehicle-tab");
                            $("#preloader").fadeOut('fast');
                            $("#preloader-overlay").fadeOut('fast');
                        },
                        error: function (err) {
                            console.log(err);
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
                    $('ul.tabs').tabs("select", "vehicle-tab");
                }
            }
        }
    });

    $('#status').change(function () {
        var status = $(this).val();
        var content = `
            <h5 class="center">Datos del propietario</h5>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extranjero<br>J: Juridico">
                <i class="icon-public prefix"></i>
                <select name="type_document" id="type_document" required>
                    <option value="null" selected disabled>...</option>
                    <option value="V">V</option>
                    <option value="E">E</option>
                </select>
                <label for="type_document">Documento</label>
            </div>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                 <input id="document" type="text" name="document" data-validate="documento" maxlength="8" class="validate number-only rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                 <label for="document">Cedula</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                 <i class="icon-person prefix"></i>
                 <input id="name" type="text" name="name" class="validate rate" data-validate="nombre"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." required readonly>
                 <label for="name">Nombre</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                <i class="icon-person prefix"></i>
                <input id="email" type="text" name="email" class="validate rate" data-validate="email"  title="Solo puede agregar letras (con acentos)." required >
                <label for="email">Correo</label>
            </div>
            <div class="input-field col s12 m6">
                 <i class="icon-directions prefix"></i>
                 <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion" class="materialize-textarea rate" required></textarea>
                 <label for="address">Dirección</label>
            </div>
            <input id="surname" type="hidden" name="surname" class="validate" value="">
            <input id="user_name" type="hidden" name="name_user" class="validate" value="">
       `;
        if (status == 'responsable') {


            $('#content').append(content);
            $('.validate.number-only').keyup(function () {
                this.value = (this.value + '').replace(/[^.,0-9]/g, '');
            });

            $('select').formSelect();
            M.textareaAutoResize($('#address'));
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
        }
        else {
            $('#content').html('');
        }
    });

    $('#email').change(function () {
        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: url + "users/verify-email/" + email,
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

    function findDocument() {
        var type_document = $('#type_document').val();
        var document = $('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');
        if (document !== '' && document >= 7) {
            $.ajax({
                method: "GET",
                url: url + "rate/taxpayers/find/" + type_document + "/" + document, // Luego cambiar ruta
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status !== 'error') {
                        if (response.type == 'not-user') {
                            var user = response.user.response;
                            if(user.inscrito==false){
                                swal({
                                    title: "Lo sentimos",
                                    text: "Su cédula no se encuentra registrada en el CNE.",
                                    icon: "info",
                                    button: {
                                        text: "Entendido",
                                        className: "red-gradient"
                                    },
                                }).then(function () {
                                    $('#document').val('');
                                    $('#document').focus();
                                });

                            }else{
                                $('#name').val(user.nombres + ' ' + user.apellidos);
                                $('#name').attr('readonly');
                                $('#surname').val(user.apellidos);
                                $('#user_name').val(user.nombres);
                                $('#type').val('user');
                                $('#idUser').val(user.id);
                            }

                        } else if (response.type == 'user') {
                            var user = response.user;
                            $('#name').val(user.name + ' ' + user.surname);
                            $('#name').attr('readonly');
                            $('#surname').val(user.surname);
                            $('#idUser').val(user.id);

                            $('#type').val('user');
                            $('#address').val(user.address);
                            $('#address').attr('readonly', '');
                            $('#email').val(user.email);
                            $('#email').attr('readonly','');
                        } else if (response.type == 'company') {
                            var company = response.company;
                            $('#name').val(company.name);
                            $('#address').val(company.address);
                            $('#name').attr('readonly');
                            $('#address').attr('disabled');
                            $('#id').val(company.id);
                            $('#type').val('company');
                            $('#address').attr('readonly', '');

                        } else {
                            $('#type').val('company');
                        }
                    } else {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

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

    $('#bodySerial').change(function () {
        var bodySerial = $(this).val();
        var id = $('#id').val();
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

    $('#vehicle').on('submit', function (e) {
        e.preventDefault();
        var brand = $('#brand').val();
        var brandN = $('#brand-n').val();
        var modelN = $('#model-n').val();
        var idCompany = $('#idCompany').val();

        console.log(idCompany);
        if (brand == null && brandN == undefined) {
            swal({
                title: "Información",
                text: "Debe seleccionar un marca de vehículo para poder completar el registro",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "red-gradient"
                },
            });
            $('#brand').focus();
        } else if (brandN == '' || modelN == '') {
            swal({
                title: "Información",
                text: "Debe seleccionar un marca de vehículo para poder completar el registro",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "red-gradient"
                },
            });
            $('#brand-n').focus();
        } else if ((brand != null) || (brandN != null && modelN != null)) {
            $.ajax({
                type: "POST",
                url: url + "vehicles/save",
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),

                beforeSend: function () {
                    //$('#button-vehicle').prop('disabled', true);
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    console.log(data);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    if (data.status == 'success' && data.isCompany ==false) {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Vehículo registrado con exito!",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            window.location.href = url + "vehicles/read";
                        });
                    } else if (data.isCompany == true && data.status=== 'success') {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Vehículo registrado con exito!",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            window.location.href = url + "company/vehicles/" + idCompany;
                        });
                    }
                    else {
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
                            $("#preloader").fadeIn('fast');
                            $("#preloader-overlay").fadeIn('fast');
                        },
                        success: function (data) {
                            $("#preloader").fadeOut('fast');
                            $("#preloader-overlay").fadeOut('fast');
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
        }
    });

    $('#button-brand').on('click', function (e) {
        e.preventDefault();
        if (buttonBrand) {
            if (controlButtonBrand) {
                $('#group-MB').hide();
                var html =
                    `<div class="input-field col s12 m6">
                        <i class="icon-directions_car prefix"></i>
                        <input type="text" name="brand-n" id="brand-n" minlength="1" maxlength="20"
                        >
                         <label for="brand-n">Marca</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="icon-local_shipping prefix"></i>
                        <input type="text" name="model-n" id="model-n" minlength="1" maxlength="20">
                        <label for="model-n">Módelo</label>
                    </div>`;
                $('#group-new-MB').html(html);
                $('#brand-n').focus();
                console.log(buttonBrand);
                buttonBrand = false;
                controlButtonBrand = false;
            } else {
                $('#group-MB').hide();
                $('#group-new-MB').show();
                $('#brand-n').focus();
            }

        } else {
            $('#group-new-MB').hide();
            $('#group-MB').show();
            buttonBrand = true;
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

    /*
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
    */

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
                console.log(response);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
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
                        //window.location.href = url + "ticketOffice/vehicle/read";
                    }
                });

                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

            },
            error: function (err) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                $('#button-company').removeAttr('disabled', '');
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

    $('#image').change(function () {
        var file = this.files[0];
        var mimetype = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((mimetype == match[0]) || (mimetype == match[1]) || (mimetype == match[2]))) {
            swal({
                title: "Informacion",
                text: "Por favor, elige una imagen con formato compatible. (JPG/JPEG/PNG)",
                icon: "warning",
                button: {
                    text: "Aceptar",
                    visible: true,
                    value: true,
                    className: "green",
                    closeModal: true
                }
            });
            $(this).val('');
            return false;
        }
    });

    $('#year').change(function () {
        var anio=$(this).val();
        var yearCurrent= (new Date).getFullYear();

        if (anio > yearCurrent){
            swal({
                title:"informacion",
                text:'Debe introducir un año valido',
                icon:'info'
            });
            $(this).val('');
            $(this).focus();
        }else{

        }
    });
});




