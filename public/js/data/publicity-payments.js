$(document).ready(function() {
    var url = localStorage.getItem('url');

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

    $('#register').submit(function(e) {
        e.preventDefault();

        var base_imponible = $('#base_imponible').val();
        var interest = $('#interest').val();
        var fiscal_credit = $('#fiscal_credit').val();
        val publicity_id = $('')

        $()
    })
});