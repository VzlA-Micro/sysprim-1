function makeTimer() {

	//		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");	
		var endTime = new Date("15 January 2020 23:59:59 GMT+01:00");			
			endTime = (Date.parse(endTime) / 1000);

			var now = new Date();
			now = (Date.parse(now) / 1000);

			var timeLeft = endTime - now;

			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#days").css('font-size','70px').html(days + "<h6 style='font-size:20px;margin-top:-20px'>Días</h6>");
			$("#hours").css('font-size','70px').html(hours + "<h6 style='font-size:20px;margin-top:-20px'>Horas</h6>");
			$("#minutes").css('font-size','70px').html(minutes + "<h6 style='font-size:20px;margin-top:-20px'>Minutos</h6>");
			$("#seconds").css('font-size','70px').html(seconds + "<h6 style='font-size:16px;margin-top:-20px'>Segundos</h6>");		

	}
	setInterval(function() { makeTimer(); }, 1000);