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
            "data": [65, 59, 80, 81, 56, 92, 40, 0, 0, 0, 0, 0, 0],
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
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",  "Julio", "Agosto", "Septiembre", "Octubre", "Novienbre", "Diciembre"
        ],
        "datasets": [{ // Sets de datos que tendra la chart
            "label": "Banco de Venezuela",
            "data": [30, 59, 80, 81, 56, 80, 40, 0, 0, 0, 0, 0, 0],
            "fill": false,
            "borderColor": "#ba0f1a",
            "lineTension": 0.1
        }, {
            "label": "Banesco",
            "data": [70, 80, 20, 25, 56, 92, 40, 0, 0, 0, 0, 0, 0],
            "fill": false,
            "borderColor": "#15cb23",
            "lineTension": 0.1
        }, {
            "label": "100% Banco",
            "data": [10, 40, 20, 25, 42, 20, 45, 0, 0, 0, 0, 0, 0],
            "fill": false,
            "borderColor": "#34beff",
            "lineTension": 0.1
        }, {
            "label": "BOD",
            "data": [80, 70, 60, 75, 82, 85, 90, 0, 0, 0, 0, 0, 0],
            "fill": false,
            "borderColor": "#3b52ff",
            "lineTension": 0.1
        }, {
            "label": "BOD",
            "data": [80, 70, 60, 75, 82, 85, 90, 0, 0, 0, 0, 0, 0],
            "fill": false,
            "borderColor": "#3b52ff",
            "lineTension": 0.1
        }

        ]
    },
    options: {
        title: {
            display: true,
            text: "Ganancias Mensuales",
            fontSize: 25
        },
        legend: {
            position: 'top'
        }
    }
});

// COunters
$('.timer').countTo({
    from: 0,
    speed: 5000
});