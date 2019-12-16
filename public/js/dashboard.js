var url = "https://sysprim.com/";
var controller = "collection/statistics";

var width = $(window).width();
var height = $(window).height();

var bar="bar";
var pie="pie";
var line="line";

var type;

if ((width>=300 && width <=1000) &&( height>=640 && height<= 1200) ){
    type=bar ;
}else{
    type= line;
}

function isMobile(){
    return (
        (navigator.userAgent.match(/Android/i)) ||
        (navigator.userAgent.match(/webOS/i)) ||
        (navigator.userAgent.match(/iPhone/i)) ||
        (navigator.userAgent.match(/iPod/i)) ||
        (navigator.userAgent.match(/iPad/i)) ||
        (navigator.userAgent.match(/BlackBerry/i))
    );
}


$('document').ready(function () {



/*    $('#bs').html('Bolivar '+0+'<i class="i-bss left"></i>');
    $('#eur').html('Euros '+0+'<i class="fas fa-euro-sign left"></i>');
    $('#cny').html('Yuan '+0+'<i class="fas fa-yen-sign left"></i>');
    $('#rub').html('Ruplas '+0+'<i class="fas fa-ruble-sign left"></i>');
    $('#usd').html('Dolar '+0+'<i class="fas fa-dollar-sign left"></i>');

    var preloader="<div class='preloader-wrapper center small active'>"+
        "<div class='spinner-layer spinner-green-only'>"+
        "<div class='circle-clipper left'>"+
        "<div class='circle'></div>"+
        "</div><div class='gap-patch'>"+
        "<div class='circle'></div>"+
        "</div><div class='circle-clipper right'>"+
        "<div class='circle'></div>"+
        "</div></div></div>";
    $('#petro').html(preloader);
    function api() {
        const url = 'https://petroapp-price.petro.gob.ve/price/';
        const data = {
            "coins": ["PTR", "BTC"],
            "fiats": ["USD", "EUR", "RUB", "CNY", "BS"]
        };

        fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
            .catch(error => {
                console.error('Error:', error);

            })
            .then(response => {
                value = response;
                $.ajax({
                    method: "GET",
                    url: url+'bs',
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (responses) {
                        console.log('success');
                        var total = responses[0] / value['data']['PTR']['BS'];
                        var eur = value['data']['PTR']['EUR'];
                        var rub = value['data']['PTR']['RUB'];
                        var cny = value['data']['PTR']['CNY'];
                        var usd = value['data']['PTR']['USD'];
                        var bs = value['data']['PTR']['BS'];

                        $('#petro').html(total+" <i class='i-petro'>");

                        $('#bs').html('Bolivar '+bs+'<i class="i-bss left"></i>');
                        $('#eur').html('Euros '+eur+'<i class="fas fa-euro-sign left"></i>');
                        $('#cny').html('Yuan '+cny+'<i class="fas fa-yen-sign left"></i>');
                        $('#rub').html('Ruplas '+rub+'<i class="fas fa-ruble-sign left"></i>');
                        $('#usd').html('Dolar '+usd+'<i class="fas fa-dollar-sign left"></i>');

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });

            });

    }*/



    $.ajax({
        method: "GET",
        url: url + controller,
        dataType: 'json',

        beforeSend: function () {
            $("#preloader").fadeIn('fast');
            $("#preloader-overlay").fadeIn('fast');
        },
        success: function (response) {
            console.log('hola3');
            console.log(response);
            if (response !== 'error') {
                $('#recaudacion').text(response[0]['total']);
                $('#banesco').text(response[0]['banesco']);
                $('#bnc').text(response[0]['bnc']);
                $('#bicentenario').text(response[0]['bicentenario']);
                $('#bod').text(response[0]['bod']);
                $('#banco100').text(response[0]['banco100']);
                chartsMonth(response);
                topTaxes(response[11]);
                dear(response[12]);
                api();
            }
        },
        error: function (e) {
            console.log('hola4');
            console.log(e);
            if (e !== 'error') {
                $('#recaudacion').text(e['total']);
            }
        }


    });

});

function chartsMonth(data) {

// Charts
    var taxCollectionChart = document.querySelector("#tax-collection");
    var taxCollection = new Chart(taxCollectionChart, {

        type: "bar", // Tipo de chart
        data: { // Incluye lo referente a datos
            "labels": [ // Etiquetas para la leyenda
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Novienbre", "Diciembre"
            ],
            "datasets": [{ // Sets de datos que tendra la chart
                "label": "",
                "data": [
                    data[1]['enero'],
                    data[1]['febrero'],
                    data[1]['marzo'],
                    data[1]['abril'],
                    data[1]['mayo'],
                    data[1]['junio'],
                    data[1]['julio'],
                    data[1]['agosto'],
                    data[1]['septiembre'],
                    data[1]['octubre'],
                    data[1]['noviembre'],
                    data[1]['diciembre']],
                "fill": false,
                "borderColor": "rgb(0,0,0,.5)",
                "backgroundColor": [
                    "#e91e63",
                    "#9c27b0",
                    "#4caf50",
                    "#03a9f4",
                    "#e91e63",
                    "#9c27b0",
                    "#4caf50",
                    "#03a9f4",
                    "#e91e63",
                    "#9c27b0",
                    "#4caf50",
                    "#03a9f4",
                ],
                "lineTension": 0.1
            }]
        },
        options: {
            title: {
                display: true,
                text: "Recaudo de Impuestos Mensual",
                fontSize: 25
            },
            legend: {
                position: 'bottom'
            },
            resonsive: true
        }
    });

    var taxCollectionChart = document.querySelector("#typeTaxes");
    var taxCollection = new Chart(taxCollectionChart, {

        type: type, // Tipo de chart
        data: { // Incluye lo referente a datos
            "labels": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            "datasets": [ // Sets de datos que tendra la chart
                {
                "label": "Actividad Economica",
                "data": [
                    data[7]['enero'],
                    data[7]['febrero'],
                    data[7]['marzo'],
                    data[7]['abril'],
                    data[7]['mayo'],
                    data[7]['junio'],
                    data[7]['julio'],
                    data[7]['agosto'],
                    data[7]['septiembre'],
                    data[7]['octubre'],
                    data[7]['noviembre'],
                    data[7]['diciembre']],

                "borderColor": "#ba0f1a",
                    "fill":false,
                "backgroundColor":
                    "#e91e63",
                "borderCapStyle":"round",
                "lineTension": 0.1
            }, {
                "label": "Inmueble Urbano",
                "data": [
                    data[8]['enero'],
                    data[8]['febrero'],
                    data[8]['marzo'],
                    data[8]['abril'],
                    data[8]['mayo'],
                    data[8]['junio'],
                    data[8]['julio'],
                    data[8]['agosto'],
                    data[8]['septiembre'],
                    data[8]['octubre'],
                    data[8]['noviembre'],
                    data[8]['diciembre']],
                "fill":
                    false,
                "borderColor":
                    "#2dce8a",
                "borderCapStyle":"round",
                "backgroundColor":
                "#2dce8a",
                "lineTension":
                    0.1
            },
                {
                    "label":
                        "Vehiculo",
                    "data": [
                        data[9]['enero'],
                        data[9]['febrero'],
                        data[9]['marzo'],
                        data[9]['abril'],
                        data[9]['mayo'],
                        data[9]['junio'],
                        data[9]['julio'],
                        data[9]['agosto'],
                        data[9]['septiembre'],
                        data[9]['octubre'],
                        data[9]['noviembre'],
                        data[9]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#34beff",
                    "backgroundColor":
                        "#34beff",
                    "lineTension":
                        0.1
                }
                ,
                {
                    "label":
                        "Publicidad",
                    "data": [
                        data[5]['enero'],
                        data[5]['febrero'],
                        data[5]['marzo'],
                        data[5]['abril'],
                        data[5]['mayo'],
                        data[5]['junio'],
                        data[5]['julio'],
                        data[5]['agosto'],
                        data[5]['septiembre'],
                        data[5]['octubre'],
                        data[5]['noviembre'],
                        data[5]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#3b52ff",
                    "backgroundColor":
                        "#3b52ff",
                    "lineTension":
                        0.1
                }
                ,
                {
                    "label":
                        "Eventos",
                    "data": [
                        data[10]['enero'],
                        data[10]['febrero'],
                        data[10]['marzo'],
                        data[10]['abril'],
                        data[10]['mayo'],
                        data[10]['junio'],
                        data[10]['julio'],
                        data[10]['agosto'],
                        data[10]['septiembre'],
                        data[10]['octubre'],
                        data[10]['noviembre'],
                        data[10]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#9c27b0",
                    "backgroundColor":
                        "#9c27b0",
                    "lineTension":
                        0.1
                }

            ]
        },
        options: {

            title: {
                display: true,
                text: "Recaudo Por Impuestos Mensual",
                fontSize: 25
            },
            legend: {
                position: 'bottom'
            },
            resonsive: true
        }
    });

    var bankEarningsChart = document.querySelector("#bank-earnings");
    var bankEarningsOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: "bottom"
        },
        hover: {
            mode: "label"
        },
        scales: {
            xAxes: [
                {
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Mes"
                    }
                }
            ],
            yAxes: [
                {
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Recaudación en BS"
                    }
                }
            ]
        },
        title: {
            display: true,
            text: "Recaudación Mensual",
            fontSize: 25
        }
    };

    var bankData = {
        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Novienbre", "Diciembre"],
        datasets: [
            {
                label: "My First dataset",
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: "#e91e63",
                pointBorderColor: "#e91e63",
                pointBackgroundColor: "#FFF",
                pointBorderWidth: 2,
                pointHoverBorderWidth: 2,
                pointRadius: 4
            },
            {
                label: "My Second dataset",
                data: [28, 48, 40, 19, 86, 27, 90],
                fill: false,
                borderColor: "#03a9f4",
                pointBorderColor: "#03a9f4",
                pointBackgroundColor: "#FFF",
                pointBorderWidth: 2,
                pointHoverBorderWidth: 2,
                pointRadius: 4
            },
            {
                label: "My Third dataset - No bezier",
                data: [45, 25, 16, 36, 67, 18, 76],
                fill: false,
                borderColor: "#ffc107",
                pointBorderColor: "#ffc107",
                pointBackgroundColor: "#FFF",
                pointBorderWidth: 2,
                pointHoverBorderWidth: 2,
                pointRadius: 4
            }
        ]
    };


    var bankEarnings = new Chart(bankEarningsChart, {
        type: type, // Tipo de chart
        data: { // Incluye lo referente a datos
            "labels": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Novienbre", "Diciembre"],
            "datasets": [{ // Sets de datos que tendra la chart
                "label": "Bicentenario",
                "data": [
                    data[4]['enero'],
                    data[4]['febrero'],
                    data[4]['marzo'],
                    data[4]['abril'],
                    data[4]['mayo'],
                    data[4]['junio'],
                    data[4]['julio'],
                    data[4]['agosto'],
                    data[4]['septiembre'],
                    data[4]['octubre'],
                    data[4]['noviembre'],
                    data[4]['diciembre']],
                "fill": false,
                "borderColor": "#ba0f1a",
                "lineTension": 0.1
            }, {
                "label": "Banesco",
                "data": [
                    data[2]['enero'],
                    data[2]['febrero'],
                    data[2]['marzo'],
                    data[2]['abril'],
                    data[2]['mayo'],
                    data[2]['junio'],
                    data[2]['julio'],
                    data[2]['agosto'],
                    data[2]['septiembre'],
                    data[2]['octubre'],
                    data[2]['noviembre'],
                    data[2]['diciembre']],
                "fill":
                    false,
                "borderColor":
                    "#15cb23",
                "lineTension":
                    0.1
            },
                {
                    "label":
                        "100% Banco",
                    "data": [
                        data[6]['enero'],
                        data[6]['febrero'],
                        data[6]['marzo'],
                        data[6]['abril'],
                        data[6]['mayo'],
                        data[6]['junio'],
                        data[6]['julio'],
                        data[6]['agosto'],
                        data[6]['septiembre'],
                        data[6]['octubre'],
                        data[6]['noviembre'],
                        data[6]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#34beff",
                    "lineTension":
                        0.1
                }
                ,
                {
                    "label":
                        "BOD",
                    "data": [
                        data[5]['enero'],
                        data[5]['febrero'],
                        data[5]['marzo'],
                        data[5]['abril'],
                        data[5]['mayo'],
                        data[5]['junio'],
                        data[5]['julio'],
                        data[5]['agosto'],
                        data[5]['septiembre'],
                        data[5]['octubre'],
                        data[5]['noviembre'],
                        data[5]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#3b52ff",
                    "lineTension":
                        0.1
                }
                ,
                {
                    "label":
                        "BNC",
                    "data": [
                        data[3]['enero'],
                        data[3]['febrero'],
                        data[3]['marzo'],
                        data[3]['abril'],
                        data[3]['mayo'],
                        data[3]['junio'],
                        data[3]['julio'],
                        data[3]['agosto'],
                        data[3]['septiembre'],
                        data[3]['octubre'],
                        data[3]['noviembre'],
                        data[3]['diciembre']],
                    "fill":
                        false,
                    "borderColor":
                        "#9c27b0",
                    "lineTension":
                        0.1
                }

            ]
        },
        options: bankEarningsOptions
    });
}

function topTaxes(data) {
    var circularChart = new Chart($('#donus'), {
        type: 'doughnut', //Gráfica circular
        data: {
             //Etiquetas
            datasets: [
                {
                    data: [
                        data['ptb'],
                        data['ppc'],
                        data['ppe'],
                        data['ppv'],
                        ], //Cantidad de la ¿rebanada?
                    backgroundColor: [ //Color del segmento
                        "#8BC34A",
                        "#03A9F4",
                        "#FFCE56",
                        "#9c27b0"
                    ],
                    hoverBackgroundColor: [ //Color al hacer hover al segmento
                        "#7CB342",
                        "#039BE5",
                        "#FFA000",
                        "#9c27b0"
                    ]
                }],
            labels: ['Transferencia', 'Cheques', 'Efectivo','Punto De Venta']
        }
    });
}

function dear(data) {
    var taxCollectionChart = $("#dear");
    var taxCollection = new Chart(taxCollectionChart, {
        type: "bar", // Tipo de chart
        data: { // Incluye lo referente a datos
            "labels": [ // Etiquetas para la leyenda
                "Estimado", "Incremento", "Total",],
            "datasets": [{ // Sets de datos que tendra la chart
                "label": "",
                "data": [
                    data['estimado'],
                    data['incremento'],
                    data['total']
                ],

                "fill": false,
                "borderColor": "rgb(0,0,0,.5)",
                "backgroundColor": [
                    "#e91e63",
                    "#9c27b0",
                    "#4caf50",

                ],
                "lineTension": 0.1
            }]
        },
        options: {
            title: {
                display: true,
                text: "Estimado",
                fontSize: 25
            },
            legend: {
                position: 'bottom'
            },
            resonsive: true
        }
    });
}


