$('document').ready(function () {
    var url = 'http://sysq.com.devel/';


    $('#call').click(function () {
        $.ajax({
            url: url + "Panel/First",
            method: "GET",
            datatype: "JSON",
            beforeSend: function () {
                console.log("Recibiendo datos");
            },
            success: function (response) {

                var turn = response.first;
                var idTurn = response.first.id;
                var code = response.first.random_code;
                var ci = response.first.clients.ci_client;

                var idTicket=1;

                if (turn != null) {
                    $.ajax({
                        method: 'POST',
                        url: url + "Turn/Call",
                        data: {idTurn: idTurn},

                        beforeSend: function () {

                        },
                        success: function (data) {
                            $.ajax({
                                method: 'POST',
                                url: url + "Attention/Save",
                                data: {
                                    idTurn: idTurn,
                                    idTicket: idTicket
                                },
                                beforeSend: function () {

                                },
                                success: function () {
                                    console.log("registrado");
                                },

                                error: function () {
                                    console.log("No se ha podido obtener la información");
                                }
                            });
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
                        }
                    })
                } else {

                    swal({
                        text: "No tienes clientes en cola",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });
                }
            },
            error: function () {
                console.log("No se ha podido obtener la información");
            }

        });
    });

    $('#open-ticket-office').click(function () {
        var url='http://sysq.com.devel/';

        $.ajax({
            method: "GET",
            url: url +'/ticket/all',


            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (response) {

                    console.log(response);
                   $('.content').html('');


                    var response=response.ticket;
                    var html ='';

                    for(var i=0;i<response.length;i++){
                        if(response[i].status_ticket==='taken'){

                            html='<a class="waves-effect waves-light red btn col l2 href="#">'+ response[i].number_ticket +'</a>';
                        }else if(response[i].status_ticket==='Activa'){
                            html='<a class="waves-effect waves-light green btn col l2 ticket href="#">'+ response[i].number_ticket +'</a>';
                        }


                        $('.content').append(html);


                    }



                $('.ticket').click(function() {
                    changeStatus($(this).text(),'taken');

                });

                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }, error: function (err) {
                console.log(err);


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

    });






    $('#init').click(function(e) {

        var idTurn=$("#idTurn").val();

        $.ajax({
            method:'POST',
            url: url+"Turn/Start",
            data:{idTurn:idTurn,
                "_token": $("meta[name='csrf-token']").attr("content")
            },

            beforeSend: function () {
                console.log(idTurn);
            },
            success: function(data) {
                console.log(data);

                swal({
                    title: "¡Se ha Iniciado con exito!",
                    text: "Puedes seguir atendiendo ",
                    icon: "success",
                    button: {
                        text: "Aceptar",
                        visible: true,
                        value: true,
                        className: "green",
                        closeModal: true
                    },
                    timer: 3000

                });

                //Buttons
                $("#preloader").hide();
                $("#preloader-overlay").hide();
                $('#llamar').hide();
                $('#iniciar').hide();
                $("#block_llamar").hide();
                $("#block_iniciar").hide();

                $('#finalizar').show();
                $('#block_finalizar').show();
                $('#cancelar').show();
                $('#block_cancelar').show();

                $("#block_finalizar").addClass("col s12 m6 animated bounceIn");
                $("#block_cancelar").addClass("col s12 m6 animated bounceIn");

            },
            error: function(err) {

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
            }
        })
    });

    $('#finalizar').click(function (e){

        var idTurn=$("#idTurn").val();
        var idTicket=$("#idTicket").val();

        swal({
            title: "¿Quieres finalizar el servicio?",
            text: "Al finalizar seguira con el proximo cliente en cola, no se revertiran los cambios.",
            icon: "warning",
            buttons: {
                confirm: {
                    text: "Finalizar",
                    value: true,
                    visible: true,
                    className: "green"

                },
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }}).then(function(value){

            if(value == true){
                $.ajax({
                    method:'POST',
                    url: url+"Turn/Finally",
                    data:{idTurn:idTurn,
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function(data) {
                        var idTurn=$("#idTurn").val('0');

                        // $('#preLoader').hide();
                        // $('#text_llamar').html('Llamar');
                        // $("#block_llamar").removeClass();
                        // $("#block_llamar").addClass("col s12 m12 animated bounceIn");

                        swal({
                            title: "¡Se ha finalizado con exito!",
                            text: "Puedes seguir atendiendo ",
                            icon: "success",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            },
                            timer: 3000

                        }).then(redirect => {
                            location.href = url + "Panel/" + idTicket;
                        });

                        // //Buttons
                        // $("#preloader").hide();
                        // $("#preloader-overlay").hide();

                        // $('#llamar').show();
                        // $("#block_llamar").show();

                        // $('#iniciar').hide();
                        // $("#block_iniciar").hide();

                        // $('#finalizar').hide();
                        // $('#block_finalizar').hide();

                        // $('#cancelar').hide();
                        // $('#block_cancelar').hide();

                        // $("#block_llamar").removeClass();
                        // $("#block_llamar").addClass("col s12 m12 animated bounceIn");

                    },
                    error: function(err) {

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
                    }
                })}else {

                swal({
                    text: "No se ha finalizado de no finalizar seguira el cliente en cola",
                    icon: "info",
                    button: {
                        text: "Aceptar",
                        className: "green"
                    }
                });
            }
        });
    });

    $('#cancelar').click(function (e){

        var idTurn=$("#idTurn").val();

        swal({
            title: "¿Quieres cancelar el servicio?",
            text: "Al cancelar seguira con el proximo cliente en cola, no se revertiran los cambios.",
            icon: "error",
            buttons: {
                confirm: {
                    text: "Finalizar",
                    value: true,
                    visible: true,
                    className: "green"

                },
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }}).then(function(value){

            if(value){
                $.ajax({
                    method:'POST',
                    url: url+"Turn/Cancel",
                    data:{idTurn:idTurn,
                        "_token": $("meta[name='csrf-token']").attr("content")
                    },

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function(data) {
                        console.log(data);
                        swal({
                            title: "¡Se cancelo con exito!",
                            text: "Puedes seguir atendiendo ",
                            icon: "success",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            },
                            timer: 3000
                        });
                        //Buttons
                        $("#preloader").hide();
                        $("#preloader-overlay").hide();

                        $('#llamar').show();
                        $("#block_llamar").show();

                        $('#iniciar').hide();
                        $("#block_iniciar").hide();

                        $('#finalizar').hide();
                        $('#block_finalizar').hide();

                        $('#cancelar').hide();
                        $('#block_cancelar').hide();

                        $("#block_llamar").removeClass();
                        $("#block_llamar").addClass("col s12 m12 animated bounceIn");
                    },
                    error: function(err) {

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
                    }
                })}else {

                swal({
                    text: "No se ha cancelado",
                    icon: "warning",
                    button: {
                        text: "Aceptar",
                        className: "green"
                    }
                });
            }
        });

    });
    
    function  changeStatus(id,status) {
        var url='http://sysq.com.devel/';

        $.ajax({
            method: "GET",
            url: url +'ticket/change-status/'+id+'/'+status,

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');

            },
            success: function (response) {

                console.log(response);


                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');
            }, error: function (err) {
                console.log(err);


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
