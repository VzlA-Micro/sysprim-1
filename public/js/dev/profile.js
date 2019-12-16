$(document).ready(function() {
    var url = "https://sysprim.com/";


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
                    text: "Se ha actualizado su perfil éxitosamente.",
                    icon: "success",
                    button:{
                        text: "Esta bien",
                        className: "green-gradient"
                    },
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
                    button:{
                        text: "Entendido",
                        className: "red-gradient"
                    },
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
    		    	className: "blue-gradient",
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
    						className: "blue-gradient"
    					}
    				}
    			}).then(password => {
    				firstPassword = `${password}`;
    				if(!password) {
    					swal({
    						icon: "warning",
    						text: "No se puede cambiar la contraseña",
    						button: {
    							text: "Entendido",
    							className: "red-gradient"
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
		    						className: "blue-gradient"
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
    											className: "green-gradient"
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
                                                    text: "Entendido",
                                                    value: true,
                                                    className: "red-gradient"
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
                                            text: "Entendido",
                                            value: true,
                                            className: "red-gradient"
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

