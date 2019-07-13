
function ajaxCall(url, data, loader){
			
	var request = 	$.ajax({
			"url": url,
			"type":'GET',
			"data":	data,
			"dataType": 'json'
		});
	
	return request;
}
function ajaxError(xhr, textStatus, error){
	alertify.error("Error" + error);
	console.error(xhr);
	console.error(textStatus);
	console.error(error);
}

$( document ).ready(function() {
	
	
	function cargarTabla(){
		$("#icono_carga").toggleClass("fa-search fa-spinner fa-spin");
		$("#tabla_ventas").load("control/get_almacen_movimientos.php", 
			"fecha_reporte="+ $("#fecha_reporte").val(),
			function(response){
				console.log(response);
				$("#icono_carga").toggleClass("fa-search fa-spinner fa-spin");
		});
	}
	
	$("#form_reporte").submit(function(event){
		event.preventDefault();
		cargarTabla();
		
	});
	
	$( ".fecha" ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate : 0
		//yearRange: '1920:2000'
	});
	
	
	cargarTabla();
	
	
	
	$(".filtro_buscar").keyup(function(event){
		var valor_filtro = $(this).val();
		var campo_filtro = $(this).data("campo_filtro");
		
		console.log("filtrar WHERE " + campo_filtro +"=" + valor_filtro );
		
		$("#tbody").load("tabla_Articulos.php", 
			{"campo_filtro" : campo_filtro, "valor_filtro" : valor_filtro});
		
	});
	
	
});
