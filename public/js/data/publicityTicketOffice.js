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

    $('#form-1').hide();
    $('#form-2').hide();
    $('#form-3').hide();
    $('#form-4').hide();
    $('#form-5').hide();


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
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                 <i class="icon-person prefix"></i>
                 <input id="name" type="text" name="name" class="validate rate" data-validate="nombre"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." required>
                 <label for="name">Nombre</label>
            </div>
            <div class="input-field col s12 m12">
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

    function findDocument() {
        var type_document = $('#type_document_full').val();
        var document = $('#document_full').val();
        $('#surname_full').val('');
        $('#user_name_full').val('');
        $('#type').val('');
        $('#address_full').val('');
        $('#name_full').val('');
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
                            $('#name').val(user.nombres + ' ' + user.apellidos);
                            $('#name').attr('readonly', '');
                            $('#surname').val(user.apellidos);
                            $('#user_name').val(user.nombres);
                            $('#type').val('user');
                            $('#address').prop('readonly', false);

                        } else if (response.type == 'user') {

                            var user = response.user;
                            $('#name').val(user.name + ' ' + user.surname);
                            $('#name').attr('readonly', '');
                            $('#surname').val(user.surname);
                            $('#person_id').val(user.id);
                            $('#type').val('user');
                            $('#address').val(user.address);
                            $('#address').attr('readonly', '');

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

        if ($('#type').val() == 'company') {
            status = 'propietario';
        }
        var type_document = $('#type_document_full').val();

        if(type_document === 'J' || type_document === 'G') {
            var name_full = $('#name_full').val();
            var address = $('#address').val();
            var document_full = $('#document_full').val();

            if (name_full === '' && address === '' && document_full === '') {
                swal({
                    title: "Información",
                    text: "Debe ingresar el documento de identificación para continuar con el registro.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }

        } else if ((status == null || status == '')) {
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

            $('#two').removeClass('disabled');
            $('#one').addClass('disabled');
            $('ul.tabs').tabs("select", "typePublicity-tab");
        }
        else if(status !== 'propietario') {
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
            }else if($('#document').val() == ''){
                swal({
                    title: "Información",
                    text: "Debe introducir el documento de la persona responsable.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }else{
                $('#two').removeClass('disabled');
                $('#one').addClass('disabled');
                $('ul.tabs').tabs("select", "vehicle-tab");
            }
        }
        else {
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

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        surname: surname,
                        type_document: type_document,
                        document: document,
                        address: address,
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

                var template = '';


                if (valType == 1) {
                    //PUBLICIDAD POR TIEMPO
                    //$('#form-3').removeClass('hide');
                    $('#form-3').show();
                    $('#form-1').remove();
                    $('#form-2').remove();
                    $('#form-4').remove();
                    $('#form-5').remove();
                    for (i; i < data.length; i++) {
                        template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
                        $('#type_id-3').html(template);
                        $('select').formSelect();
                    }
                } else if (valType == 2) {
                    //$('#form-4').removeClass('hide');
                    $('#form-4').show();
                    $('#form-1').remove();
                    $('#form-2').remove();
                    $('#form-3').remove();
                    $('#form-5').remove();
                    for (i; i < data.length; i++) {
                        template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
                        $('#type_id-4').html(template);
                        $('select').formSelect();
                    }
                } else if (valType == 3) {
                    //$('#form-2').removeClass('hide');
                    $('#form-2').show();
                    $('#form-1').remove();
                    $('#form-4').remove();
                    $('#form-3').remove();
                    $('#form-5').remove();
                    for (i; i < data.length; i++) {
                        template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
                        $('#type_id-2').html(template);
                        $('select').formSelect();
                    }
                } else if (valType == 4) {
                    //$('#form-1').removeClass('hide');
                    $('#form-1').show();
                    $('#form-2').remove();
                    $('#form-4').remove();
                    $('#form-3').remove();
                    $('#form-5').remove();
                    for (i; i < data.length; i++) {
                        template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
                        $('#type_id-1').html(template);
                        $('select').formSelect();
                    }
                } else if (valType == 5) {
                    //$('#form-5').removeClass('hide');
                    $('#form-5').show();
                    $('#form-1').remove();
                    $('#form-4').remove();
                    $('#form-3').remove();
                    $('#form-2').remove();
                    for (i; i < data.length; i++) {
                        template += `<option value="${data[i]['id']}">${data[i]['name']}</option>`;
                        $('#type_id-5').html(template);
                        $('select').formSelect();
                    }
                }

                $('ul.tabs').tabs("select", "publicity-tab");

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

    $('#update-publicity').click(function () {
        var typePublicity = $('#advertising_type_id2').val();
        if (typePublicity == 1) {
            $('#date-begin').hide();
            $('#date-end').hide();
            $('#U-date-begin').removeClass('hide');
            $('#U-date-end').removeClass('hide');
            $('#name').prop('disabled', false);
            $('#licor').prop('disabled', false);
            $('select').formSelect();
            $('#state_location').prop('disabled', false);
            $('select').formSelect();
            $(this).hide();
            $('#update-publicity-save').removeClass('hide');

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


});




