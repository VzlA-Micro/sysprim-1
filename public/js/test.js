        // var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

if(type === 'monthly') {
    console.log('Marica aqui');
    var year = parseInt(fiscalPeriod.substr(0,4));
    console.log(year, date.getFullYear());
    if(year === date.getFullYear()) {
        $('#month').attr('disabled',false);
        var options = `<option value="null" disabled selected>Seleccione un mes...</option>`;
        for(var i = 0; i <= date.getMonth(); i++) {
            options += `<option value="0${ i+1 }">${ months[i] }</option>`;
        }
        $('#month').html(options);
        
    }
    else {
        $('#month').attr('disabled',false);
        var options = `<option value="null" disabled selected>Seleccione un mes...</option>`;
        for(var i = 0; i <= 11; i++) {
            options += `<option value="0${ i+1 }">${ months[i] }</option>`;
        }
        $('#month').html(options);
    }
    $('select').formSelect();
}

PUB00000004