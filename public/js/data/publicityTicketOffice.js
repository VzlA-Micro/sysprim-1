var url = localStorage.getItem('url');
var updateType = false;

$('document').ready(function () {
    var date = new Date();
    $('.date_start').datepicker({
        maxDate: date,
        format: 'yyyy-mm-dd', // Configure the date format
        // yearRange: [1900,date.getFullYear()],
        showClearBtn: false,
        i18n: {
            cancel: 'Cerrar',
            clear: 'Reiniciar',
            done: 'Hecho',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    });
    $('.date_end').datepicker({
        maxDate: null,
        format: 'yyyy-mm-dd', // Configure the date format
        minDate: date,
        showClearBtn: false,
        i18n: {
            cancel: 'Cerrar',
            clear: 'Reiniciar',
            done: 'Hecho',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    });

    /*$('#form-1').hide();
    $('#form-2').hide();
    $('#form-3').hide();
    $('#form-4').hide();
    $('#form-5').hide();
*/

    $('#model').prop('disabled', true);
    $('select').formSelect();

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
            <div class="input-field col s12 m6 tooltipped name-div" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                <i class="icon-person prefix"></i>
                <input id="name" type="text" name="name" class="validate rate" data-validate="nombre" minlength="2" maxlength="150" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                <label for="name">Nombre</label>
            </div>
            <div class="input-field col s12 m3 tooltipped surname-div hide" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                <i class="icon-person prefix"></i>
                <input id="surname-div" type="text" name="surname-div" class="validate" minlength="2" maxlength="40" data-validate="apellido" pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+" title="Solo puede agregar letras (con acentos)." required>
                <label for="surname-div">Apellido</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                <i class="icon-mail_outline prefix"></i>
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

                /*generate correo */
                $('#generate-correo').removeClass('hide');
                $('#generate-correo').click(function () {
                    if ($('#type_document').val() !== '' && $('#document').val() !== '') {
                        if ($('#user_name').val() !== '' && $('#surname').val()) {
                            swal({
                                title: "Información",
                                text: "¿Está seguro que desea generar un correo aleatorio?",
                                icon: "info",
                                buttons: {
                                    confirm: {
                                        text: "SI",
                                        className: "blue-gradient",
                                        visible: true,
                                        value: true
                                    },
                                    cancel: {
                                        text: "NO",
                                        className: "grey lighten-2",
                                        visible: true,
                                        value: false,
                                        closeModal: true
                                    }
                                }
                            }).then(confirm => {
                                if (confirm) {
                                    // if($('#user_name').val()!==''&&$('#surname').val()){
                                    var number_rando = getRandomArbitrary(1, 999);
                                    var email = $('#user_name').val().substr(0, 4).toLocaleLowerCase() + number_rando + '@sincorreo.com';
                                    $('#email').val(email);
                                    M.updateTextFields();
                                    // }
                                }
                                else {
                                    $('#email').val('');
                                }
                            });
                        }
                        else {
                            swal({
                                title: 'Información',
                                text: 'Debe llenar el nombre y el apellido para generar el correo aleatorio.',
                                icon: 'info',
                                button: {
                                    text: "Esta bien",
                                    className: "blue-gradient"
                                },
                            });
                        }
                    }
                    else {
                        swal({
                            title: 'Información',
                            text: 'Debe llenar el documento y la identificación para generar el correo aleatorio.',
                            icon: 'info',
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                    }
                });


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

                $('#email').change(function () {
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

                            }
                        });
                    }
                });

                /* person foreign*/

                $('#surname-div').change(function () {
                    $('#surname').val($(this).val());

                });

                $('#name').change(function () {
                    $('#user_name').val($(this).val());
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

    function getRandomArbitrary(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

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
                            $('#email_full').attr('readonly', '');


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
        $('#person_id').val('');
        $('#surname-div').val('');

        /* person foreign*/

        if (type_document === 'E') {
            $('.name-div').removeClass('m6');
            $('.name-div').addClass('m3');
            $('.surname-div').removeClass('hide');
            /*foreign new*/
            $('#surname-div').addClass('rate');
            $('#surname-div').attr('required', 'required');
        } else {
            $('.name-div').removeClass('m3');
            $('.name-div').addClass('m6');
            $('.surname-div').addClass('hide');
        }


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

                            /* person foreign*/
                            if (type_document === 'E') {
                                $('#name').prop('readonly', false);
                                $('#surname').prop('readonly', false);
                                $('#email').prop('readonly', false);

                                $('.name-div').removeClass('m6');
                                $('.name-div').addClass('m3');
                                $('.surname-div').removeClass('hide');
                                $('#type').val('user');
                                $('#address').removeAttr('readonly', '');
                                $('#name').val('');
                                $('#address').val('');
                                $('#email').val('');

                                M.updateTextFields();
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');

                            }
                            else {
                                if (user.inscrito == false) {
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

                                } else {
                                    $('#name').val(user.nombres + ' ' + user.apellidos);
                                    $('#name').attr('readonly', '');
                                    $('#surname').val(user.apellidos);
                                    $('#user_name').val(user.nombres);
                                    $('#surname-div').val(user.apellidos);
                                    $('#type').val('user');
                                    $('#email').prop('readonly', false);
                                    $('#address').prop('readonly', false);
                                }
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
                            $('#email').attr('readonly', '');


                            /* person foreign*/
                            $('.name-div').removeClass('m3');
                            $('.name-div').addClass('m6');
                            $('.surname-div').addClass('hide');

                            /*foreign new*/
                            $('#surname-div').removeClass('rate');
                            $('#surname-div').removeAttr('required', '');

                            /*validations foreign*/
                            $('#surname-div').val(user.surname);

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
        var email = $('#email').val();
        var document_full = $('#document').val();
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
        } else if (status == 'propietario') {
            if ((type === 'J' || type === 'G') && type_document_company) {
                $('#two').removeClass('disabled');
                $('#one').addClass('disabled');
                $('ul.tabs').tabs("select", "typePublicity-tab");
            } else if (type === 'V' || type === 'E' && document_full !== '') {
                $('#two').removeClass('disabled');
                $('#one').addClass('disabled');
                $('ul.tabs').tabs("select", "typePublicity-tab");
            }
        }
        else if (status != 'propietario') {
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
            }
            else if (name_full == '') {
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
            } else if ($('#type_document').val() == 'E' && $('#surname-div').val() == '') {
                swal({
                    title: "Información",
                    text: "Debe llenar el apellido  para poder continuar.",
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
            else {
                /* $('#two').removeClass('disabled');
                 $('#user-tab-one').addClass('disabled');
                 $('ul.tabs').tabs("select", "vehicle-tab");*/
                responsable = true;
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
                        email: email,
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
                        $('#one').addClass('disabled');
                        $('ul.tabs').tabs("select", "typePublicity-tab");
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
                $('ul.tabs').tabs("select", "typePublicity-tab");
            }
        }
    });

    var valType = null;
    var checkType = true;

    $('#f1').click(function () {
        if (checkType) {
            valType = $(this).val();
            $('button#f1 > i').removeClass('icon-add_circle');
            $('button#f1 > i').addClass('icon-check');

            checkType = false;
        } else {
            valType = '';
            $('button#f1 > i').removeClass('icon-check');
            $('button#f1 > i').addClass('icon-add_circle');
            checkType = true;
        }

    });

    $('#f2').click(function () {
        if (checkType) {
            valType = $(this).val();
            $('button#f2 > i').removeClass('icon-add_circle');
            $('button#f2 > i').addClass('icon-check');
            checkType = false;
        } else {
            valType = '';
            $('button#f2 > i').removeClass('icon-check');
            $('button#f2 > i').addClass('icon-add_circle');
            checkType = true;
        }
    });

    $('#f3').click(function () {
        if (checkType) {
            valType = $(this).val();
            $('button#f3 > i').removeClass('icon-add_circle');
            $('button#f3 > i').addClass('icon-check');
            checkType = false;
        } else {
            valType = '';
            $('button#f3 > i').removeClass('icon-check');
            $('button#f3 > i').addClass('icon-add_circle');
            checkType = true;
        }
    });

    $('#f4').click(function () {
        if (checkType) {
            valType = $(this).val();
            $('button#f4 > i').removeClass('icon-add_circle');
            $('button#f4 > i').addClass('icon-check');
            checkType = false;
        } else {
            valType = '';
            $('button#f4 > i').removeClass('icon-check');
            $('button#f4 > i').addClass('icon-add_circle');
            checkType = true;
        }
    });

    $('#f5').click(function () {
        if (checkType) {
            valType = $(this).val();
            $('button#f5 > i').removeClass('icon-add_circle');
            $('button#f5 > i').addClass('icon-check');
            checkType = false;
        } else {
            valType = '';
            $('button#f5 > i').removeClass('icon-check');
            $('button#f5 > i').addClass('icon-add_circle');
            checkType = true;
        }

    });

    $('#data1-next').click(function () {
        $.ajax({
            method: 'get',
            url: url + "/ticketOffice/publicity/getTypeGroup/" + valType,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');

            },
            success: function (data) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                var i = 0;

                $('#there').removeClass('disabled');
                $('#two').addClass('disabled');
                $('#user-tab-one').addClass('disabled');


                $('ul.tabs').tabs("select", "publicity-tab");

                form(valType,data);

            },
            error: function (e) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }
        });
    });

    $('#register').submit(function (e) {
        if ($('#advertising_type_id').val() !== null && $('#state_location').val() !== null && $('#licor').val() !== null) {
            e.preventDefault();
            var formData = new FormData(this);
            // var image = $('#image')[0].files[0]; // Getting file input data
            // formData.append('image',image);
            $.ajax({
                url: url + "/ticketOffice/publicity/save",
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
                    console.log(resp);
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Se ha registrado la publicidad exitosamente.",
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + "ticketOffice/publicity/show-Ticket-office";
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
        } else {


            if ($('#advertising_type_id').val() === null) {
                swal({
                    title: "Información",
                    text: "Debes selecionar el tipo de publicidad para poder registralar.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });


            } else if ($('#state_location').val() === null) {
                swal({
                    title: "Información",
                    text: "Debes selecionar si la publicidad está ubicada en un espacio reservado de la alcaldía.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

            } else if ($('#licor').val() === null) {

                swal({
                    title: "Información",
                    text: "Debes selecionar si la publicidad hace refencia a cigarrillos o bebidas alcoholicas.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });


            }
        }
    });

    //::::::::UPDATE FOR TICKET OFFICE::::::::::::::::::

    console.log($('#update-publicity'));
    var typePublicity = null;
    $('#update-publicity').click(function () {
        typePublicity = $('#advertising_type_id2').val();
        console.log(typePublicity);
        if (typePublicity == 1) {
            console.log('hola');

            $('#date-begin').addClass('hide');
            $('#date-end').addClass('hide');
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

            $('#block-update').addClass('col s12 m12 center-align');
            $('#block-status').hide();
            $('#block-back').show();


        } else if (typePublicity == 2) {
            $('#date-begin').hide();
            $('#date-end').hide();
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#width').prop('disabled', false);
            $('#height').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

            $('#block-update').addClass('col s12 m12 center-align');
            $('#block-status').hide();
            $('#block-back').show();

        } else if (typePublicity == 3) {
            $('#date-begin').hide();
            $('#date-end').hide();
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#quantity').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

            $('#block-update').addClass('col s12 m12 center-align');
            $('#block-status').hide();
            $('#block-back').show();

        } else if (typePublicity == 4) {
            $('#date-begin').hide();
            $('#date-end').hide();
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#width').prop('disabled', false);
            $('#height').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $('#quantity').prop('disabled', false);
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

            $('#block-update').addClass('col s12 m12 center-align');
            $('#block-status').hide();
            $('#block-back').show();

        } else if (typePublicity == 5) {
            $('#date-begin').hide();
            $('#date-end').hide();
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#width').prop('disabled', false);
            $('#height').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $('#side').prop('disabled', false);
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

            $('#block-update').addClass('col s12 m12 center-align');
            $('#block-status').hide();
            $('#block-back').show();
        }
    });

    $('#update-register').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: url + "publicity/update",
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
                console.log(resp);
                swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha actulizado los datos de la publicidad exitosamente.",
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "green-gradient"
                    }
                }).then(function (accept) {
                    location.reload();
                    //window.location.href = url + "publicity/my-publicity";
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
        var documentOld = $('#ci-uw').val();
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
                url: url + "ticketOffice/publicity/change-user-web/" + type + "/" + document + "/" + id,

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

    $('#publicity-status').on('click', function () {

        var publicityStatus = 0;
        publicityStatus = $(this).val();
        var id = $('#id').val();
        var status = null;

        if (publicityStatus == 'disabled') {
            var status = 'true';

            $.ajax({
                type: "get",
                url: url + "/ticketOffice/publicity/changeStatus/" + id + "/" + status,

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
                            title: "Publicidad",
                            text: data['message'],
                            icon: "success",
                            button: "Ok",
                        });
                        location.reload();
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
                type: "get",
                url: url + "/ticketOffice/publicity/changeStatus/" + id + "/" + status,

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
                            title: "Publicidad",
                            text: data['message'],
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            location.reload();
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

    $('#publicity-previous').click(function () {
        $('#user-tab-one').removeClass('disabled');
        $('#two').addClass('disabled');
        $('ul.tabs').tabs("select", "user-tab");
    });

    $('#publicity-previous2').click(function () {
        //$("#preloader").fadeOut('fast');
        //$("#preloader-overlay").fadeOut('fast');
        //location.reload();
        $('#two').removeClass('disabled');
        $('#there').addClass('disabled');
        $('ul.tabs').tabs("select", "typePublicity-tab");
        typePublicity = 0;
    });

});

function form(valType,data) {
    var template = '';
    var templateForm = '';
    var i=0;


    if (valType == 1) {
        //PUBLICIDAD POR TIEMPO
        //$('#form-3').removeClass('hide');

        templateForm = `<div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="type_id-3">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" minlength="5" maxlength="190">
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-smoking_rooms prefix"></i>
                                <select name="licor" id="licor">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <select name="state_location" id="state_location">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                            </div>`;

        $('#form-1').html(templateForm);


        for (i; i < data.length; i++) {
            template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
            $('#type_id-3').html(template);
            $('select').formSelect();
        }
    } else if (valType == 2) {
        //$('#form-4').removeClass('hide');
        templateForm = `<div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="type_id-4">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" minlength="5" maxlength="190">
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-smoking_rooms prefix"></i>
                                <select name="licor" id="licor">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <select name="state_location" id="state_location">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                            </div>

                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" selected>Metro</option>
                                    <option value="qnt" disabled>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_horizontal prefix"></i>
                                <label for="width">Ancho</label>
                                <input type="text" class="validate only-number-positive number-only-float" maxlength="7" name="width" id="width" value="">
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_vertical prefix"></i>
                                <label for="height">Alto</label>
                                <input type="text" class="validate only-number-positive number-only-float" maxlength="1" name="height" id="height" value="">
                            </div>`;

        $('#form-1').html(templateForm);


        for (i; i < data.length; i++) {
            template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
            $('#type_id-4').html(template);
            $('select').formSelect();
        }
    } else if (valType == 3) {
        //$('#form-2').removeClass('hide');

        templateForm = `  <div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="type_id-2">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-smoking_rooms prefix"></i>
                                <select name="licor" id="licor">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <select name="state_location" id="state_location">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" minlength="5" maxlength="190">
                                <label for="name">Nombre</label>
                            </div>
                           
                            <div class="col s12 input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" disabled>Metro</option>
                                    <option value="qnt" selected>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="icon-chrome_reader_mode prefix"></i>
                                <input type="text" class="validate only-number-positive number-date" maxlength="9" name="quantity" id="quantity">
                                <label for="quantity">Ejemplares</label>
                            </div>`;

        $('#form-1').html(templateForm);

        for (i; i < data.length; i++) {
            template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
            $('#type_id-2').html(template);
            $('select').formSelect();
        }
    } else if (valType == 4) {
        //$('#form-1').removeClass('hide');

        templateForm = `<div class="input-field col s12">
            <i class="icon-linked_camera prefix"></i>
            <select name="advertising_type_id" id="type_id-1">
            <option value="null" disabled selected>Elija un tipo</option>
        </select>
        <label>Tipo de Publicidad</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="icon-smoking_rooms prefix"></i>
            <select name="licor" id="licor">
            <option value="" disabled selected>Elija una opción</option>
        <option value="SI">SI</option>
            <option value="NO">NO</option>
            </select>
            <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
        </div>
        <div class="input-field col s12 m6">
            <i class="icon-my_location prefix"></i>
            <select name="state_location" id="state_location">
            <option value="" disabled selected>Elija una opción</option>
        <option value="SI">SI</option>
            <option value="NO">NO</option>
            </select>
            <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
        </div>

        <div class="input-field col s12">
            <i class="icon-format_size prefix"></i>
            <input type="text" name="name" id="name" minlength="5" maxlength="190">
            <label for="name">Nombre</label>
            </div>
            <div class="col s12">
      
        <div class="col s12 input-field">
            <i class="icon-straighten prefix"></i>
            <select name="unit" id="unit">
            <option value="null" disabled>Elige la unidad</option>
        <option value="mts" selected>Metro</option>
        <option value="qnt" disabled>Cantidad</option>
        </select>
        <label>Unidad</label>
        </div>
        <div class="input-field col s12 m6">
            <i class="icon-panorama_horizontal prefix"></i>
            <label for="width">Ancho</label>
            <input type="text" class="validate only-number-positive number-only-float" name="width" id="width" maxlength="5" value="">
            </div>
            <div class="input-field col s12 m6">
            <i class="icon-panorama_vertical prefix"></i>
            <label for="height">Alto</label>
            <input type="text" class="validate only-number-positive number-only-float" name="height" id="height" maxlength="5" value="">
            </div>
            <div class="input-field col s12">
            <i class="icon-exposure_plus_1 prefix"></i>
            <input type="text" class="validate only-number-positive number-date" maxlength="4" name="quantity" id="quantity">
            <label for="quantity">Cantidad de Lugares</label>
        </div>`;

        $('#form-1').html(templateForm);

        for (i; i < data.length; i++) {
            template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
            $('#type_id-1').html(template);
            $('select').formSelect();
        }
    } else if (valType == 5) {
        templateForm = `<div class="input-field col s12">
                                <i class="icon-linked_camera prefix"></i>
                                <select name="advertising_type_id" id="type_id-5">
                                    <option value="null" disabled selected>Elija un tipo</option>
                                </select>
                                <label>Tipo de Publicidad</label>
                            </div>
                            
                            <div class="input-field col s12">
                                <i class="icon-format_size prefix"></i>
                                <input type="text" name="name" id="name" minlength="5" maxlength="190">
                                <label for="name">Nombre</label>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="icon-smoking_rooms prefix"></i>
                                <select name="licor" id="licor">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad hace refencia a cigarrillos o bebidas alcoholicas?</label>
                            </div>
                            
                            <div class="input-field col s12 m6">
                                <i class="icon-my_location prefix"></i>
                                <select name="state_location" id="state_location">
                                    <option value="" disabled selected>Elija una opción</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                <label>¿Su publicidad está ubicada en un espacio reservado de la alcaldía?</label>
                            </div>

                            <div class="col s12  input-field">
                                <i class="icon-straighten prefix"></i>
                                <select name="unit" id="unit">
                                    <option value="null" disabled>Elige la unidad</option>
                                    <option value="mts" selected>Metro</option>
                                    <option value="qnt" disabled>Cantidad</option>
                                </select>
                                <label>Unidad</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_horizontal prefix"></i>
                                <label for="width">Ancho</label>
                                <input type="text" class="validate only-number-positive number-only-float" maxlength="7" name="width" id="width" value="">
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="icon-panorama_vertical prefix"></i>
                                <label for="height">Alto</label>
                                <input type="text" class="validate only-number-positive number-only-float" maxlength="1"  name="height" id="height" value="">
                            </div>
                            <div class="input-field col s12 ">
                                <i class="icon-exposure_plus_1 prefix"></i>
                                <input type="text" class="validate only-number-positive number-only-float" maxlength="2" name="side" id="side">
                                <label for="side">Cantidad de Caras</label>
                            </div>
`;

        $('#form-1').html(templateForm);
        for (i; i < data.length; i++) {
            template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
            $('#type_id-5').html(template);
            $('select').formSelect();
        }
    }

    $('.validate.number-only').keyup(function (){
        this.value = (this.value + '').replace(/[^.,0-9]/g, '');
    });

    $('.validate.number-and-capital-letter-only').keyup(function (){
        this.value = (this.value + '').replace(/[^A-Z0-9]/g, '');
    });

    $('.validate.number-only-float').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9.]/g, '');
    });

    $('.validate.number-date').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

    $('.validate.code-only').keyup(function (){
        this.value = (this.value + '').replace(/[^A-Z0-9-]/g, '');

    });

    $('.only-number-positive').change(function () {
        if($(this).val()<1) {
            swal({
                title: "Información",
                text: "El campo no debe ser mayor o igual 1.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $(this).val('');
        }
    });

    $('.validate.text-validate').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Z ]/g, '');
    });

    $('.validate.serial-vehicle').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Z0-9-]/g, '');

    });
}




