$('document').ready(function () {

    var url = localStorage.getItem('url');

    $('#edit-btn').click(function () {

        console.log('epa');
        $('#update-btn').removeClass('hide');
        $('#location_cadastral').removeAttr('disabled', '');
        $('#type_const').removeAttr('disabled', '');
        $('#area_ground').removeAttr('readonly');
        $('#area_build').removeAttr('readonly');
        $('#type_inmueble_id').removeAttr('disabled', '');
        $('#parish').removeAttr('disabled', '');
        $('#address').removeAttr('disabled');
        $('#block-owner').hide();
        $('#block-location').hide();
        $('#block-edit').addClass('col s12 m12 center-align');
        $('#block-type').show();
        $('#block-ubication').removeClass();
        $('#block-ubication').addClass('input-field col m6 s12');
        $('#block-info-type').hide();

        $('#alias').removeAttr('readonly', '');
        $('select').removeAttr('disabled', '');
        $('select').formSelect();
        $('#C3').prop('readonly', false);
        $('#C4').prop('readonly', false);
        $('#C5').prop('readonly', false);
        $('#C6').prop('readonly', false);
        $('#C7').prop('readonly', false);
        $('#C8').prop('readonly', false);
        $(this).addClass('hide');

        swal({
            title: "¡Actualizar!",
            text: "Puedes elegir los campos a modificar del inmueble.",
            icon: "info",
            button: "Ok",
        });
    });


    $('#update-property').on('submit', function (e) {
        e.preventDefault();
        $('#location_cadastral').removeAttr('disabled', 'disabled');
        $('#parish').removeAttr('disabled', 'disabled');


        $('#name').removeAttr('readonly');
        swal({
            icon: "warning",
            title: "Actualizar Inmueble",
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
                    url: url + "property/ticket-office/update-property",
                    data: new FormData(this),
                    dataType: false,

                    beforeSend: function () {
                        $('#name').attr('readonly', 'readonly');
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.status == "error") {
                            swal({
                                title: "Información",
                                text: data.message,
                                icon: "success",
                                button: "Ok",
                            })
                        } else {
                            swal({
                                title: "¡Bien Hecho!",
                                text: "Has Actualizado Los datos del inmueble con éxito.",
                                icon: "success",
                                button: "Ok",
                            }).then(function () {
                                location.reload();
                            });

                        }
                    },
                    error: function (e) {
                        console.log(e);
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
    });


    $('#change-users').click(function () {
        swal({
            title: "Información",
            text: "¿Desea cambiar el usuario que administrará esta inmueble?.Recuerda que los cambios son  permanentes.",
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
        }).then(function (accept) {
            if (accept) {
                swal({
                    text: 'Ingresa la cedula del usuario a cambiar Ej:V12345678.',
                    content: "input",
                    attributes: {
                        placeholder: "Escribe la cedula Ej:V1234567",
                        type: "text",
                    },
                    button: {
                        text: "Buscar",
                        className: "amber-gradient",
                        closeModal: false,


                    },
                }).then(ci => {
                    var property_id = $('#id').val();
                    if (ci !== null) {
                        console.log(ci.toUpperCase());
                        $.ajax({
                            type: "GET",
                            url: url + 'property/ticket-office/change-user/' + property_id + '/' + ci.toUpperCase(),
                            dataType: "JSON",
                            beforeSend: function () {
                                $("#preloader").fadeIn('fast');
                                $("#preloader-overlay").fadeIn('fast');
                            },
                            success: function (data) {

                                if (data.status === 'success') {
                                    swal({
                                        title: "Bien hecho",
                                        text: data.message,
                                        icon: "success",
                                        button: {
                                            text: "Aceptar",
                                            className: "blue-gradient"
                                        },
                                    }).then(function (accept) {

                                        location.reload();
                                    });
                                } else {
                                    swal({
                                        title: "Información",
                                        text: data.message,
                                        icon: "info",
                                        button: {
                                            text: "Aceptar",
                                            className: "blue-gradient"
                                        },
                                    });
                                }


                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                                console.log(data);
                            },
                            error: function (e) {

                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                                console.log(e);
                            }

                        });


                    } else {
                        swal({
                            title: "Información",
                            text: "Acción cancelada,Debes ingresar la cedula primero.",
                            icon: "info",
                            button: {
                                text: "Aceptar",
                                className: "blue-gradient"
                            },
                        });

                    }


                })

            }
        });
    });


    $('#edit-propietario').click(function () {
        swal({
            title: "Información",
            text: "¿Desea cambiar el usuario que administrará esta inmueble?.Recuerda que los cambios son  permanentes.",
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
        }).then(function (accept) {
            if (accept) {
                $('#document_pro').focus();
                $('#document_pro').removeAttr('readonly');
                $('#document_type_prop').removeAttr('disabled', '');
                $('#address_full').parent().removeClass('m12');
                $('#address_full').parent().addClass('m6');
                $('#update-propietario').removeClass('hide');
                $('select').formSelect();

            } else {
                swal({
                    title: "Información",
                    text: "Acción cancelada,Debes ingresar la cedula primero.",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        className: "blue-gradient"
                    },
                });

            }
        });
    });

    $('#update-propietario').click(function () {
        var type = '';
        var property_id = $('#id').val();
        var document = $('#document_type_prop').val() + $('#document_pro').val();

        if ($('#document_type_prop').val() === 'J' || $('#document_type_prop').val() === 'G') {
            type = 'company';
        } else {
            type = 'user';
        }


        if ($('#document_pro').val() !== '') {


            $.ajax({
                type: "GET",
                url: url + 'property/ticket-office/change-propietario/' + type + '/' + document + '/' + property_id,
                dataType: "JSON",
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {

                    if (data.status === 'success') {
                        swal({
                            title: "Bien hecho",
                            text: data.message,
                            icon: "success",
                            button: {
                                text: "Aceptar",
                                className: "blue-gradient"
                            },
                        }).then(function (accept) {

                            location.reload();
                        });
                    } else {
                        swal({
                            title: "Información",
                            text: data.message,
                            icon: "info",
                            button: {
                                text: "Aceptar",
                                className: "blue-gradient"
                            },
                        });
                    }


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    console.log(data);
                },
                error: function (e) {

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    console.log(e);
                }

            });
        } else {
            swal({
                title: "Información",
                text: "Debe ingresar una cedula valida, para poder guardar los cambios.",
                icon: "info",
                button: {
                    text: "Aceptar",
                    className: "blue-gradient"
                },
            }).then(function () {
                location.reload();
            });

        }

    });


    $('#change-maps').click(function () {
        swal({
            title: "Información",
            text: "Marca la nueva ubicación dentro del mapa.",
            icon: "info",
            button: {
                text: "Esta bien",
                className: "blue-gradient"
            },
        }).then(function (accept) {

            var focalizar = $("div#div-map").position().top;
            $('html,body').animate({scrollTop: focalizar}, 1000);


            var lat = parseFloat($('#lat').val());
            var lng = parseFloat($('#lng').val());
            var image = 'https://sysprim.com/images/mark-map.png';


            var marcadores = [];
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {lat: lat, lng: lng}
            });
            map.addListener('click', function (e) {
                console.log(e.latLng);
                addMark(e.latLng, map, image, marcadores, true);
            });

        });
    });


    $('#C4').change(function () {

        var sector = $(this).val();


        if (sector !== '') {

            $.ajax({
                method: "GET",
                url: url + "properties/filter-sector/" + sector,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    var sector = response.sector;

                    $('#location_cadastral').html('');
                    $('#location_cadastral').removeAttr('disabled', 'disabled');
                    $('#parish option:first').prop('selected', true);
                    $('#parish').removeAttr('disabled', 'disabled');


                    var html = '<option value="null" disabled selected>Seleccionar ubicacion Catastral</option>';
                    for (var i = 0; i < sector.length; i++) {

                        if (sector.length >= 2) {
                            html += '<option value=' + sector[i].id + '>' + sector[i].name + '</option>';
                        } else {
                            html += '<option value=' + sector[i].id + ' selected>' + sector[i].name + '</option>';

                            if (sector[i].parish_id != '0') {
                                $("#parish option[value=" + sector[i].parish_id + "]").prop("selected", true);
                                $('#parish').attr('disabled', 'disabled');
                            }

                            $('#location_cadastral').attr('disabled', 'disabled');
                        }
                    }

                    $('#location_cadastral').append(html);
                    $('select').formSelect();

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


});

window.onload = function () {
    var image = 'https://sysprim.com/images/mark-map.png';
    var lat = parseFloat($('#lat').val());
    var lng = parseFloat($('#lng').val());

    var marcadores = [];
    var myLatLng = {
        lat: lat,
        lng: lng
    };

    //creando el mapa.
    var map = new google.maps.Map(
        document.getElementById('map'), {
            zoom: 17,
            center: {lat: lat, lng: lng}
        });
    /*map.addListener('click', function(e) {
        addMark(e.latLng, map);
    });*/

    addMark(myLatLng, map, image, marcadores, false);


    //aniade una marca al mapa
}

function addMark(myLatLng, map, image, marcadores, remove) {

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        animation: google.maps.Animation.BOUNCE,
        title: "ESTOY AQUÍ",
    });


    if (remove) {
        google.maps.event.addListener(marker, 'click', function () {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null); //borramos el marcador del mapa
            $('#lng').val(" ");
            $('#lat').val(" ");
        });

        swal({
            title: "Información",
            text: "¿Deseas guardar la ubicación del mapa seleccionada?",
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
        }).then(function (accept) {
            if (accept) {
                var id = $('#id').val();
                var lat = $('#lat').val();
                var lng = $('#lng').val();
                var url = localStorage.getItem('url');

                $.ajax({
                    type: "POST",
                    url: url + "property/ticket-office/update-map",
                    data: {
                        id: id,
                        lat: lat,
                        lng: lng
                    },
                    dataType: "JSON",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');

                    },
                    success: function (data) {
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Se actualizo la ubicación del inmueble con éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {

                            location.reload();
                        });
                    },
                    error: function (e) {

                        swal({
                            title: "¡Oh no!",
                            text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                            icon: "error",
                            button: {
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });


                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        console.log(e)
                    }

                });

            } else {


            }

        });

    }


    marcadores.push(marker);
    if (marcadores.length > 1) {
        removeItemFromArr(marcadores, marker);
        marker.setMap(null);

        swal({
            title: "¡Oh no!",
            text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
            icon: "error",
            button: {
                text: "Entendido",
                className: "red-gradient"
            },
        });
    } else {
        $('#lng').val(marcadores[0].getPosition().lng());//coloca la marca
        $('#lat').val(marcadores[0].getPosition().lat);//a quien le coloco la multa
    }


}


// quita un valor de un array
function removeItemFromArr(arr, item) {
    var i = arr.indexOf(item);

    if (i !== -1) {
        arr.splice(i, 1);
    }
}


