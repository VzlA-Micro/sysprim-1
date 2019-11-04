var url = "http://sysprim.com.devel/";
function initMap() {
    findCompanySolvent();
}



$('#refresh').click(function () {
    findCompanySolvent();
});
$('#company-solvent').click(function () {
    findCompanySolvent();
});

$('#company-process').click(function () {
    $.ajax({
        method: "GET",
        url: url + "geosysprim/find-company/process",
        beforeSend: function () {

        },
        success: function (response) {

            if(response.taxes!==null){
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: {lat: 10.0736954, lng: -69.3498597},
                });


                for (var i = 0; i < response.company.length; i++) {


                    var lat = parseFloat(response.company[i].lat);
                    var lng = parseFloat(response.company[i].lng);
                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company[i].name,
                        icon: 'http://sysprim.com.devel/images/mark-companies.png'
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


function findCompanySolvent() {
    $.ajax({
        method: "GET",
        url: url + "geosysprim/find-company/solvent",
        beforeSend: function () {

        },
        success: function (response) {

            if(response.taxes!==null){
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: {lat: 10.0736954, lng: -69.3498597},
                });


                for (var i = 0; i < response.company.length; i++) {


                    var lat = parseFloat(response.company[i].lat);
                    var lng = parseFloat(response.company[i].lng);
                    var marker = new google.maps.Marker({
                        position: {lat: lat, lng: lng},
                        map: map,
                        title: response.company[i].name,
                        icon: 'http://sysprim.com.devel/images/mark-companies.png'
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


