$('document').ready(function () {

    var url = localStorage.getItem('url');

    var descuento = false;
    var fraccion = false;
    var btnDiscount = $('#descuento');
    var btnFractional = $('#fraccionado');

    var total = $('#total').val();
    $('#fraccionado').on('click', function () {
        if (descuento === false && fraccion === false) {
            var total = $('#total').val();
            // console.log(fraccion);
            $.ajax({
                url: url + "properties/fractionalCalculation",
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
                    btnDiscount.addClass('disabled');
                },
                error: function (e) {
                    console.log(e);
                }
            })

        }
    });

    $('#descuento').on('click', function () {
        if (fraccion === false && descuento === false) {
            $.ajax({
                url: url + "properties/discount",
                data: {
                    value: total
                },
                method: "POST",
                beforeSend: function () {
                },
                success: function (response) {
                    $('#total').val(response['value']);
                    descuento = true;
                    // console.log(descuento);
                    // console.log(fraccion);
                    btnFractional.addClass('disabled');
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });

    $('input[type="text"].money_keyup').on('keyup', function (event) {
        var total = $(this).val();
        if ($(this).val() == 0 && $(this).val().toString().length >= 2) {
            $(this).val('');
        } else if ($(this).val().toString().length >= 2 && total[0] == 0) {
            $(this).val('');
        } else {
            $(event.target).val(function (index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1,$2')
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    });

    $('#fiscal_credit').blur(function() {
        var fiscal_credit = $(this).val();
        var amount = $('#amount').val();
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: {
                fiscal_credit: fiscal_credit,
                amount: amount
            },
            url: url + 'properties/taxes/total',
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
                if(resp.status == 'success') {
                    swal({
                        title: '¡Bien Hecho!',
                        text: resp.message,
                        icon: 'success',
                        button: {
                            text: 'Entendido',
                            className: 'blue-gradient'
                        }
                    });
                    /*$('#fiscal_credit').val(resp.fiscal_credit);
                    console.log(resp.fiscal_credit);*/
                    $('#amount').val(resp.total);
                }
                else if(resp.status == 'error') {
                    swal({
                        title: '¡Oh No!',
                        text: resp.message,
                        icon: 'error',
                        button: {
                            text: 'Entendido',
                            className: 'blue-gradient'
                        }
                    });
                    $('#fiscal_credit').val(0);
                }
                else if(resp.status == 'void'){
                    $('#fiscal_credit').val(0);
                }
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            },
            error: function (err) {
                console.log(err);
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
        })
    });

    $('#property-taxes').submit(function(e) {
        var property_id = $('#property_id').val();
        var owner_id = $('#owner_id').val();
        var base_imponible = $('#base_imponible').val();
        var recharge = $('#recharge').val();
        var terrain_amount = $('#terrain_amount').val();
        var build_amount = $('#build_amount').val();
        var interest = $('#interest').val();
        // var alicuota = $('#alicuota').val();
        var fiscal_credit = $('#fiscal_credit').val();
        var discount = $('#discount').val();
        var amount = $('#amount').val();
        var status = $('#status').val();
        console.log(amount, property_id);
        e.preventDefault();
        $.ajax({
            method: "POST",
            dataType: "json",
            data: {
                property_id:property_id,
                owner_id: owner_id,
                base_imponible: base_imponible,
                recharge: recharge,
                interest: interest,
                terrain_amount: terrain_amount,
                build_amount: build_amount,
                // alicuota: alicuota,
                fiscal_credit: fiscal_credit,
                discount: discount,
                amount: amount,
                status: status
            },
            url: url + 'properties/taxes/store',
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
                console.log(resp.taxe_id);
                swal({
                    title: "!Bien Hecho!",
                    text: "Se ha generado una Planilla. Ahora debes proceder con el pago.",
                    icon: "success",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                }).then(function() {
                    location.href = url + 'properties/taxes/payments/' + resp.taxe_id;
                });
            },
            error: function (err) {
                console.log(err);
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
    });

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


    $('.type_payment_event').click(function () {
        $('#two-payments').addClass('disabled');
        $('#three-payments').addClass('disabled');
        var type = $(this).val();
        $('#type_payment').val(type.toUpperCase());

        if (type === 'ppb') {
            ConfirmtypePayment();
        }

        if (type === 'ptb') {
            $('#bod-div').addClass('hide');
        } else {
            $('#bod-div').removeClass('hide');
        }

        setTimeout(function () {
            if (type !== 'ppv') {
                $('#two-payments').removeClass('disabled');
                $('ul.tabs').tabs("select", "payment-bank");
            } else {
                $('#three-payments').removeClass('disabled');
                $('ul.tabs').tabs("select", "payment-receipt");
            }
        }, 250);
    });


    $('.bank-div').click(function () {
        var type = $(this).val();
        $('#bank_payment').val(type);
        setTimeout(function () {
            $('#three-payments').removeClass('disabled');
            $('ul.tabs').tabs("select", "payment-receipt");
        }, 250);

    });


    $('#div-send').click(function () {
        $("#preloader").fadeIn('fast');
        $("#preloader-overlay").fadeIn('fast');
        console.log(this);
        $('#form-payment')[0].submit()
    });


    $('#previous-receipt').click(function () {
        var type = $('#type_payment').val();
        if (type !== 'PPV') {
            $('ul.tabs').tabs("select", "payment-bank");
        } else {
            $('ul.tabs').tabs("select", "payment-method");

        }
    });


    $('#previous-bank').click(function () {
        $('ul.tabs').tabs("select", "payment-method");
    });

    function ConfirmtypePayment() {
        swal({
            title: "Información",
            text: "Debe eliger la forma en que va hacer su deposito:",
            icon: "warning",
            buttons: {
                CHEQUE: {
                    text: "CHEQUE",
                    value: 'PPC',
                    visible: true,
                    className: "amber-gradient"

                },
                CANCEL: {
                    text: "EFECTIVO",
                    value: 'PPE',
                    visible: true,
                    className: "green-gradient"
                },


            }
        }).then(function (value) {
            if (value !== null) {
                $('#type_payment').val(value);
            } else {
                ConfirmtypePayment();
            }
        });
    }
});