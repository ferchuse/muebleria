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
	var filtros = {};
	
	cargarTabla(filtros);
	cargarTablaCategorias(filtros);
	llenarCategorias($("#grupo_estatus"));
	
	$form = $( "#form_insert" );
	$modal = $form.closest(".modal");
	
	$( "#form_insert" ).submit(function submitDoctor(event){ // Cuando enviamos el formulario

		event.preventDefault(); // Cancelamos el comportamiento predeterminado del formulario de ser enviado y recargar la pagina tambien podemos usar return false para detener la funcion
		
		form = $(this)[0];
		modal = $(this).closest(".modal");
		icono_carga= $(this).find(".fa-spin"); //Seleccionamos el icono de carga 
		icono_carga.toggleClass("hide"); //Mostramos el icono de carga
		boton = icono_carga.closest(".btn");
		boton.attr("disabled", true);
		action = $("#form_insert").find("#action");
		
		if(action.val() == "insert"){
			var url ="control/rows_name_insert.php";
			var	data= {
					"fields_value" : $("#form_insert").serializeArray(), //COnvertimos los campos del formulario a un array de pares {name , value}
					"table": $("#form_insert").data("table_name") //indicamos la tabla de la base de datos a la que se insertaran	
				};
			
		}
		else{
			var url ="control/rows_name_update.php";
			var	data= {
					"fields_value" : $("#form_insert").serializeArray(), 
					"table": $("#form_insert").data("table_name"),
					"id_field":  $("#form_insert").data("id_field"),
					"id_value":  $(".id_field").val()
				};
		}
		$.ajax({ // creamos una llamada de ajax indicando sus parametros: 
				"url": url, // Dirección del codigo a ejecutar en la solicitud
				"dataType": "json", // El tipo de texto que esperamos de respuesta
				"method": "POST", 
				"data": data //Array (Objeto) que enviamos junto con el POST
			}).done( function( respuesta ) { 
						if(respuesta.estatus == "success"){ // si el estatus es exitoso mostramos mensaje correcto
							alertify.success("Guardado correctamente" );
							console.log(respuesta);
							modal.modal("hide")
							icono_carga.toggleClass("hide"); //Volvemos a ocultar el icono de carga
							boton.attr("disabled", false);
							form.reset(); //Reseteamos el formulario
							cargarTabla(filtros); 
														
						}
						else{ // si no lo es mostramos mensaje de error
							
							alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " +respuesta.mensaje  );
							
						}
						
						
						console.debug("Respuesta: " );
						console.debug(  respuesta);	// Para depuracion mostramos la respuesta del servidor
				}).fail( ajaxError);
				
		});
		
		
	$( ".form_insert" ).submit(function submitForm(event){ // Cuando enviamos el formulario

		event.preventDefault();
		
		$form = $(this);
		modal = $(this).closest(".modal");
		icono_carga= $(this).find(".fa-spin"); //Seleccionamos el icono de carga 
		icono_carga.toggleClass("hide"); //Mostramos el icono de carga
		boton = icono_carga.closest(".btn");
		boton.attr("disabled", true);
		action = $form .find(".action");
		
		if(action.val() == "insert"){
			var url ="control/rows_name_insert.php";
			var	data= {
					"fields_value" : $(this).serializeArray(), 
					"table": $form.data("table_name") 
				};
			
		}
		else{
			var url ="control/rows_name_update.php";
			var	data= {
					"fields_value" : $form.serializeArray(), 
					"table": $form.data("table_name"),
					"id_field":  $form.data("id_field"),
					"id_value":  $(".id_field").val()
				};
		}
		$.ajax({ // creamos una llamada de ajax indicando sus parametros: 
				"url": url, // Dirección del codigo a ejecutar en la solicitud
				"dataType": "json", // El tipo de texto que esperamos de respuesta
				"method": "POST", 
				"data": data //Array (Objeto) que enviamos junto con el POST
			}).done( function( respuesta ) { 
						if(respuesta.estatus == "success"){ // si el estatus es exitoso mostramos mensaje correcto
							alertify.success("Guardado correctamente" );
							console.log(respuesta);
							modal.modal("hide")
							icono_carga.toggleClass("hide"); //Volvemos a ocultar el icono de carga
							boton.attr("disabled", false);
							$form[0].reset(); //Reseteamos el formulario
							cargarTablaCategorias(filtros); 
														
						}
						else{ // si no lo es mostramos mensaje de error
							
							alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " +respuesta.mensaje  );
							
						}
				}).fail( ajaxError);
				
		});
	
	
	$("#btn_insert").click(function(e){
		$("#action").val("insert");
		$( "#form_insert" )[0].reset();
		//$( "#form_insert" ).find(".modal-title").html("Insert");
		$( "#modal_form" ).modal("show");
		//console.log("reset form and insert"); 
	}); 
	
	$("#btn_insert_categoria").click(function(e){
		$( "#modal_categorias" ).find(".action").val("insert");
		$( "#modal_categorias" ).find(".form_insert")[0].reset();
		$( "#modal_categorias" ).find(".modal-title").html("Nueva Categoria");
		$( "#modal_categorias" ).modal("show");
	}); 
	
	
	function llenarCategorias($select){
		console.log("llenarCategorias()");
		$.ajax({ 
				"url": "control/get_select_options.php", 
				"method": "POST", 
				"data": {
					"id_field" : "id_categoria",
					"field" : "categoria_estatus",
					"table": "categorias_estatus",
					"order": "id_categoria"
					
				}
			}).done( function( respuesta ) { 
				$select.html(respuesta);		
			}).fail( ajaxError);
	
	}
	function cargarTablaCategorias(filtros){
		
		$("#tbody_categorias").html("<div class='text-center'><i class='fa fa-3x fa-spinner fa-spin '></i></div>");
		$.ajax({
			"url": "control/get_tabla_categorias.php", 
			"method": "POST", 
			"data": filtros
		}).done(function terminaCargarCategorias(respuesta){
				
					$("#tbody_categorias").html(respuesta);
				$(".borrar_fila").click(function(){
					boton= $(this);
					tabla = $(this).closest("table").data("tabla");
					id_field = $(this).closest("table").data("id_field");
					fila = boton.closest("tr");
					
					alertify.confirm("¿Está seguro que desea borrar este registro?", borrarFila).setHeader("Confirmar Borrado");
					
					function borrarFila(){
						data = {
								"table": tabla,
								"id_field": id_field,
								"id_value": boton.data("id_value")
							};
						url = "control/row_delete.php";
						boton.prop("disabled", true);
						loader = boton.find(".fa")
						loader.toggleClass("fa-trash fa-spinner fa-spin");
						
						ajaxCall(url, data).then(function(response){
								loader.toggleClass("fa-trash fa-spinner fa-spin");
								if(response.estatus == "success"){
									alertify.success(response.mensaje);
									fila.fadeOut(50,  function(){
										fila.remove();
									});
									llenarCategorias($("#grupo_estatus"));
								}
								else{
									alertify.error("Error");
								}
							},
							ajaxError, 
							function(progress){
							
						});
						
					}
				});
				
				$(".editar_fila").click(function(){
					boton= $(this);	//asignamos el buton presionado a una variable
					id_value=  boton.data("id_value"); //obtenemos el id del registro guardado en el atributo data
					data = {
						"table": $("#form_insert").data("table_name"),
						"id_field": $("#form_insert").data("id_field"),
						"id_value": id_value
					}
					url = "control/get_row_json.php";
					loader = boton.find(".fa");
					loader.toggleClass("fa-pencil fa-spinner fa-spin");
					$("#action").val( "update");
					$form.find(".modal-title").html("Editar Estatus" );
						
				
					$.ajax(
					{"url":		url			, 
						"data":data,
						"method": "GET"
					}).done(function(respuesta){
								loader.toggleClass("fa-pencil fa-spinner fa-spin");
								console.log(respuesta);
								if(respuesta.found ){
									console.log("Llenando Inputs");
									$.each(respuesta.data,function(key, value){
										$("#" + key).val(value);
										
									});
								}
								else{
									
								}
								$modal.modal("show");
								
							}).fail(ajaxError);
							
						$("#div_existencias").html("<i class='fa fa-spinner fa-spin fa-2x'></i>");
						
						$("#div_existencias").load("control/get_existencia.php",
							{"formato": "html" , "id_articulo": id_value}, 
							function(respuesta){
							
							
						});					
						
				});				
			});
	}

	
	
	
	function cargarTabla(filtros){
		
		$("#tbody_estatus").html("<div class='text-center'><i class='fa fa-3x fa-spinner fa-spin '></i></div>");
		$("#tbody_estatus").load("control/get_tabla_estatus.php", 
			filtros,
			function(response){
				
				$(".borrar_fila").click(function(){
					boton= $(this);
					tabla = $(this).closest("table").data("tabla");
					id_field = $(this).closest("table").data("id_field");
					fila = boton.closest("tr");
					
					alertify.confirm("¿Está seguro que desea borrar este registro?", borrarFila).setHeader("Confirmar Borrado");
					
					function borrarFila(){
						data = {
								"table": tabla,
								"id_field": id_field,
								"id_value": boton.data("id_value")
							};
						url = "control/row_delete.php";
						boton.prop("disabled", true);
						loader = boton.find(".fa")
						loader.toggleClass("fa-trash fa-spinner fa-spin");
						
						ajaxCall(url, data).then(function(response){
								loader.toggleClass("fa-trash fa-spinner fa-spin");
								if(response.estatus == "success"){
									alertify.success(response.mensaje);
									fila.fadeOut(50,  function(){
										fila.remove();
									});
								}
								else{
									alertify.error("Error");
								}
							},
							ajaxError, 
							function(progress){
							
						});
						
					}
				});
				
				$(".editar_fila").click(function(){
					boton= $(this);	//asignamos el buton presionado a una variable
					id_value=  boton.data("id_value"); //obtenemos el id del registro guardado en el atributo data
					data = {
						"table": $("#form_insert").data("table_name"),
						"id_field": $("#form_insert").data("id_field"),
						"id_value": id_value
					}
					url = "control/get_row_json.php";
					loader = boton.find(".fa");
					loader.toggleClass("fa-pencil fa-spinner fa-spin");
					$("#action").val( "update");
					$form.find(".modal-title").html("Editar Estatus" );
						
				
					$.ajax(
					{"url":		url			, 
						"data":data,
						"method": "GET"
					}).done(function(respuesta){
								loader.toggleClass("fa-pencil fa-spinner fa-spin");
								console.log(respuesta);
								if(respuesta.found ){
									console.log("Llenando Inputs");
									$.each(respuesta.data,function(key, value){
										$("#" + key).val(value);
										
									});
								}
								else{
									
								}
								$modal.modal("show");
								
							}).fail(ajaxError);
							
						$("#div_existencias").html("<i class='fa fa-spinner fa-spin fa-2x'></i>");
						
						$("#div_existencias").load("control/get_existencia.php",
							{"formato": "html" , "id_articulo": id_value}, 
							function(respuesta){
							
							
						});					
						
				});				
			});
	}
});


