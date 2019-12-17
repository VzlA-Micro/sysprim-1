$('document').ready(function () {
<<<<<<< HEAD
    //var url = "https://sysprim.com/";
    var url="http://172.19.50.253/";
=======
    var url = "https://sysprim.com/";
    //var url="http://172.19.50.253/";

>>>>>>> 7f1887910d268285de2e104566acb98923ea8992
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
            text: '¿Estas seguro de realizar esta acción?, El estado de esta planilla cambiaria  el status a "'+ message+'", tanto está como lo pagos asociado a la misma.Los cambios realizados son permanente, en caso de error debe contactarse con los administradores.',
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

