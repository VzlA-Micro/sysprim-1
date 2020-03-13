$(document).ready(function() {
    var url = localStorage.getItem('url');





    $('#register').submit(function(e) {
        e.preventDefault();
        var ci=$('#document').val();
        var phone=$('#phone').val();


        if(ci.length>6&&phone.length>6) {


            var formData = new FormData(this);
            $.ajax({
                url: url + "payments/bdv/store",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                method: "POST",
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (resp) {
                    console.log(resp.success);

                    if (resp.success) {
                        window.location = resp.urlPayment;
                        $('#link').attr('href', resp.urlPayment);
                    } else {

                        $('.message').removeClass('hide');
                        $('#message').text(resp.responseMessage);
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
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });
        }else{
            console.log('epa');
            console.log(ci.length);
            if(ci.length<=6){
                swal({
                    title: "Información",
                    text: "Debes Ingresar una cedula valida para realizar un pago.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }else if(phone.length<=6){
                swal({
                    title: "Información",
                    text: "Debes Ingresar un telefono valido para realizar un pago.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });
            }

        }
    });







    $('#document').keyup(function () {
        if ($('#type_document').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar la nacionalidad, antes de ingresar el número de cedula.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#document').val('')
        }

    });





    $('#phone').keyup(function () {
        if ($('#country_code').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar la operadora, antes de ingresar el número de teléfono.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });

            $('#phone').val('');
        }
    });

    $('input[type="text"].money').each(function () {
        $(this).val(function (index, value) {
            return number_format(value, 2);
        });
    });

    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

        return amount_parts.join(',');
    }


});