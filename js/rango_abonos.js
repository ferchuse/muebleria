
function ajaxError(xhr, textStatus, error){
	alertify.error("Error" + error);
	console.error(xhr);
	console.error(textStatus);
	console.error(error);
}

$( document ).ready(function() {
	
	

function cargarTabla(filtros, tbody, tabla_php){
		tbody.html("<tr ><td class='text-center' colspan='13'> <i class='fa fa-spinner fa-spin fa-3x'></i><td><tr>");
		tbody.load("control/get_tabla_compras.php", 
			filtros,
			function(response){
				
				$(".borrar_fila").click(function(){
					boton= $(this);
					tabla = $(this).closest("table").data("tabla");
					id_field = $(this).closest("table").data("id_field");
					fila = boton.closest("tr");
					
					alertify.confirm("¿Está seguro que desea borrar este artículo?", borrarFila).setHeader("Confirmar Borrado");
					
					function borrarFila(){
						data = {
								"table": tabla,
								"id_field": id_field,
								"id_value": boton.data("id_value")
							};
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
				
				$(".btn_recibir").click(function(){
					$("#id_compra").val($(this).data("id_value"));
					$("#modal_recibir").modal("show");
					
					
				});
				$(".editar_fila").click(function(){
					boton= $(this);
					tabla = $(this).closest("table").data("tabla");
					id_field =  $(this).closest("table").data("id_field");
					id_value=  boton.data("id_value");
					id_modal = $(this).closest("table").data("modal");
					id_form = $(this).closest("table").data("form");
					$(id_form).data("action", "update");
					$(id_modal).find(".titulo_action").html("Editar " + tabla );
					
					
					data = {
								"table": tabla,
								"id_field": id_field,
								"id_value": id_value
							};
					url = "control/get_row_json.php";
					loader = boton.find(".fa")
					loader.toggleClass("fa-pencil fa-spinner fa-spin");
				
					console.log("Cargando datos del Especialidad ");
					
					ajaxCall(url, data).then(function(response){
								loader.toggleClass("fa-pencil fa-spinner fa-spin");
								//console.log("---DONE---"); 
								console.log(response);
								if(response.found ){
									console.log("Llenando Inputs en FOrmulario" + id_form);
									console.log($(id_form).attr("id") );
									$.each(response.data,function(key, value){
										$(id_form).find("#" + key).val(value);
										console.log(key +", "+ value)
									});
								}
								else{
									
								}
								$(id_modal).modal("show");
								
							},
							ajaxError, 
							function(progress){
								console.log("--Progress--");
								console.log(progress);
							
						});
				});				
			});
	}
	
	
		$(".insertar_fila").click(function(){
		$nombre_tabla = $(this).data("nombre_tabla");
		
		$modal = $($(this).data("modal"));
		$modal.modal("show");
		$modal.find("form").data("action" , "insert");
		$modal.find("form")[0].reset();
		$modal.find(".titulo_action").html("Agregar " + $nombre_tabla );
		console.log("Insertar");
		
	});
	
	
	
	
	/* $("form").submit(function (form_event){
		
		form_event.preventDefault();  
		this_form = $(this);
		action = this_form.data("action");
		modal= this_form.closest(".modal"); //Seleccionamos el cuadro de dialogo
		tbody = $("#"+this_form.data("tabla")).find("tbody");
		
		icono_carga= modal.find(".fa-spin"); //Seleccionamos el icono de carga 
		icono_carga.toggleClass("hide"); //Mostramos el icono de carga
		if(action == "insert"){
			url = "control/rows_name_insert.php";
			data = {
					"fields_value" : this_form.serializeArray(), //COnvertimos los campos un array de pares {name , value}
					"table": this_form.data("tabla") ,//indicamos la tabla de la base de datos a la que se insertaran	
			}
		}
		else{
			url = "control/rows_name_update.php";
			data = {
					"fields_value" : this_form.serializeArray(), //COnvertimos los campos un array de pares {name , value}
					"table": this_form.data("tabla") ,//indicamos la tabla de la base de datos a la que se insertaran	
					"id_field": this_form.data("id_field"),
					"id_value" : $("#"+ this_form.data("id_field")).val()
				}
		}
		$.ajax({  // creamos una llamada de ajax indicando sus parametros: 
				"url": url, // Dirección del codigo a ejecutar en la solicitud
				"dataType": "json", // El tipo de texto que esperamos de respuesta
				"method": "POST", 
				"data": data//Array (Objeto) que enviamos junto con el POST 
				
				})
				.done(function( respuesta ) { 
						if(respuesta.estatus == "success"){ // si el estatus es exitoso mostramos mensaje correcto
							alertify.success("Guardado correctamente" );
							
							icono_carga.toggleClass("hide"); //Volvemos a ocultar el icono de carga
							modal.modal("hide"); //Cerramos el cuadro de dialogo 
							this_form[0].reset(); //Reseteamos el formulario
							cargarTabla(filtros, tbody);
						}
						else{ // si no lo es mostramos mensaje de error
							
							alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " +respuesta.mensaje  );
							
						}
						
						console.debug("Respuesta: " );
						console.debug(  respuesta);	// Para depuracion mostramos la respuesta del servidor
				})
				.fail(ajaxError);
		
	});
	 */
	$("#form_rangos").submit(function (event){
		event.preventDefault();  
		var modal = $("#modal_recibir");
		var boton = $(this).find(":submit");
		var icono_carga = boton.find(".fa");
	
	
		icono_carga.toggleClass("fa-save fa-spinner fa-spin");
		boton.attr("disabled", true);
		
			$.ajax({
				"url": "control/guardar_rango_abonos.php", 
				"dataType": "json", 
				"method": "POST", 
				"data": $("#form_rangos").serialize()
				
				})
				.done(function( respuesta ) { 
						if(respuesta.estatus == "success"){ // si el estatus es exitoso mostramos mensaje correcto
							alertify.success("Guardado correctamente" );
							
						
						}
						else{ // si no lo es mostramos mensaje de error
							
							alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " +respuesta.mensaje  );
							
						}
				})
				.fail(ajaxError)
				.always(function(){
						icono_carga.toggleClass("fa-save fa-spinner fa-spin");
						boton.attr("disabled", false);
					
				});
	});
	
	
});