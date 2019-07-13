function ajaxCall(url, data, loader){
			
	var request = 	$.ajax({
			"url": url,
			"type":'POST',
			"data":	data,
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
	table = "articulos";
	id_field = "id_articulo";
	filtros = {};
	
	$("#form_nuevo_articulo").submit(function(event){
		event.preventDefault();
		form = $(this);
		url = "control/rows_name_insert.php";
		data= {"table": "articulos", "fields_value": form.serializeArray()}
		icono_carga= form.find(".fa-spin");
		icono_carga.toggleClass("hide");
		modal = form.closest(".modal")
		ajaxCall(url, data).done(function(response){
			console.log(response);
			if(response.estatus == "success"){
				alertify.success(response.mensaje);
				icono_carga.toggleClass("hide");
				modal.modal("hide");
				console.log("Recargar Tabla");
				cargarTabla(filtros);
			}
			else{
				
				alertify.error(response.mensaje)
			}
			
			icono_carga.toggleClass("hide");
		}).fail(ajaxError).always(function(){
			
			icono_carga.toggleClass("hide");
		});
		
	});
	
	function cargarTabla(filtros){
		
		ajaxCall("control/get_tabla_articulos.php", filtros).done(function(respuesta){
			$("#tbody").html(respuesta);
			
			$(".borrar_fila").click(function(){
				
				boton= $(this);
				fila = boton.closest("tr");
				
				alertify.confirm("¿Está seguro que desea borrar esta fila?", borrarFila).setHeader("Confirmar Borrado");
				
				function borrarFila(){
					data = {"table": "articulos" , "id_field" : "id_articulo","id_value" : boton.data("id_value")};
					url = "control/fila_borrar.php";
					loader = boton.find(".fa")
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
			
			$(".editar_fila").click(function(){
				boton= $(this);
				id_value=  boton.data("id_value");
				data = {"table": table , "id_field" : id_field,"id_value" : id_value};
				url = "control/get_row_json.php";
				loader = boton.find(".fa")
				loader.toggleClass("fa-pencil fa-spinner fa-spin");
				//carga datos de paciente 
				
			
				ajaxCall(url, data).then(function(response){
							loader.toggleClass("fa-pencil fa-spinner fa-spin");
							console.log("---DONE---"); 
							console.log(response);
							if(response.found ){
								console.log("Llenando Inputs");
								$.each(response.data,function(key, value){
									$("#" + key).val(value);
									
								});
							}
							else{
								
							}
							$("#modal_nuevo_articulo").modal("show");
							
						},
						ajaxError, 
						function(progress){
							console.log("--Progress--");
							console.log(progress);
						
					});
				
				
			});
		}).fail(ajaxError);
	}
	
	cargarTabla(filtros);

});
/* 
function getSelectOptions(options){
			
	var request = 	$.ajax({
			url:'control/get_options.php',
			type:'GET',
			data:
			{
				"tabla" :  tabla,
				"campo" :  campo,
				"id_col" :  id_col
				
			},
			dataType: 'json'
			
		});
	
	return request;
} */


/* $( document ).ready(function() {
	
	var options= {
		"tabla": "CatalogoFormaPago",
		"campo": "forma",
		"id_col": "IdForma",
		"order": "forma",
		"selected": "1",
		"selector": "#forma_pago_1"
	}
	
	$("#btn_guardar").click(function(event){
		
		
	});
		
	$.when(getSelectOptions(options))
		.then(function( response ) {
			$.each(response.data, function(i, row) {
				
				//console.log(row);
				//console.log(row[0]);
				//console.log(row[1]);
				this_option = $('<option>').text(row[1]).attr('value', row[0]);
				$( options.selector).append(this_option);
			});
			$( options.selector).val(options.selected);
			//console.log("SELECTED" + options.selected);
	});

	
	
}); */