$('document').ready(function () {
    var url = 'http://sysq.com.devel/';
    var url_semat=localStorage.getItem('url');


    if (localStorage.getItem('ticket-office')!==null){
        $('#number-ticket-office').removeClass('hide');
        $('#number-ticket-office').text(localStorage.getItem('ticket-office'));
    }else{
        $('#call').addClass('hide');
        $('#init').addClass('hide');
        $('#finalizar').addClass('hide');
        $('#cancelar').addClass('hide');
        $('#exit-sysq').addClass('hide');
    }



    if(localStorage.getItem('turn')!==null){
        var turn = localStorage.getItem('turn');
        turn = JSON.parse(turn);
        if(turn.status==='call'){
            $('#call').addClass('hide');
        }else if(turn.status==='init'){
            $('#init').addClass('hide');
        }else if(turn.status==='terminated'){
            $('#call').removeClass('hide');
            $('#init').addClass('hide');
            $('#finalizar').addClass('hide');
            $('#cancelar').addClass('hide');

        }else if(turn.status==='cancel'){
            $('#init').addClass('hide');
            $('#finalizar').addClass('hide');
            $('#cancelar').addClass('hide');

        }
    }


    if(localStorage.getItem('turn')==null&&localStorage.getItem('ticket-office')!=null){
        $('#init').addClass('hide');
        $('#finalizar').addClass('hide');
        $('#cancelar').addClass('hide');
    }

    var hoy = new Date();
    var dd = hoy.getDate();

    if(localStorage.getItem('day')!=dd){
        localStorage.removeItem('bank');
        localStorage.removeItem('lot');
        localStorage.removeItem('day');
    }



    $('#call').click(function () {
        $.ajax({
            url: url + "Panel/First",
            method: "GET",
            datatype: "JSON",
            beforeSend: function () {
                console.log("Recibiendo datos");
            },
            success: function (response) {
                var band=true;


                if(localStorage.getItem('ticket-office')!==null) {


                    if (response.first != null) {


                        if (localStorage.getItem('turn') === null) {
                            var turn = {
                                turn_id: response.first.id,
                                ci: response.first.clients.ci_client,
                                code: response.first.random_code,
                                status: 'call'
                            };


                            localStorage.setItem('turn', JSON.stringify(turn));
                        } else {
                            var turn = localStorage.getItem('turn');
                            turn = JSON.parse(turn);
                            band=true;
                        }


                        if (localStorage.getItem('turn') !== null && band || (turn.status == 'cancel' || turn.status == 'terminated')) {


                            var turn_find = response.first;
                            var idTurn = response.first.id;
                            var code = response.first.random_code;
                            var ci = response.first.clients.ci_client;


                            var idTicket = localStorage.getItem('ticket-office');
                            let turn = {
                                turn_id: response.first.id,
                                ci: response.first.clients.ci_client,
                                code: response.first.random_code,
                                status: 'call'
                            };

                            localStorage.setItem('turn', JSON.stringify(turn));



                            $('#call').addClass('hide');
                            $('#init').removeClass('hide');
                            $('#finalizar').removeClass('hide');
                            $('#cancelar').removeClass('hide');


                            $.ajax({
                                method: 'POST',
                                url: url + "Turn/Call",
                                data: {idTurn: idTurn},

                                beforeSend: function () {
                                    $("#preloader").fadeIn('fast');
                                    $("#preloader-overlay").fadeIn('fast');
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
                                            $("#preloader").fadeIn('fast');
                                            $("#preloader-overlay").fadeIn('fast');
                                        },
                                        success: function () {
                                            $("#preloader").fadeOut('fast');
                                            $("#preloader-overlay").fadeOut('fast');


                                            swal({
                                                title: "Información",
                                                text: "Llamando a usuario con ticket N°:" + code,
                                                icon: "warning",
                                                button: {
                                                    text: "Aceptar",
                                                    visible: true,
                                                    value: true,
                                                    className: "green",
                                                    closeModal: true
                                                },
                                                timer: 10000

                                            });


                                        },

                                        error: function () {
                                            $("#preloader").fadeOut('fast');
                                            $("#preloader-overlay").fadeOut('fast');
                                            console.log("No se ha podido obtener la información");
                                        }
                                    });

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
                                }
                            });


                        } else {
                            swal({
                                title: "Información",
                                text: "Tiene un usuario  en proceso de atención, debes finalizar la atención o cancelar la misma.",
                                icon: "error",
                                button: {
                                    text: "Aceptar",
                                    className: "red"
                                }
                            });


                        }

                    } else {

                        swal({
                            text: "No tienes usuario en cola.",
                            icon: "error",
                            button: {
                                text: "Aceptar",
                                className: "red"
                            }
                        });
                    }
                }else{

                    swal({
                        text: "Debes seleccionar una taquilla.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });


                }
            },error:function (e) {
                console.log(e);
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

                   $('.content').html('');


                    var response=response.ticket;
                    var html ='';

                    for(var i=0;i<response.length;i++){
                        if(response[i].status_ticket==='taken'){
                            html='<div class="col l3 "><a class="waves-effect waves-light red btn col l10 center-align"'+ 'href="#"> <i class="icon-error left"> <b style="font-size: 20px;"> '+ response[i].number_ticket +'</b></a></div>';
                        }else if(response[i].status_ticket==='Activo'){
                            html='<div class="col l3 ticket"><a class="waves-effect waves-light green  btn col l10 center-align"'+ 'href="#"> <i class="icon-star left"> <b style="font-size: 20px;"> '+ response[i].number_ticket +'</b></a></div>';
                        }


                        $('.content').append(html);

                        var dd = hoy.getDate();
                        localStorage.setItem('day',dd);

                    }

                $('.ticket').click(function() {
                    changeStatus($(this).text(),'taken');
                });



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

    });



    $('#init').click(function(e) {



        if(localStorage.getItem('turn')!==null) {

            var turn = localStorage.getItem('turn');
            turn = JSON.parse(turn);



            if (turn.status != 'init' && turn.status != 'cancel' && turn.status!="terminated") {


                swal({
                    title: "¿Quieres iniciar la atención?",
                    text: "Al Iniciar la atención el usuario debe estar  presente en la taquilla.",
                    icon: "warning",
                    buttons: {
                        confirm: {
                            text: "Iniciar Atención",
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
                    }
                }).then(function (accept) {

                    if (accept) {


                        $.ajax({
                            method: 'POST',
                            url: url + "Turn/Start",
                            data: {
                                idTurn: turn.turn_id,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            beforeSend: function () {
                                $("#preloader").fadeIn('fast');
                                $("#preloader-overlay").fadeIn('fast');

                            },
                            success: function (data) {
                                turn.status = 'init';
                                localStorage.setItem('turn', JSON.stringify(turn));

                                $('#init').addClass('hide');



                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Se ha Iniciado con éxito",
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
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');

                            },
                            error: function (err) {
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
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
                            text: "Acción Cancelada.",
                            icon: "info",
                            button: {
                                text: "Aceptar",
                                className: "green"
                            }
                        });

                    }


                });


            } else {



                if(turn.status==='cancel'){
                    swal({
                        title: "Información",
                        text: "Necesitas llamar a un usuario para iniciar la atención.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });

                }else if(turn.status==='init'){

                    swal({
                        title: "Información",
                        text: "Ya la atención del usuario ha sido iniciada.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });

                }else if(turn.status==='terminated'){
                    swal({
                        title: "Información",
                        text: "Necesitas llamar a un usuario para iniciar la atención.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });
                }



            }

        }else{

            swal({
                title: "Información",
                text: "Necesitas llamar a un usuario para iniciar la atención.",
                icon: "error",
                button: {
                    text: "Aceptar",
                    className: "red"
                }
            });

        }
    });

    $('#finalizar').click(function (e){

        var turn= localStorage.getItem('turn');
        turn=JSON.parse(turn);

        var idTurn=turn.turn_id;
        var idTicket=localStorage.getItem('ticket-office');



        if(localStorage.getItem('turn')!==null) {

            if (turn.status != 'call' && turn.status != 'cancel' && turn.status!="terminated") {
                swal({
                    title: "¿Quieres finalizar el servicio?",
                    text: "Al finalizar seguira con el proximo usuario en cola, no se revertiran los cambios.",
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
                    }
                }).then(function (value) {

                    if (value) {
                        $.ajax({
                            method: 'POST',
                            url: url + "Turn/Finally",
                            data: {
                                idTurn: idTurn,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            beforeSend: function () {
                                $("#preloader").fadeIn('fast');
                                $("#preloader-overlay").fadeIn('fast');
                            },
                            success: function (data) {

                                turn.status = 'terminated';
                                localStorage.setItem('turn', JSON.stringify(turn));
                                $('#call').removeClass('hide');

                                var idTurn = $("#idTurn").val('0');

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
                                    window.location.href=url_semat+'ticketOffice/home';
                                });
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                            },
                            error: function (err) {
                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
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
                            text: "Acción Cancelada.",
                            icon: "info",
                            button: {
                                text: "Aceptar",
                                className: "green"
                            }
                        });
                    }
                });

            }else{

                if(turn.status==='call'){

                    swal({
                        title: "Información",
                        text: "Debes inciar la atención para poder finalizarla.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });


                }else if(turn.status==='cancel'){
                    swal({
                        title: "Información",
                        text: "El turno del usuario ya ha sido cancelado.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });
                }else if(turn.status==='terminated'){
                    swal({
                        title: "Información",
                        text: "El turno del usuario ya fue finalizado, puedes llamar de nuevo a otro usuario.",
                        icon: "error",
                        button: {
                            text: "Aceptar",
                            className: "red"
                        }
                    });
                }


            }
        }else{

            swal({
                title: "Información",
                text: "Necesitas llamar a un usuario para terminar la atención.",
                icon: "error",
                button: {
                    text: "Aceptar",
                    className: "red"
                }
            });


        }
    });

    $('#cancelar').click(function (e){


        var turn= localStorage.getItem('turn');
        turn=JSON.parse(turn);
        var idTurn=turn.turn_id;

        if(localStorage.getItem('turn')!==null) {


            swal({
                title: "¿Quieres cancelar el servicio?",
                text: "Al cancelar seguira con el proximo usuario en cola, no se revertiran los cambios.",
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
                }
            }).then(function (value) {

                if (value) {
                    $.ajax({
                        method: 'POST',
                        url: url + "Turn/Cancel",
                        data: {
                            idTurn: idTurn,
                            "_token": $("meta[name='csrf-token']").attr("content")
                        },

                        beforeSend: function () {
                            $("#preloader").fadeIn('fast');
                            $("#preloader-overlay").fadeIn('fast');
                        },
                        success: function (data) {
                            console.log(data);
                            turn.status = 'cancel';
                            localStorage.setItem('turn', JSON.stringify(turn));


                            $('#call').removeClass('hide');



                            swal({
                                title: "¡Se cancelo con éxito!",
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
                            }).then(function () {
                                window.location.href=url_semat+'ticketOffice/home';
                            });


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
                        }
                    })
                } else {

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
        }else{

            swal({
                title: "Información",
                text: "Necesitas llamar a un usuario para cancelar la atención.",
                icon: "error",
                button: {
                    text: "Aceptar",
                    className: "red"
                }
            });

        }
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


                if(status==='taken'){
                    localStorage.setItem('ticket-office',id);
                    swal({
                        title: "Bien hecho",
                        text: "Taquilla N°:"+id +",Habilitada con éxito.",
                        icon: "success",
                        button: {
                            text: "Aceptar",
                            visible: true,
                            value: true,
                            className: "green",
                            closeModal: true
                        },
                        timer: 3000
                    }).then(function () {
                        window.location.href=url_semat+'ticketOffice/home';
                    });
                }else{
                    swal({
                        title: "Bien hecho",
                        text: "Taquilla N°:"+id +",habilitada para otros operadores.",
                        icon: "success",
                        button: {
                            text: "Aceptar",
                            visible: true,
                            value: true,
                            className: "green",
                            closeModal: true
                        },
                        timer: 3000
                    }).then(function () {
                        localStorage.clear();
                        window.location.href=url_semat+'ticketOffice/home';
                    });


                }




                $('#number-ticket-office').removeClass('hide');
                $('#number-ticket-office').text(id);
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




    $('#exit-sysq').click(function () {

        if(localStorage.getItem('ticket-office')!==null) {


            swal({
                title: "¿Quieres cerrar la taquilla?",
                text: "Si la cierras la taquilla quedara disponible para otros operadores.",
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Cerrar",
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
                }
            }).then(function (accept) {


                if(accept){

                    var turn= localStorage.getItem('turn');
                    turn=JSON.parse(turn);

                    console.log(turn);


                    if(localStorage.getItem('turn')!=null&&(turn.status=='init'||turn.status=='call')){
                        swal({
                            title:'Error',
                            text: "tienes un cliente en proceso de atención, para poder dejar la taquillas debes atender el cliente en proceso, o marcar que no se presento.",
                            icon: "error",
                            button: {
                                text: "Aceptar",
                                className: "green"
                            }
                        });
                    }else{
                        changeStatus(localStorage.getItem('ticket-office'),'Activo');
                    }

                }else {
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


        }else{


            swal({
                title: "Información",
                text: "Debe tener una taquilla activa para poder salir de esta.",
                icon: "error",
                button: {
                    text: "Aceptar",
                    className: "red"
                }
            });

        }
    });


    $('#reset').click(function (e){

        swal({
            title: "¿Quieres cancelar todo los usuarios en colas?",
            text: "Al realizar esta acción, todos los usuarios en cola serán cancelados.",
            icon: "error",
            buttons: {
                confirm: {
                    text: "Cancelar Colas",
                    value: true,
                    visible: true,
                    className: "red"

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
                    url: url+"/Turn/Reset",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#preLoader').hide();
                        swal({
                            title: "¡Se cancelo con exito!",
                            text: "No hay usuarios en cola ",
                            icon: "success",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            },
                            timer: 3000
                        })
                            .then(redirect => {
                                window.location.href=url_semat+'ticketOffice/home';
                            })
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
                    text: "No se ha cancelado las tareas",
                    icon: "warning",
                    button: {
                        text: "Aceptar",
                        className: "green"
                    }
                });
            }
        });

    });



    $('#reset-ticket').click(function (e){

        swal({
            title: "¿Deseas limpiar todas la taquillas?",
            text: "Al realizar esta acción, todos las taquillas quedaran disponible.",
            icon: "error",
            buttons: {
                confirm: {
                    text: "Cancelar Taquillas",
                    value: true,
                    visible: true,
                    className: "red"

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
                    method:'GET',
                    url: url+"/Ticket/update/all",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function(data) {
                        console.log(data);


                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');

                        swal({
                            title: "¡Se liberaron todas la taquillas con éxito.!",
                            text: "Ahora todas la taquillas estan disponible. ",
                            icon: "success",
                            button: {
                                text: "Aceptar",
                                visible: true,
                                value: true,
                                className: "green",
                                closeModal: true
                            },
                            timer: 3000
                        })
                            .then(redirect => {
                                window.location.href=url_semat+'ticketOffice/home';
                            })
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
                    text: "No se ha cancelado las tareas",
                    icon: "warning",
                    button: {
                        text: "Aceptar",
                        className: "green"
                    }
                });
            }
        });

    });


    if(url_semat==='https://sysprim.com/'){
        $('#lateral-bar').addClass('hide');
    }

});
