$(document).ready(function () {
    /*var company_id = 1;
    var fiscal_period= "2019-10-01";
    var ciu = [];
    ciu.push({id:1,base:70000,deductions:50000,withholding:30000,fiscal_credits:8000});
    ciu.push({id:2,base:80000,deductions:80000,withholding:80000,fiscal_credits:8000});
    $.ajax({
        method: "POST",
        dataType: "json",
        data: {
            company_id:company_id,
            fiscal_period:fiscal_period,
            ciu:ciu
        },
        url: "http://sysprim.com.devel/payments/taxes",
        beforeSend: function () {

        },
        success: function (response) {
           console.log(response)
        },
        error: function (err) {
         console.log(err);
        }
    });*/
    $('input[type="text"].money_keyup').on('keyup', function (event) {
        $(event.target).val(function (index, value ) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1,$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
        });
    });


    $('.base').blur(function () {

    });
    $('#taxes-register').submit(function (e) {
        e.preventDefault();

        var band=false;

        $('.code').each(function () {
            var code=$(this).val();
            console.log(code);
            var base=$('#base_'+code).val();
            var alicuota=$('#alicuota_'+code).val();
            var deductions=$('#deductions_'+code).val();
            var withholdings=$('#withholdings_'+code).val();
            var fiscal_credits=$('#fiscal_credits_'+code).val();

            base = base.replace(/\./g,'');
            deductions=deductions.replace(/\./g,'');
            withholdings=withholdings.replace(/\./g,'');
            fiscal_credits=fiscal_credits.replace(/\./g,'');

            var total_deductions=parseFloat(deductions)+parseFloat(withholdings)+parseFloat(fiscal_credits);
            var total=Math.floor(parseFloat(base)*alicuota)/100;
            if(total!==0){
                if(total_deductions>=total){
                    swal({
                        title: "¡Oh no!",
                        text: "Verifica los datos ingresados.",
                        icon: "error",
                        button: "Ok",
                    });
                    band=true;
                }
            }
        });


        if(!band){
            $(('#taxes-register'))[0].submit();
        }

    });




    if($('.money').val()!==undefined){

        var total_ciu=0;
        var total_mora=0;
        var total_recargo=0;

        $('.total_ciu').each(function () {
            total_ciu=total_ciu+parseFloat($(this).val());
        });


        $('.mora').each(function () {
            total_mora=total_mora+parseFloat($(this).val());
        });

        $('.recargo').each(function () {
            total_recargo=total_recargo+parseFloat($(this).val());
        });

        $('#recargo').val(total_recargo);


        $('#total_mora').val(total_mora);
        $('#total_pagar').val(total_ciu+total_mora+total_recargo);

        M.updateTextFields();


        //dar formato a los numero
        $('input[type="text"].money').each(function () {
            $(this).val(function (index, value ) {
                return number_format(value, 2);
            });
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
    //Calculos de total a pagar
    $('.bank').click(function () {
        $('#bank').val($(this).attr('data-bank'));
        $('#register-taxes')[0].submit();
    });

    $('.payments').click(function () {
        $('#payments').val($(this).attr('data-payments'));
    });

    $('.tick').click(function () {
        $('#register-taxes')[0].submit();
    });
});