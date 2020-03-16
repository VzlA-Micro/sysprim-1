
var url = localStorage.getItem('url');

$('document').ready(function () {
    $('#fiscal_credits').change(function () {
        var creditsFiscal=$('#fiscal_credits').val();
        var vehicleId=$('#vehicleId').val();
        //var total=$('#totalAux').val();

        swal({
            title: "Información",
            text: "Al momento de introducir su credito fiscal, debe asegurarse de que el monto introducido sea el correcto. una vez introcducido no podra agregar un nuevo monto, en ese caso presione el botón de (CALCULAR DE NUEVO)",
            icon: "info",
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey",
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
        }).then(function (value) {
            if (value){
                $.ajax({
                    type: "GET",
                    url: url + "/taxes/credits_fiscal/vehicles/"+creditsFiscal+'/'+vehicleId,

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (data) {

                        console.log(data);
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
                $('#fiscal_credits').prop('disabled',true);
            }
        });
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