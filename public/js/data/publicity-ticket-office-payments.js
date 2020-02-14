$(document).ready(function() {
    var url = localStorage.getItem('url');

    $('#code').blur(function() {
        var code = $(this).val();
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
                        var publicity = response.publicity;
                        var user = response.publicity.users[0];
                        var id = publicity.id;
                        $('#publicity_id').val(id);
                        $('#name').val(publicity.name);
                        $('#advertising_type_id option[value=' + publicity.advertising_type_id + ']').attr('selected',true);
                        $('#advertising_type_id').attr('disabled',true);
                        $('#date_start').val(publicity.date_start).attr('disabled',true);
                        $('#date_end').val(publicity.date_end).attr('disabled',true);
                        $('#person').val(user.name + " " + user.surname).attr('disabled',true);
                        $('#fiscal_period').attr('disabled',false);
                        $('#status').attr('disabled',false);
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
                }
            });
        }
    });

    $('#fiscal_period').change(function () {
        var fiscalPeriod = $(this).val();
        var id = $('#publicity_id').val();

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
});