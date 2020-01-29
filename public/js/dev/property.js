$('document').ready(function () {
   // var url = "http://172.19.50.253/";

    var url = "http://172.19.50.253/";


    $('#verification').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "properties/verification",
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
            url: url + "properties/save",
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
                    window.location.href = url + "properties/my-properties";
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



/*function initMap() {
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
    }*/
//}


function localizar(elemento,direccion) {
    var geocoder = new google.maps.Geocoder();
    var marcadores = [];


    var map = new google.maps.Map(document.getElementById(elemento), {
        zoom: 15,
        scrollwheel: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        restriction: {latLngBounds:{north: 83.8, south: -57, west: -180, east: 180}}
    });

    geocoder.geocode({'address': direccion}, function(results, status) {


        if (status === 'OK') {
            var resultados = results[0].geometry.location,
                resultados_lat = resultados.lat(),
                resultados_long = resultados.lng();

            map.setCenter(results[0].geometry.location);


            map.addListener('click', function (e) {
                addMark(e.latLng, map,marcadores);
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
    var direccion=$(this).val();
    if(direccion!==''){
        localizar("map", "Venezuela, Baquisimeto Estado Lara. "+ direccion);
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
        addMark(e.latLng, map,marcadores);
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

function addMark(latLng, map,marcadores) {



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
