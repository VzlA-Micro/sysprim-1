var url = "https://sysprim.com/";
//var url="http://172.19.50.253/";
$(document).ready(function() {
	$('#register').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			method: "POST",
			data: formData,
			cache: false,
            contentType: false,
            processData: false,
            url: url + 'roles/save',
            beforeSend: function() {
            	$("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
            	swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha registrado el Rol con éxito.",
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    window.location.href = url + "roles/manage";
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            },
            error: function (err) {
                console.log(err);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: "Ok",
                });
            }
		});
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			method: "POST",
			data: formData,
			cache: false,
            contentType: false,
            processData: false,
            url: url + 'roles/update',
            beforeSend: function() {
            	$("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function(resp) {
            	swal({
                    title: "¡Bien Hecho!",
                    text: "Se ha actualizado el Rol con éxito.",
                    icon: "success",
                    button: "Ok",
                }).then(function (accept) {
                    window.location.href = url + "roles/manage";
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            },
            error: function (err) {
                console.log(err);
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button: "Ok",
                });
            }
		});
	});
});