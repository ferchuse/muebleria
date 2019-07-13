$(document).ready(function(){
	
	
	$("#btn_guardar").click(function(){
		$.post("guardar_cobradores.php", $( "#form_cobradores" ).serialize() + "&",   function(data_return, status){
			alert(data_return);
		
		});

	});
	var hola;
	
	//alta de cobrador
	 
	
	$('#form-alta').submit(function(event){
		console.log("Enviando...");
		var datos =	$('#form-alta').serialize();
			//event.preventDefault();
			$.ajax(
				{"url": "guardar_cobradores.php",
						"method": "POST",
						"data": datos
				}).done(function(respuesta, status){
					if(respuesta["estatus"] == "success"){
						alertify.success(respuesta["mensaje"]);
						window.location.reload();
					}else{
				
						alertify.error(respuesta["mensaje"]);
					}

				
					
				});	
					
			return false;
	});
	
	
	$(".btn_update").click(function(e){
		var $boton= $(this);
		var activo = $boton.closest("tr").find(".activo").prop("checked") ? 1 : 0;
		
		datos = {
				"nombre_cobrador" : $boton.closest("tr").find(".nombre_cobrador").val(),
				"password" : $boton.closest("tr").find(".password").val(),
				"mac_impresora" : $boton.closest("tr").find(".mac_impresora").val(),
				"tel_cobrador" : $boton.closest("tr").find(".tel_cobrador").val(),
				"activo" : activo,
				"id_cobrador" :  $boton.data("id_cobrador"),
				"update" :  "update"
				
			};
		
		
		$.ajax({
			"url": "guardar_cobradores.php",
			"method": "POST",
			"data": datos
		}).done(function(respuesta){
			if(respuesta["estatus"] == "success"){
				alertify.success(respuesta["mensaje"]);
				
			}else{
				
				alertify.error(respuesta["mensaje"]);
			}
			
		}).fail(function(xhr, error, errno){
			alertify.error(error);
			
		});
	});
});