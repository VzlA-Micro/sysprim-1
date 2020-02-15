$('document').ready(function () {
    var url = localStorage.getItem('url');
    $('#open-cashier').click(function () {
        if (localStorage.getItem('bank') == null) {
            swal({
                title: "PUNTO DE VENTA 1/2",
                text: "Introduzca el numero de lote del punto de venta:",
                icon: "info",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Escribe un numero",
                        type: "number",
                    },
                },
            }).then(function (name) {
                if (name === null || isNaN(name) || name <= 0) {
                    swal({
                        title: "Información",
                        text: "Acción cancelada,debe ingresar un numero de lote valido.",
                        icon: 'info'
                    });
                } else {
                    localStorage.setItem('lot', name);
                    swal({
                        title: "SELECIONE EL BANCO DE RECAUDACIÓN 2/2",
                        icon: "info",
                        buttons: {
                            cancel: true,
                            BANCO: {text: "100%BANCO", value: "33", className: "blue"},
                            BOD: {text: "BOD", value: "44", className: "green width"},
                        }
                    }).then(function (bank) {
                        if (bank === null) {
                            swal({
                                title: "Información",
                                text: "Acción cancelada,debe ingresar un punto.",
                                icon: 'info'
                            });
                        } else {
                            localStorage.setItem('bank', bank);
                            var hoy = new Date();
                            var dd = hoy.getDate();
                            localStorage.setItem('day',dd);
                            swal({
                                title: "Bien hecho",
                                text: "Ya puedes empezar a registrar pagos valido.",
                                icon: "success",
                            });

                            location.reload();
                        }
                    })
                }
            });

        } else {
            swal({
                title: "Información",
                text: "Acción cancelada,debe abrir caja.",
                icon: 'info'
            });
        }
    });
    var hoy = new Date();
    var dd = hoy.getDate();

    if(localStorage.getItem('day')!=dd){
        localStorage.removeItem('bank');
        localStorage.removeItem('lot');
        localStorage.removeItem('day');
    }




    if (localStorage.getItem('bank') === null && localStorage.getItem('lot') === null&&$('.content').val()!==undefined) {
        swal({
            title: "Información",
            text: "Debe abrir caja, para empezar a registrar pagos.",
            icon: "info",
        });

        $('#select-next').attr('disabled','disabled');
    } else {
        $('#select-next').removeAttr('disabled','');
        var bank = localStorage.getItem('bank');
        var lot = localStorage.getItem('lot');


        if (bank === "44") {
            $('#name_bank').val('BOD');
        } else {
            $('#name_bank').val("100%BANCO");
        }

        $('#bank').val(bank);
        $('#lot').val(lot);

        M.updateTextFields();

        $('#content').css('display', 'block');
        $('#one').removeClass('disabled');
    }



    $('#close-cashier').click(function () {
        if (localStorage.getItem('bank') !== null) {
            swal({
                title: "Información",
                text: "¿Estas seguro?, Si cierras las caja, no podras revertir los cambios.",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: "Si",
                        value: true,
                        visible: true,
                        className: "green"

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
                    localStorage.removeItem('bank');
                    localStorage.removeItem('lot');
                    window.location.href = url + 'ticket-office/type-payment';
                }

            });


        } else {
            swal({
                title: "Información",
                text: "Acción cancelada,debe abrir la caja para poder cerrarla.",
                icon: 'info'
            });

        }
    });






});