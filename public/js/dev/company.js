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
                button: "Ok",
            });
            $('#RIF').val('');
        }
    });


    $('#document_type').change(function () {
        if ($('#RIF').val() !== '' && $('#document_type').val() !== null) {
            verifyRIF();
        }
    });

    $('#parish').change(function () {
        $('#sector').text('');


        var sector = [{
            id: [1,9,10,4],
            name: 'NORTE',
            prefix:'NORTE',
            status: false
        },{
            id: [2],
            name: 'OESTE',
            prefix:'OESTE',
            status: false
        }, {
            id: [3],
            name: 'CENTRO',
            prefix:'CENTRO',
            status: false
        }, {
            id: [4],
            name: 'ZONA INDUSTRIAL I',
            prefix:'INDUSI',

            status: false

        },{
            id: [4],
            name: 'ZONA INDUSTRIAL II',
            status: false,
            prefix:'INDUSII' ,

        },{
            id: [6],
            name: 'ZONA INDUSTRIAL III',
            status: false,
            prefix:'INDUSIII',

        }, {
            id: [8],
            name: 'ESTE',
            status: false,
            prefix:'ESTE',
        }


        ];
        for (var i = 0; i < sector.length; i++) {
            for(var j=0;j<sector[i].id.length; j++){

                if(sector[i].id[j]==$(this).val()){
                    sector[i].status=true;
                }
            }
        }

        var html = '<option value="null" disabled selected>Seleccionar Ubicación</option>';
        for (var i = 0; i < sector.length; i++) {
            if (sector[i].status === true) {
                html += '<option value='+sector[i].prefix+'>' + sector[i].name + '</option>'
            }

        }

        console.log(html);


        $('#sector').append(html);
        $('select').formSelect();
    });


    $('#license').blur(function () {
        if ($('#license').val() !== '') {
            var license = $('#license').val();
            $.ajax({
                method: "GET",
                url: url + "company/verify-license/" + license,
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
                            button: "Ok",
                        });

                        $('#license').val('');

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
                        button: "Ok",
                    });
                }
            });
        }
    });


    $('#company-register').on('submit', function (e) {
        e.preventDefault();
        if ($('#lat').val() !== "") {
            if ($('#sector').val() !== null && $('#parish').val() !== null) {
                if ($('#ciu').val() !== undefined) {
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
                                text: "Empresa Registrada con Éxito.",
                                icon: "success",
                                button: "Ok",
                            }).then(function (accept) {
                                window.location.href = url + "companies/my-business";
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
                    swal({
                        title: "¡Oh no!",
                        text: "Debe tener al menos un ciiu para poder registrar una empresa..",
                        icon: "warning",
                        button: "Ok",
                    });
                }

            } else {

                if ($('#sector').val() === null) {
                    swal({
                        title: "Información",
                        text: "Seleciona un sector para completar el registro.",
                        icon: "info",
                        button: "Ok",
                    });
                } else {
                    swal({
                        title: "Información",
                        text: "Seleciona la parroquia para completar el registro.",
                        icon: "info",
                        button: "Ok",
                    });
                }

            }
        } else {
            swal({
                title: "Información",
                text: "Debe ubicar su empresa en el mapa, para poder completar el registro.",
                icon: "info",
                button: "Ok",
            });
        }

    });


    $('#phone').keyup(function () {
        if ($('#country_code_company').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar una operadora valida, antes de ingresar el número telefónico.",
                icon: "info",
                button: "Ok",
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
                button: "Ok",
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
                        button: "Ok",
                    });
                }
            });

        } else {
            console.log("epa");
            acum = "<option disabled selected>Selecione una Rama</option>";
            $("#ciu").html(acum);
            $('select').formSelect();
        }

    });


    $('#search-ciu').click(function () {
        var code = $('#code').val();
        var band = true;

        $.ajax({
            type: "GET",
            url: url + "ciu/find/" + code,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {


                if (response.status !== 'error') {
                    var subr = response.ciu.name.substr(0, 3);
                    var template = `<div>
                                <input type="hidden" name="ciu[]" id="ciu" class="ciu" value="${response.ciu.id}">
                                <div class="input-field col s12 m5">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  disabled value="${response.ciu.code}">
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="name-ciu" id="${subr}" cols="30" rows="10" class="materialize-textarea" disabled required>${response.ciu.name}</textarea>
                                </div>

                                <div class="input-field col s12 m1">
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
                                    button: "Ok",
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

                    M.textareaAutoResize($('#' + subr));
                    M.updateTextFields();
                } else {

                    swal({
                        title: "¡Oh no! ",
                        text: "El ciiu ingresado no está registrado, verifica. quizás te equivocaste al ingresarlo al sistema.",
                        icon: "warning",
                        button: "Ok",
                    });

                }


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


        $('#company-register-ticket').submit(function (e) {
            e.preventDefault();
            if ($('#sector').val() !== null && $('#parish').val() !== null) {
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
                            text: "Empresa Registrada con Éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            window.location.href = url + "ticketOffice/companies/all";
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
                if ($('#sector').val() === null) {
                    swal({
                        title: "Información",
                        text: "Seleciona un sector para completar el registro.",
                        icon: "info",
                        button: "Ok",
                    });
                } else {
                    swal({
                        title: "Información",
                        text: "Seleciona la parroquia para completar el registro.",
                        icon: "info",
                        button: "Ok",
                    });
                }

            }
        });


    });


    $('#user-next').click(function () {
        $('ul.tabs').tabs();
        $('ul.tabs').tabs("select", "company-tab");
    });


    $('#company-next').click(function () {
        $('ul.tabs').tabs();
        $('ul.tabs').tabs("select", "map-tab");
    });


    $('#company-previous').click(function () {
        $('ul.tabs').tabs();
        $('ul.tabs').tabs("select", "user-tab");
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
                        button: "Ok",
                    });
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    $('#RIF').val("");
                    $('#RIF').addClass('validate');
                } else {
                    findCompany(rif);
                }

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
                    className: "red"

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
                    $('#RIF').val(company.rif.substr(1));
                    $('#license').val(company.codigo_licencia);
                    $('#address').val(company.direccion);
                    $('#phone-company').val(company.telefono_principal);


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

            },
            error: function (err) {
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


function initMap() {
    function removeItemFromArr(arr, item) {
        var i = arr.indexOf(item);

        if (i !== -1) {
            arr.splice(i, 1);
        }
    }

    var marcadores = [];
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat: 10.0736954, lng: -69.3498597}
    });

    map.addListener('click', function (e) {
        addMark(e.latLng, map);
    });

    var image = 'https://sysprim.com/images/mark-map.png';

    function addMark(latLng, map) {
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
                title: "¡Oh no!",
                text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
                icon: "error",
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
}



