$(document).ready(function() {
    var url = localStorage.getItem('url');
    var date = new Date();
    var currentYear = date.getFullYear();

    $('#code').blur(function() {
        var code = $(this).val();
        $('#publicity_id').val('');
        $('#person').val('');
        $('#advertising_type_id').val('');
        $('#type').val('');
        $('#name').val('');
        $('#date_start').val('');
        $('#date_end').val('');
        $('select').formSelect();

        if(code !== '') {
            $.ajax({
                method: 'GET',
                dataType: 'json',
                data: { code: code },
                url: url + 'publicity/ticket-office/find/code/' + code,
                beforeSend: function() {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function(response) {
                    if(response.status == 'success') {
                        console.log(response);
                        var publicity = response.publicity;
                        var user = response.publicity.users[0];
                        var taxeType = response.type;
                        var id = publicity.id;
                        $('#publicity_id').val(id);
                        $('#name').val(publicity.name);
                        $('#advertising_type_id option[value=' + publicity.advertising_type_id + ']').attr('selected',true);
                        $('#advertising_type_id').attr('disabled',true);
                        $('#advertising_type_id_2 option[value=' + publicity.advertising_type_id + ']').attr('selected',true);
                        $('#date_start').val(publicity.date_start).attr('disabled',true);
                        $('#date_end').val(publicity.date_end).attr('disabled',true);
                        $('#person').val(user.name + " " + user.surname).attr('disabled',true);
                        $('#type').val(taxeType);
                        $('#taxe_id').val(response.taxe_id);
                        console.log(response.taxe_id);
                        var period = currentYear.toString() + '-01-01';
                        if(taxeType === 'annual') {
                            $('#fiscal_period').attr('disabled',false);
                            $('#status option').each(function(index) {
                                if(this.value !== taxeType) {
                                    this.setAttribute('disabled',true);
                                    this.setAttribute('selected',false);
                                }
                                /*else {
                                    this.setAttribute('disabled',false);
                                }*/
                            });
                            $('#status option[value=' + taxeType + ']').attr('selected',true).attr('disabled',false);
                            $('#status').attr('disabled',false);
                        }
                        else if(taxeType === 'monthly') {
                            $('#fiscal_period').attr('disabled',false);
                            $('#fiscal_period option').each(function(index) { // Deshabilita los años diferentes al año actual del select
                                if(this.value !== period) {
                                    this.setAttribute('disabled',true);
                                    this.setAttribute('selected',false);
                                }
                            });
                            $('#fiscal_period option[value='+ date.getFullYear() + '-01-01' + ']').attr('selected',true);
                            $('#status option').each(function(index) {
                                if(this.value !== taxeType) {
                                    this.setAttribute('disabled',true);
                                    this.setAttribute('selected',false);
                                }
                                /*else {
                                    this.setAttribute('disabled',false);
                                }*/
                            });
                            // Selecciona el tipo de pago
                            $('#status option[value=' + taxeType + ']').attr('selected',true).attr('disabled',false);
                            $('#status').attr('disabled',false);
                        }
                        else if(taxeType === 'daily') {
                            $('#fiscal_period').attr('disabled',false);
                            $('#fiscal_period option').each(function(index) { // Deshabilita los años diferentes al año actual del select
                                if(this.value !== period) {
                                    this.setAttribute('disabled',true);
                                    this.setAttribute('selected',false);
                                }
                            });
                            $('#fiscal_period option[value='+ date.getFullYear() + '-01-01' + ']').attr('selected',true);
                            $('#status option').each(function(index) {
                                if(this.value !== taxeType) {
                                    this.setAttribute('disabled',true);
                                    this.setAttribute('selected',false);
                                }
                                /*else {
                                    this.setAttribute('disabled',false);
                                }*/
                            });
                            // Selecciona el tipo de pago
                            $('#status option[value=' + taxeType + ']').attr('selected',true).attr('disabled',false);
                            $('#status').attr('disabled',false);
                        }
                        $('select').formSelect();
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
                        $('#code').val('');
                    }
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                },
                error: function(err) {
                    $('#code').val('');
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
                    console.log(err);
                }
            });
        }
    });

    $('#fiscal_period').change(function () {
        var fiscalPeriod = $(this).val();
        var id = $('#publicity_id').val();
        var type = $('#type').val();
        if(type == 'annual') {
            $.ajax({
                type: "GET",
                url: url + "publicity/ticket-office/verify/fiscal-period/" + id + "/" + fiscalPeriod,
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
                        $('#general-next').attr('disabled','disabled');
                        /*$('#fiscal_period option[value='+ fiscalPeriod +']').attr('selected',false).attr('disabled',true);
                        $('#fiscal_period option[value=null]').attr('selected',true);
                        $('select').formSelect();*/
                    }else {
                        $('#general-next').removeAttr('disabled', '');
                    }
                },
                error: function (e) {
                    console.log(e);
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
        }
    });

    $('#fiscal_credit').change(function() {
        var fiscal_credit = $(this).val();
        var amount = $('#amount').val();
        var taxe_id = $('#taxe_id').val();
        var publicity_id = $('#publicity_id').val();

        swal({
            title: "Información",
            text: "Al momento de introducir su crédito fiscal, debe asegurarse de que el monto introducido sea el correcto. Una vez introcducido no podra agregar un nuevo monto, en caso de equivocarse en el monto deberá anular la planilla y volver a generarla.",
            icon: "info",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey lighten-2",
                    closeModal: true
                },
                confirm: {
                    text: "Confirmar",
                    value: true,
                    visible: true,
                    className: "red",
                    closeModal: true
                }
            }
        }).then(confirm => {
            if(confirm) {
                $.ajax({
                    method: 'post',
                    dataType: 'json',
                    data: {
                        fiscal_credit: fiscal_credit,
                        amount: amount,
                        taxe_id: taxe_id,
                        publicity_id: publicity_id
                    },
                    url: url + 'publicity/taxes/total',
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
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    }
                });
                $('#fiscal_credit').prop('disabled',true);
            }
            else {
                $('#fiscal_credit').val('');
            }
        });
    });


    $('#general-next').click(function () {
        if ($('#publicity_id').val() === '') {
            swal({
                title: "Información",
                text: 'Debe ingresar un código de publicidad para con continuar con el registro.',
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
            var id = $('#publicity_id').val();
            var status = $('#status').val();
            var fiscal_period = $('#fiscal_period').val();
            console.log(id);
            $.ajax({
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                    status: status
                },
                url: url + 'publicity/ticket-office/taxes/' + id + '/' + status + '/' + fiscal_period,
                beforeSend: function() {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function(resp) {
                    console.log(resp);
                    if(resp.state == 'success') {
                        var advertisingType = resp.publicity.advertising_type;
                        var publicity = resp.publicity;
                        console.log(publicity.advertising_type_id);
                        var owner_id = resp.owner_id;
                        var owner = resp.owner;
                        var status = resp.status;
                        var amount = resp.amount;
                        $('#owner_id').val(owner_id);
                        $('#base_imponible').val(resp.baseImponible);
                        $('#increment').val(resp.increment);
                        $('#statusTax').val(status);
                        $('#advertising_type_id option[value=' + publicity.advertising_type_id + ']').attr('selected',true);
                        $('#value').val(advertisingType.value);
                        $('#amount').val(amount);
                        $('#taxe_id').val(resp.taxe_id);
                        $('select').formSelect();
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


    $('#generate-payroll').submit(function(e) {
        e.preventDefault();
        swal({
            title: "¡Bien Hecho!",
            text: "Se ha registrado una planilla. ¿Desea seguir generando planillas?",
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
                window.location.href = url + 'publicity/ticket-office/payments/taxes';
            }
        });
    });

    /* $('#generate-payroll').submit(function(e) {
        // e.preventDefault();
        var publicity_id = $('#publicity_id').val();
        var owner_id = $('#owner_id').val();
        var base_imponible = $('#base_imponible').val();
        var increment = $('#increment').val();
        var fiscal_credit = $('#fiscal_credit').val();
        var fiscal_period = $('#fiscal_period').val();
        var amount = $('#amount').val();
        var status = $('#status').val();
        var type = $('#type').val();

        e.preventDefault();
        $.ajax({
            method: "POST",
            dataType: "json",
            data: {
                publicity_id:publicity_id,
                owner_id: owner_id,
                base_imponible: base_imponible,
                fiscal_credit: fiscal_credit,
                fiscal_period: fiscal_period,
                amount: amount,
                increment: increment,
                type: type,
                status: status
            },
            url: url + 'publicity/ticket-office/taxes/store',
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
                        window.location.href = url + 'publicity/ticket-office/payments/taxes';
                    }
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
    }); */ 

    var publicity_id = '';
    var type_taxes = '';


    $('.payroll').change(function () {

        if (publicity_id !== '') {
            console.log('if');

            if ($(this).is(":checked") && $(this).attr('data-property') == publicity_id) {
                console.log('lleno');
                //vehicle_id = $(this).attr('data-vehicle');
            } else if ($(this).attr('data-property') != publicity_id) {
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
                publicity_id = '';
            }
        } else {
            console.log('else');
            publicity_id = $(this).attr('data-property');
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
        window.open(url + 'publicity/ticket-office/receipt/' + taxes_id + '/true', "RECIBO DE PAGO", "width=500, height=600");
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
                url: url + "ticketOffice/publicity/cashier/" + search,
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
                        var publicity = response.taxe[0]['publicities'][0].code;
                        var publicityId = response.taxe[0]['publicities'][0].id;
                        swal({
                            title: "¡Bien hecho!",
                            text: "Escaneo de QR realizado correctamente.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            var link;

                            link = '<a href=' + url + 'publicity/ticket-office/payments/details/' + taxe.id + '"' +
                                '\nclass="btn indigo waves-effect waves-light"><i\n' +
                                'class="icon-pageview left"></i>Detalles</a>';


                            $('#receipt-body').append('' +
                                '<tr>' +
                                '<td>' + publicity.substr(14,12) + '</td>' +
                                '<td><i class="icon-check text-green"></i>' + taxe.created_at + '</td>' +
                                '<td>' + taxe.code + '</td>' +
                                '<td>' + taxe.branch + '</td>' +
                                '<td>' + taxe.amountFormat + '</td>' +
                                '<td>' + '<p>' +
                                '  <label>\n' +
                                '           <input type="checkbox" name="payroll" class="payroll"\n' +
                                '                       value="' + taxe.id + '"' +
                                'data-vehicle="' + publicityId +
                                '"/>\n' +
                                '                         <span></span>\n' +
                                '                                  </label>\n' +
                                '</p>' +
                                '</td>' +
                                '<td>' + link + '</td>' +
                                '</tr>'
                            );
                            var publicity_id = '';
                            var type_taxes = '';


                            $('.payroll').change(function () {


                                if (publicity_id !== '') {
                                    console.log('if');

                                    if ($(this).is(":checked") && $(this).attr('data-property') == publicity_id) {
                                        console.log('lleno');
                                        //vehicle_id = $(this).attr('data-vehicle');
                                    } else if ($(this).attr('data-property') != publicity_id) {
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
                                        publicity_id = '';
                                    }
                                } else {
                                    console.log('else');
                                    publicity_id = $(this).attr('data-property');
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