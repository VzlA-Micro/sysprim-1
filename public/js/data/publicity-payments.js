$(document).ready(function() {
    var url = localStorage.getItem('url');

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

    $('#register').submit(function(e) {
        e.preventDefault();

        var base_imponible = $('#base_imponible').val();
        var interest = $('#interest').val();
        var fiscal_credit = $('#fiscal_credit').val();
        var publicity_id = $('#publicity_id').val();
        var amount = $('#amount').val();
        var increment = $('#increment').val();

        $.ajax({
            method: 'POST',
            dataType: 'json',
            data: {
                base_imponible: base_imponible,
                interest: interest,
                fiscal_credit: fiscal_credit,
                increment: increment,
                publicity_id: publicity_id,
                amount: amount
            },
            url: url + 'publicity/taxes/store',
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
                    location.href = url + 'publicity/payments/taxes/' + resp.taxe_id;
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