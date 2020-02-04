$(document).ready(function () {
    var url = localStorage.getItem('url');

    // var url = "https://sysprim.com/";
  
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


    $('.base').keyup(function () {
        if ($('#fiscal_period').val() == null) {
            swal({
                title: "Información",
                text: "Debes seleccionar el periodo fiscal.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $(this).val('');
        }
    });


    $('#taxes-register-definitive').submit(function (e) {
        e.preventDefault();
        var band = false;

        var base_band = true;

        var fiscal = $('#fiscal_period').val();
        if (fiscal === null) {
            swal({
                title: "Información",
                text: "Debes selecionar el periodo fiscal.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            band = true;
        }


        $('.base').each(function () {
            if ($(this).val() === '') {
                band = true;
                base_band = false;
            }

        });


        var tributo = $('#tributo').val();
        $('.code').each(function () {
            var code = $(this).val();
            var base = $('#base_' + code).val();
            var alicuota = $('#alicuota_' + code).val();
            var anticipated = $('#anticipated_' + code).val();


            // var deductions = $('#deductions_' + code).val();
            // var withholdings = $('#withholdings_' + code).val();
            //var fiscal_credits = $('#fiscal_credits_' + code).val();
            var min_tribu = $('#min_tribu_' + code).val();


            base = base.replace(/\./g, '');
            anticipated = anticipated.replace(/\./g, '');

            // if(deductions!==undefined) {
            // deductions = deductions.replace(/\./g, '');
            // withholdings = withholdings.replace(/\./g, '');
            // fiscal_credits = fiscal_credits.replace(/\./g, '');


            //var total_antipacit = parseFloat(deductions) + parseFloat(withholdings) + parseFloat(fiscal_credits);
            var total = Math.floor(parseFloat(base) * alicuota);


            var min_total = min_tribu  * tributo*12;

            if(min_total>total){
                total=min_total;
            }
;


            if (total !== 0) {
                if (parseFloat(anticipated)>total) {
                    swal({
                        title: "Información",
                        text: "Verifique los datos ingresados, el monto anticipado no puede ser mayor, que el calculo total de la base.",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });


                    band = true;
                }
                /* if(min_total>total){
                     swal({
                         title: "Información",
                         text: "El monto de la base imponible no " +
                         "puede ser menor que el minimo tributable " +
                         "por este CIIU,en caso de ser menor debe declarar " +
                         "como base imponible  0. Ord. Act. Económica Art.44",
                         icon: "info",
                         button: {
                             text: "Esta bien",
                             className: "blue-gradient"
                         },
                     }).then(function () {
                         $('.deductions').each(function () {

                             if ($(this).val() == '0') {
                                 $(this).val('');
                             }
                         });
                         $('.withholding').each(function () {
                             if ($(this).val() == '0') {
                                 $(this).val('');
                             }
                         });
                         $('.credits_fiscal').each(function () {
                             if ($(this).val() == '0') {
                                 $(this).val('');
                             }
                         });
                     });
                     band = true;
                 }
             }
             */
            } else {

                console.log(parseFloat(anticipated));
                console.log(parseFloat(min_total));

                if (parseFloat(anticipated)>min_total) {
                    swal({
                        title: "Información",
                        text: "Verifique los datos ingresados, el monto anticipado no puede ser mayor, que el calculo total de la base imponible anual.",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                    band=true;
                }

            }
        });
        if (!band) {
            if($('#credits_fiscal').val()==''){
                $('#credits_fiscal').val(0);
            }

            $('#taxes-register-definitive')[0].submit();
        }

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