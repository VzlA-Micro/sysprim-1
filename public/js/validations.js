$(document).ready(function(){
	$('.validate.number-only').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });

	$('.validate.number-and-capital-letter-only').keyup(function (){
        this.value = (this.value + '').replace(/[^A-Z0-9]/g, '');
      });
});