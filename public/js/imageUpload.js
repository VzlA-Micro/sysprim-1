(function () {
    //var url = "https://sysprim.com/";
    // var url="http://sysprim.com.devel/";
    var url = "https://sysprim.com/";

  var uploader = document.createElement('input'),
    image = document.getElementById('img-result');
  var formdata = new FormData();

  uploader.type = 'file';
  uploader.id = 'image';

  uploader.accept = 'image/*';


  image.onclick = function() {
    uploader.click();
  }

  uploader.onchange = function() {
    var reader = new FileReader();
    reader.onload = function(evt) {
      image.classList.remove('no-image');
      image.style.backgroundImage = 'url(' + evt.target.result + ')';
  	  
    }
    reader.readAsDataURL(uploader.files[0]);
    var id = document.querySelector('#id').value;
    if(formdata) {
    	formdata.append('id',id);
    	formdata.append("image",uploader.files[0]);
    	if(checkImageType(uploader) == false) {
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
    	}
    	else{
    	   $.ajax({
	       	url: url + "users/setImage",
	        cache: false,
	        contentType: false,
	        processData: false,
	        data: formdata,
	        method: "POST",
	        beforeSend: function () {
	            $("#preloader").fadeIn('fast');
	            $("#preloader-overlay").fadeIn('fast');
	        },
	        success: function (response) {
	        	console.log(response);
	            swal({
	                title: "¡Bien Hecho!",
	                text: response.message,
	                icon: "success",
	                button: "Ok",
	            }).then(function (accept) {
	                window.location.href = url + "profile";
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
    	}
    }
  }

})();
  function checkImageType(uploader) {
        var file = uploader.files[0];
        var mimetype = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if(!((mimetype == match[0]) || (mimetype == match[1]) || (mimetype == match[2]))){
            $(uploader).val('');
            return false;
        }
  }