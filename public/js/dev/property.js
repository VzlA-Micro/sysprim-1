$('document').ready(function () {
    var url = "https://sysprim.com/";

    $('#verification').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "inmueble/verification",
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
                console.log(response[0][0]);
                swal({
                    title: "¡Bien Hecho!",
                    text: 'Codigo Encontrado',
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    $('#address').val(response[0]['direction']);
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
    });


    $('#property').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "/inmueble/save",
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
                    window.location.href = url + "inmueble/my-property";
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
    });


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

    function addMark(latLng, map) {
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title: "ESTOY AQUÍ"
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