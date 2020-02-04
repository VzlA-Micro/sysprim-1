$(document).ready(function() {

    // var url = "https://sysprim.com/";
    var url ="http://sysprim.com.devel/";


	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "advertising-type/save",
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
                    text: "Se ha registrado el tipo de publicidad exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "advertising-type/manage";
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

	$('#modify-btn').click(function() {
		$(this).hide();
		$('#update-btn').removeClass('hide');
        $('#name').removeAttr('readonly');
        $('#value').removeAttr('readonly');
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "advertising-type/update",
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
                    text: "Se ha actualizado el tipo de publicidad exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "advertising-type/manage";
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
});