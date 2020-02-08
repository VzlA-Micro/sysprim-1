$(document).ready(function(){
	$('.validate.number-only').keyup(function (){
        this.value = (this.value + '').replace(/[^.,0-9]/g, '');
    });

	$('.validate.number-and-capital-letter-only').keyup(function (){
        this.value = (this.value + '').replace(/[^A-Z0-9]/g, '');
      });

    $('.validate.number-only-float').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9.]/g, '');
    });

    $('.validate.number-date').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

    $('.only-number-positive').change(function () {
         if($(this).val()<1) {
             swal({
                 title: "Información",
                 text: "El campo no debe ser mayor o igual 1.",
                 icon: "info",
                 button: {
                     text: "Esta bien",
                     className: "blue-gradient"
                 },
             });
             $(this).val('');
        }
    });

    $('.validate.text-validate').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Z ]/g, '');
    });
});