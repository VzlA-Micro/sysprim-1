$('document').ready(function () {
    var url = localStorage.getItem('url');
    var user=$('#user').val();



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
            $('#document').val('');
        }

    });


    $('#document').change(function () {
        findDocument();
    });


    $('#type_document').change(function () {
        findDocument();
    });

    $('#data-next').click(function () {
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
                    url: url + 'rate/taxpayers/company-user/register',

                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        $('#id').val(response.id);

                        $('#two').removeClass('disabled');
                        $('#one').addClass('disabled');
                        $('ul.tabs').tabs("select", "rate-tab");
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                    },
                    error: function (err) {

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
                $('ul.tabs').tabs("select", "rate-tab");
            }
        }


    });



    $('#register-rates').click(function () {
        var rate_id=[];
        var type=$('#type').val();
        var id=$('#id').val();


        $('#rates').DataTable().destroy();

        $("input[type=checkbox]:checked").each(function(){
            rate_id.push($(this).val());
        });

        if(rate_id.length>0) {
            $.ajax({
                method: "POST",
                dataType: "json",
                data: {
                    rate_id: rate_id,
                    type: type,
                    id: id,
                },
                url: url + 'rate/taxpayers/save',

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    swal({
                        title: "!Bien Hecho!",
                        text: "Se ha generado la planilla de tasa con éxito,verifique los montos y continue. ",
                        icon: "success",
                        button:{
                            text: "Esta bien",
                            className: "blue-gradient"
                        },
                    }).then(function () {
                        if(!user){
                            location.href=url+'rate/taxpayers/details/'+response.taxe_id;
                        }else {
                            swal({
                                title: "¡Bien Hecho!",
                                text: "La planilla ha sido generado con éxito, ¿Desea seguir generando planillas?",
                                icon: "success",
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
                                    location.reload();
                                } else {
                                    window.location.href = url + 'ticket-office/taxes';
                                }

                            });
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

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                }
            });
        }else{
            swal({
                title: "Información",
                text: "Debes seleccionar al menos una  tasa a generar.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }

    });



    function findDocument() {
        var type_document=$('#type_document').val();
        var document=$('#document').val();
        $('#surname').val('');
        $('#user_name').val('');
        $('#type').val('');
        $('#address').val('');
        $('#name').val('');


        if(document!=='') {
            $.ajax({
                method: "GET",
                url: url + "rate/taxpayers/find/" + type_document  +"/"+document,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {



                    if(response.status!=='error') {


                        if (response.type == 'not-user') {

                            var user = response.user.response;

                            if(user.inscrito==false){
                                swal({
                                    title: "Lo sentimos",
                                    text: "Su cédula no se encuentra registrada en el CNE.",
                                    icon: "info",
                                    button: {
                                        text: "Entendido",
                                        className: "red-gradient"
                                    },
                                }).then(function () {
                                    $('#document').val('');
                                    $('#document').focus();
                                });

                            }else{
                                $('#name').val(user.nombres + ' ' + user.apellidos);
                                $('#name').attr('readonly');
                                $('#surname').val(user.apellidos);
                                $('#user_name').val(user.nombres);
                                $('#type').val('user');
                                $('#id').val(user.id);
                                $('#address').removeAttr('readonly', '');
                            }

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


    $('.prev-view').click(function () {
        window.history.back();
    });




});