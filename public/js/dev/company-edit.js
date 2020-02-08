
var url = localStorage.getItem('url');

var addCiiu = false;
var disabledCiiu = false;
var updateCompany = false;

$('document').ready(function () {

    $('#company-status').click(function () {
        var status=$(this).val();
        var message;

        var company_id=$('#id').val();
        if(status==='enabled'){
            message='activar esta empresa? , recuerde que al activar esta empresa podra realizar pagos.';
        }else{
            message='deshabilitar esta empresa? ,recuerda que al deshabilitar esta empresa no podra realizar pagos.';
        }
        swal({
            icon: "info",
            title: "Empresa",
            text: "¿Está seguro de "+ message,
            buttons: {
                confirm: {
                    text: "Aceptar",
                    value: true,
                    visible: true,
                    className: "green-gradient"
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
                $.ajax({
                    method: "GET",
                    url: url+"company/change-status/"+company_id+"/"+status,

                    beforeSend:function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (response) {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "La Empresa fue "+ message  +" con éxito.",
                            icon: "success",
                            button:{
                                text: "Esta bien",
                                className: "green-gradient"
                            },
                        }).then(function (accept) {
                            location.reload();
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');


                    },
                    error: function (err) {
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


    $('#update-company').on('click', function () {

        if (!updateCompany) {
            $('#document_type').prop("disabled", false);
            $('select').formSelect();
            $('#RIF').removeAttr('readonly');
            $('#name').removeAttr('readonly');
            $('#license').removeAttr('readonly');
            $('#opening_date').removeAttr('disabled');
            $('#number_employees').removeAttr('disabled');
            $('#sector').removeAttr('disabled');
            $('#code_catastral').removeAttr('disabled');
            $('#country_code_company').removeAttr('disabled');
            $('select').formSelect();
            $('#parish').removeAttr('disabled', '');
            $('select').formSelect();
            $('#address').removeAttr('disabled');
            $('#phone').removeAttr('disabled');
            updateCompany=true;
            $('#update-company').text('Guardar');
            swal({
                title: "Información",
                text: "Los campos fueron habilitados, una vez hagas los cambios has click en guardar.",
                icon: "info",
                button: "Ok",
            });


        }
        else {
            var documentType = $('#document_type').val();
            var rif = documentType+$('#RIF').val();
            var name = $('#name').val();
            var license = $('#license').val();
            var openingDate = $('#opening_date').val();
            var numberEmployees = $('#number_employees').val();
            var sector = $('#sector').val();
            var codeCadastral = $('#code_catastral').val();
            var countryCodeCompany = $('#country_code_company').val();
            var parish = $('#parish').val();
            var address=$('#address').val();
            var phone = $('#phone').val();
            var id = $('#id').val();
            $.ajax({
                type: "POST",
                url: url + "company/update",
                data: {
                    id: id,
                    rif:rif,
                    name:name,
                    license:license,
                    opening_date:openingDate,
                    numberEmployees:numberEmployees,
                    sector:sector,
                    codeCadastral:codeCadastral,
                    countryCodeCompany:countryCodeCompany,
                    parish:parish,
                    address:address,
                    phone:phone
                },
                dataType: "JSON",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                    $('#document_type').prop("disabled", true);
                    $('select').formSelect();
                    $('#RIF').attr('readonly','readonly');
                    $('#name').attr('readonly','readonly');
                    $('#license').attr('readonly','readonly');
                    $('#opening_date').attr('disabled','disabled');
                    $('#number_employees').attr('disabled','disabled');
                    $('#sector').attr('disabled','disabled');
                    $('#code_catastral').attr('disabled','disabled');
                    $('#country_code_company').attr('disabled','disabled');
                    $('select').formSelect();
                    $('#parish').attr('disabled', 'disabled');
                    $('select').formSelect();
                    $('#address').attr('disabled','disabled');
                    $('#phone').attr('disabled','disabled');
                },
                success: function (data) {

                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                     if(data) {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Has actualizado Los datos de la empresas con éxito",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            location.reload();
                        });
                    }

                },
                error: function (e) {

                    if(e.status===500){
                            location.reload();
                    }else{
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



                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    console.log(e);
                }

            });
        }
    });




    $('#add-ciiu').on('click', function () {
        if (addCiiu == false) {
            $('#code').prop("disabled", false);
            $('#search-ciu').removeAttr('disabled');
            addCiiu = true;
            $('#add-ciiu').text('Guardar CIIU');
            swal({
                title: "Información",
                text: "Ingresa los codigo CIIU en la casilla selecionada",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "amber-gradient"
                },
            }).then(function () {
                $('#code').focus();
            });


        } else {
            var ciu = [];
            var id = $('#id').val();



            $('.ciu').each(function () {
                ciu.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: url + "company/addCiiu",
                data: {
                    id: id,
                    ciu: ciu
                },
                dataType: "JSON",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (data) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    $('#bDelete').remove();


                    if (data == true) {
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Has Añadido Los nuevos CIIU Con éxito",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {
                            location.reload();
                        });

                    }
                },
                error: function (e) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    console.log(e);
                }

            });
        }
    });


    $('#search-ciu').click(function () {
        var code = $('#code').val();

        var band = true;
        if (code != "") {
            $.ajax({
                type: "GET",
                url: url + "ciu/find/" + code,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status !== 'error') {
                        var subr = response.ciu.name.substr(0, 3);
                        var template = `<div>
                                <input type="hidden" name="ciuAdd[]" id="ciuAdd" class="ciu" value="${response.ciu.id}">
                                <div class="input-field col s12 m4">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  disabled value="${response.ciu.code}" >
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="name-ciu" id="${subr}" cols="30" rows="10" class="materialize-textarea" disabled required>${response.ciu.name}</textarea>
                                </div>

                                <div class="input-field col s12 m1" id="bDelete">
                                    <button  class="btn waves-effect waves-light peach col s12 delete-ciu"><i class="icon-close"></i>
                                    </button>
                                </div>
                            </div>
                        `;

                        if ($('.ciu').val() !== undefined) {
                            $('.ciu').each(function (index, value) {
                                if ($(this).val() == response.ciu.id) {
                                    swal({
                                        title: "¡Oh no!",
                                        text: "El CIIU " + response.ciu.code + " ya esta ingresado en esta empresa.",
                                        icon: "warning",
                                        button:{
                                            text: "Esta bien",
                                            className: "amber-gradient"
                                        },
                                    });
                                    $('#code').val("");
                                    band = false;
                                }

                            });

                            if (band) {
                                $('#group-ciu').append(template);
                                confirmCiu();
                            }

                        } else {
                            $('#group-ciu').append(template);
                            confirmCiu();
                        }

                        $('.delete-ciu').click(function () {
                            $(this).parent().parent().text("");
                        });

                        M.textareaAutoResize($('#' + subr));
                        M.updateTextFields();
                    } else {
                        swal({
                            title: "Información",
                            text: "El CIIU que ingresó no se encuentra registrado en el sistema.",
                            icon: "info",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        });
                    }

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
            });
        } else {
            swal({
                title: "Información",
                text: "Debe ingresar un CIIU valido.",
                icon: "info",
                button:{
                    text: "Esta bien",
                    className: "blue-gradient"
                },
            });
        }
    });



    $('.disabled-ciu-selected').click(function () {
        var ciu_id=$(this).val();
        var company_id= $('#id').val();
        var status=$(this).attr('data-ciiu');


        swal({
            title: "Cambiar estado de CIIU",
            text: "Esta seguro que desea cambiar el estado del CIIU?",
            icon: "info",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "amber-gradient"
                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (accept) {
            if(accept){
                $.ajax({
                    type: "GET",
                    url: url + "company/ciu/" +ciu_id+'/'+company_id+'/'+status,
                    dataType: "JSON",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');
                    },
                    success: function (data) {
                        swal({
                            title: "Bien hecho",
                            text: "El estado del CIIU ha cambiando con éxito.",
                            icon: "success",
                            button:{
                                text: "Esta bien",
                                className: "blue-gradient"
                            },
                        }).then(function () {
                            location.reload();
                        });

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        console.log(data);
                    },
                    error: function (e) {

                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        console.log(e);
                    }

                });
            }
        });

    });



    $('#change-users').click(function () {
        swal({
            title: "Información",
            text: "¿Desea cambiar el usuario que administrará esta empresa?.Recuerda que los cambios son  permanentes.",
            icon: "info",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "amber-gradient"
                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (accept) {
            if(accept){
                swal({
                    text: 'Ingresa la cedula del usuario a cambiar Ej:V12345678.',
                    content: "input",
                    attributes: {
                        placeholder: "Escribe la cedula Ej:V1234567",
                        type: "text",
                    },
                    button: {
                        text: "Buscar",
                        className: "amber-gradient",
                        closeModal: false,



                    },
                }).then(ci => {
                    var company_id= $('#id').val();
                    if(ci!==null){
                    console.log(ci.toUpperCase());
                        $.ajax({
                            type: "GET",
                            url: url + '/company/change-users/'+company_id+'/'+ci.toUpperCase(),
                            dataType: "JSON",
                            beforeSend: function () {
                                $("#preloader").fadeIn('fast');
                                $("#preloader-overlay").fadeIn('fast');
                            },
                            success: function (data) {

                                if(data.status==='success'){
                                    swal({
                                        title: "Bien hecho",
                                        text: data.message,
                                        icon: "success",
                                        button:{
                                            text: "Aceptar",
                                            className: "blue-gradient"
                                        },
                                    }).then(function (accept) {

                                        location.reload();
                                    });
                                }else{
                                    swal({
                                        title: "Información",
                                        text: data.message,
                                        icon: "info",
                                        button:{
                                            text: "Aceptar",
                                            className: "blue-gradient"
                                        },
                                    });
                                }


                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                                console.log(data);
                            },
                            error: function (e) {

                                $("#preloader").fadeOut('fast');
                                $("#preloader-overlay").fadeOut('fast');
                                console.log(e);
                            }

                        });


                    }else{
                        swal({
                            title: "Información",
                            text: "Acción cancelada,Debes ingresar la cedula primero.",
                            icon: "info",
                            button:{
                                text: "Aceptar",
                                className: "blue-gradient"
                            },
                        });

                    }


                })





            }else{

            }

        });



    });





    function confirmCiu() {
        swal({
            title: "¡Bien Hecho!",
            text: "CIIU ingresado con éxito, ¿Desea añadir otro CIIU? ",
            icon: "info",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "amber-gradient"
                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then();
    }







    $('#disabled-ciiu').on('click', function () {
        if (disabledCiiu == false) {
            var ciiu;
            var selected = [];




                $('.ciu').each(function () {
                    ciiu = $(this).val();
                    var status=$(this).siblings('.ciu_status').val();

                    if(status=='disabled'){
                        button=`
                            <div class="input-field col s12 m1" id="bDelete">
                                <button type="button" class="btn waves-effect waves-light red col s12  disabled-ciu-selected" value="${ciiu}"  data-ciiu="enabled">
                                  <i class="icon-do_not_disturb_alt "></i></button>
                             
                            </div>`;
                        $(this).siblings('.nameCiiu').after(button);
                    }else{
                        button=`
                            <div class="input-field col s12 m1" id="bDelete">
                                <button type="button" class="btn waves-effect waves-light green col s12  disabled-ciu-selected" value="${ciiu}" data-ciiu="disabled">
                                  <i class="icon-check"></i></button>
                             
                            </div>`;
                        $(this).siblings('.nameCiiu').after(button);
                    }
                });


                /*var checkBox =
                    `<label class="col m1">
                        <input type="checkbox" name="ciiuCheck[]" class=".ciiuCheck" value=${ciiu}>
                        <span></span>
                    </label>`;
            */





            disabledCiiu = true;
        }
        else {
            $('.Dciiu').each(function () {
                check = $('.ciiuCheck').val();
                //$('.ciiuCheck').each(function () {
                  //  check = $(this).val();
                //});

                console.log(check);
                //if (check) {
                //  selected.push($(this).val());
                //}
            });

            //console.log(selected);
        }
    });



    $('#change-maps').click(function () {
        swal({
            title: "Información",
            text: "Marca la nueva ubicación dentro del mapa.",
            icon: "info",
            button:{
                text: "Esta bien",
                className: "blue-gradient"
            },
        }).then(function (accept) {


            var focalizar = $("div#div-map").position().top;
            $('html,body').animate({scrollTop: focalizar}, 1000);


            var lat = parseFloat($('#lat').val());
            var lng = parseFloat($('#lng').val());
            var image = 'https://sysprim.com/images/mark-map.png';



            var marcadores = [];
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: {lat: lat, lng:lng}
            });
            map.addListener('click', function (e) {
                console.log(e.latLng);
                addMark(e.latLng, map,image,marcadores,true);
            });



        });

    });





    $('#license').change(function () {
        var license=$('#license').val();
        var rif=$('#document_type').val()+$('#RIF').val();
        verifylicense(license,rif);
    });

    function verifylicense(license,rif) {
        if (license !== '') {
            $.ajax({
                method: "GET",
                url: url + "company/verify-license/" + license+"/"+rif,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    console.log(response);
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button:{
                                text: "Entendido",
                                className: "red-gradient"
                            },
                        }).then(function () {
                            location.reload();
                        });
                    }

                },
                error: function (err) {
                    console.log(err);
                    $('#license').val('');
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
            });
        }
    }
});

window.onload = function () {
    var image = 'https://sysprim.com/images/mark-map.png';
    var lat = parseFloat($('#lat').val());
    var lng = parseFloat($('#lng').val());

    var marcadores = [];
    var myLatLng = {lat: lat,
                    lng: lng
                    };

    //creando el mapa.
    var map = new google.maps.Map(
        document.getElementById('map'), {
        zoom: 17,
        center: {lat: lat, lng: lng}
    });
    /*map.addListener('click', function(e) {
        addMark(e.latLng, map);
    });*/

    addMark(myLatLng, map,image,marcadores,false);



    //aniade una marca al mapa
}

function addMark(myLatLng, map,image,marcadores,remove) {

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        animation: google.maps.Animation.BOUNCE,
        title: "ESTOY AQUÍ",
    });


    if(remove){
        google.maps.event.addListener(marker, 'click', function () {
            removeItemFromArr(marcadores, marker);
            marker.setMap(null); //borramos el marcador del mapa
            $('#lng').val(" ");
            $('#lat').val(" ");
        });

        swal({
            title: "Información",
            text: "¿Deseas guardar la ubicación del mapa seleccionada?",
            icon: "info",
            buttons: {
                confirm: {
                    text: "Si",
                    value: true,
                    visible: true,
                    className: "amber-gradient"
                },
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: "grey lighten-2"
                }
            }
        }).then(function (accept) {
            if(accept){
                var id=$('#id').val();
                var lat=$('#lat').val();
                var lng=$('#lng').val();

                $.ajax({
                    type: "POST",
                    url: url + "company/update/map",
                    data: {
                        id: id,
                        lat:lat,
                        lng:lng
                    },
                    dataType: "JSON",
                    beforeSend: function () {
                        $("#preloader").fadeIn('fast');
                        $("#preloader-overlay").fadeIn('fast');

                    },
                    success: function (data) {
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        swal({
                            title: "¡Bien Hecho!",
                            text: "Se actualizo la ubicación de la empresa con éxito.",
                            icon: "success",
                            button: "Ok",
                        }).then(function () {

                            location.reload();
                        });




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


                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        console.log(e)
                    }

                });

            }else{



            }

        });

    }



    marcadores.push(marker);
    if (marcadores.length > 1) {
        removeItemFromArr(marcadores, marker);
        marker.setMap(null);

        swal({
            title: "¡Oh no!",
            text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
            icon: "error",
            button:{
                text: "Entendido",
                className: "red-gradient"
            },
        });
    } else {
        $('#lng').val(marcadores[0].getPosition().lng());//coloca la marca
        $('#lat').val(marcadores[0].getPosition().lat);//a quien le coloco la multa
    }
}


// quita un valor de un array
function removeItemFromArr(arr, item) {
    var i = arr.indexOf(item);

    if (i !== -1) {
        arr.splice(i, 1);
    }
}


