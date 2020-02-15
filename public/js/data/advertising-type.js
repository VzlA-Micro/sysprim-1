$(document).ready(function() {

    var url = localStorage.getItem('url');

	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();

        if($('#group_id').val()!==null) {


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

        }else{
            swal({
                title: "Información",
                text: "Debes seleccionar el grupo  al que pertenecera esta publicidad.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
	});

	$('#modify-btn').click(function() {
		$(this).hide();
		$('#update-btn').removeClass('hide');
        $('#name').removeAttr('readonly');
        $('#value').removeAttr('readonly');
        $('#group_id').removeAttr('disabled','');
        $('select').formSelect();
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
                    window.location.href = url + "advertising-type/details/"+$('#id').val();
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