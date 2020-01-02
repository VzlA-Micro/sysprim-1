$(document).ready(function () {


    //var url="https://sysprim.com/";
    var url="http://172.19.50.253/";
   // var url="http://sysprim.com.devel/";

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
                            text: "El código de la planilla ingresada no es válido, por favor ingrese una planilla válida.",
                            icon: "error",
                            button:{
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });
                        $('#search').val('');
                    } else if (response.status === 'verified') {
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya fue conciliada, por favor ingrese el código de una planilla válida.",
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        $('#search').val('');

                    }else if(response.status === 'cancel'){
                        swal({
                            title: "Información",
                            text: "La planilla ingresada esta cancelada, por favor ingrese un código de planilla válido.",
                            icon: "warning",
                            button:{
                                text: "Entendido",
                                className: "amber-gradient"
                            },
                        });
                        $('#search').val('');
                    }else if(response.status === 'old'){
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya expiró, por favor ingrese un código de planilla válido.",
                            icon: "warning",
                            button:{
                                text: "Entendido",
                                className: "red-gradient"
                            },
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
                            button:{
                                text: "Listo",
                                className: "green-gradient"
                            },

                        }).then(function (accept) {
                            $('#modal-tick').modal('close');
                            if (accept) {
                                $('#two').removeClass('disabled');
                                $('ul.tabs').tabs();
                                $('ul.tabs').tabs("select", "details-tab");
                            }

                        });

                        $('#fiscal_period').val(taxe.fiscal_period);
                        $('#license').val(company.license);
                        $('#name_company').val(company.name);
                        $('#address').val(company.address);
                        $('#RIF').val(company.RIF);
                        $('#taxes_id').val(taxe.id);
                        $('#taxes_id_tr').val(taxe.id);
                        for (var i = 0; i < ciu.length; i++) {

                            var subr = ciu[i].ciu.name.substr(0, 3);

                            $('ul.tabs').tabs();
                            var template = `
                            <div class="row pt-2">
                                <input type="hidden" name="ciu[]" id="ciu" class="ciu " value="${ciu[i].ciu.id}" >
                                <div class="input-field col s12 m4">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"   value="${ciu[i].ciu.code}" readonly>
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m8"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="${subr}" id="${subr}" cols="30" rows="10" class="materialize-textarea " readonly required>${ciu[i].ciu.name}</textarea>
                                </div>
                                
                                <div class="input-field col s12 m4">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="base[]" id="base" class="validate money" value="${ciu[i].base}" readonly>
                                    <label for="base">Base Imponible</label>
                                </div>
                                
                                                        
                                <div class="input-field col s12 m4">
                                   <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].withholding}" readonly>
                                    <label for="withholdings">Retenciones</label>
                                </div>                               
                             
                             
                        
                                <div class="input-field col s12 m4">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="deductions[]" id="deductions" class="validate money_keyup" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].deductions}" readonly>
                                    <label for="deductions">Deducciones</label>
                                </div>
                             
                                <div class="input-field col s12 m4">
                                    <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money_keyup" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].fiscal_credits}" readonly>
                                    <label for="fiscal_credits">Creditos Fiscales</label>
                                </div>
                           
                                <div class="input-field col s12 m4">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="interest[]" id="interest" class="validate money_keyup" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].interest}" readonly>
                                    <label for="interest">Interes por mora<b> (Bs)</b></label>
                                </div>
                      
                      
                                <div class="input-field col s12 m4">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="tasa[]" id="tasa" class="validate recargo money_keyup" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].tax_rate}" readonly>
                                    <label for="tasa">Recargo (12%)<b> (Bs)</b></label>
                                </div>
                            </div>
                            <div class="divider" style="height:3px !important;"></div>
                       `;


                            $('ul.tabs').tabs();
                            $('#amount_total').val(taxe.amount);
                            $('#amount_total_tr').val(taxe.amount);

                            M.textareaAutoResize($('#' + subr));
                            $('.modal').modal();
                            $('#details').append(template);
                            M.textareaAutoResize($('#' + subr));
                            M.updateTextFields();
                            $('#details-tab').css("overflow-x", "hidden");
                            $('body').css("overflow-y", "scroll");
                            $('#details-tab').css("height", "100%");
                        }
                        formatMoney();
                        M.updateTextFields();
                        $('#search').val('');

                    }


                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                },
                error: function (err) {
                    $('#license').val('');
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
        }
    });


    $('#register-payment').submit(function (e) {
        e.preventDefault();

        var amount = $('#amount_total').val();
        var amount_pay = $('#amount').val();

        if (amount_pay > amount) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button:{
                    text: "Entendido",
                    className: "red-gradient"
                },
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
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });


                    } else {
                        swal({
                            title: "¡Bien hecho!",
                            text: "Planilla registrada y conciliada con éxito.",
                            icon: "success",
                            button:{
                                text: "Listo",
                                className: "green-gradient"
                            },
                        }).then(function (accept) {
                            $('#amount_total').val('');
                            if ($('#company_id').val() !== '') {
                                window.open(url + 'ticket-office/pdf/taxes/' + $('#taxes_id').val(), "RECIBO DE PAGO", "width=500, height=600")
                            }
                            location.reload();
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });

        }
    });



    $('#register-payment-tr').submit(function (e) {
        e.preventDefault();

        var amount = $('#amount_total_tr').val();
        var amount_pay = $('#amount_tr').val();

        if (amount_pay > amount) {
            swal({
                title: "Error",
                text: "El monto del punto de venta, no puede ser mayor que el monto total a pagar.",
                icon: "error",
                button:{
                    text: "Entendido",
                    className: "red-gradient"
                },
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
                        $('#amount_total_tr').val(response.payment);

                        $('#amount_total_tr').val(function (index, value) {
                            return number_format(value, 2);
                        });

                        swal({
                            title: "Información",
                            text: "Para conciliar esta planilla " +
                            "el monto debe ser cancelado en su totalidad.Debe cancelar el dinero restante:" + $('#amount_total_tr').val() + "Bs",
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });


                    } else {
                        swal({
                            title: "¡Bien hecho!",
                            text: "Planilla registrada y conciliada con éxito.",
                            icon: "success",
                            button:{
                                text: "Listo",
                                className: "green-gradient"
                            },
                        }).then(function (accept) {
                            $('#amount_total_tr').val('');
                            if ($('#company_id').val() !== '') {
                                window.open(url + '/ticket-office/pdf/taxes/' + $('#taxes_id_tr').val(), "RECIBO DE PAGO", "width=500, height=600")
                            }
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });

        }


    });

    function reset() {
        $('#details').text('');
        $('ul.tabs').tabs("select", "general-tab");
        $('#three').addClass('disabled');
        $('#two').addClass('disabled');
        $('#register-taxes')[0].reset();

    }




    $('#details-next').click(function () {
        var band=false;


        $('.anticipated').each(function () {
            if($(this).val()==="") {
                swal({
                    title: "Información",
                    text: "La base anticipada  no puede estar vacio, por favor ingrese un monto válido.",
                    icon: "info",
                    button: "Ok",
                });

                band=true;
            }
        });

        $('.base').each(function () {
            if($(this).val()==="") {
                swal({
                    title: "Información",
                    text: "El campo Base Imponible no puede estar vacio, por favor ingrese un monto válido.",
                    icon: "info",
                    button: "Ok",
                });

                band=true;
            }else{
                $('.deductions').each(function () {
                    if($(this).val()==''){
                        $(this).val('0');
                    }
                });
                $('.withholding').each(function () {
                    if($(this).val()==''){
                        $(this).val('0');
                    }
                });
                $('.credits_fiscal').each(function () {
                    if($(this).val()==''){
                        $(this).val('0');
                    }
                });
                M.updateTextFields();
            }
        });






        if(!band){
            swal({
                title: "Información",
                text: "Recuerde verificar al monto antes de realizar el pago, una vez confirmado, no podrá revertir los cambios.",
                icon: "info",
                buttons: {
                    confirm: {
                        text: "Confirmar.",
                        value: true,
                        visible: true,
                        className: "red-gradient"

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
                    registerTaxes();

                }



            });
        }
    });


    $('#scan').click(function () {
        $('#search').focus();
        $('#search').val("");
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

    function registerTaxes() {
        var form = new FormData(document.getElementById('register-taxes'));
        form.append('fiscal_period', $('#fiscal_period').val());
        $.ajax({
            url: url + "ticket-office/taxes/save",
            contentType: false,
            processData: false,
            data: form,
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {
                console.log(response);

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
                        reset();
                    }else{
                        window.location.href=url+'ticket-office/taxes';
                    }
                });



                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

                M.updateTextFields();
                formatMoney();
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
    }


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


    $('#fiscal_period').change(function () {
        var company = $('#company_id').val();
        var fiscal_period = $('#fiscal_period').val();
        var type=$('#type').val()

        if(type!=null){
        if(company!==''){
            if (fiscal_period !== '') {
                $.ajax({
                    method: "GET",
                    url: url + "ticket-office/find/fiscal-period/" + fiscal_period + "/" + company,
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {


                        if (response.status === 'error') {
                            swal({
                                title: "Información",
                                text: 'La empresa ' + $('#name_company').val() + 'ya declaró el periodo de ' + $('#fiscal_period').val() + ', seleccione un periodo fiscal valido',
                                icon: "info",
                                button:{
                                    text: "Esta bien",
                                    className: "blue-gradient"
                                },
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
                            button:{
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });
                    }
                });


            }
        }else{
            $('#fiscal_period').val('');
            swal({
                title: "Información",
                text: 'Debe ingresar una licencia valida de una empresa, para generar una planilla.',
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
        }else{
            $('#fiscal_period').val('');
            swal({
                title: "Información",
                text: 'Debe Selecionar el tipo de planilla a generar',
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
    });




    $('#type').change(function () {
        var type=$(this).val();
        var company = $('#company_id').val();

        if(company!=='') {
            if (type == 'definitive') {
                $.ajax({
                    method: "GET",
                    url: url + "tick-office/taxes/definitive/verify/"+company,
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        if (response.status === 'verified') {
                            swal({
                                title: "Información",
                                text: 'La empresa ' + $('#name_company').val() + ' ya realizo la declración definitiva de este anio.',
                                icon: "info",
                                button: {
                                    text: "Esta bien",
                                    className: "blue-gradient"
                                },
                            });

                        } else if (response.status === 'process') {
                            swal({
                                title: "Información",
                                text: 'La empresa ' + $('#name_company').val() + ' tiene una declaracion definitiva en proceso.',
                                icon: "info",
                                button: {
                                    text: "Esta bien",
                                    className: "blue-gradient"
                                },
                            })
                        }else if(response.status==='new'){
                            $('#fiscal_period').val('2019-01-01');
                            $('#fiscal_period').attr('readonly','readonly');

                            $('#details').html('');


                            for (var i = 0; i < ciu.length; i++) {
                                var subr = ciu[i].name.substr(0, 3);
                                $('ul.tabs').tabs();
                                var template = `<div class="row pt-2">
                      
                    
                               <input type="hidden" id="min_tribu_men_${ciu[i].code}" name="min_tribu_men[]" class="min_tribu" value="${ciu[i].min_tribu_men}">
                               <input type="hidden" id="alicuota_${ciu[i].code}" name="alicuota[]" class="alicuota" value="${ciu[i].alicuota}">
                 
                                <input type="text"  name="ciu_id[]" id="ciu_id" class="ciu hide" value="${ciu[i].id}">
                                <div class="input-field col s12 m6">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  value="${ciu[i].code}">
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="${subr}" id="${subr}" cols="30" rows="10" class="materialize-textarea " >${ciu[i].name}</textarea>
                                </div>
                                
                               <div class="input-field col s12 m6">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="base[]" id="base_${subr}" class="validate money money_keyup base " value="">
                                    <label for="base_${subr}">Base Imponible(Bs) ANUAL</label>
                               </div>
                              
                              
                              <div class="input-field col s12 m6">
                     
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="anticipated[]" id="anticipated_${subr}" class="validate money money_keyup anticipated " value="">
                                    <label for="anticipated_${subr}">Base Anticipada(Bs) ANUAL</label>
                              </div> 
                                <input type="hidden" value="definitive" name="typeTaxes">
                                
                                <input type="hidden" name="withholding[]" id="withholdings_${subr}" class="validate money money_keyup withholding" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                                <input type="hidden" name="deductions[]" id="deductions_${subr}" class="validate money  money_keyup deductions" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                                <input type="hidden" name="fiscal_credits[]" id="fiscal_credits_${subr}" class="validate money money_keyup credits_fiscal" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                           
                         
                           
       
                   
                       </div>
          
            
                      <div class="divider" style="height:3px !important;">
                      
                      </div>
                          
                     `;



                                $('#details').append(template);
                                M.textareaAutoResize($('#' + subr));
                                M.updateTextFields();



                                $('.base').change(function () {
                                    var total=$(this).val();

                                    var base=$(this).val();
                                    var alicuota=$(this).parent().siblings('input.alicuota').val();
                                    var min_tribu=$(this).parent().siblings('input.min_tribu').val();
                                    var min_total=min_tribu*$('#tributo').val()*12;
                                    base= base.replace(/\./g, '');
                                    if (base !== '0') {
                                        if (parseFloat(base) <= min_total) {
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
                                            });
                                        }

                                        if ($(this).val() != 0) {
                                            console.log($(this).val());
                                            $('.min > input.money_keyup').prop('readonly', false);
                                            $(this).parent().siblings().removeClass('min');
                                        } else {
                                            $(this).parent().siblings().addClass('min');
                                            $('.min > input.money_keyup').prop('readonly', true);
                                        }
                                    }
                                });



                                $('.anticipated').change(function () {
                                    var  base=$(this).parent().siblings().find('input.base').val();

                                    var alicuota=$(this).parent().siblings('input.alicuota').val();

                                    var min_tribu=$(this).parent().siblings('input.min_tribu').val();

                                    base= base.replace(/\./g, '');

                                    var anticipated=$(this).val().replace(/\./g, '');

                                    var total = Math.floor(parseFloat(base) * alicuota);
                                    var min_total=min_tribu*$('#tributo').val();

                                    if (base !== '0') {

                                        if (total <= parseFloat(anticipated) ) {
                                            swal({
                                                title: "Información",
                                                text: "Verifique los datos ingresados, " +
                                                "el monto anticipado no puede ser mayor," +
                                                " que el calculo total de la base.",
                                                icon: "info",
                                                button: {
                                                    text: "Esta bien",
                                                    className: "blue-gradient"
                                                },
                                            });
                                            band = true;
                                            $(this).val('');
                                        }

                                    }else{
                                        total=min_tribu*12*$('#tributo').val();

                                        if (parseFloat(anticipated)>total ) {
                                            swal({
                                                title: "Información",
                                                text: "Verifique los datos ingresados, " +
                                                "el monto anticipado no puede ser mayor," +
                                                " que el calculo total de la base.",
                                                icon: "info",
                                                button: {
                                                    text: "Esta bien",
                                                    className: "blue-gradient"
                                                },
                                            });
                                            $(this).val('');
                                        }


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

                                M.updateTextFields();


                            }



                            M.updateTextFields();

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
                            button: {
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        });
                    }
                });


            }else{
                $('#fiscal_period').removeAttr('readonly','');
                $('#fiscal_period').val('');
                $('#details').html('');
                generarCiiu();








            }
        }

    });

    $('#search-code').blur(function () {
        if ($('#search-code').val() !== '') {
            var code = $('#search-code').val();
            $.ajax({
                method: "GET",
                url: url + "ticket-office/find/code/" + code,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });


                    } else {

                        var company = response.company[0];
                        var user = response.company[0].users[0];
                        ciu = response.company[0].ciu;

                        $('#name_company').val(company.name);
                        $('#address').val(company.address);
                        $('#RIF').val(company.RIF);
                        $('#company_id').val(company.id);
                        $('#person').val(user.name + " " + user.surname);
                        M.updateTextFields();


                        generarCiiu();
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
                        button:{
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                }
            });
        }
    });







    $('#general-next').click(function () {

        if ($('#company_id').val() === '') {
            swal({
                title: "Información",
                text: 'Debe ingresar una empresa,  para con continuar con el registro.',
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        } else if ($('#fiscal_period').val() === '') {
            swal({
                title: "Información",
                text: 'Debe seleccionar un periodo fiscal, para continuar con el registro.',
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });

        } else {
            $('#two').removeClass('disabled');
            $('ul.tabs').tabs("select", "details-tab");
        }


    });


    function userUpdate() {
        $.ajax({
            url: url + "users/update",
            cache: false,
            contentType: false,
            processData: false,
            data: new FormData(this),
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {

                swal({
                    title: "¡Bien Hecho!",
                    text: response.message,
                    icon: "success",
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
                }).then(function (accept) {
                    window.location.href = url + "users/manage";
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
                    button:{
                        text: "Entiendo",
                        className: "red-gradient"
                    },
                });
            }
        });
    }


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


    $('#ci').blur(function () {
        if ($('#ci').val() !== '' && $('#nationality').val() !== null) {
            CheckCedula();
        }
    });

    $('#ci').keyup(function () {
        if ($('#nationality').val() === null) {
            swal({
                title: "Información",
                text: "Debes seleccionar la nacionalidad, antes de ingresar el número de cedula.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
            $('#ci').val('')
        }

    });


    $('#nationality').change(function () {
        if ($('#ci').val() !== '' && $('#nationality').val() !== null) {
            CheckCedula();
        }
    });
    function CheckCedula() {
        if ($('#ci').val() !== '') {
            var ci = $('#ci').val();
            var nationality = $('#nationality').val();
            $.ajax({
                method: "GET",
                url: url + "ticket-office/find/user/" + nationality + ci,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status === 'error') {
                        swal({
                            title: "Información",
                            text: "El Contribuyente no esta registrado, debe registrar el contribuyente antes para poder registrar una empresa.",
                            icon: "info",
                            buttons: {
                                confirm: {
                                    text: "Registrarlo",
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
                                window.location.href = url + "taxpayers/register";
                            }
                        })

                    } else {
                        var user = response[0].user;
                        $('#name_user').val(user.name);
                        $('#user_id').val(user.id);
                        $('#surname').val(user.surname);
                        $('#email').val(user.email);
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
        }
    }

/*
    console.log(localStorage.getItem('epale'));
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
       if(localStorage.getItem('bank')!==null){


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
                   location.href=url+'ticket-office/payments';
               }
           });


       }else{
           swal({
               title: "Información",
               text: "Acción cancelada,debe abrir la caja para poder cerrarla.",
               icon: 'info'
           });

       }




    });

    $('#open-cashier').click(function () {
        if(localStorage.getItem('bank')==null){
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
                if (name===null||isNaN(name)||name<=0) {
                    swal({
                        title: "Información",
                        text: "Acción cancelada,debe ingresar un numero de lote valido.",
                        icon: 'info'
                    });
                }else{
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
                        if(bank===null){
                            swal({
                                title: "Información",
                                text: "Acción cancelada,debe ingresar un punto.",
                                icon: 'info'
                            });
                        }else{
                            localStorage.setItem('bank', bank);
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

        }else{
            swal({
                title: "Información",
                text: "Acción cancelada,debe abrir caja.",
                icon: 'info'
            });
        }
    });

    */



    $('#previous-details').click(function () {
        $('ul.tabs').tabs("select", "general-tab");
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
                    className: "ambre-gradient"

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



    function  generarCiiu() {


        for (var i = 0; i < ciu.length; i++) {
            var subr = ciu[i].name.substr(0, 3);
            $('ul.tabs').tabs();
            var template = `<div class="row pt-2">
                      
                               <input type="text" id="min_tribu_men_${ciu[i].code}" name="min_tribu_men[]" class="hide min_tribu" value="${ciu[i].min_tribu_men}">
                               <input type="text" id="alicuota_${ciu[i].code}" name="" class="hide alicuota" value="${ciu[i].alicuota}">
                               
                                <input type="text"  name="ciu_id[]" id="ciu_id_${ciu[i].code}" class="ciu hide" value="${ciu[i].id}">
                                <div class="input-field col s12 m6">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu_${ciu[i].code}"  value="${ciu[i].code}">
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="${subr}" id="${subr}" cols="30" rows="10" class="materialize-textarea " >${ciu[i].name}</textarea>
                                </div>
                                
                               <div class="input-field col s12 m6">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="base[]" id="base_${ciu[i].code}" class="validate money money_keyup base " value="">
                                    <label for="base_${ciu[i].code}">Base Imponible</label>
                                </div>
                                
                                                        
                              <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="withholding[]" id="withholdings_${ciu[i].code}" class="validate money money_keyup withholding" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                                <label for="withholdings_${subr}">Retenciones</label>
                              </div>                               
                             
                     
                             <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="deductions[]" id="deductions_${ciu[i].code}" class="validate money  money_keyup deductions" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                                <label for="deductions_${subr}">Deducciones</label>
                            </div>
                             
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits_${ciu[i].code}" class="validate money money_keyup credits_fiscal" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="">
                                <label for="fiscal_credits_${subr}">Creditos Fiscales</label>
                            </div>
                           
                             <input type="hidden" value="actuated" name="typeTaxes">
                   
                       </div>
          
            
                      <div class="divider" style="height:3px !important;"></div>`;


            $('#details').append(template);
            M.textareaAutoResize($('#' + subr));
            M.updateTextFields();
        }


            $('.base').change(function () {
                var total=$(this).val();

                var base=$(this).val();
                var alicuota=$(this).parent().siblings('input.alicuota').val();
                var min_tribu=$(this).parent().siblings('input.min_tribu').val();
                var min_total=min_tribu*$('#tributo').val();
                base= base.replace(/\./g, '');

                var total_base = Math.floor(parseFloat(base) * alicuota);


                console.log(min_total);

                if($(this).val()!=0){
                    if(parseFloat(total_base)<=min_total){
                        swal({
                            title: "Información",
                            text: "El monto de la base imponible("+ total +")  no " +
                            "puede ser menor que el minimo tributable " +
                            "por este CIIU,en caso de ser menor debe declarar " +
                            "como base imponible  0. Ord. Act. Económica Art.44",
                            icon: "info",
                            button: {
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                        $(this).val('');
                    }

                    $('.min > input.money_keyup').prop('readonly',false);
                    $(this).parent().siblings().removeClass('min');
                }else{
                    $(this).parent().siblings().addClass('min');
                    $('.min > input.money_keyup').prop('readonly',true);
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

            M.updateTextFields();




    }


});



