var descuento = false;
var fraccion = false;
$('document').ready(function () {
    var url="https://sysprim.com/";

    var total = $('#total').val();


    $('#fraccionado').on('click', function () {
        if (descuento === false && fraccion === false) {
            var total = $('#total').val();
            console.log(fraccion);
            $.ajax({
                url: url + "inmueble/calcuFraccionado",
                data: {
                    value: total
                },
                method: "POST",
                beforeSend: function () {
                },
                success: function (response) {
                    $('#total').val(response['value']);
                    fraccion = true;
                    console.log(fraccion);
                },
                error: function (e) {
                    console.log(e);
                }
            })

        }
    });

    console.log(fraccion);


        $('#descuento').on('click', function () {
            if (fraccion === false && descuento === false) {
                $.ajax({
                    url: url + "inmueble/calcu",
                    data: {
                        value: total
                    },
                    method: "POST",
                    beforeSend: function () {
                    },
                    success: function (response) {
                        $('#total').val(response['value']);
                        descuento = true;
                        console.log(descuento);
                        console.log(fraccion);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                })
            }
        });

    //Calculos de total a pagar
    $('.bank').click(function () {
        $('#bank').val($(this).attr('data-bank'));
        $('#register-taxes')[0].submit();
    });

    $('.payments').click(function () {
        $('#payments').val($(this).attr('data-payments'));
    });

    $('.tick').click(function () {
        $('#payments').val($(this).attr('data-payments'));
        $('#register-taxes')[0].submit();
    });
});