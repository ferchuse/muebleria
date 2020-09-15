/* function ajaxCall(url, data, loader){		
	var request = 	$.ajax({
			"url": url,
			"type":'POST',
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
} */

$( document ).ready(function() {
	

	$("#form_liquidar").submit(function(event){
		event.preventDefault();
		
		data = $(this).serialize() + "&" + "id_usuario=" + $("#id_usuario").val()+ "&" + "folio_venta=" + $("#folio_venta").val() ;
		url = "control/ventas_liquidar.php";
		loader = $(this).find(".fa-usd");
		loader.toggleClass("fa-usd fa-spinner fa-spin");
		
		
		ajaxCall(url, data).then(function(response){
				loader.toggleClass("fa-usd fa-spinner fa-spin");
				console.log("---DONE---"); 
				console.log(response);
				if(response.estatus == "success"){
					alertify.success("Abono Guardado");
				}
				else{
					
				}
			},
			ajaxError, 
			function(progress){
				console.log("--Progress--");
				console.log(progress);
			
		});
			
	});
});