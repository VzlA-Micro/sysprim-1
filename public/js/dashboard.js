var url = "http://sysprim.com.devel/";
var controller = "collection/statistics";

$('document').ready(function () {
    console.log('hola1');
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
                $('#recaudacion').text(,response[0]['total']);
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
                "label": "Ventas",
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
            }
        }
    });

    var bankEarningsChart = document.querySelector("#bank-earnings");
    var bankEarnings = new Chart(bankEarningsChart, {
        type: "line", // Tipo de chart
        data: { // Incluye lo referente a datos
            "labels": [ // Etiquetas para la leyenda
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Novienbre", "Diciembre"
            ],
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
        options: {
            title: {
                display: true,
                text:
                    "Ganancias Mensuales",
                fontSize:
                    25
            }
            ,
            legend: {
                position: 'top'
            }
        }
    });
}

