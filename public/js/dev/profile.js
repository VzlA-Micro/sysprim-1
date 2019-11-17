$(document).ready(function() {
    var url = "https://sysprim.com/";


    $("#user_form").hide();
    $("#btn-edit").click(function(e) {
        e.preventDefault();
        console.log("Hello world");
        $("#user_info").hide();
        $("#user_form").show();
        $("#btn-edit").hide();
    }); 


    $('#image').change(function() {
        var file = this.files[0];
        var mimetype = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if(!((mimetype == match[0]) || (mimetype == match[1]) || (mimetype == match[2]))){
            swal({
                text: "Por favor, elige una imagen con formato compatible. (JPG/JPEG/PNG)",
                icon: "warning",
                button: {
                    text: "Aceptar",
                    visible: true,
                    value: true,
                    className: "green",
                    closeModal: true
                }
            });
            $(this).val('');
            return false;
        }
    });

    $('#change-image').submit(function(e) {
    	e.preventDefault();
    	var formData = new FormData(this); // Creating FormData object.
        var image = $('#image')[0].files[0]; // Getting file input data
        formData.append('file',image);
        var reader = new FileReader();
        reader.onload = function(evt) {
	        image.classList.remove('no-image');
	        image.style.backgroundImage = 'url(' + evt.target.result + ')';
	        $.ajax({
	        	url: url + "users/setImage",
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: formData,
	            method: "POST",
	            beforeSend: function () {
	                $("#preloader").fadeIn('fast');
	                $("#preloader-overlay").fadeIn('fast');
	            },
	            success: function (response) {

	                swal({
	                    title: "¡Bien Hecho!",
	                    text: response.message,
	                    icon: "success",
	                    button: "Ok",
	                }).then(function (accept) {
	                    window.location.href = url + "profile";
	                });
	                ;

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
	        })
	  	}
    	reader.readAsDataURL(image.files[0]);

    })
});

