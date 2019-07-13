
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

function calcularPrecios(event){
		
	$(".porc_ganancia").each(function(index, element){
			var porc_precio = Number($(element).val());
			var precio = Number($("#costo_compra").val()) * (1 + (porc_precio / 100 ));
			
			$(element).closest(".row").find(".precio").val(precio.toFixed(2));
			
	}); 
	 
}
function toggleButton(event){
		var desactivado = $(this).hasClass("btn-danger") ? true : false;
		
		$(this).find(".fa").toggleClass("fa-ban fa-check");
		$(this).toggleClass("btn-success btn-danger");
		
		$(this).closest(".row").find(".activo").val(!desactivado + 0);
		$(this).closest(".row").find(".porc_ganancia").prop("disabled", desactivado);
		$(this).closest(".row").find(".precio").prop("disabled", desactivado);
	 
}

 
$( document ).ready(function() {
	
	$("input").focus(function focus(){
		console.log("focus()");
		$(this).select();
			
	});
	
	$(".filtro_buscar").on("keyup", function buscarCliente(event) {
				var value = $(this).val().toLowerCase();
				$("#tbody tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
	
	$(".btn_toggle").click( toggleButton);
	
	$("#costo_compra").keyup( calcularPrecios);
	$("#costo_compra").change( calcularPrecios);
	
	$(".porc_ganancia").keyup( calcularPrecios);
	$(".porc_ganancia").change( calcularPrecios);
	
	$("input").scroll(function scroll(){
		console.log("scroll()");
		return false;
	});
	$("input").change(function change(){
		console.log("change()");
		//return false;
	});
	
	var filtros = {};
	 
	cargarTabla(filtros);
	
	
	
	// $(".filtro_buscar").keyup( function filtro_buscar(event){
		// var valor_filtro = $(this).val();
		// var campo_filtro = $(this).data("campo_filtro");
		
		
		// filtros.campo_filtro = campo_filtro;
		// filtros.valor_filtro = valor_filtro;
		
		// cargarTabla(filtros);
	// });	
	
	// $(".filtro_select").change( function filtro_select(event){
		// var valor_filtro = $(this).val();
		// var campo_filtro = $(this).data("campo_filtro");
		// console.log("filtro_select");
		
		// filtros.campo_filtro = campo_filtro;
		// filtros.valor_filtro = valor_filtro;
		
		// cargarTabla(filtros);
	// });	
	
	$("#id_almacen").change(function(event){
		filtros.id_almacen = $("#id_almacen").val();
		cargarTabla(filtros);
	});
	$("#existencia").change(function(event){
		filtros.existencia = $("#existencia").val();
		cargarTabla(filtros);
	});
	
	function cargarTabla(filtros){
		console.log("filtros");
		console.log(filtros);
		$("#tbody").html("<td colspan='8'><div class='text-center'><i class='fa fa-4x fa-spinner fa-spin '></i></div></td>");
		$("#tbody").load("control/get_tabla_articulos.php", 
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
				
				$(".editar_fila").click(function(){
					boton= $(this);	//asignamos el buton presionado a una variable
					id_articulo=  boton.data("id_value"); //obtenemos el id del registro guardado en el atributo data
				
					loader = boton.find(".fa")
					boton.prop("disabled", true);
					loader.toggleClass("fa-pencil fa-spinner fa-spin");
					$("#form_nuevo_articulo").data("action", "update");
					console.log("update");
					$("#modal_nuevo_articulo").find(".modal-title").html("Editar Artículo" );
					$("#id_articulo").val(id_articulo);
						
					//Cargar Producto
					$.ajax({
						url: "control/get_row_json.php",
						data: {
							"table":  "productos",
							"id_field": "id_articulo",
							"id_value": id_articulo
							
						}
					 }).done(function(respuesta){
								$.each(respuesta.data, function(name, value){
									$("#" + name).val(value);
								});
					}).always(function(){
						boton.prop("disabled", false);
							loader.toggleClass("fa-pencil fa-spinner fa-spin");
					});
				
				//Cargar Precio
					$.ajax({
						url: "control/articulos_precios.php",
						data: {
							"id_articulo":  id_articulo
						}
					 }).done(function(respuesta){
								//loader.toggleClass("fa-pencil fa-spinner fa-spin");
								$("#articulos_precios").html(respuesta);
								
								$("#costo_compra").keyup( calcularPrecios);
								$("#costo_compra").change( calcularPrecios);
								
								$(".porc_ganancia").keyup( calcularPrecios);
								$(".porc_ganancia").change( calcularPrecios);
								$("#modal_nuevo_articulo").modal("show");
									$(".btn_toggle").click( toggleButton);
						});
				
						// $("#div_existencias").html("<i class='fa fa-spinner fa-spin fa-2x'></i>");
						
						// $("#div_existencias").load("control/get_existencia.php",
							// {"formato": "html" , "id_articulo": id_value}, 
							// function(respuesta){
							
							
						// });					
				});
				
				
				
			});
		
	}
	
	
	$(".insertar_fila").click(function(){
		console.log("insertar()");
		$nombre_tabla = $(this).data("nombre_tabla");
		
		$modal = $($(this).data("modal"));
		$modal.modal("show");
		$modal.find("form").data("action" , "insert");
		$modal.find("form")[0].reset();
		$modal.find(".modal-title").html("Agregar " + $nombre_tabla );
		console.log("Insertar");
		$("#action").val("insert");
	});
	
	$("#form_nuevo_articulo").submit(function(event){
		
		event.preventDefault();
		$form =  $(this);
		modal=  $(this).closest(".modal");
		action = $form.data("action");
		boton= $(this).find(":submit"); 
		icono = $(this).find(".fa-spin"); 
		
		icono.toggleClass("fa-save fa-spinner fa-spin"); 
		boton.prop("disabled" , true);
				
		
		$.ajax({
				"url" : "control/articulos_guardar.php",
				"method": "POST",
				"data": $form.serialize()
				})
				.done(function(response){
					
					alertify.success(response.mensaje);
					cargarTabla(filtros);
					modal.modal("hide");
				})
				.fail(ajaxError).always(function(){
						icono.toggleClass("fa-save fa-spinner fa-spin"); 
						boton.prop("disabled" , false);
					
				});
	});
	
	
	
});
