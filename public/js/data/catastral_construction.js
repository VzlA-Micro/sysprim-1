$(document).ready(function() {
    var url = localStorage.getItem('url');

	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();

		if($('#regimen_horizontal').val()!==null) {
            var formData = new FormData(this);
            $.ajax({
                url: url + "catastral-construction/save",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                method: "POST",
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (resp) {
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Se ha registrado el valor castastral exitosamente.",
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + "catastral-construction/read";
                    });
                },
                error: function (err) {
                    console.log(err);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
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
        }else{
            swal({
                title: "Información",
                text: "Debe selecionar el regimen del valor de contrucción catastral.",
                icon: "info",
                button: "Ok",
            });
        }
	});

	$('#modify-btn').click(function() {
		$(this).hide();
		$('#update-btn').removeClass('hide');
        $('#name').removeAttr('readonly');
        $('#status').removeAttr('disabled');
        $('#regimen_horizontal').removeAttr('disabled');
        $('select').formSelect();
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "catastral-construction/update",
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
                    text: "Se ha actualizado el valor catastral exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "catastral-construction/details/"+$('#id').val();
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
});