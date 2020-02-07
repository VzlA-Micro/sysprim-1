$(document).ready(function () {

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
                                   title="Solo puede agregar letras (con acentos)." required readonly> 
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
                            $('#name_full').attr('readonly');
                            $('#surname_full').val(user.surname);
                            $('#id').val(user.id);
                            $('#type').val('user');
                            $('#address_full').val(user.address);
                            $('#address_full').attr('readonly', '');


                        } else if (response.type == 'company') {
                            var company = response.company;
                            $('#name_full').val(company.name);
                            $('#address_full').val(company.address);
                            $('#name_full').attr('readonly');
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
                            $('#name').attr('readonly');
                            $('#surname').val(user.apellidos);
                            $('#user_name').val(user.nombres);
                            $('#type').val('user');
                            $('#address').removeAttr('readonly', '');

                        } else if (response.type == 'user') {

                            var user = response.user;
                            $('#name').val(user.name + ' ' + user.surname);
                            $('#name').attr('readonly');
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


        if ((status == null || status == '')) {
            swal({
                title: "Información",
                text: "Debe seleccionar una condicion legal para continuar con el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else if (status == 'propietario') {
            $('#two').removeClass('disabled');
            $('#one').addClass('disabled');
            $('ul.tabs').tabs("select", "property-tab");
        } else {

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
                        $('ul.tabs').tabs("select", "property-tab");
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
                $('ul.tabs').tabs("select", "property-tab");
            }
        }
    });


    $('#property').on('submit', function (e) {
        var type = $('#type').val();
        var id = $('#id').val();
        e.preventDefault();


        if($('#location_cadastral').val()!=null&&$('#type_const').val()!=null&&$('#type_inmueble_id').val()!=null&&$('#parish').val()!=null&&$('#lat').val() !== "") {
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
                        window.location.href = url + "property/ticket-office/read-property";
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
        }else{
            if ($('#location_cadastral').val() == null) {
                swal({
                    title: "Información",
                    text: "Seleciona la ubicación castrastral para completar el registro.",
                    icon: "info",
                    button:{
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            } else if($('#type_const').val()==null) {
                swal({
                    title: "Información",
                    text: "Seleciona el tipo  de construcción para completar el registro.",
                    icon: "info",
                    button:{
                        text: "Esta bien",
                        className: "blue-gradient"
                    }
                });
            }else if($('#type_inmueble_id').val()==null){
                swal({
                    title: "Información",
                    text: "Seleciona el tipo  de inmueble para completar el registro.",
                    icon: "info",
                    button:{
                        text: "Esta bien",
                        className: "blue-gradient"
                    }
                });
            }else if($('#parish').val()==null){
                swal({
                    title: "Información",
                    text: "Seleciona la parroquia  para completar el registro.",
                    icon: "info",
                    button:{
                        text: "Esta bien",
                        className: "blue-gradient"
                    }
                });
            }else if($('#lat').val()== ""){
                swal({
                    title: "Información",
                    text: "Debe ubicar su empresa en el mapa, para poder completar el registro.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }
        }




    });



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


    var image = 'http://sysprim.com/images/mark-map.png';


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