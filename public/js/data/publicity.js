$(document).ready(function() {
	var url = localStorage.getItem('url');

    var user = $('#user').val();


    $('#data-next').click(function () {
        var status = $('#status').val();
        if(status == null || status == '') {
            swal({
                title: "Información",
                text: "Debe seleccionar una condicion social para continuar con el registro.",
                icon: "info",
                button: {
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
        else if(status == 'propietario') {
            $('#two').removeClass('disabled');
            $('#one').addClass('disabled');
            $('ul.tabs').tabs("select", "property-tab");
        }
        else {
            band=true;
            $('.rate').each(function () {
                if($(this).val()===''||$(this).val()===null) {
                    swal({
                        title: "Información",
                        text: "Complete el campo " + $(this).attr('data-validate') + " para continuar con el registro.",
                        icon: "info",
                        button: {
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                    band = false;
                }
            });
            if(band) {
                if ($('#id').val() == '') {
                    var type = $('#type').val();
                    var name;
                    if (type == 'user') {
                        name = $('#user_name').val();
                    } else {
                        name = $('#name').val();
                    }

                    var type_document = $('#type_document').val();
                    var document = $('#document').val();
                    var address = $('#address').val();
                    var surname = $('#surname').val();

                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        data: {
                            name: name,
                            surname: surname,
                            type_document: type_document,
                            document: document,
                            address: address,
                            type: type,
                            user:user
                        },
                        url: url + 'properties/taxpayers/company-user/register',

                        beforeSend: function () {
                            $("#preloader").fadeIn('fast');
                            $("#preloader-overlay").fadeIn('fast');
                        },
                        success: function (response) {
                            console.log(response);
                            $('#id').val(response.id);
                            $('#two').removeClass('disabled');
                            $('#one').addClass('disabled');
                            $('ul.tabs').tabs("select", "property-tab");
                            $("#preloader").fadeOut('fast');
                            $("#preloader-overlay").fadeOut('fast');
                        },
                        error: function (err) {
                            console.log(err);
                            swal({
                                title: "¡Oh no!",
                                text: "Ha ocurrido un error inesperado, refresca la página e intentalo de nuevo.",
                                icon: "error",
                                button: {
                                    text: "Aceptar",
                                    visible: true,
                                    value: true,
                                    className: "green",
                                    closeModal: true
                                }
                            });

                            $("#preloader").fadeOut('fast');
                            $("#preloader-overlay").fadeOut('fast');
                        }
                    });
                } else {
                    $('#two').removeClass('disabled');
                    $('#one').addClass('disabled');
                    $('ul.tabs').tabs("select", "property-tab");
                }
            }
        }
    });

    $('#status').change(function() {
        var status = $(this).val();
        var content = `
             <div class="s12 m12">
                <h5 class="center-align">Datos del Propietario</h5>
            </div>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="V: Venezolano<br>E: Extranjero<br>J: Juridico">
                <i class="icon-public prefix"></i>
                <select name="type_document" id="type_document" required>
                    <option value="null" selected disabled>...</option>
                    <option value="V">V</option>
                    <option value="E">E</option>
                    <!--<option value="J">J</option>-->
                </select>
                <label for="type_document">Documento</label>
            </div>
            <div class="input-field col s6 m3 tooltipped" data-position="bottom" data-tooltip="Solo puede escribir números. Ej: 12345678">
                 <input id="document" type="text" name="document" data-validate="documento" maxlength="8" class="validate number-only rate" pattern="[0-9]+" title="Solo puede escribir números." required>
                 <label for="document">Identificación</label>
            </div>
            <div class="input-field col s12 m6 tooltipped" data-position="bottom" data-tooltip="Solo puede agregar letras (con acentos).">
                 <i class="icon-person prefix"></i>
                 <input id="name" type="text" name="name" class="validate rate" data-validate="nombre"
                                   pattern="[A-Za-zàáâäãèéêëìíîïòóôöõùúûüñçÀÁÂÄÃÈÉÊËÌÍÎÏÒÓÔÖÕÙÚÛÜÑßÇ ]+"
                                   title="Solo puede agregar letras (con acentos)." required readonly>
                 <label for="name">Nombre</label>
            </div>
            <div class="input-field col s12 m12">
                 <i class="icon-directions prefix"></i>
                 <textarea name="address" id="address" cols="30" rows="12" data-validate="direccion" class="materialize-textarea rate" required></textarea>
                 <label for="address">Dirección</label>
            </div>
            <input id="surname" type="hidden" name="surname" class="validate" value="">
            <input id="user_name" type="hidden" name="name_user" class="validate" value="">
       `;
        if(status == 'responsable') {
            $('#content').append(content);
            $('select').formSelect();
            M.textareaAutoResize($('#address'));
            $('#document').keyup(function () {
                if($('#type_document').val()===null){
                    swal({
                        title: "Información",
                        text: "Debes seleccionar el tipo de documento, antes de ingresar el número de documento.",
                        icon: "info",
                        button:{
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    });
                    $('#document').val('')
                }
            });

            $('#document').change(function () {
                findDocument();
            });


            $('#type_document').change(function () {
                findDocument();
            });
        }
        else {
            $('#content').html('');
        }
    });


    // Registrar
	$('#register').submit(function(e) {
		e.preventDefault();



		if($('#advertising_type_id').val()!==null) {

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
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (resp) {
                    /*if(resp.status == 'success') {

                    }*/
                    console.log(resp);
                    swal({
                        title: "¡Bien Hecho!",
                        text: resp.message + resp.code,
                        icon: "success",
                        button: {
                            text: "Esta bien",
                            className: "green-gradient"
                        }
                    }).then(function (accept) {
                        window.location.href = url + "publicity/my-publicity";
                    });
                },
                error: function (err) {
                    console.log(err);
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: {
                            text: "Entendido",
                            className: "red-gradient"
                        },
                    });
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                }
            });
        }else{
            swal({
                title: "Información",
                text: "Debes selecionar el tipo de publicidad para poder registralar.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
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
                swal({
                    title: "¡Oh no!",
                    text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                    icon: "error",
                    button:{
                        text: "Entendido",        
                        className: "red-gradient"
                    },
                });
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }
		});
	});

    function findDocument() {
        var type_document=$('#type_document').val();
        var document=$('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');
        console.log(document);
        if(document!==''&&document.length>=7) {
            $.ajax({
                method: "GET",
                url: url + "rate/taxpayers/find/" + type_document  + "/" + document, // Luego cambiar ruta
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    if(response.status!=='error') {
                        if (response.type == 'not-user') {
                            var user = response.user.response;
                            $('#name').val(user.nombres + ' ' + user.apellidos);
                            $('#name').attr('readonly');
                            $('#surname').val(user.apellidos);
                            $('#user_name').val(user.nombres);
                            $('#type').val('user');
                            $('#id').val(user.id);
                            $('#address').removeAttr('readonly', '');
                        } else if (response.type == 'user') {
                            var user = response.user;
                            $('#name').val(user.name + ' ' + user.surname);
                            $('#name').attr('readonly');
                            $('#surname').val(user.surname);
                            $('#id').val(user.id);

                            $('#type').val('user');
                            $('#address').val(user.address);
                            $('#address').attr('readonly', '');
                        } else if (response.type == 'company') {
                            var company = response.company;
                            $('#name').val(company.name);
                            $('#address').val(company.address);
                            $('#name').attr('readonly');
                            $('#address').attr('disabled');
                            $('#id').val(company.id);
                            $('#type').val('company');
                            $('#address').attr('readonly', '');

                        } else {
                            $('#type').val('company');

                        }
                    }else{
                        swal({
                            title: "Información",
                            text: response.message,
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });

                        $('#document').val('');
                    }
                    M.updateTextFields();
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                },
                error: function (err) {
                    console.log(err);
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                }
            });
        }
    }
});