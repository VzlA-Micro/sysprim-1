var url = "http://sysprim.com.devel/";
var controller = "collection/statistics";


$('document').ready(function () {
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
                    url: 'http://sysprim.com.devel/bs',
                    dataType: 'json',
                    beforeSend:function(){
                        console.log('enviando')
                    },
                    success: function (responses) {
                        console.log('success');
                        var total=responses[0]/value['data']['PTR']['BS'];
                        console.log(value['data']['PTR']['BS']);
                        console.log(total);
                        $('#petro').text(total);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                console.log(value);
            });

    }

    console.log('hola1');
    api();
    $.ajax({
        method: "GET",
        url: url + controller,
        dataType: 'json',

        beforeSend: function () {
            console.log('hola2');
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
                text: "Recaudos de Impuestos Mensuales",
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
        type: "line", // Tipo de chart
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

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x [0];
    x2 = x.length > 1 ? '.' + x [1] : '';
    var rgx = / (\ d +) (\ d {3}) /;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$ 1' + ',' + '$ 2');
    }
    return x1 + x2;
}

