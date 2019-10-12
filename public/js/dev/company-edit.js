window.onload = function() {

    var lat=parseFloat($('#lat').val());
    var lng=parseFloat($('#lng').val());
    var marcadores=[];
    var myLatLng={lat:lat,lng:lng};
    //creando el mapa.
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat:10.0736954, lng:-69.3498597}
    });
    map.addListener('click', function(e) {
        addMark(e.latLng, map);
    });
    addMark(myLatLng,map);
    // quita un valor de un array
    function removeItemFromArr ( arr, item ) {
        var i = arr.indexOf( item );

        if ( i !== -1 ) {
            arr.splice( i, 1 );
        }
    }
    //aniade una marca al mapa
    function addMark(myLatLng,map) {

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            animation: google.maps.Animation.BOUNCE,
            title: "ESTOY AQUÍ"
        });

        google.maps.event.addListener(marker, 'click', function () {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null); //borramos el marcador del mapa
            $('#lgn').val(" ");
            $('#lat').val(" ");
        });


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




