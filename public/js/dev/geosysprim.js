var url="https://sysprim.com/";
function initMap() {
    findCompanySolvent();
}



$('#refresh').click(function () {
    findCompanySolvent();
});
$('#company-solvent').click(function () {
    findCompanySolvent();
});


    $('#company-registered').click(function () {
        $.ajax({
            method: "GET",
            url: url + "geosysprim/find-company/registered",
            beforeSend: function () {

            },
            success: function (response) {

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: {lat: 10.0736954, lng: -69.3498597},
                });

                if(response.company!==null){

                    for (var i = 0; i < response.company.length; i++) {

                        var lat = parseFloat(response.company[i].lat);
                        var lng = parseFloat(response.company[i].lng);
                        var marker = new google.maps.Marker({
                            position: {lat: lat, lng: lng},
                            map: map,
                            title: response.company[i].name,
                            animation: google.maps.Animation.DROP,
                            icon: 'https://sysprim.com/images/maps/maps-and-flags_blue_24.png'
                        });

                        var infowindow;


                        google.maps.event.addListener(marker, 'click', function (marker) {
                            console.log("click");

                            var contentString =
                                '<div class="card">' +
                                '<div class="header">' +
                                +
                                    '</div>' +
                                '<div class="card-content">' +

                                '</div>' +

                                '<div class="card-action">' +
                                '<a href=' + url + 'payments/taxes/' + '' + ' class="btn btn-primary">Ult.Pago</a>' +
                                '</div>' +

                                '</div>';

                            if (!infowindow) {
                                infowindow = new google.maps.InfoWindow();
                            }
                            infowindow.setContent('epa');
                            infowindow.open(map, marker);
                        });




                    }



                }

            },
            error: function (err) {

            }
        });

});


$('#company-process').click(function () {
    $.ajax({
        method: "GET",
        url: url + "geosysprim/find-company/process",
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: 10.0736954, lng: -69.3498597},
            });

            if(response.company!==null){

                for (var i = 0; i < response.company.length; i++) {

                    var lat = parseFloat(response.company[i].lat);
                    var lng = parseFloat(response.company[i].lng);
                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company[i].name,
                        animation: google.maps.Animation.DROP,
                        icon: 'https://sysprim.com/images/maps/maps-and-flags_orange_24.png'
                    });

                    var infowindow;


                    google.maps.event.addListener(marker, 'click', function (marker) {
                        console.log("click");

                        var contentString =
                            '<div class="card">' +
                            '<div class="header">' +
                            +
                                '</div>' +
                            '<div class="card-content">' +

                            '</div>' +

                            '<div class="card-action">' +
                            '<a href=' + url + 'payments/taxes/' + '' + ' class="btn btn-primary">Ult.Pago</a>' +
                            '</div>' +

                            '</div>';

                        if (!infowindow) {
                            infowindow = new google.maps.InfoWindow();
                        }
                        infowindow.setContent('epa');
                        infowindow.open(map, marker);
                    });




                }





            }


        },
        error: function (err) {

        }
    });




});


$('#company-process-verified').click(function () {
    $.ajax({
        method: "GET",
        url: url + "geosysprim/find-company/solvent-process",
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);





            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: 10.0736954, lng: -69.3498597},
            });


            if(response.company_process!==null){

                for (var i = 0; i < response.company_process.length; i++) {

                    var lat = parseFloat(response.company_process[i].lat);
                    var lng = parseFloat(response.company_process[i].lng);


                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company_process[i].name,
                        animation: google.maps.Animation.DROP,
                        icon: 'https://sysprim.com/images/maps/maps-and-flags_orange_24.png'
                    });
                }
            }



            if(response.company_verified!==null){

                for (var i = 0; i < response.company_verified.length; i++) {

                    var lat = parseFloat(response.company_verified[i].lat);
                    var lng = parseFloat(response.company_verified[i].lng);


                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company_verified[i].name,
                        animation: google.maps.Animation.DROP,
                        icon: 'https://sysprim.com/images/maps/maps-and-flags_green_24.png'
                    });
                }
            }

        },
        error: function (err) {

        }
    });

});



function findCompanySolvent() {
    $.ajax({
        method: "GET",
        url: url + "geosysprim/find-company/solvent",
        beforeSend: function () {

        },
        success: function (response) {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: {lat: 10.0736954, lng: -69.3498597},
            });

            if(response.company!==null){



                for (var i = 0; i < response.company.length; i++) {


                    var lat = parseFloat(response.company[i].lat);
                    var lng = parseFloat(response.company[i].lng);
                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company[i].name,
                        animation: google.maps.Animation.DROP,
                        icon: 'https://sysprim.com/images/maps/maps-and-flags_green_24.png'
                    });

                    var infowindow;


                    google.maps.event.addListener(marker, 'click', function (marker) {
                        console.log("click");

                        var contentString =
                            '<div class="card">' +
                            '<div class="header">' +
                            +
                                '</div>' +
                            '<div class="card-content">' +

                            '</div>' +

                            '<div class="card-action">' +
                            '<a href=' + url + 'payments/taxes/' + '' + ' class="btn btn-primary">Ult.Pago</a>' +
                            '</div>' +

                            '</div>';

                        if (!infowindow) {
                            infowindow = new google.maps.InfoWindow();
                        }
                        infowindow.setContent('epa');
                        infowindow.open(map, marker);
                    });




                }
            }


        },
        error: function (err) {

        }
    });





}


