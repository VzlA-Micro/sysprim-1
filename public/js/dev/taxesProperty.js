$('document').ready(function () {
    var url = "http://sysprim.com.devel/";
    var descuento = false;
    var fraccion = false;
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

    if (descuento === false && fraccion === false) {
        $('#descuento').on('click', function () {


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

        });
    }
});