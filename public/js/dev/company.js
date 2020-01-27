$(document).ready(function () {

    var url = "http://sysprim.com.devel/";


    $('#RIF').blur(function () {
        if ($('#RIF').val() !== '' && $('#document_type').val() !== null) {
            verifyRIF();
        }
    });


    $('#RIF').keyup(function () {
        if ($('#document_type').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar el tipo de documento, antes de ingresar el número de RIF.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#RIF').val('');
        }
    });


    $('#document_type').change(function () {
        if ($('#RIF').val() !== '' && $('#document_type').val() !== null) {
            verifyRIF();
        }
    });


    function filterByParish(parish_id) {
        var sector = [{
            id: [9, 10, 4, 6, 10],
            name: 'NORTE',
            prefix: 'NORTE',
            status: false
        }, {
            id: [2, 6],
            name: 'OESTE',
            prefix: 'OESTE',
            status: false
        }, {
            id: [1, 3],
            name: 'CENTRO',
            prefix: 'CENTRO',
            status: false
        }, {
            id: [4],
            name: 'ZONA INDUSTRIAL I',
            prefix: 'INDUSI',

            status: false

        }, {
            id: [4],
            name: 'ZONA INDUSTRIAL II',
            status: false,
            prefix: 'INDUSII',

        }, {
            id: [2],
            name: 'ZONA INDUSTRIAL III',
            status: false,
            prefix: 'INDUSIII',

        }, {
            id: [8],
            name: 'ESTE',
            status: false,
            prefix: 'ESTE',
        },
            {
                id: [7, 5],
                name: 'SUR',
                status: false,
                prefix: 'ESTE',
            }


        ];
        for (var i = 0; i < sector.length; i++) {
            for (var j = 0; j < sector[i].id.length; j++) {

                if (sector[i].id[j] == parish_id) {
                    sector[i].status = true;
                }
            }
        }

        var html = '<option value="null" disabled selected>Seleccionar Ubicación</option>';
        for (var i = 0; i < sector.length; i++) {
            if (sector[i].status === true) {
                html += '<option value=' + sector[i].prefix + '>' + sector[i].name + '</option>'
            }

        }

        $('#sector').append(html);
        $('select').formSelect();
    }

    $('#parish').change(function () {
        $('#sector').text('');
        filterByParish($(this).val());
    });


    $('#license').blur(function () {
        var license = $('#license').val();
        var rif = $('#document_type').val() + $('#RIF').val();
        verifylicense(license, rif);
    });


    function verifylicense(license, rif) {


        if (license !== '') {
            $.ajax({
                method: "GET",
                url: url + "company/verify-license/" + license + "/" + rif,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    console.log(response);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: {
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });
                        $('#license').val('');
                    }

                },
                error: function (err) {
                    console.log(err);
                    $('#license').val('');
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
    }


    $('#company-register').on('submit', function (e) {
        e.preventDefault();

        $('#button-company').attr('disabled', 'disabled');


        if ($('#lat').val() !== "") {
            if ($('#sector').val() !== null && $('#parish').val() !== null) {
                if ($('#ciu').val() !== undefined || $('#question_license').val() == 'false') {
                    $.ajax({
                        url: url + "companies/save",
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
                                text: "La empresa se ha registrado con éxito.",
                                icon: "success",
                                button: {
                                    text: "Esta bien",
                                    className: "green-gradient"
                                },
                            }).then(function (accept) {
                                window.location.href = url + "companies/my-business";
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
                } else {
                    $('#button-company').removeAttr('disabled', '');
                    swal({
                        title: "Información",
                        text: "Debe tener al menos un ciiu para poder registrar una empresa..",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });

                }

            } else {

                if ($('#sector').val() === null) {
                    swal({
                        title: "Información",
                        text: "Selecione un sector para completar el registro.",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                } else {
                    swal({
                        title: "Información",
                        text: "Selecione la parroquia para completar el registro.",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                }
                $('#button-company').removeAttr('disabled', '');
            }
        } else {
            swal({
                title: "Información",
                text: "Debe ubicar su empresa en el mapa, para poder completar el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#button-company').removeAttr('disabled', '');
        }

    });


    $('#phone').keyup(function () {
        if ($('#country_code_company').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar una operadora valida, antes de ingresar el número telefónico.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });

            $('#phone').val('');
        }
    });


    $('#phone_company').keyup(function () {
        if ($('#country_code_company').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar una operadora valida, antes de ingresar el número telefónico.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });

            $('#phone_company').val('');
        }
    });


    $('#ciu_group').change(function () {
        var id = $(this).val();
        console.log(id);
        if (id.length >= 1) {
            $.ajax({
                type: "POST",
                url: url + "ciu/filter-group",
                data: {id: id},


                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    var ciu = response[0].ciu;
                    var acum = "<option disabled selected>Elige una rama</option>";
                    //compruebo si viene vacio el array de objetos
                    if (response[0] === null) {
                        acum = "<option disabled selected>No hay rama asociada a esa categoria</option>";
                    } else {//si no viene vacio lo recorro
                        for (var i = 0; i < ciu.length; i++) {
                            var ciu_group = ciu[i];
                            for (var j = 0; j < ciu_group.length; j++) {
                                acum += '<option value=' + ciu_group[j].id + '>' + ciu_group[j].name + '</option>';
                            }
                        }
                    }

                    //finalmente suplanto el contenido del select
                    $("#ciu").html(acum);
                    $('select').formSelect();

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
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });

        } else {
            acum = "<option disabled selected>Selecione una Rama</option>";
            $("#ciu").html(acum);
            $('select').formSelect();
        }

    });


    $('#search-ciu').click(function () {
        var code = $('#code').val();


        var band = true;
        if (code !== "") {
            $.ajax({
                type: "GET",
                url: url + "ciu/find/" + code,
                beforeSend: function () {
                    $('#search-ciu').attr('disabled', 'disabled');
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $('#search-ciu').removeAttr('disabled', '');
                    if (response.status !== 'error') {
                        var subr = response.ciu.name.substr(0, 3);
                        var template = `<div>
                                <input type="hidden" name="ciu[]" id="ciu" class="ciu" value="${response.ciu.id}">
                                <div class="input-field col s12 m5">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  disabled value="${response.ciu.code}" >
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m5"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="name-ciu" id="${subr + response.ciu.code}" cols="30" rows="10" class="materialize-textarea" disabled required>${response.ciu.name}</textarea>
                                </div>

                                <div class="input-field col s12 m2">
                                    <button  class="btn waves-effect waves-light peach col s12 delete-ciu"><i class="icon-close"></i>
                                    </button>
                                </div>
                            </div>
                        `;


                        if ($('.ciu').val() !== undefined) {
                            $('.ciu').each(function (index, value) {
                                if ($(this).val() == response.ciu.id) {
                                    swal({
                                        title: "¡Oh no!",
                                        text: "El ciiu " + response.ciu.code + " ya  esta ingresado en esta empresa.",
                                        icon: "warning",
                                        button: {
                                            text: "Entendido",
                                            className: "red-gradient"
                                        },
                                    });
                                    $('#code').val("");
                                    band = false;
                                }

                            });


                            if (band) {
                                $('#group-ciu').append(template);
                                confirmCiu();
                            }


                        } else {
                            $('#group-ciu').append(template);
                            confirmCiu();
                        }

                        $('.delete-ciu').click(function () {
                            $(this).parent().parent().text("");
                        });

                        M.textareaAutoResize($('#' + subr + response.ciu.code));
                        M.updateTextFields();
                    } else {
                        swal({
                            title: "Información",
                            text: "El CIIU que ingresó no se encuentra registrado en el sistema.",
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });


                    }


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                },
                error: function (err) {
                    $('#search-ciu').removeAttr('disabled', '');
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
            swal({
                title: "Información",
                text: "Debe ingresar un CIIU valido.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
        });

        $('#company-register-ticket').submit(function (e) {
            e.preventDefault();

            console.log(e);



            if ($('#sector').val() !== null && $('#parish').val() !== null) {

                $('#button-company').attr('disabled','disabled');

                $.ajax({
                    url: url + "ticketOffice/company/save",
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
                            text: "La empresa ha sido registrada con éxito.",
                            icon: "success",
                            button:{
                                text: "Esta bien",
                                className: "green-gradient"
                            },
                        }).then(function (accept) {
                            if(accept){
                                window.location.href = url + "ticketOffice/companies/all";
                            }
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                    },
                    error: function (err) {
                        $('#button-company').removeAttr('disabled','');
                        console.log(err);
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Oh no!",
                            text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                            icon: "error",
                            button:{
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });
                    }
                });
            } else {
                if ($('#sector').val() === null) {
                    swal({
                        title: "Información",
                        text: "Seleciona un sector para completar el registro.",
                        icon: "info",
                        button:{
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                } else {
                    swal({
                        title: "Información",
                        text: "Seleciona la parroquia para completar el registro.",
                        icon: "info",
                        button:{
                            text: "Esta bien",
                            className: "blue-gradient"
                        }
                    });
                }

            }
        });




        function verifyRIF() {
            var rif = $('#document_type').val() + $('#RIF').val();
            $.ajax({
                method: "GET",
                url: url + "company/verify-rif/" + rif,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        var company = response.company[0];
                        $('#name').val(company.name);
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    } else {
                        if (response.status === 'registered') {
                            var company = response.company[0];
                        } else {
                            findCompany(rif);
                        }

                    }
                    M.updateTextFields();

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
                    $('#RIF').val(' ');
                }
            });
        }


        function confirmCiu() {
            swal({
                title: "¡Bien Hecho!",
                text: "CIIU  ingresado con éxito, ¿Desea añadir otro CIIU? ",
                icon: "info",
                buttons: {
                    confirm: {
                        text: "Si",
                        value: true,
                        visible: true,
                        className: "amber-gradient"

                    },
                    cancel: {
                        text: "No",
                        value: false,
                        visible: true,
                        className: "grey lighten-2"
                    }
                }
            }).then(function (aceptar) {
                if (aceptar) {
                    $('#code').focus();
                    $('#code').val('');
                } else {

                    if ($('#user-next').val() !== undefined) {
                        $('ul.tabs').tabs();
                        $('ul.tabs').tabs("select", "map-tab");

                    } else {
                        var focalizar = $("div#div-map").position().top;
                        $('html,body').animate({scrollTop: focalizar}, 1000);
                    }


                }
            });

        }

        function findCompany(rif) {

            $.ajax({
                method: "GET",
                url: url + "company/find/" + rif.toUpperCase(),
                beforeSend: function () {

                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    console.log(response);

                    if (response.status === 'success') {
                        var company = response.company;

                        $('#name').val(company.historico_nombre_empresa);
                        $('#name_company').val(company.historico_nombre_empresa);
                        $('#RIF').val(company.rif.substr(1));
                        $('#license').val(company.codigo_licencia);
                        $('#address').val(company.direccion);
                        $('#phone-company').val(company.telefono_principal);
                        if (company.direccion !== '') {
                            localizar("map", "Venezuela, Baquisimeto Estado Lara " + company.direccion);
                        }
                        if ($('#ci-license').val() !== undefined) {
                            $('#name_company').val(company.historico_nombre_empresa);
                            $('#ci-license').val(company.historico_cedula);
                            $('#phone-user').val(company.telefono_principal);
                            $('#name-license').val(company.historico_nombre_representante);
                            $('#email').val(company.email);
                        }
                        M.textareaAutoResize($('#address'));
                        M.updateTextFields();

                    }
                    if (response.status === 'registered') {

                        swal({
                            title: "Información",
                            text: "Empresa encontrada con éxito, verifique que  los datos encontrados son los correctos, complete los CIIU, código catastral y número de empleados, y confirme su ubicación en el mapa.",
                            icon: "success",
                            button: "Ok",
                        });


                        var company = response.company;
                        $('#name').val(company.name);
                        $('#license').val(company.license);
                        $('#address').val(company.address);
                        $('#phone').val(company.phone);
                        $("#parish option").each(function () {
                            if ($(this).val() == company.parish_id) {
                                $(this).attr("selected", true);
                            }
                        });
                        $('#parish').formSelect();
                        filterByParish(company.parish_id);

                        $("#country_code_company option").each(function () {
                            if ($(this).val() == company.operator) {
                                $(this).attr("selected", true);
                            }
                        });

                        $("#sector option").each(function () {
                            if ($(this).val() == company.sector) {
                                $(this).attr("selected", true);
                            }
                        });
                        $('#sector').formSelect();
                        $('#country_code_company').formSelect();
                        $('#phone').val(company.numberPhone);

                        var lat = parseFloat(company.lat);
                        var lng = parseFloat(company.lng);

                        var marcadores = [];

                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 15,
                            center: {lat: lat, lng: lng}
                        });

                        addMark({lat: lat, lng: lng}, map, marcadores);
                        map.addListener('click', function (e) {
                            addMark(e.latLng, map, marcadores);
                        });

                        M.textareaAutoResize($('#address'));
                        M.updateTextFields();
                    }

                },
                error: function (err) {
                    $('#license').val('');
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

        $('#number_employees').change(function () {
            var value = $(this).val();
            if (value < 0) {
                $(this).val(1);
            }
        });


        $('#question_license').change(function () {
            var questions_license = $('#question_license').val();

            console.log(questions_license);


            if (questions_license == 'true') {

                swal({
                    title: "Información",
                    text: "Ingrese el numero de licencia otorgado y su código catastral.",
                    icon: "info",
                    button: "Ok",
                });
                $('#license').removeAttr('disabled', '');
                $('#code_catastral').removeAttr('disabled', '');
                $('#code').removeAttr('disabled', '');

            } else {
                $('#license').attr('disabled', '');
                $('#code_catastral').attr('disabled', '');
                $('#code').attr('disabled', '');
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


                $('#company-tab-two').removeClass('disabled');
                $('ul.tabs').tabs();
                $('ul.tabs').tabs("select", "company-tab");

            }

        });


        $('#company-next').click(function () {
            var band = true;


            console.log($('#question_license').val());


            $('.company-validate').each(function () {
                if (($(this).val() === '' || $(this).val() === null) && ($('#question_license').val() != 'false') && ($(this).attr('data-validate') == 'licencia'||$(this).attr('data-validate')=='Código Catastral')) {

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
                } else if ($('#question_license').val() !== 'false' && $('#ciu').val() === undefined) {
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





    function localizar(elemento, direccion) {
        var geocoder = new google.maps.Geocoder();
        var marcadores = [];


        var map = new google.maps.Map(document.getElementById(elemento), {
            zoom: 15,
            scrollwheel: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            restriction: {latLngBounds: {north: 83.8, south: -57, west: -180, east: 180}}
        });

        geocoder.geocode({'address': direccion}, function (results, status) {


            if (status === 'OK') {
                var resultados = results[0].geometry.location,
                    resultados_lat = resultados.lat(),
                    resultados_long = resultados.lng();

                map.setCenter(results[0].geometry.location);


                map.addListener('click', function (e) {
                    addMark(e.latLng, map, marcadores);
                });


            } else {
                var mensajeError = "";
                if (status === "ZERO_RESULTS") {
                    mensajeError = "No hubo resultados para la dirección ingresada.";
                    initMap();
                } else if (status === "OVER_QUERY_LIMIT" || status === "REQUEST_DENIED" || status === "UNKNOWN_ERROR") {
                    mensajeError = "Error general del mapa.";
                } else if (status === "INVALID_REQUEST") {
                    mensajeError = "Error de la web. Contacte con Name Agency.";
                }
                alert(mensajeError);
            }
        });
    }


    $('#address').change(function () {
        var direccion = $(this).val();
        if (direccion !== '') {
            localizar("map", "Venezuela, Baquisimeto Estado Lara. " + direccion);
        }
    });
});

    function initMap() {
        var marcadores = [];
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: {lat: 10.0736954, lng: -69.3498597}
        });

        map.addListener('click', function (e) {
            console.log(e.latLng);
            addMark(e.latLng, map, marcadores);
        });

    }

    //    swal({
    //        title: "Información",
    //        text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
    //        icon: "info",
    //        button:{
    //            text: "Esta bien",
    //            className: "blue-gradient"
    //        },
    //    });
    // else {
    //    $('#lng').val(marcadores[0].getPosition().lng());
    //    $('#lat').val(marcadores[0].getPosition().lat());
    //    M.updateTextFields();

    function addMark(latLng, map, marcadores) {


        function removeItemFromArr(arr, item) {
            var i = arr.indexOf(item);

            if (i !== -1) {
                arr.splice(i, 1);
            }
        }


        var image = 'https://sysprim.com/images/mark-map.png';


        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: image,
            title: "ESTOY AQUÍ",
            animation: google.maps.Animation.BOUNCE
        });
        map.panTo(latLng);

        marcadores.push(marker);

        if (marcadores.length > 1) {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null);

            swal({
                title: "Información",
                text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
                icon: "info",
                button: "Ok",
            });
        } else {
            $('#lng').val(marcadores[0].getPosition().lng());
            $('#lat').val(marcadores[0].getPosition().lat());
            M.updateTextFields();
        }
        google.maps.event.addListener(marker, 'click', function () {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null); //borramos el marcador del mapa
            $('#lng').val(" ");
            $('#lat').val(" ")
        });
        console.log(marcadores[0].getPosition().lat() + '-' + marcadores[0].getPosition().lng());
    }

