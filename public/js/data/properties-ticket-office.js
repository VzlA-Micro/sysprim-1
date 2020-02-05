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
                    if(response.status == 'error') {
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
                    else if(response.status == 'success') {
                        var property = response.property[0];
                        var user = response.property[0].users[0];
                        var id = property.id;
                        $('#property_id').val(property.id);
                        console.log($('#property_id').val());
                        $('#area_ground').val(property.area_ground).prop('readonly');
                        $('#area_build').val(property.area_build).prop('readonly');
                        $('#address').val(property.address).prop('readonly');
                        $('#person').val(user.name + " " + user.surname).prop('readonly');
                        $('#value_cadastral_ground_id option[value='+ property.value_cadastral_ground_id + ']').attr('selected',true);                        $('#value_cadastral_ground_id option[value='+ property.value_cadastral_ground_id + ']').attr('selected',true);
                        $('#value_cadastral_build_id option[value='+ property.value_cadastral_build_id + ']').attr('selected',true);
                        $('#type_inmueble_id option[value='+ property.type_inmueble_id + ']').attr('selected',true);
                        $('#parish_id option[value='+ property.parish_id + ']').attr('selected',true);

                        $('select')/*.attr('disabled',true)*/.formSelect();
                        // $('#status').attr('disabled',false);
                        M.updateTextFields();
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
        } else if ($('#fiscal_period').val() === '') {
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
            console.log(id, status);
            $.ajax({
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                    status: status
                },
                url: url + 'properties/ticket-office/taxes/' + id + '/' + status,
                beforeSend: function() {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function(resp) {
                    console.log(resp);
                    if(resp.state == 'success') {
                    }
                    var property = resp.property[0];
                    var owner_id = resp.owner_od;
                    var owner = resp.owner;
                    var alicuota = resp.declaration['porcentaje'];
                    var discount = resp.declaration['discount'];
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
                    $('#status').val(status);
                    $('#amount').val(total);
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
        e.preventDefault();
        var property_id = $('#property_id').val();
        var owner_id = $('#owner_id').val();
        var base_imponible = $('#base_imponible').val();
        var recharge = $('#recharge').val();
        var interest = $('#interest').val();
        var alicuota = $('#alicuota').val();
        var fiscal_credit = $('#fiscal_credit').val();
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


});