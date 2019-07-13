

$( document ).ready(function() {
	console.log("ready");
	$( "#articulo").autocomplete({
			autoFocus: false,
			source: function( request, response) {
				
				$.ajax({
							url: "control/search_json.php",
							dataType: "json",
							data: {
								term: request.term,
								tabla: "productos",
								campo: "descripcion",
								valor: "descripcion",
								etiqueta: "descripcion",
								limit: 5
								//extra_labels: ['nombre_productos']
							},
							success: function( data ) {
										response( data );
										
							},
							error: function( data, status , errno) {
								alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " + errno );
								console.log(errno);
									console.log(data);
									console.log(status);
							}
					}).always(function(){

					});
			},
			minLength : 2,
			select: function( event, ui ) {
				console.log("x Y");
				console.log($("#btn_guardar").css("left"));
				console.log($("#btn_guardar").css("top"));
				console.log($("#btn_guardar").css("width"));
				console.log($("#btn_guardar").position());
				if(ui.item.extras){

					// console.log(ui.item.extras);
					var producto_elegido = ui.item.extras;
					$('#importe_total').val(ui.item.extras.credito);
					$('#saldo_actual').val(ui.item.extras.credito);
					var id_articulo = ui.item.extras.id_articulo;
					
				
					$.ajax({
						url: 'control/cargar_precios.php',
						method: 'GET',
						dataType: 'HTML',
						data: {"id_articulo" : id_articulo}
					}).done(function(respuesta){
						$('#precios').html(respuesta);
						
						$('.btn-radio').click(function(){
							console.log("eligePrecio");
							$('.btn-radio').each(function(index, item){
								$(item).addClass("btn-default");
								$(item).removeClass("btn-success");
								
								$(item).find(".fa").removeClass("fa-check"); 
								$(item).find(".fa").addClass("fa-circle-o");
							});
							 
							$(this).addClass("btn-success");
							$(this).find(".fa").removeClass("fa-circle-o");
							$(this).find(".fa").addClass(" fa-check-circle");
							
							var precio = Number($(this).data("precio"));
							var abono = 0;
							if(precio <= 1000){
								
									abono = 50;
							}else{
								if(precio > 1000 && precio <= 1500 ){
									abono = 60;
								}else{
									if(precio > 1500 && precio <= 2000 ){
										abono = 70;
									}else{
										if(precio > 2000 && precio <= 2500 ){
											abono = 80;
										}else{
											if(precio > 2500 && precio <= 3500 ){
												abono = 90;
											}else{
												if(precio > 3500 && precio <= 5000 ){
													abono = 100;
												}else{
													abono = Math.round(precio / 52);
												}
											}
										}
									}
								}
							}
							
							
							$("#importe_total").val($(this).data("precio"));
							$("#cantidad_pagos").val(Math.round(precio / abono));
							$("#cantidad_abono").val(abono);
							var num_dias = $("#cantidad_pagos").val() * 7;
							$("#fecha_vencimiento").val(Date.today().add(num_dias).days().toString("yyyy-MM-dd"));
							$("#num_dias").val(num_dias);
							
						});
				
						$('#forma_pago').change(function(){
							num_pagos = $("#num_dias").val() / $(this).val();
							$("#cantidad_pagos").val(num_pagos.toFixed());
							$("#cantidad_abono").val(($("#importe_total").val() / num_pagos ).toFixed(0));
							
						});
						
						
						$('#tipo_pago').change(function(){
							var option = $('#tipo_pago option:selected');
							var datos = option.val();
							var semanas = option.data('semanas');
							var cantidad = option.data('cantidad');
							console.log(semanas);

							var cantidad_abono = Math.round(Number(cantidad/semanas));
							$('#cantidad_abono').val(cantidad_abono.toFixed(2));
							$('#importe_total').val(cantidad);
							$('#saldo_actual').val(cantidad);

							$("#fecha_vencimiento").val(Date.today().add(semanas * 7).days().toString("dd/MM/yyyy"));
						});
					});


				}else{
					console.log("No hay extras");
				}

			}
		});

	
	
	$( "#form_insert" ).submit( function submitForm(event){ // Cuando enviamos el formulario

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
			}).done( function ( respuesta ) { 
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
});
		

	


