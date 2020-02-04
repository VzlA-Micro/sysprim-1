$(document).ready(function() {
    // var url = "https://sysprim.com/";
    var url ="http://sysprim.com.devel/";


    var date = new Date();
    $('#to').datepicker({
        maxDate:  null,
        format: 'yyyy-mm-dd', // Configure the date format
        // yearRange: [1900,date.getFullYear()],
        showClearBtn: false,
        i18n: {
            cancel: 'Cerrar',
            clear: 'Reiniciar',
            done: 'Hecho',
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    }); 

	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "recharges/save",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            method: "POST",
            beforeSend: function() {
            	$("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
            	swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha registrado el recargo exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "recharges/manage";
                });
            },
            error: function(err) {
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
	});

	$('#btn-modify').click(function() {
		$(this).hide();
		$('#btn-update').removeClass('hide');
        $('#since').removeAttr('readonly');
        $('#to').removeAttr('readonly');
        $('#name').removeAttr('readonly');
        $('#value').removeAttr('readonly');
        $('#branch').removeAttr('disabled');
        $('select').formSelect();
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "recharges/update",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            method: "POST",
            beforeSend: function() {
            	$("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
            	swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha actualizado el recargo exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "recharges/manage";
                });
            },
            error: function(err) {
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
	})
})