$(document).ready(function() {
    var url = localStorage.getItem('url');

	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();

		if($('#parish_id').val()!==null) {
            var formData = new FormData(this);
            $.ajax({
                url: url + "catastral-terreno/save",
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
                        text: "Se ha registrado el valor catastral del terreno exitosamente.",
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + "catastral-terreno/read";
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
                text: "Debe selecionar la parroquia para poder completar el  registro.",
                icon: "info",
                button: "Ok",
            });
        }
	});

	$('#modify-btn').click(function() {
		$(this).hide();
		$('#update-btn').removeClass('hide');
        $('#name').removeAttr('readonly');
        $('#sector_nueva').removeAttr('readonly');
        $('#sector_catastral').removeAttr('readonly');
        $('#parish_id').removeAttr('disabled','');
        $('#status').removeAttr('disabled','');
        $('select').formSelect();
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			url: url + "catastral-terreno/update",
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
                    text: "Se ha actualizado el valor el valor catastral del terreno exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "catastral-terreno/details/"+$('#id').val();
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