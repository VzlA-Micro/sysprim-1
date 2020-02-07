$('document').ready(function () {
    var url = localStorage.getItem('url');
    var user=$('#user').val();



    $('#document').keyup(function () {
        if($('#type_document').val()===null){
            swal({
                title: "Información",
                text: "Debes seleccionar el tipo de documento, antes de ingresar el número de documento.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#document').val('')
        }

    });


    $('#document').change(function () {
        findDocument();
    });


    $('#type_document').change(function () {
        findDocument();
    });

    $('#data-next').click(function () {
        band=true;


        $('.rate').each(function () {
            if(($(this).val()===''||$(this).val()===null) && $('#type_company').val()!='company'&& $(this).attr('data-validate')!='email') {
                swal({
                    title: "Información",
                    text: "Complete el campo " + $(this).attr('data-validate') + " para continuar con el registro.",
                    icon: "info",
                    button: {
                        text: "Esta bien",
                        className: "blue-gradient"
                    },
                });

                band = false;
            }
        });



        if(band) {
            if ($('#id').val() == '') {
                var type = $('#type').val();
                var name;
                if (type == 'user') {
                    name = $('#user_name').val();
                } else {
                    name = $('#name').val();
                }

                var type_document = $('#type_document').val();
                var document = $('#document').val();
                var address = $('#address').val();
                var surname = $('#surname').val();
                var email = $('#email').val();





                $.ajax({
                    method: "POST",
                    dataType: "json",
                    data: {
                        name: name,
                        surname: surname,
                        email:email,
                        type_document: type_document,
                        document: document,
                        address: address,
                        type: type,
                        user:user,

                    },
                    url: url + 'rate/taxpayers/company-user/register',

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        $('#id').val(response.id);

                        $('#two').removeClass('disabled');
                        $('#one').addClass('disabled');
                        $('ul.tabs').tabs("select", "rate-tab");
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    },
                    error: function (err) {

                        swal({
                            title: "¡Oh no!",
                            text: "Ha ocurrido un error inesperado, refresca la página e intentalo de nuevo.",
                            icon: "error",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            }
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    }
                });
            } else {
                $('#two').removeClass('disabled');
                $('#one').addClass('disabled');
                $('ul.tabs').tabs("select", "rate-tab");
            }
        }


    });



    $('#register-rates').click(function () {
        var rate_id=[];
        var type=$('#type').val();
        var id=$('#id').val();


        $('#rates').DataTable().destroy();

        $("input[type=checkbox]:checked").each(function(){
            rate_id.push($(this).val());
        });

        if(rate_id.length>0) {
            $.ajax({
                method: "POST",
                dataType: "json",
                data: {
                    rate_id: rate_id,
                    type: type,
                    id: id,
                },
                url: url + 'rate/ticket-office/register',

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                            swal({
                                title: "¡Bien Hecho!",
                                text: "La planilla ha sido generado con éxito, ¿Desea seguir generando planillas?",
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

                            }).then(function (aceptar) {
                                if (aceptar) {
                                    location.reload();

                                } else {
                                    window.location.href = url + 'rate/ticket-office/payments';

                                }
                            });

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                },
                error: function (err) {
                    console.log(err);
                    swal({
                        title: "¡Oh no!",
                        text: "Ha ocurrido un error inesperado, refresca la página e intentalo de nuevo.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            visible: true,
                            value: true,
                            className: "green",
                            closeModal: true
                        }
                    });

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                }
            });
        }else{
            swal({
                title: "Información",
                text: "Debes seleccionar al menos una  tasa a generar.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }

    });



    function findDocument() {
        var type_document=$('#type_document').val();
        var document=$('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');


        if(document!=='') {
            $.ajax({
                method: "GET",
                url: url + "rate/taxpayers/find/" + type_document  +"/"+document,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if(response.type=='not-user') {
                        var user = response.user.response;
                        $('#name').val(user.nombres + ' ' + user.apellidos);
                        $('#name').attr('readonly');
                        $('#surname').val(user.apellidos);
                        $('#user_name').val(user.nombres);
                        $('#type').val('user');
                        $('#id').val(user.id);

                    }else if(response.type=='user'){

                        var user = response.user;
                        $('#name').val(user.name + ' ' + user.surname);
                        $('#name').attr('readonly');
                        $('#surname').val(user.surname);
                        $('#id').val(user.id);
                        $('#address').val(user.address);
                        $('#email').val(user.email);



                        $('#type').val('user');


                        $('#address').attr('readonly','');
                        $('#email').attr('readonly','');



                    }else if(response.type=='company'){
                        var company = response.company;
                        $('#name').val(company.name);
                        $('#address').val(company.address);
                        $('#name').attr('readonly');
                        $('#address').attr('disabled');
                        $('#id').val(company.id);
                        $('#type').val('company');
                        $('#address').attr('readonly','');
                        $('#email').attr('readonly','');

                    }else if(response.type=='not-company'){
                        swal({
                            title: "Información",
                            text: "La empresa no esta registrada en el sistema, debes ingresar un empresa valida.",
                            icon: "info",
                            buttons: {
                                confirm: {
                                    text: "Registrarla",
                                    value: true,
                                    visible: true,
                                    className: "green-gradient"

                                },
                                cancel: {
                                    text: "Cancelar",
                                    value: false,
                                    visible: true,
                                    className: "grey lighten-2"
                                }
                            }
                        }).then(function (aceptar) {
                            if (aceptar) {
                                window.location.href = url + "ticketOffice/company/register";
                            }
                        });




                        $('#document').val('');
                    }

                    M.updateTextFields();
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
    }



        var companies_id='';
        var type_taxes='';



        $('.payroll').change(function () {

            var c=0;



            $("input[type=checkbox]:checked").each(function(index, check ){
                c++;
            });

            if(c>1) {
                swal({
                    title: "Información",
                    text: "Solo se puede selecionar una planilla para realiazar el pago. ",
                    icon: "info",
                    button: "Ok",
                });
                $(this).prop('checked', false);

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
            window.open(url + 'rate/taxpayers/pdf/' +taxes_id+'/false', "RECIBO DE PAGO", "width=500, height=600");
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

                            swal({
                                title: "¡Bien hecho!",
                                text: "Escaneo de QR realizado correctamente.",
                                icon: "success",
                                button: "Ok",
                            }).then(function (accept) {
                                var link;

                                link='<a href='+url+'rate/ticket-office/details/'+taxe.id+'"' +
                                        '\nclass="btn indigo waves-effect waves-light"><i\n' +
                                        'class="icon-pageview left"></i>Detalles</a>';


                                $('#receipt-body').append('' +
                                    '<tr>' +
                                    '<td><i class="icon-check text-green"></i>'+taxe.created_at+'</td>'+
                                    '<td>' +taxe.code+'</td>'+
                                    '<td>' +taxe.branch+'</td>'+
                                    '<td>' +taxe.amountFormat+'</td>'+
                                    '<td>' +'<p>' +
                                    '  <label>\n' +
                                    '           <input type="checkbox" name="payroll" class="payroll"\n' +
                                    '                       value="'+taxe.id+'"/>\n' +
                                    '                         <span></span>\n' +
                                    '                                  </label>\n' +
                                    '</p>'+
                                    '</td>'+
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
                                window.open(url + 'rate/taxpayers/pdf/' +taxes_id+'/false', "RECIBO DE PAGO", "width=500, height=600");
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



    $('#email').blur(function () {


        if ($('#email').val() !== '') {
            var email = $('#email').val();
            $.ajax({
                method: "GET",
                url: url+"rate/ticket-office/verify-email/"+email,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        $('#email').val('');
                    }
                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button:{
                            text: "Entendido",
                            className: "blue-gradient"
                        },
                    });
                    $('#email').val('');
                }
            });
        }



    });

});
