$(document).ready(function () {
    var url = "http://sysprim.com.devel/";

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
                    if(response.status==='error'){
                        swal({
                            title: "Error",
                            text: "El código de planilla ingresado no es validado, por favor ingrese  una planilla valida.",
                            icon: "error",
                            button: "Ok",
                        });

                        $('#search').val('');
                    }else if(response.status==='verified'){
                        swal({
                            title: "Información",
                            text: "La planilla ingresada ya fue conciliada, por favor ingrese un código de  planilla valida.",
                            icon: "info",
                            button: "Ok",
                        });
                        $('#search').val('');
                    }else{

                        var taxe = response.taxe[0];
                        var ciu = response.ciu;
                        var company = taxe.companies;

                        swal({
                            title: "¡Bien hecho!",
                            text: "Escaneo de QR realizado correctamente.",
                            icon: "success",
                            button: "Ok",
                        }).then(function (accept) {

                            if(accept){
                                $('#two').removeClass('disabled');
                                $('ul.tabs').tabs();
                                $('ul.tabs').tabs("select", "details-tab");


                                $('#details-tab').css("overflow-x", "hidden");
                                $('#details-tab').css("overflow-y", "scroll");
                                $('#details-tab').css("height", "700px");
                            }
                        });

                        $('#fiscal_period').val(taxe.fiscal_period);
                        $('#license').val(company.license);
                        $('#name_company').val(company.name);
                        $('#address').val(company.address);
                        $('#RIF').val(company.RIF);
                        $('#taxes_id').val(taxe.id);
                        for (var i = 0; i < ciu.length; i++) {

                            var subr = ciu[i].ciu.name.substr(0, 3);

                            $('ul.tabs').tabs();
                            var template = `<div>
                                <input type="hidden" name="ciu[]" id="ciu" class="ciu " value="${ciu[i].ciu.id}">
                                <div class="input-field col s12 m5">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  readonly disabled value="${ciu[i].ciu.code}">
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
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
                                <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].deductions}" readonly>
                                <label for="deductions">Deducciones</label>
                            </div>
                             
                            <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].fiscal_credits}" readonly>
                                <label for="fiscal_credits">Creditos Fiscales</label>
                            </div>
                           
                         <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="interest[]" id="interest" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].interest}" readonly>
                            <label for="interest">Interes por mora<b> (Bs)</b></label>
                        </div>
                      
                      
                        <div class="input-field col s12 m4">
                            <i class="prefix">
                                <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                            </i>   
                            <input type="text" name="tasa[]" id="tasa" class="validate recargo money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].tax_rate}" readonly>
                            <label for="tasa">Recargo (12%)<b> (Bs)</b></label>
                        </div>
                        <div class="dividir">
                        </div>
           
                               
                       </div>
                          
                       `;

                            console.log(taxe);
                            $('ul.tabs').tabs();
                            $('#amount_total').val(taxe.amount);
                            M.textareaAutoResize($('#' + subr));
                            $('.modal').modal();
                            $('#ciu').append(template);
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
                        button: "Ok",
                    });
                }
            });
        }
    });



    $('#register-payment').submit(function (e) {
        e.preventDefault();
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

    });

    $('#details-next').click(function () {
        swal({
            title: "Información",
            text: "Recuerde verificar al monto antes de realizar el pago, una vez confirmado, no se podrá revertir los cambios.",
            icon: "info",
            buttons: {
                confirm: {
                    text: "Confirmar.",
                    value: true,
                    visible: true,
                    className: "red"

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
                $('#three').removeClass('disabled');
                $('ul.tabs').tabs("select", "payment-tab");
            }
        });

    });



    $('#scan').click(function () {
        $('#search').focus();
        $('#search').val("");
    });



    function formatMoney() {
        $('input[type="text"].money').each(function () {
            $(this).val(function (index, value ) {
                return number_format(value, 2);
            });
        });



        $('#amount').text(function (index, value ) {
            return number_format(value, 2);
        });

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
    }
});