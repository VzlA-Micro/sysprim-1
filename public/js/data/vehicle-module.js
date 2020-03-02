$(document).ready(function () {

    var buttonBrand = true;
    var controlButtonBrand = true;

    $('#model').prop('disabled', true);
    $('select').formSelect();
    var url = localStorage.getItem('url');

    $('#type_document_full').change(function () {
        console.log($(this).val());
        if ($(this).val() === 'J' || $(this).val() === 'G') {
            $('#condition').addClass('hide');
            $('#status').val('propietario');
            $('#type').val('company');
        } else {
            $('#condition').removeClass('hide');
            $('#type').val('');
            $('#status').val('')
        }

    });


    $('#document_full').keyup(function () {
        if ($('#type_document_full').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar el tipo de documento, antes de ingresar el número de documentos.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#document_full').val('')
        }
    });


    $('#document_full').change(function () {
        if ($('#type_document_full').val() !== null) {
            findDocument();
        }
    });


    $('#type_document_full').change(function () {
        findDocument();
    });


    $('#status_view').click(function () {


    });


    $('#status_view').change(function () {


        var document = $('#document_full').val();
        console.log($('#document_full').val());
        if (document == '') {
            swal({
                title: "Información",
                text: "Debes ingresar una cedula valida para poder selecionar la condicion legal del usuario.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $("#status_view").prop("selectedIndex", 0); // set the first option as selected
            $("#status_view").formSelect();
        } else {


            var status = $(this).val();
            $('#status').val(status);

            var content = `

            <div class="s12 m12">
                <h5 class="center-align">Datos del Propietario</h5>
            </div>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extranjero<br>J: Juridico">
                <i class="icon-public prefix"></i>
                <select name="type_document" id="type_document" required>
                    <option value="null" selected disabled>...</option>
                    <option value="V">V</option>
                    <option value="E">E</option>
                    <!--<option value="J">J</option>-->
                </select>
                <label for="type_document">Documento</label>
            </div>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                 <input id="document" type="text" name="document" data-validate="documento" maxlength="8" class="validate number-only rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                 <label for="document">Identificación</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                 <i class="icon-person prefix"></i>
                 <input id="name" type="text" name="name" class="validate rate" data-validate="nombre"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." required>
                 <label for="name">Nombre</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                <i class="icon-person prefix"></i>
                <input id="email" type="email" name="email" class="validate rate" data-validate="email"  title="Solo puede agregar letras (con acentos)." required >
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
                    findDocumentResponsable();
                });


                $('#type_document').change(function () {
                    findDocumentResponsable();
                });
            } else {

                $('#person_id').val($('#id').val());

                $('#content').html('');
            }
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
        var type_document = $('#type_document_full').val();
        var document = $('#document_full').val();
        $('#surname_full').val('');
        $('#user_name_full').val('');
        $('#type').val('');
        $('#address_full').val('');
        $('#name_full').val('');
        $('#email_full').val('');

        if (document !== '') {
            $.ajax({
                method: "GET",
                url: url + "property/find/" + type_document + "/" + document + '/false', // Luego cambiar ruta
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status !== 'error') {
                        if (response.type == 'not-user') {

                            swal({
                                title: "Información",
                                text: "El usuario no esta registrado, debe ingresar un valido..",
                                icon: "info",
                                buttons: {
                                    confirm: {
                                        text: "Registrarlo",
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
                                    window.location.href = url + "taxpayers/register";
                                }
                            })


                        } else if (response.type == 'user') {
                            var user = response.user;
                            $('#name_full').val(user.name + ' ' + user.surname);
                            $('#name_full').attr('readonly', '');
                            $('#surname_full').val(user.surname);
                            $('#id').val(user.id);
                            $('#type').val('user');
                            $('#address_full').val(user.address);
                            $('#address_full').attr('readonly', '');
                            $('#email_full').val(user.email);
                            $('#email_full').attr('readonly','');


                        } else if (response.type == 'company') {
                            var company = response.company;
                            $('#name_full').val(company.name);
                            $('#address_full').val(company.address);
                            $('#name_full').attr('readonly', '');
                            $('#address_full').attr('disabled');
                            $('#id').val(company.id);
                            $('#type').val('company');
                            $('#address_full').attr('readonly', '');

                        } else {
                            $('#type').val('company');
                        }
                    } else {
                        swal({
                            title: "Información",
                            text: "La empresa no esta registrada, debe ingresar un RIF valido.",
                            icon: "info",
                            buttons: {
                                confirm: {
                                    text: "Registrarlo",
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

    function findDocumentResponsable() {
        var type_document = $('#type_document').val();
        var document = $('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');
        $('#email').val('');


        if (document !== '') {
            $.ajax({
                method: "GET",
                url: url + "property/find/" + type_document + "/" + document + '/true', // Luego cambiar ruta
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
                                $('#name').attr('readonly', '');
                                $('#surname').val(user.apellidos);
                                $('#user_name').val(user.nombres);
                                $('#type').val('user');
                                $('#email').prop('readonly', false);
                                $('#address').prop('readonly', false);
                            }


                        } else if (response.type == 'user') {

                            var user = response.user;
                            $('#name').val(user.name + ' ' + user.surname);
                            $('#name').attr('readonly', '');
                            $('#surname').val(user.surname);
                            $('#person_id').val(user.id);
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
                        $('#document').val('');
                    }
                    M.updateTextFields();
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                },
                error: function (err) {

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

    $('#data-next').click(function () {
        var status = $('#status').val();
        var name_full = $('#name').val();
        var address = $('#address').val();
        var document_full = $('#document').val();
        var email = $('#email').val();
        var responsable = null;
        var type_document_company = false;

        if ($('#type').val() == 'company') {
            status = 'propietario';
        }
        var type = $('#type_document_full').val();

        if (type === 'J' || type === 'G') {
            var name_f = $('#name_full').val();
            var address_f = $('#address_full').val();
            var document_f = $('#document_full').val();
            if (name_f === '' && address_f === '' && document_f === '') {
                swal({
                    title: "Información",
                    text: "Debe ingresar el documento de identificación para continuar con el registro.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            } else {
                type_document_company = true;
            }

        }


        if ((status == null || status == '')) {
            swal({
                title: "Información",
                text: "Debe seleccionar una condicion social para continuar con el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else if (status !== 'propietario') {

            if ($('#type_document').val() == null) {

                swal({
                    title: "Información",
                    text: "Debe seleccionar un tipo de documento de la persona responsable.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            } else if ($('#document').val() == '') {

                swal({
                    title: "Información",
                    text: "Debe introducir el documento de la persona responsable.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            } else if (name_full == '') {

                swal({
                    title: "Información",
                    text: "Debe llenar todos los campos para poder continuar.",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        visible: true,
                        value: true,
                        className: "green",
                        closeModal: true
                    }
                });
            } else if (address == '') {

                swal({
                    title: "Información",
                    text: "Debe llenar todos los campos para poder continuar.",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        visible: true,
                        value: true,
                        className: "green",
                        closeModal: true
                    }
                });
            }
            else if (email == '') {
                swal({
                    title: "Información",
                    text: "Debe llenar todos los campos para poder continuar.",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        visible: true,
                        value: true,
                        className: "green",
                        closeModal: true
                    }
                });
            }
            else if (document_full == '') {

                swal({
                    title: "Información",
                    text: "Debe llenar todos los campos para poder continuar.",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        visible: true,
                        value: true,
                        className: "green",
                        closeModal: true
                    }
                });
            } else {

                /* $('#two').removeClass('disabled');
                 $('#user-tab-one').addClass('disabled');
                 $('ul.tabs').tabs("select", "vehicle-tab");*/
                responsable = true;
            }
        } else if (status == 'propietario') {
            if ((type === 'J' || type === 'G') && type_document_company) {
                $('#two').removeClass('disabled');
                $('#user-tab-one').addClass('disabled');
                $('ul.tabs').tabs("select", "vehicle-tab");
            } else if (type === 'V' || type === 'E' && document_full !== '') {
                $('#two').removeClass('disabled');
                $('#user-tab-one').addClass('disabled');
                $('ul.tabs').tabs("select", "vehicle-tab");
            }
        }

        if (responsable) {
            band = true;
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
            if ($('#person_id').val() !== '') {
                band = false;
            }

            if (band) {
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
                        email:email,
                        type: type
                    },
                    url: url + 'properties/taxpayers/company-user/register',

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        $('#person_id').val(response.id);
                        $('#two').removeClass('disabled');
                        $('#user-tab-one').addClass('disabled');
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
                $('#user-tab-one').addClass('disabled');
                $('ul.tabs').tabs("select", "vehicle-tab");
            }
        }

    });

    $('#vehicles-previous').click(function () {
        $('#user-tab-one').removeClass('disabled');
        $('#two').addClass('disabled');
        $('ul.tabs').tabs("select", "user-tab");
    });

    /*$('#property').on('submit', function (e) {
        var type = $('#type').val();
        var id = $('#id').val();
        e.preventDefault();

        if ($('#brand').val() == '') {
            swal({
                title: "Información",
                text: "Debe seleccionar una marca de vehículo para poder continuar",
                icon: "success",
                button: "Ok",
            });
        } else {
            $.ajax({
                url: url + "property/ticket-office/save-property",
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
                        text: response.message,
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        if (type == 'company') {
                            window.location.href = url + "properties/company/my-properties/" + id;
                        }
                        else {
                            window.location.href = url + "properties/my-properties";
                        }
                    });
                    ;

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
    });*/

    $('#year').change(function () {
        var anio = $(this).val();
        var yearCurrent = (new Date).getFullYear();

        if (anio > yearCurrent) {
            swal({
                title: "informacion",
                text: 'Debe introducir un año valido',
                icon: 'info'
            });
            $(this).val('');
            $(this).focus();
        } else {

        }
    });

    $('#license_plates').change(function () {
        var license = $(this).val();
        console.log(license);
        if (license == '') {
            swal({
                title: "Información",
                text: "Introduzca una placa",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "red-gradient"
                },
            });
        } else if (license.length < 7) {
            swal({
                title: "Información",
                text: "Introduzca una placa valida",
                icon: "info",
                button: {
                    text: "Entendido",
                    className: "red-gradient"
                },
            });
        } else {
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
        }


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

    $('#button-brand').on('click', function (e) {
        e.preventDefault();
        if (buttonBrand) {
            if (controlButtonBrand) {
                $('#group-MB').hide();
                var html =
                    `<div class="input-field col s6">
                        <i class="icon-directions_car prefix"></i>
                        <input type="text" name="brand-n" id="brand-n" minlength="1" maxlength="20"
                        >
                         <label for="brand-n">Marca</label>
                    </div>
                    <div class="input-field col s6">
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

    $('#vehicle-register-ticket').submit(function (e) {
        e.preventDefault();
        console.log($('#brand').val());
        //$('#button-company').attr('disabled', 'disabled');
        var brand = $('#brand').val();
        var brandN = $('#brand-n').val();
        var modelN = $('#model-n').val();
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
                success: function (data) {
                    console.log(data);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    if (data['status'] == 'success') {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Vehículo registrado con exito!",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            window.location.href = url + "ticketOffice/vehicle/read";
                        });
                    } else {
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
                error: function (err) {
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