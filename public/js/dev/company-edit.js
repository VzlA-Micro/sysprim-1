var url = "https://sysprim.com/";
var addCiiu = false;
$('document').ready(function () {

    $('#update-company').on('click', function () {

        $('#document_type').prop("disabled", false);
        $('select').formSelect();
        $('#RIF').removeAttr('readonly');
        $('#name').removeAttr('readonly');
        $('#license').removeAttr('readonly');
        $('#opening_date').removeAttr('disabled');
        $('#number_employees').removeAttr('disabled');
        $('#sector').removeAttr('disabled');
        $('#code_catastral').removeAttr('disabled');
        $('#country_code_company').removeAttr('disabled');
        $('select').formSelect();
        $('#parish').removeAttr('disabled', '');
        $('select').formSelect();
        $('#address').removeAttr('disabled');
        $('#phone').removeAttr('disabled');
    });
    if (addCiiu == false) {
        $('#add-ciiu').on('click', function () {

            $('#code').prop("disabled", false);
            $('#search-ciu').removeAttr('disabled');
            $('#code').focus();
            addCiiu = true;

        });
    }
if (addCiiu==true){
        $('#add-ciiu').on('click', function () {
        console.log('else')
        var ciu = $('#ciu').val();
        var id = $('#id');
        $.ajax({
            type: "POST",
            url: url + "company/addCiiu",
            data: {
                id: id,
                ciu: ciu
            },
            dataType:"JSON",

            beforeSend:function () {
                console.log('hola');
            },
            success:function (data) {
                console.log(data);
            },
            error:function (e) {
                console.log(e);
            }

        });
    });
}

    $('#search-ciu').click(function () {
        var code = $('#code').val();

        var band = true;
        if (code !== "") {
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
                                    <input type="text" name="search-ciu" id="ciu"  disabled value="${response.ciu.code}" >
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
                            title: "Información",
                            text: "El campo del codigo CIIU no debe estar vacio para iniciar la busquedad.",
                            icon: "info",
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
        } else {
            swal({
                title: "Información",
                text: "Debe ingresar un CIIU valido.",
                icon: "info",
                button: "Ok",
            });
        }
    });


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

    $('#delete-ciiu').on('click', function () {

        $('#document_type').prop("disabled", false);
        $('select').formSelect();
        $('#RIF').removeAttr('disabled');
        $('#name').removeAttr('readonly');
        $('#license').removeAttr('readonly');
        $('#opening_date').removeAttr('disabled');
        $('#number_employees').removeAttr('disabled');
        $('#sector').removeAttr('disabled');
        $('#code_catastral').removeAttr('disabled');
        $('#country_code_company').removeAttr('disabled');
        $('select').formSelect();
        $('#parish').removeAttr('disabled', '');
        $('select').formSelect();
        $('#address').removeAttr('disabled');
        $('#phone').removeAttr('disabled');
    });
});

window.onload = function () {
    var image = 'https://sysprim.com/images/mark-map.png';

    var lat = parseFloat($('#lat').val());
    var lng = parseFloat($('#lng').val());
    var marcadores = [];
    var myLatLng = {lat: lat, lng: lng};
    //creando el mapa.
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat: 10.0736954, lng: -69.3498597}
    });
    /*map.addListener('click', function(e) {
        addMark(e.latLng, map);
    });*/
    addMark(myLatLng, map);

    // quita un valor de un array
    function removeItemFromArr(arr, item) {
        var i = arr.indexOf(item);

        if (i !== -1) {
            arr.splice(i, 1);
        }
    }

    //aniade una marca al mapa
    function addMark(myLatLng, map) {

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image,
            animation: google.maps.Animation.BOUNCE,
            title: "ESTOY AQUÍ",
        });

        /*google.maps.event.addListener(marker, 'click', function () {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null); //borramos el marcador del mapa
            $('#lgn').val(" ");
            $('#lat').val(" ");
        });*/


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
            $('#lng').val(marcadores[0].getPosition().lng());//coloca la marca
            $('#lat').val(marcadores[0].getPosition().lat);//a quien le coloco la multa
        }

    }


}




