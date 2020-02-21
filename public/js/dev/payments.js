$('document').ready(function () {

    var url = localStorage.getItem('url');

    $('.change-status').click(function () {
        var status=$(this).data('status');
        var taxes_id=$(this).val();

        console.log(taxes_id);
        if(status==='verified'){
            message='verificada';
        }else{
            message='cancelada';
        }
        swal({
            title: "Información",
            text: '¿Estas seguro de realizar esta acción?,' +
                   'El estado del pago cambiara a "'+ message+'".',
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "green-gradient"

                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (aceptar) {
            if (aceptar) {

                $.ajax({
                    method: "GET",
                    url: url + "payments/change-status/"+ taxes_id +"/"+ status ,

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        if (response.status) {
                            swal({
                                title: "¡Bien hecho!",
                                text: "La planilla fue "+ response.status +" con exito.",
                                icon: "success",
                                button:{
                                    text: "Esta bien",
                                    className: "green-gradient"
                                },
                            }).then(function (accept) {
                                location.reload();
                            });
                        }

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                    }, error: function (err) {
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Oh no!",
                            text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                            icon: "error",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                    }
                });


            }
        });


    });




    $('.reconcile').click(function () {
        var status=$(this).data('status');
        var taxes_id=$('#taxes_id').val();
        var message;

        if(status==='verified'){
            message='verificada';
        }else{
            message='cancelada';
        }

        swal({
            title: "Información",
            text: '¿Estas seguro de realizar esta acción?, El estado de este pago  cambiaria  el status a "'+ message+'".Los cambios realizados son permanente, en caso de error debe contactarse con los administradores.',
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "green-gradient"

                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (aceptar) {
            if (aceptar) {

                $.ajax({
                    method: "GET",
                    url: url + "ticket-office/payments/change/"+ taxes_id +"/"+ status ,

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {

                        if(response.status!='error') {

                            if (response.status) {
                                swal({
                                    title: "¡Bien hecho!",
                                    text: "La planilla fue " + response.status + " con exito.",
                                    icon: "success",
                                    button: {
                                        text: "Esta bien",
                                        className: "green-gradient"
                                    },
                                }).then(function (accept) {
                                    location.reload();
                                });
                            }
                        }else{

                            swal({
                                title: "Información",
                                text:  'El estado de la planilla cambio  a verificado, ' +
                                       'sin embargo no se pudo enviar el correo verificado,' +
                                        'intente más tarde, dando el boton de Enviar Planilla vericada.',
                                icon: "info",
                                button: "Ok",
                            }).then(function (accept) {
                                if(accept){
                                    location.reload();
                                }
                            });
                        }

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                    }, error: function (err) {
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Oh no!",
                            text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                            icon: "error",
                            button:{
                                text: "Esta bien",        
                                className: "blue-gradient"
                            },
                        });
                    }
                });
            }
        });
    });



    $('#change-status').click(function () {
        var status=$(this).attr('data-status');
        var id=$(this).val();


        if(status==='verified'){
            message='verificada';
        }else{
            message='cancelada';
        }

        swal({
            title: "Información",
            text: '¿Estas seguro de realizar esta acción?, El estado de esta planilla cambiara   a "'+ message+'",.Los cambios realizados son permanente, en caso de error debe contactarse con los administradores.',
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "green-gradient"

                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (aceptar) {

            if(aceptar){
                $.ajax({
                    method: "GET",
                    url: url + '/payments/change-status/'+id +'/'+status,
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {

                            swal({
                                title: "!Bien Hecho",
                                text: 'El pago ha sido '+ response.status +' con éxito.',
                                icon: "success",
                                button: "Ok",
                            }).then(function (accept) {
                                if(accept){
                                    location.reload();
                                }
                            });




                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                    }, error: function (err) {
                        $('#license').val('');
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
        });


    });



    $('#send-email-verified').click(function () {
        var id=$(this).val();
        $.ajax({
            method: "GET",
            url: url + "ticket-office/taxes/ateco/send-email/" +id,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {

                if (response.status === 'error') {
                    swal({
                        title: "Información",
                        text: response.message,
                        icon: "info",
                        button: "Ok",
                    });
                }else{
                    swal({
                        title: "Bien Hecho",
                        text: response.message,
                        icon: "success",
                        button: "Ok",
                    })
                }

                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

            }, error: function (err) {
                $('#license').val('');
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




    $('.details-payment').click(function () {
        var bank=   $(this).attr('data-bank');
        var destino= $(this).attr('data-destino');
        var phone=   $(this).attr('data-phone');
        var name=   $(this).attr('data-name');
        var ref=   $(this).attr('data-reference');

        swal({
            title: "Datos de Pago:",
            text:   'Nombre: '+   name +'\n'+
                    'Telefono:'+ phone+'\n'+
                    'Banco:' + bank+'\n'+
                    'Destino:'+  destino+'\n'
                    +'Referencia:'+  ref+'\n',
            icon: "info",
            button: "Ok",
        });

    });

    $('.prev-view').click(function () {
        window.history.back();
    });

/*
        $.ajax({
            method: "GET",
            url: url + "ticket-office/fin" + fiscal_period + "/" + company,
            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {


                if (response.status === 'error') {
                    swal({
                        title: "Información",
                        text: 'La empresa ' + $('#name_company').val() + 'ya declaro el periodo de ' + $('#fiscal_period').val() + ', seleccione un periodo fiscal valido',
                        icon: "info",
                        button: "Ok",
                    });
                    $('#fiscal_period').val(' ')
                }

                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

            }, error: function (err) {
                $('#license').val('');
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


*/




});

