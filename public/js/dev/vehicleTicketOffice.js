//var url = "http://172.19.50.253/";
var url = "http://sysprim.com.devel/";

var updateType = true;
var buttonBrand = true;
var controlButtonBrand = true;

$('document').ready(function () {

    $('#model').prop('disabled', true);
    $('select').formSelect();

    $('#update-vehicle').on('click', function () {
        if (updateType) {
            $('#status').prop("disabled", false);
            $('select').formSelect();
            $('#license_plate').removeAttr('disabled');
            $('#type').removeAttr('disabled');
            $('#bodySerial').removeAttr('disabled');
            $('#color').removeAttr('disabled');
            $('#serialEngine').removeAttr('disabled');
            $('#year').removeAttr('disabled');
            $('#brand').removeAttr('disabled');
            updateType=false;
        }else{

        }

    });


});




