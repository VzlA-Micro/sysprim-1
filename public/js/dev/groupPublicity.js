var url = localStorage.getItem('url');


var updateType = false;

$('document').ready(function () {

    $('#groupName').blur(function () {

        $.ajax({
            url: url + "group_publicity/verifyName",
            data: {group: $('#groupName').val()},
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                if (data) {
                    $("#preloader").hide();
                    $("#preloader-overlay").hide();
                    swal({
                        title: "¡Grupo de Publicidad Registrado!",
                        text: "No puedes registrar este grupo.",
                        icon: "warning",
                        button: {
                            text: "Aceptar",
                            className: "orange-gradient"
                        },
                    });
                    $('#groupRegister').prop('disabled', true);
                } else {
                    $("#preloader").hide();
                    $("#preloader-overlay").hide();
                    $('#groupRegister').prop('disabled', false);
                }

            },
            error: function (e) {
                console.log(e);
            }
        });
    });



    $('#register').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: url + "group_publicity/save",
            data: {name: $('#groupName').val()},
            dataType: 'json',
            method: "POST",

            beforeSend: function () {
                $("#preloader").fadeIn('fast');
                $("#preloader-overlay").fadeIn('fast');
            },
            success: function (data) {
                $("#preloader").hide();
                $("#preloader-overlay").hide();
                if (data) {
                    swal({
                        title: "¡Bien Hecho!",
                        text: "Grupo de Publicidad, registrado con exito!",
                        icon: "info",
                        button: {
                            text: "Aceptar",
                            className: "green-gradient"
                        },
                    }).then(function () {
                        location.reload();
                    });
                }

            },
            error: function (e) {
                $("#preloader").hide();
                $("#preloader-overlay").hide();

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
        });
    });


    $('#btn-modify').click(function() {
        $(this).hide();
        $('#name').removeAttr('readonly');
        $('#btn-update').removeClass('hide');
        swal({
            title: "¡Actualizar!",
            text: "Puedes elegir los campos a modificar",
            icon: "info",
            button: "Ok",
        });
    });



    $('#updateGroup').on('submit', function (e) {
            e.preventDefault();
            $('#name').removeAttr('readonly');


            swal({
                icon: "info",
                title: "Actualizar el grupo",
                text: "¿Está seguro que desea modificar los datos?, Si lo hace, no podrá revertir los cambios.",
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
                    $.ajax({
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        url: url + "group_publicity/update",
                        data: new FormData(this),
                        dataType: false,

                        beforeSend: function () {
                            $('#name').attr('readonly', 'readonly');
                        },
                        success: function (data) {
                            if (data['update'] == true) {
                                swal({
                                    title: "¡Bien Hecho!",
                                    text: "Has Actualizado Los datos del grupo, Con Exito",
                                    icon: "success",
                                    button: "Ok",
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        },
                        error: function (e) {
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
                    });
                    updateType = false;
                }
            });
    });
});




