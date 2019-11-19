$(document).ready(function() {
    var url = "http://sysprim.com.devel/";


    $("#user_form").hide();
    $("#btn-edit").click(function(e) {
        e.preventDefault();
        $("#user_info").hide();
        $("#user_form").show();
        $("#btn-edit").hide();
    }); 

    $('#update').submit(function (e) {
    	e.preventDefault();
    	var formData = new FormData(this);
    	$.ajax({
    		url: url + "profile/update",
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
                    text: "Se ha actualizado el perfil exitosamente.",
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
    	})
    });

    var firstPassword, lastPassword;
    $('#change-password').click(function() {
    	swal({
    		icon: "info",
    		title: "Cambiar Contraseña",
    		text: "¿Está seguro que desea cambiar su contraseña?, Si lo hace, no podrá revertir los cambios.",
    		buttons: {
    		    cancel: {
    		    	text: "Cancelar",
    		    	value: false,
    		    	visible: true,
    		    	className: "grey",
    		    	closeModal: true
    		    },
    		    confirm: {
    		    	text: "Aceptar",
    		    	value: true,
    		    	visible: true,
    		    	className: "blue",
    		    },
    		}

    	}).then(confirm => {
    		if(confirm) {
    			swal({
    				icon: "info",
    				text: "Escribe la nueva contraseña:",
    				content: {
    					element: "input",
    					attributes: {
    						type: "password",
    						name: "password",
    						id: "password"
    					}
    				},
    				button: {
    					continue: {
    						text: "Continuar",
    						value:true,
    						visible: true,
    						className: "blue"
    					}
    				}
    			}).then(password => {
    				firstPassword = `${password}`;
    				if(!password) {
    					swal({
    						icon: "warning",
    						text: "No se puede cambiar la contraseña",
    						button: {
    							text: "Esta bien",
    							className: "blue"
    						}
    					});
    				}
    				else if(password !== '') {
    					swal({
    						icon: "info",
    						text: "Confirma la nueva contraseña",
    						content: {
		    					element: "input",
			    					attributes: {
			    						type: "password",
			    						name: "confirm_password",
			    						id: "confirm_password"
			    				}
			    			},
			    			buttons: {
		    					cancel: {
		    						text: "Cancelar",
		    						visible: true,
		    						className: "grey"
		    					},
			    				confirm: {
		    						text: "Confirmar",
		    						visible: true,
		    						className: "blue"
		    					},
			    			}
    					}).then(confirmPassword => {
    						lastPassword = `${confirmPassword}`;
    						var id = $('#id').val();
    						console.log(lastPassword);
    						console.log(id);

    						if(firstPassword === lastPassword) {
    							$.ajax({
    								method: "POST",
    								data: { id: id, password: lastPassword },
    								url: url + "profile/setPassword",
    								// beforeSend: function() {
    								// 	$("#preloader").fadeIn('fast');
            //     						$("#preloader-overlay").fadeIn('fast');
    								// },
    								success: function(resp) {
    									console.log(resp);
    									swal({
    										icon: "success",
    										text: "¡La contraseña se ha cambiado exitosamente!",
    										button: {
    											text: "Listo",
    											value: true,
    											visible: true,
    											className: "green"
    										}
    									});
    								},
    								error: function(err) {
    									console.log(err);
    									swal({
                                            title: "!Oh no!",
                                            text: "Ocurrio un error inesperado, por favor refresque la pagina e intentelo de nuevo.",
                                            icon: "error",
                                            buttons: {
                                                confirm:{
                                                    text: "¡Esta bien!",
                                                    value: true,
                                                    className: "blue"
                                                }
                                            }
                                        });
    								}
    							})
    						}
    						else {
    							swal({
                                    title: "!Oh no!",
                                    text: "Ocurrio un error inesperado, por favor refresque la pagina e intentelo de nuevo.",
                                    icon: "error",
                                    buttons: {
                                        confirm:{
                                            text: "¡Esta bien!",
                                            value: true,
                                            className: "blue-45deg-gradient-1"
                                        }
                                    }
                                });
    						}
    					})
    				}
    			});
    		}
    	})
    });
});

