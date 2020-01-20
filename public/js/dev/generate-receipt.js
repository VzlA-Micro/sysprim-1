$('document').ready(function () {

    var url = "http://sysprim.com.devel/";

    var companies_id='';
    var type_taxes='';


    $('.payroll').change(function () {
        if(companies_id!==''){
            if($(this).is(":checked")&&$(this).attr('data-company')==companies_id) {
                 companies_id=$(this).attr('data-company');
            }else if ($(this).attr('data-company')!=companies_id){
                swal({
                    title: "Información",
                    text: "Las planillas selecionadas no pertenecen a la misma empresa.",
                    icon: "info",
                    button: "Ok",
                });
                $(this).prop('checked', false);
            }
        }else{
            companies_id=$(this).attr('data-company');
        }


        if(type_taxes!==''){
            if($(this).is(":checked")&&$(this).attr('data-company')==type_taxes) {
                type_taxes=$(this).attr('data-taxes');
            }else if ($(this).attr('data-taxes')!=type_taxes){
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
        }else{
            type_taxes=$(this).attr('data-taxes');
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




    /*
            $.ajax({
                method: "GET",
                url: url + "ticket-office/fin" + fiscal_period + "/" + company,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {


                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: 'La empresa ' + $('#name_company').val() + 'ya declaro el periodo de ' + $('#fiscal_period').val() + ', seleccione un periodo fiscal valido',
                            icon: "info",
                            button: "Ok",
                        });
                        $('#fiscal_period').val(' ')
                    }

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


    */


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


    $('#open-cashier').click(function () {
        if (localStorage.getItem('bank') == null) {
            swal({
                title: "PUNTO DE VENTA 1/2",
                text: "Introduzca el numero de lote del punto de venta:",
                icon: "info",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Escribe un numero",
                        type: "number",
                    },
                },
            }).then(function (name) {
                if (name === null || isNaN(name) || name <= 0) {
                    swal({
                        title: "Información",
                        text: "Acción cancelada,debe ingresar un numero de lote valido.",
                        icon: 'info'
                    });
                } else {
                    localStorage.setItem('lot', name);
                    swal({
                        title: "SELECIONE EL BANCO DE RECAUDACIÓN 2/2",
                        icon: "info",
                        buttons: {
                            cancel: true,
                            BANCO: {text: "100%BANCO", value: "33", className: "blue"},
                            BOD: {text: "BOD", value: "44", className: "green width"},
                        }
                    }).then(function (bank) {
                        if (bank === null) {
                            swal({
                                title: "Información",
                                text: "Acción cancelada,debe ingresar un punto.",
                                icon: 'info'
                            });
                        } else {
                            localStorage.setItem('bank', bank);
                            var hoy = new Date();
                            var dd = hoy.getDate();
                            localStorage.setItem('day',dd);
                            swal({
                                title: "Bien hecho",
                                text: "Ya puedes empezar a registrar pagos valido.",
                                icon: "success",
                            });

                            location.reload();
                        }
                    })
                }
            });

        } else {
            swal({
                title: "Información",
                text: "Acción cancelada,debe abrir caja.",
                icon: 'info'
            });
        }
    });
    var hoy = new Date();
    var dd = hoy.getDate();

    if(localStorage.getItem('day')!=dd){
        localStorage.removeItem('bank');
        localStorage.removeItem('lot');
        localStorage.removeItem('day');
    }





    if (localStorage.getItem('bank') === null && localStorage.getItem('lot') === null&&$('.content').val()!==undefined) {
        swal({
            title: "Información",
            text: "Debe abrir caja, para empezar a registrar pagos.",
            icon: "info",
        });
        $('.content').css('display', 'none');
    } else {

        var bank = localStorage.getItem('bank');
        var lot = localStorage.getItem('lot');


        if (bank === "44") {
            $('#name_bank').val('BOD');
        } else {
            $('#name_bank').val("100%BANCO");
        }

        $('#bank').val(bank);
        $('#lot').val(lot);

        M.updateTextFields();

        $('#content').css('display', 'block');
    }




    $('#close-cashier').click(function () {
        if (localStorage.getItem('bank') !== null) {
            swal({
                title: "Información",
                text: "¿Estas seguro?, Si cierras las caja, no podras revertir los cambios.",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Si",
                        value: true,
                        visible: true,
                        className: "green"

                    },
                    cancel: {
                        text: "No",
                        value: false,
                        visible: true,
                        className: "grey lighten-2"
                    }
                }
            }).then(function (aceptar) {
                if (aceptar) {
                    localStorage.removeItem('bank');
                    localStorage.removeItem('lot');
                    location.href = url + 'ticket-office/payments';
                }
            });


        } else {
            swal({
                title: "Información",
                text: "Acción cancelada,debe abrir la caja para poder cerrarla.",
                icon: 'info'
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

    $('input[type="text"].money_keyup').on('keyup', function (event) {
        var total=$(this).val();

        if($(this).val()==0&&$(this).val().toString().length>=2){
            $(this).val('');
        }else if($(this).val().toString().length>=2&&total[0]==0){
            $(this).val('');
        }else{
            $(event.target).val(function (index, value) {
                return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1,$2')
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
            });
        }
    });

    function generateReceipt() {
        var taxes_id=$('.taxes_id').val();
        window.open(url + 'ticket-office/generate-receipt/' +taxes_id, "RECIBO DE PAGO", "width=500, height=600");
    }



    $('#search').change(function () {
        if ($('#search').val() !== '') {
            var search = $('#search').val();
            $.ajax({
                method: "GET",
                url: url + "ticket-office/cashier/" + search,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
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
                        });
                        $('#search').val('');

                    } else {

                        var taxe = response.taxe[0];
                        var ciu = response.ciu;
                        var company = taxe.companies[0];

                        swal({
                            title: "¡Bien hecho!",
                            text: "Escaneo de QR realizado correctamente.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {
                            var link;


                            if(taxe.type!=='definitive'){
                                link='<a href='+url+'payments/taxes/'+taxe.id+''+
                                '\n class="btn indigo waves-effect waves-light"><i\n' +
                                ' class="icon-pageview left"></i>Detalles</a>';

                            }else{
                                link='<a href='+url+'ticket-office/taxes/definitive/'+taxe.id+'"' +
                                    '\nclass="btn indigo waves-effect waves-light"><i\n' +
                                    'class="icon-pageview left"></i>Detalles</a>';
                            }




                            $('#receipt-body').append('' +
                                '<tr>' +
                                    '<td><i class="icon-check text-green"></i>'+company.name+'</td>'+
                                    '<td>' +company.license+'</td>'+
                                    '<td>' +taxe.code+'</td>'+
                                    '<td>' +taxe.fiscalPeriodFormat+'</td>'+
                                    '<td>' +'<p>' +
                                        '  <label>\n' +
                                        '           <input type="checkbox" name="payroll" class="payroll"\n' +
                                        '                       value="'+taxe.id+'"/>\n' +
                                        '                         <span></span>\n' +
                                        '                                  </label>\n' +
                                        '</p>'+
                                    '</td>'+
                                     '<td>' +taxe.amountFormat+'</td>'+
                                     '<td>'+link+'</td>'+
                                '</tr>');

                            $(this).val();
                            M.updateTextFields();
                        });


                    }
                    formatMoney();
                    M.updateTextFields();
                    $('#search').val('');


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                },error: function (err) {
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
                                window.open(url + 'ticket-office/generate-receipt/' +taxes_id, "RECIBO DE PAGO", "width=500, height=600");
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
                    className: "green"

                },
                CANCEL: {
                    text: "EFECTIVO",
                    value: 'PPE',
                    visible: true,
                    className: "green"
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

    $('#phone_user').keyup(function () {
        if($('#country_code_user').val()===null){
            swal({
                title: "Información",
                text: "Debes seleccionar la operadora, antes de ingresar el número de teléfono.",
                icon: "info",
                button: "Ok",
            });
            $('#phone_user').val('');
        }
    });

});

