$(document).ready(function() {
	var url = localStorage.getItem('url');
	
	// Registrar
	$('#register').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
        // var image = $('#image')[0].files[0]; // Getting file input data
        // formData.append('image',image);
		$.ajax({
			url: url + "publicity/save",
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
                    text: "Se ha registrado la publicidad exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "publicity/my-publicity";
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
		$('#name').removeAttr('disabled');
		$('#date_start').removeAttr('disabled');
		$('#date_end').removeAttr('disabled');
		$('.js-range-slider').ionRangeSlider({
			block: false
		});
		$('#quantity').removeAttr('disabled');
		$('#floor').removeAttr('disabled');
		$('#side').removeAttr('disabled');
		$(this).hide();
		$('#btn-update').removeClass('hide');
	});

	$('#update').submit(function(e) {
		e.preventDefault();
		var id = $('#id').val();
		var formData = new FormData(this);
		$.ajax({
			url: url + "publicity/update",
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
                    text: "Se ha actualizado la publicidad exitosamente.",
                    icon: "success",
                    button: {
                    	text: "Esta bien",
                    	className: "green-gradient"
                    }
                }).then(function (accept) {
                    window.location.href = url + "publicity/details/" + id;
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