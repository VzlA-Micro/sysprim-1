var url = "http://172.19.50.253/";
$(document).ready(function() {
	$('#register').submit(function(e) {
        var  name = $('#name').val();
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
                    text: "Se ha registrado el '" + name + "' con éxito.",
                    icon: "success",
                    button:{
                        text: "Esta bien",        
                        className: "green-gradient"
                    },
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
                    button:{
                        text: "Entendido",        
                        className: "red-gradient"
                    },
                });
            }
		});
	});

	$('#update').submit(function(e) {
		e.preventDefault();
        var  name = $('#name').val();
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
                    text: "Se ha actualizado el '" + name +"' con éxito.",
                    icon: "success",
                    button:{
                        text: "Entendido",        
                        className: "green-gradient"
                    },
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
                    button:{
                        text: "Entendido",        
                        className: "red-gradient"
                    },
                });
            }
		});
	});
});