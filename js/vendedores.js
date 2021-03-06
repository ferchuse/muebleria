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
	
	
	$("#btn_insert").click(function(e){
		$("#action").val("insert");
		$( "#form_insert" )[0].reset();
		$form.find(".modal-title").html("Editar Vendedor" );
		$( "#modal_form" ).modal("show");
	}); 
	
	
	function cargarTabla(filtros){
		console.log("filtros");
		console.log(filtros);
		$("#tbody").html("<div class='text-center'><i class='fa fa-3x fa-spinner fa-spin '></i></div>");
		$("#tbody").load("control/get_tabla_vendedores.php", 
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
					url = "control/get_row_json.php";
					data = {
						"table": $("#form_insert").data("table_name"),
						"id_field": $("#form_insert").data("id_field"),
						"id_value": id_value
					}
					
					loader = boton.find(".fa");
					loader.toggleClass("fa-pencil fa-spinner fa-spin");
					$("#action").val( "update");
					$modal.find(".modal-title").html("Editar Vendedor" );
						
				
					$.ajax(
					{"url":		url			, 
						"data":data,
						"method": "GET"
					}).done(function(respuesta){
								loader.toggleClass("fa-pencil fa-spinner fa-spin");
								console.log(respuesta);
								if(respuesta.found ){
									console.log("Llenando Datos");
									$("#id_vendedor").val(respuesta.data.clave_vendedor);
									$.each(respuesta.data,function(key, value){
										$("#" + key).val(value);
										
										console.log(key);
										console.log(value);
									});
								}
								else{
									
								}
								$modal.modal("show");
								
						}).fail(ajaxError);			
				});
			});
	}
});


