$( document ).ready(function() {
	hideLoader();
	
	cargarMensajes();
	
	$("#nuevo_mensaje").click(function(){
		
		alertify.prompt("Nuevo Mensaje", "Mensaje", "", function(event, mensaje){
			$.ajax({
			"url": "control/insert_mensajes.php",
			"method": "GET",
			"data": {
				"mensaje":mensaje
			}
			}).done(function(respuesta){
				alertify.success(respuesta.mensaje);
				console.log(mensaje);
				cargarMensajes();
			});	
			
		}, 
		function(){
			
		});
		
	});
	
	
	function hideLoader(){
		console.log("hideLoader");
		$("#loader").hide();
	}
	function showLoader(){
		console.log("showLoader");
		$("#loader").show();
	}
	
	
	
	function cargarMensajes(){
		$.ajax({
			"url": "control/get_mensajes.php",
			"method": "POST",
			
		}).done(function(respuesta){
			
			$(".li_mensaje").remove(); //Borra los mensajes Anteriores
			$("#inicio_mensajes").after(respuesta); //Inserta los nuevos mensajes
			
			contarMensajes();
			
			function contarMensajes(){
				var cant_mensajes = $(".mensaje .fa-envelope").length;
				console.log(cant_mensajes)
				$("#mensajes_nuevos").html(cant_mensajes);
			}
			
			
			$('.dropdown-menu .mensaje').click(function(e) {
					e.stopPropagation();
					console.log("No Ocultar");
			});
			$(".mensaje").click(function(){
				//$(this).find(".leido").toggleClass("text-primary");
				var id_mensaje = $(this).data("id_mensaje");
				$(this).toggleClass("text-muted bg-info");
				$sobre = $(this).find(".leido");
				$sobre.toggleClass("fa-envelope fa-check text-primary");
				contarMensajes();
				$(this).find(".hora_leido").toggleClass("hide");
				$.ajax({
					"url": "control/rows_name_update.php",
					"method": "POST",
					"data": {
						"table": "mensajes",
						"fields_value": [
							{
								"name": "leido",
								"value": 1
							}
						],
						"id_field": "id_mensaje",
						"id_value": id_mensaje
					}
				});
			});
		}).fail();
		
	}
	
	 
});