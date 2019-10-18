$(document).ready(function () {
    var url="https://sysprim.com/";
    $('#RIF').blur(function () {
        if ($('#RIF').val() !== '') {
            var rif = $('#document_type').val()+$('#RIF').val();
                console.log(rif);

            $.ajax({
                method: "GET",
                url: url+"company/verify-rif/" + rif,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
                        });
                        $("#preloader").fadeOut('fast');
                        $("#preloader-overlay").fadeOut('fast');
                        $('#RIF').val("");
                        $('#RIF').addClass('validate');
                    }else{
                        findCompany(rif);
                    }

                },
                error: function (err) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                    $('#RIF').val(' ');

                }
            });
        }
    });


    $('#license').blur(function () {
        if ($('#license').val() !== '') {
            var license = $('#license').val();
            $.ajax({
                method: "GET",
                url: url+"company/verify-license/" + license,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                    if (response.status === 'error') {
                        swal({
                            title: "¡Oh no!",
                            text: response.message,
                            icon: "error",
                            button: "Ok",
                        });

                        $('#license').val('');

                    }

                },
                error: function (err) {
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

    $('#company-register').on('submit',function (e) {
        e.preventDefault();
        console.log($('#lgn').val());
        if($('#lgn').val()!==" "){
            $.ajax({
                url: url+"companies/save" ,
                cache:false,
                contentType:false,
                processData:false,
                data:new FormData(this),
                method: "POST",

                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {

                    swal({
                        title: "¡Bien Hecho!",
                        text: "Ciiu Registrado con Exito",
                        icon: "success",
                        button: "Ok",
                    }).then(function (accept) {
                        window.location.href=url+"companies/my-business";
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
            });
        }else{
            swal({
                title: "¡Oh no!",
                text: "Debe ubicar su empresa en el mapa, para poder completar el registro.",
                icon: "error",
                button: "Ok",
            });
        }

    });


    $('#ciu_group').change(function () {
       var id=$(this).val();
            console.log(id);
       if(id.length>=1){
           $.ajax({
               type: "POST",
               url: url + "ciu/filter-group",
               data: {id:id},


               beforeSend: function () {
                   $("#preloader").fadeIn('fast');
                   $("#preloader-overlay").fadeIn('fast');
               },
               success: function (response) {
                   var ciu=response[0].ciu;
                   var acum="<option disabled selected>Elige una rama</option>";
                   //compruebo si viene vacio el array de objetos
                   if(response[0] === null){
                       acum="<option disabled selected>No hay rama asociada a esa categoria</option>";
                   }else{//si no viene vacio lo recorro
                       for (var i=0;i<ciu.length;i++){
                           var ciu_group=ciu[i];
                           for(var j=0;j<ciu_group.length;j++) {
                               acum += '<option value=' + ciu_group[j].id + '>' + ciu_group[j].name + '</option>';
                           }
                       }
                   }

                   //finalmente suplanto el contenido del select
                   $("#ciu").html(acum);
                   $('select').formSelect();

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

       }else{
           console.log("epa");
           acum="<option disabled selected>Selecione una Rama</option>";
           $("#ciu").html(acum);
           $('select').formSelect();
       }

    });







    function findCompany(rif){

        $.ajax({
            method: "GET",
            url: url+"company/find/" + rif.toUpperCase(),
            beforeSend: function () {

            },
            success: function (response) {
                $("#preloader").fadeOut('fast');
                $("#preloader-overlay").fadeOut('fast');

                console.log(response);
                if (response.status === 'success') {
                     var company=response.company;

                    $('#name').val(company.historico_nombre_empresa);
                    $('#RIF').val(company.rif.substr(1));
                    $('#license').val(company.codigo_licencia);
                    $('#address').val(company.direccion);
                    M.updateTextFields();
                }

            },
            error: function (err) {
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



function initMap() {
    function removeItemFromArr ( arr, item ) {
        var i = arr.indexOf( item );

        if ( i !== -1 ) {
            arr.splice( i, 1 );
        }
    }
    var marcadores =[];
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat:10.0736954, lng:-69.3498597}
    });

    map.addListener('click', function(e) {
        addMark(e.latLng, map);
    });

    function addMark(latLng, map) {
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            title:"ESTOY AQUÍ"
        });
        map.panTo(latLng);

        marcadores.push(marker);

        if(marcadores.length>1){
            removeItemFromArr( marcadores, marker );
            marker.setMap(null);

            swal({
                title: "¡Oh no!",
                text: "Solo puedes hacer una marca para ubicar tu empresa, si te equivocaste añadiendo la marca, haga click en ella y esta se eliminara automaticamente.",
                icon: "error",
                button: "Ok",
            });
        }else{
            $('#lng').val(marcadores[0].getPosition().lng());
            $('#lat').val(marcadores[0].getPosition().lat());
            M.updateTextFields();
        }
        google.maps.event.addListener(marker, 'click', function() {
            removeItemFromArr( marcadores, marker );
            marker.setMap(null); //borramos el marcador del mapa
            $('#lng').val(" ");
            $('#lat').val(" ")
        });
        console.log(marcadores[0].getPosition().lat()+'-'+marcadores[0].getPosition().lng());
    }
}
