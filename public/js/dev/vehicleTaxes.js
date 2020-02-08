
var url = localStorage.getItem('url');

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
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                console.log(data[0]);
                console.log(data[1]);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast')
                if (data[0]) {
                    swal({
                        title: "Valor incorrecto",
                        text: "No puede introducir un credito fiscal superior al monto a pagar",
                        icon: "warning",
                        button: "Ok",
                    });
                    $('#continue').prop('disabled', true);
                } else {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast')
                    $('#fiscal_credits').val(data[2]);
                    $('#total').val(data[1]);
                    $('#continue').prop('disabled', false);
                }
            },
            error: function (e) {
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
});