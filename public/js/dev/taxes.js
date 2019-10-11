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

    var acum=0;
    $('.total_ciu').each(function () {
        acum=acum+parseFloat($(this).val());
    });

    $('#total_pagar').val(acum);
    M.updateTextFields();
});