//var url = "http://172.19.50.253/";
var url = "http://sysprim.com.devel/";

$('document').ready(function () {
    $('#fiscal_credits').blur(function () {
        var creditsFiscal=$('#fiscal_credits').val();
        var total=$('#totalAux').val();
        console.log(total);
        console.log(creditsFiscal);
        $.ajax({
            type: "POST",
            url: url + "/taxes/credits_fiscal/vehicles",
            data: {
                creditsFiscal: creditsFiscal,
                total:total
            },

            beforeSend: function () {

            },
            success: function (data) {
                console.log(data[0]);
                console.log(data[1]);
                if (data[0]) {
                    swal({
                        title: "Valor incorrecto",
                        text: "No puede introducir un credito fiscal superior al monto a pagar",
                        icon: "warning",
                        button: "Ok",
                    });
                    $('#continue').prop('disabled', true);
                } else {
                    $('#fiscal_credits').val(data[2]);
                    $('#total').val(data[1]);
                    $('#continue').prop('disabled', false);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});