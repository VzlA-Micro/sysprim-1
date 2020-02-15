$(document).ready(function() {
    var url = localStorage.getItem('url');

    // Buscar datos por Codigo catastral
    $('#code_cadastral').blur(function() {
        var code = $(this).val();
        if(code !== '') {
            $.ajax({
                method: 'GET',
                dataType: 'json',
                data: { code: code },
                url: url + 'properties/ticket-office/find/code/' + code,
                beforeSend: function() {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function(response) {
                    if(response.status == 'success') {
                        var property = response.property;
                        var user = response.property.users[0];
                        var id = property.id;
                        // console.log(response.taxe_id);
                        $('#property_id').val(property.id);
                        // console.log($('#property_id').val());
                        $('#area_ground').val(property.area_ground).attr('disabled',true);
                        $('#area_build').val(property.area_build).attr('disabled',true);
                        $('#address').val(property.address).attr('disabled',true);
                        $('#person').val(user.name + " " + user.surname).attr('disabled',true);
                        $('#value_cadastral_ground_id option[value='+ property.value_cadastral_ground_id + ']').attr('selected',true);
                        $('#value_cadastral_ground_id').attr('disabled',true);
                        $('#value_cadastral_build_id option[value='+ property.value_cadastral_build_id + ']').attr('selected',true);
                        $('#value_cadastral_build_id').attr('disabled',true);
                        $('#type_inmueble_id option[value='+ property.type_inmueble_id + ']').attr('selected',true);
                        $('#type_inmueble_id').attr('disabled',true);
                        $('#parish_id option[value='+ property.parish_id + ']').attr('selected',true);
                        $('#parish_id').attr('disabled',true);
                        $('#fiscal_period').attr('disabled',false);
                        $('#status').attr('disabled',false);
                        // $('#taxe_id').val(response.taxe_id);
                        $('select').formSelect();
                        // $('#status').attr('disabled',false);
                        M.updateTextFields();
                    }
                    else {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "warning",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                    }
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                },
                error: function(err) {
                    $('#code_cadastral').val('');
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
            })
        }
    });

    $('#fiscal_period').change(function () {
        var fiscalPeriod = $(this).val();
        var id = $('#property_id').val();

        $.ajax({
            type: "GET",
            url: url + "properties/verify/fiscal-period/" + id + "/" + fiscalPeriod,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                console.log(data);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                if (data) {
                    swal({
                        title: "Información",
                        text: 'Ya tiene un pago declarado para este periodo fiscal',
                        icon: "info",
                    });
                    $('#fiscal_period option[value=null]').attr('selected',true);
                }else {

                }
            },
            error: function (e) {
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

    $('#general-next').click(function () {
        if ($('#property_id').val() === '') {
            swal({
                title: "Información",
                text: 'Debe ingresar un código catastral para con continuar con el registro.',
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else if ($('#fiscal_period').val() == null) {
            swal({
                title: "Información",
                text: 'Debe seleccionar un periodo fiscal, para continuar con el registro.',
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });

        }
        else if($('#status').val() === '' || $('#status').val() === null) {
            swal({
                title: "Información",
                text: 'Debe seleccionar la forma de pago para continuar con el registro.',
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
        else {
            var id = $('#property_id').val();
            var status = $('#status').val();
            var fiscal_period = $('#fiscal_period').val();
            console.log(id, status, fiscal_period);
            $.ajax({
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                    status: status
                },
                url: url + 'properties/ticket-office/taxes/' + id + '/' + status + '/' + fiscal_period,
                beforeSend: function() {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function(resp) {
                    console.log(resp);
                    if(resp.state == 'success') {
                        var property = resp.property[0];
                        var owner_id = resp.owner_od;
                        var owner = resp.owner;
                        var alicuota = resp.alicuota;
                        var discount = resp.discount;
                        var interest = resp.interest;
                        var recharge = resp.recharge;
                        var status = resp.status;
                        var total = resp.total;
                        console.log(resp.totalGround, resp.totalBuild);
                        $('#owner_id').val(owner_id);
                        $('#totalGround').val(resp.totalGround);
                        $('#totalBuild').val(resp.totalBuild);
                        $('#base_imponible').val(resp.baseImponible)
                        $('#alicuota').val(alicuota);
                        $('#discount').val(discount);
                        $('#interest').val(interest);
                        $('#recharge').val(recharge);
                        $('#statusTax').val(status);
                        $('#amount').val(total);
                        M.updateTextFields();
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "details-tab");
        }
    });

    $('#generate-payroll').submit(function(e) {
        // e.preventDefault();
        var property_id = $('#property_id').val();
        var owner_id = $('#owner_id').val();
        var base_imponible = $('#base_imponible').val();
        var recharge = $('#recharge').val();
        var interest = $('#interest').val();
        var alicuota = $('#alicuota').val();
        var fiscal_credit = $('#fiscal_credit').val();
        var fiscal_period = $('#fiscal_period').val();
        var discount = $('#discount').val();
        var amount = $('#amount').val();
        var status = $('#status').val();
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
                alicuota: alicuota,
                fiscal_credit: fiscal_credit,
                fiscal_period: fiscal_period,
                discount: discount,
                amount: amount,
                status: status
            },
            url: url + 'properties/ticket-office/taxes/store',
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
                console.log(resp.taxe_id);
                swal({
                    title: "¡Bien Hecho!",
                    text: resp.message + " ¿Desea seguir generando planillas?",
                    icon: "success",
                    buttons: {
                        confirm: {
                            text: "Si",
                            value: true,
                            visible: true,
                            className: "green-gradient"

                        },
                        cancel: {
                            text: "No",
                            value: false,
                            visible: true,
                            className: "grey lighten-2"
                        }
                    }

                }).then(function (confirm) {
                    if (confirm) {
                        location.reload();
                    } else {
                        url=localStorage.getItem('url');
                        window.location.href = url + 'properties/ticket-office/payments/taxes';
                    }
                });
                /*console.log(resp.taxe_id);
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
                });*/
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

    /*function sendPayroll() {

    }*/
    /*$('#register-payroll').submit(function(e) {
        e.preventDefault();

        $.ajax({
            method: 'post',
            dataType: 'json',
            data: formData,
            url: url + 'properties/ticket-office/store/',
            beforeSend: function() {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
                console.log(resp);
            },
            error: function (err) {
                console.log(err);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
                });
            }
        });
    });*/

    var property_id = '';
    var type_taxes = '';


    $('.payroll').change(function () {


        if (property_id !== '') {
            console.log('if');

            if ($(this).is(":checked") && $(this).attr('data-property') == property_id) {
                console.log('lleno');
                //vehicle_id = $(this).attr('data-vehicle');
            } else if ($(this).attr('data-property') != property_id) {
                swal({
                    title: "Información",
                    text: "La planilla selecionada no pertenece al mismo inmueble .",
                    icon: "info",
                    button: "Ok",
                }).then(function () {
                    location.reload();
                });
                $(this).prop('checked', false);
                console.log('no coincide');
            }
            else if (!$(this).is(":checked")) {
                console.log('limpio');
                property_id = '';
            }
        } else {
            console.log('else');
            property_id = $(this).attr('data-property');
        }


        /*if (type_taxes !== '') {
            if ($(this).is(":checked") && $(this).attr('data-company') == type_taxes) {
                type_taxes = $(this).attr('data-taxes');
            } else if ($(this).attr('data-taxes') != type_taxes) {
                swal({
                    title: "Información",
                    text: "Las planillas selecionadas deben ser del mismo tipo.",
                    icon: "info",
                    button: "Ok",
                }).then(function () {

                    location.reload();
                });


                $(this).prop('checked', false);
            }
        } else {
            type_taxes = $(this).attr('data-taxes');
        }*/

    });

    var date = new Date();

    $('.fiscal_period').datepicker({
        maxDate: date,
        // defaultDate: date,
        format: 'yyyy-mm-dd', // Configure the date format
        yearRange: [1900, date.getFullYear()],
        showClearBtn: false,
        i18n: {
            cancel: 'Cerrar',
            clear: 'Reiniciar',
            done: 'Hecho',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        },
        disableDayFn: function (date) {
            if (date.getDate() == 1) // getDay() returns a value from 0 to 6, 1 represents Monday
                return false;
            else
                return true;
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


    $('#select-next').click(function () {
        var acum = '';
        var band=false;


        $('input.payroll:checked').each(function () {
            band=true;
            acum += $(this).val() + '-';
        });

        if(band){
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "payment-tab");
            $.ajax({
                method: "GET",
                url: url + "ticket-office/taxes/calculate/" + acum,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {



                    if(response.status==='success'){
                        $('.taxes_id').each(function () {
                            $(this).val(acum);
                        });

                        $('.amount').each(function(){
                            $(this).val(response.amount);
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                        $('#amount_total_depo').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        $('#amount_total').val(function (index, value) {
                            return number_format(value, 2);
                        });
                        $('#amount_total_tr').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        M.updateTextFields();

                    }else{
                        swal({
                            title: "!Bien Hecho",
                            text: "La planilla ingresada se ha verificada con éxito, ya que el dinero a pagar es igual a 0.",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            window.open(url + 'ticket-office/generate-receipt/' +acum, "RECIBO DE PAGO", "width=500, height=600");

                            location.reload();
                        });
                    }
                },

                error: function (err) {
                    console.log(err);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }else{
            swal({
                title: "Información",
                text: "Debes selecionar una planilla válida.",
                icon: "info",
                button: "Ok",
            });
        }

    });

    $('#register-payment').submit(function (e) {
        e.preventDefault();
        var amount = $('#amount_total').val();
        var amount_pay = $('#amount').val();

        amount=amount.replace(/\./g,'');
        amount_pay=amount_pay.replace(/\./g,'');


        amount=amount.replace(/,/g, "");
        amount_pay=amount_pay.replace(/,/g, "");


        if (parseInt(amount_pay) > parseInt(amount)) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button: "Ok",
            });

        } else {
            $.ajax({
                url: url + "ticket-office/payment/save",
                contentType: false,
                processData: false,
                data: new FormData(this),
                method: "POST",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    console.log(response);
                    if (response.status === 'process') {
                        $('#amount_total').val(response.payment);
                        $('#amount_total').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        swal({
                            title: "Información",
                            text: "Para conciliar esta planilla " +
                            "el monto debe ser cancelado en su totalidad.Debe cancelar el dinero restante:" + $('#amount_total').val() + "Bs",
                            icon: "info",
                            button: "Ok",
                        });


                    } else {
                        swal({
                            title: "¡Bien hecho!",
                            text: "Planillas ingresa y conciliada con éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            if(accept||!accept){
                                generateReceipt();
                                location.reload();
                            }
                        });



                    }
                    $('#ref').val('');
                    $('#amount').val('');

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
                        button: "Ok",
                    });
                }
            });

        }
    });

    function generateReceipt() {
        var taxes_id=$('.taxes_id').val();
        window.open(url + 'properties/ticket-office/receipt/' + taxes_id + '/true', "RECIBO DE PAGO", "width=500, height=600");
    }

    $('#register-payment-depo').submit(function (e) {
        e.preventDefault();

        if($('input:radio:checked.check-payment').val()!==undefined&&$('input:radio:checked.bank-div').val()!==undefined){
            $.ajax({
                url: url + "ticket-office/payment/save",
                contentType: false,
                processData: false,
                data: new FormData(this),
                method: "POST",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    var taxes_id=$('.taxes_id').val();
                    swal({
                        title: "¡Bien hecho!",
                        text: "Planilla ingresa y registrada con éxito.",
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        $('#amount_total_tr').val('');
                        if ($('#company_id').val() !== '') {
                            generateReceipt();
                            location.reload();
                        }

                    });
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
                        button: "Ok",
                    });
                }
            });

        }else{
            if($('input:radio:checked.check-payment').val()===undefined){
                swal({
                    title: "Información",
                    text: "Debes de selecionar la forma de pago en que se va hacer el deposito.",
                    icon: "warning",
                    button: "Ok",
                });
            }else if($('input:radio:checked.bank-div').val()===undefined){
                swal({
                    title: "Información",
                    text: "Debes de selecionar el banco en el cual se va realizar el deposito.",
                    icon: "warning",
                    button: "Ok",
                });
            }


        }

    });


    $('#register-payment-tr').submit(function (e) {
        e.preventDefault();
        var amount = $('#amount_total_tr').val();
        var amount_pay = $('#amount_tr').val();

        amount=amount.replace(/\./g,'');
        amount_pay=amount_pay.replace(/\./g,'');


        amount=amount.replace(/,/g, "");
        amount_pay=amount_pay.replace(/,/g, "");




        if (parseInt(amount_pay) > parseInt(amount)) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button: "Ok",
            });

        } else {

            if($('#bank_destinations_tr').val()!=null&&$('#bank_tr').val()!=null) {
                $.ajax({
                    url: url + "ticket-office/payment/save",
                    contentType: false,
                    processData: false,
                    data: new FormData(this),
                    method: "POST",

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        var taxes_id = $('.taxes_id').val();

                        console.log(response);
                        if (response.status === 'process') {
                            $('#amount_total_tr').val(response.payment);

                            $('#amount_total_tr').val(function (index, value) {
                                return number_format(value, 2);
                            });
                            swal({
                                title: "Información",
                                text: "Para conciliar esta planilla " +
                                "el monto debe ser cancelado en su totalidad.Debe cancelar el dinero restante:" + $('#amount_total_tr').val() + "Bs",
                                icon: "info",
                                button: "Ok",
                            });

                        } else {
                            swal({
                                title: "¡Bien hecho!",
                                text: "Planilla ingresa, una vez se verifique el pago se enviara la planilla, al correo afiliado a esta empresa.",
                                icon: "success",
                                button: "Ok",
                            }).then(function (accept) {
                                location.reload();
                            });

                        }
                        $('#ref_tr').val('');
                        $('#amount_tr').val('');
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
                            button: "Ok",
                        });
                    }
                });

            }else{
                if($('#bank_destinations_tr').val()===null){
                    swal({
                        title: "Información",
                        text: "Debe selecionar el banco donde el dinero va ingresar.",
                        icon: "info",
                        button: "Ok",
                    });
                }else if($('#bank_tr').val()===null){
                    swal({
                        title: "Información",
                        text: "Debe selecionar el banco de donde se realizara la transferencia.",
                        icon: "info",
                        button: "Ok",
                    });
                }
            }



        }

    });

    $('.check-payment').click(function () {
        if($(this).val()==='PPC'){
            $('#ref_depo').removeAttr('readonly');
        }else{
            $('#ref_depo').attr('readonly','readonly');
            $('#ref_depo').val('');
        }
        $('#payments_type_depo').val($(this).val());
    });

    function formatMoney() {
        $('input[type="text"].money').each(function () {
            $(this).val(function (index, value) {
                return number_format(value, 2);
            });
        });

        $('#amount').text(function (index, value) {
            return number_format(value, 2);
        });


    }

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

    $('#search').change(function () {
        if ($('#search').val() !== '') {
            var search = $('#search').val();
            $.ajax({
                method: "GET",
                url: url + "ticketOffice/property/cashier/" + search,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'error') {
                        swal({
                            title: "Error",
                            text: "El código de planilla ingresado no es validado, por favor ingrese  una planilla valida.",
                            icon: "error",
                            button: "Ok",
                        });


                        $('#search').val('');
                    } else if (response.status === 'verified') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya fue conciliada, por favor ingrese un código de  planilla valido.",
                            icon: "info",
                            button: "Ok",
                        });
                        $('#search').val('');

                    } else if (response.status === 'cancel') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada esta cancelada, por favor ingrese un código de  planilla valido.",
                            icon: "warning",
                            button: "Ok",
                        });
                        $('#search').val('');
                    } else if (response.status === 'old') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya expiró, por favor ingrese un código de  planilla valido.",
                            icon: "warning",
                            button: "Ok",
                        }).then(response=>function () {
                            location.reload();
                        });
                        $('#search').val('');

                    } else {

                        var taxe = response.taxe[0];
                        var property = response.taxe[0]['properties'][0].code_cadastral;
                        var propertyId = response.taxe[0]['properties'][0].id;
                        swal({
                            title: "¡Bien hecho!",
                            text: "Escaneo de QR realizado correctamente.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            var link;

                            link = '<a href=' + url + 'rate/ticket-office/details/' + taxe.id + '"' +
                                '\nclass="btn indigo waves-effect waves-light"><i\n' +
                                'class="icon-pageview left"></i>Detalles</a>';


                            $('#receipt-body').append('' +
                                '<tr>' +
                                '<td>' + property.substr(14,12) + '</td>' +
                                '<td><i class="icon-check text-green"></i>' + taxe.created_at + '</td>' +
                                '<td>' + taxe.code + '</td>' +
                                '<td>' + taxe.branch + '</td>' +
                                '<td>' + taxe.amountFormat + '</td>' +
                                '<td>' + '<p>' +
                                '  <label>\n' +
                                '           <input type="checkbox" name="payroll" class="payroll"\n' +
                                '                       value="' + taxe.id + '"' +
                                'data-vehicle="' + propertyId +
                                '"/>\n' +
                                '                         <span></span>\n' +
                                '                                  </label>\n' +
                                '</p>' +
                                '</td>' +
                                '<td>' + link + '</td>' +
                                '</tr>'
                            );
                            var property_id = '';
                            var type_taxes = '';


                            $('.payroll').change(function () {


                                if (property_id !== '') {
                                    console.log('if');

                                    if ($(this).is(":checked") && $(this).attr('data-property') == property_id) {
                                        console.log('lleno');
                                        //vehicle_id = $(this).attr('data-vehicle');
                                    } else if ($(this).attr('data-property') != property_id) {
                                        swal({
                                            title: "Información",
                                            text: "La planilla selecionada no pertenece al mismo inmueble .",
                                            icon: "info",
                                            button: "Ok",
                                        }).then(function () {
                                            location.reload();
                                        });
                                        $(this).prop('checked', false);
                                        console.log('no coincide');
                                    }
                                    else if (!$(this).is(":checked")) {
                                        console.log('limpio');
                                        property_id = '';
                                    }
                                } else {
                                    console.log('else');
                                    property_id = $(this).attr('data-property');
                                }


                                /*if (type_taxes !== '') {
                                    if ($(this).is(":checked") && $(this).attr('data-company') == type_taxes) {
                                        type_taxes = $(this).attr('data-taxes');
                                    } else if ($(this).attr('data-taxes') != type_taxes) {
                                        swal({
                                            title: "Información",
                                            text: "Las planillas selecionadas deben ser del mismo tipo.",
                                            icon: "info",
                                            button: "Ok",
                                        }).then(function () {

                                            location.reload();
                                        });


                                        $(this).prop('checked', false);
                                    }
                                } else {
                                    type_taxes = $(this).attr('data-taxes');
                                }*/

                            });
                            $(this).val();
                            M.updateTextFields();
                        });


                    }
                    formatMoney();
                    M.updateTextFields();
                    $('#search').val('');


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                }, error: function (err) {
                    $('#license').val('');
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }
    });
});