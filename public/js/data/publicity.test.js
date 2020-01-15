$('select[name=unit]').change(function () {
		var unit = $(this).val();
		var content = $('#content');
		var template;
		if(unit === 'mts') {
			template = `
            	<div class="col s12">
           			<label for="width">Ancho</label>
        			<input type="text" class="js-range-slider" name="width" id="width" value="">
            	</div>
            	<div class="col s12">
           			<label for="height">Alto</label>
        			<input type="text" class="js-range-slider" name="height" id="height" value="">
            	</div>
			`;
			content.html(template);
			$(".js-range-slider").ionRangeSlider({
    			skin: "modern",
    			max: 50,
    			min: 0,
    			grid: true,
    			step: 0.1,
    			postfix: ' m'
    		});
		}
		else if(unit === 'qnt'){
			template = `
				<div class="input-field col s12">
                    <input type="text" name="quantity" id="quantity">
                    <label for="quantity">Cantidad</label>
                </div>
			`;
			content.html(template);
		}
	});


	$('#advertising_type_id').change(function(){
		var array = new Array();
		var template;
		var content = $('#content');

		$('#advertising_type_id :selected').each(function(i, selected){
			array.push({'id': $(this).val(), 'name': $(this).text()});
			// array.push()
		});
		console.log(array);
		array.forEach(function(type) {
			// console.log(type);
			switch(type.id) {
				case '1':  
					template = `
						<div class="input-field col s12">
	            			<input type="text" name="type" id="type" value="${ type.name }" readonly>
	            		</div>
						<div class="input-field col s12 m6">
	           				<input type="text" name="date_start" id="date_start" class="datepicker date_start">
	            			<label for="date_start">Fecha de Inicio</label>
	            		</div>
	            		<div class="input-field col s12 m6">
	            			<input type="text" name="date_end" id="date_end" class="datepicker date_end">
	            			<label for="date_end">Fecha de Fin</label>
	            		</div>
	            		<div class="col s12 input-field">
	                        <select name="unit" id="unit">
	                            <option value="null" disabled>Elige la unidad</option>
	                            <option value="mts" selected>Metro</option>
	                            <option value="qnt" disabled>Cantidad</option>
	                        </select>
	                        <label>Unidad</label>
	                    </div>
	            		<div class="col s12">
		           			<label for="width">Ancho</label>
		        			<input type="text" class="js-range-slider" name="width" id="width" value="">
		            	</div>
		            	<div class="col s12">
		           			<label for="height">Alto</label>
		        			<input type="text" class="js-range-slider" name="height" id="height" value="">
		            	</div>
						<div class="input-field col s12">
		                    <input type="text" name="quantity" id="quantity">
		                    <label for="quantity">Cantidad de Lugares</label>
		                </div>
		                <div class="divider"></div>
					`;
					content.html(template);
	    			$('select').formSelect();
	    			var date = new Date();
	    			$('.date_start').datepicker({
		                maxDate:  date,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
		            $('.date_end').datepicker({
		                maxDate:  null,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
					$(".js-range-slider").ionRangeSlider({
		    			skin: "modern",
		    			max: 50,
		    			min: 0,
		    			grid: true,
		    			step: 0.1,
		    			postfix: ' m'
		    		});
					break;
				case '2':
				case '3': 
				case '4': 
				case '5': 
				case '6':
				case '7': 
				case '12':
				case '14': 
					template = `
		            	<div class="input-field col s12">
	            			<input type="text" name="type" id="type" value="${ type.name }" readonly>
	            		</div>
						<div class="input-field col s12 m6">
	           				<input type="text" name="date_start" id="date_start" class="datepicker date_start">
	            			<label for="date_start">Fecha de Inicio</label>
	            		</div>
	            		<div class="input-field col s12 m6">
	            			<input type="text" name="date_end" id="date_end" class="datepicker date_end">
	            			<label for="date_end">Fecha de Fin</label>
	            		</div>
	            		<div class="col s12 input-field">
	                        <select name="unit" id="unit">
	                            <option value="null" disabled>Elige la unidad</option>
	                            <option value="mts" disabled>Metro</option>
	                            <option value="qnt" selected>Cantidad</option>
	                        </select>
	                        <label>Unidad</label>
	                    </div>
	                    <div class="input-field col s12">
		                    <input type="text" name="quantity" id="quantity">
		                    <label for="quantity">Ejemplares</label>
		                </div>
		                <div class="divider"></div>
					`;
					content.append(template);
					$('select').formSelect();
	    			var date = new Date();
	    			$('.date_start').datepicker({
		                maxDate:  date,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
		            $('.date_end').datepicker({
		                maxDate:  null,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
		            break;
		        case '8':
		        case '9':
		        case '13':
		        	template = `
		            	<div class="input-field col s12">
	            			<input type="text" name="type" id="type" value="${ type.name }" readonly>
	            		</div>
						<div class="input-field col s12 m6">
	           				<input type="text" name="date_start" id="date_start" class="datepicker date_start">
	            			<label for="date_start">Fecha de Inicio</label>
	            		</div>
	            		<div class="input-field col s12 m6">
	            			<input type="text" name="date_end" id="date_end" class="datepicker date_end">
	            			<label for="date_end">Fecha de Fin</label>
	            		</div>
		                <div class="divider"></div>
					`;
					content.append(template);
					$('select').formSelect();
	    			var date = new Date();
	    			$('.date_start').datepicker({
		                maxDate:  date,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
		            $('.date_end').datepicker({
		                maxDate:  null,
		                format: 'yyyy-mm-dd', // Configure the date format
		                // yearRange: [1900,date.getFullYear()],
		                showClearBtn: false,
		                i18n: {
		                    cancel: 'Cerrar',
		                    clear: 'Reiniciar',
		                    done: 'Hecho',
		                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		                    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		                    weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
		                }
		            }); 
		            break;
		        case '10':
		        case '11':
		        case '15':

			}
			// else {
			// 	// content.html("");
			// }
		});
		// console.log($(selected).val());

		// var advertisingType = $(this).val();
		// alert($(sel).val());

	})

