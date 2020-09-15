function ajaxCall(url, data, method){		
	var request = 	$.ajax({
			"url": url,
			"method": method,
			"data":	data,
			"dataType": 'json'
		});
	
	return request;
}
function ajaxError(xhr, textStatus, error){
	alertify.error("<i class='fa fa-warning'></i> Error: " + error);
	console.error(xhr);
	console.error(textStatus);
	console.error(error);
}


$( document ).ready(function() {
	$( "#btn_agregar_egreso" ).click(function(event) {
		console.log("Cargar Folio Egreso");
	});
	$( "#btn_agregar_banco" ).click(function(event) {
		console.log("Cargar Folio Banco");
		url = "control/getNuevoFolio.php";
		data = {"table" : "Banco", "turno" : $("#turno").val()}
		method = "GET";
		
		
		ajaxCall(url, data, method).done(function(response){
			
			console.log("done ajax call");
			console.log(response);
			$("#folio_banco").val(response.data);
			
		}).fail(ajaxError);
		
	});
	
	
	$(".borrar_fila").click(function(){
		
		boton= $(this);
		fila = boton.closest("tr");
		
		alertify.confirm("¿Está seguro que desea borrar este registro?", borrarFila).setHeader("Confirmar Borrado");
		
		function borrarFila(){
			table = boton.data("table");
			id_field = boton.data("id_field");
			id_value = boton.data("id_value");
			
			data = {"table": table , "id_field" : id_field,"id_value" : id_value};
			url = "control/fila_borrar.php";
			
			loader = boton.find(".fa");
			loader.toggleClass("fa-trash fa-spinner fa-spin");
			
			
			
			
			ajaxCall(url, data).then(function(response){
					loader.toggleClass("fa-trash fa-spinner fa-spin");
			 
					console.log("---DONE---"); 
					console.log(response);
					if(response.estatus == "success"){
						alertify.success(response.mensaje);
						fila.fadeOut(50,  function(){
							fila.remove();
						});
					}
					else{
						
					}
					
					
				},
				ajaxError, 
				function(progress){
					console.log("--Progress--");
					console.log(progress);
				
			});
			
		}
	});
	
});