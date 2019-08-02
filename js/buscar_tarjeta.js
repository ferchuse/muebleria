$(document).ready(onLoad);

function onLoad(){
	
	$("#btn_aviso").click(function(e){
		var $tarjeta= $("#tarjeta").val();
		var $pagos_atrasados= $("#pagos_atrasados").val();
		var $intereses= $("#intereses").val();
		var $pagos_vencidos= $("#pagos_vencidos").val();
		window.open(`imprimir_aviso.php?tarjeta=${$tarjeta}&pagos_atrasados=${$pagos_atrasados}&intereses=${$intereses}&pagos_vencidos=${$pagos_vencidos}`, '_blank')
	});
	
	
	$("#enganche").keyup(function(e){
		var enganche = Number($(this).val());
		var importe = Number($("#importe").val());
		var saldo_actual = importe -enganche;
		$("#saldo_actual").val(saldo_actual);
		
	});
	
	$(".editar_venta").click( function cargarRegistro(e){
		var id_registro = $(this).data("id_registro");
		
		$.ajax({
			"url": "funciones/fila_select.php",
			
			"dataType": "JSON",
			"data": {
				"tabla": "ventas",
				"id_campo": "id_ventas",
				"id_valor": id_registro
				
			}
			
			
			}).done(function(respuesta){
			console.log(respuesta.data)
			$.each(respuesta.data, function(name, value){
				if(name != "No."){
					console.log("name", name);
					console.log("value", value);
					$("#"+ name).val(value);
				}
			});
			
		});
		
		$("#modal_venta").modal("show");
		
	});
	
	
	$("#form_venta").submit( function guardarRegistro(event){
		event.preventDefault();
		
		var boton = $(this).find(":submit");
		var icono = boton.find(".fa");
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-save fa-spinner fa-spin");
		
		$.ajax({
			url: "funciones/fila_update.php",
			"method": "POST",
			"data":
			{
				tabla: "ventas",
				id_campo: "id_ventas",
				id_valor: $("#id_ventas").val(),
				valores: $("#form_venta").serializeArray()					
			}
			}).done(function(respuesta){
			
			
			window.location.reload();
			
			}).always(function (respuesta){
			
			boton.prop("disabled", false);
			icono.toggleClass("fa-save fa-spinner fa-spin");
			alertify.success(respuesta.mensaje);
		});
		
		
		$("#modal_venta").modal("hide");
		
	});
	$("#btn_cargo").click(function(){
		// $("#btn_cargo").html("");
		$("#modal_cargo").modal("show");
		
	});
	$("#form_cargos").submit(function(event){
		// $("#btn_cargo").html("");
		event.preventDefault();
		btn = $(this).find(":submit");
		
		btn.prop("disabled", true);
		
		$.ajax({
			url: "control/guardar_cargos.php",
			"method": "POST",
			"data":
			$("#form_cargos").serialize()					
			}).done(function(respuesta){
			
			btn.prop("disabled", false);
			alertify.success(respuesta.mensaje);
			$("#modal_cargo").modal("hide");
			window.location.reload();
			
		});
		
	});
	
	$( "#producto_cargos" ).autocomplete({
		source: "search_json.php?tabla=productos&campo=descripcion&valor=descripcion&etiqueta=descripcion",
		minLength : 2,
		select: function( event, ui ) {
			console.log("item",ui.item );
			
			$( "#importe_cargos" ).val(ui.item.extras.direccion);
		}
	});
	
	$("#btn_ticket").click(function(){
		$("#estado_cuenta").html("");
		$.ajax({ 
			url: "imprimir_contado.php",
			data:{
				tarjeta : $("#tarjeta").val()
			}
			}).done(function(respuesta){
			$("#ticket").html(respuesta);
			window.print();
			
		})
		
		
	});
	
	$("#btn_venta").click(function(){
		console.log("nueva_venta");
		window.location.href="nueva_venta.php?tarjeta="+ $("#tarjeta").val();
		
	});
	
	$("#btn_estado_de_cuenta").click(function(){
		$("#ticket").html("");
		$.ajax({
			url: "imprimir_estado_cuenta.php",
			data:{
				tarjeta : $("#tarjeta").val()
			}
			}).done(function(respuesta){
			$("#estado_cuenta").html(respuesta);
			window.print();
			
		})
		
	});
	
}



$( document ).ready(function() {
	
	$("#txt_folio_venta").focus();
	
	//Selecciona todo el texto al recibir el evento focus 
	$("input:text").focus(function() { $(this).select(); } );
	
	function cargarSaldoActual(){
		console.log("cargarSaldoActual()");
		$.get("get_saldo_actual.php",  { "tarjeta":$("#tarjeta").val()  } , function(respuesta, status){
			
			if(status =="success"){
				console.log(respuesta);
				if(respuesta["existe"]){
					
					$("#saldo_actual").val(respuesta.datos_tarjeta.saldo_actual);	
					
					
					cargarTablaAbonos();
					
				}
				else{
					alertify.error("Tarjeta No Encontrada");
				}
				
			}
		});	
	}
	
	cargarSaldoActual();
	function cargarIncidencias(){
		
	}
	
	$('.asignar_coord').click(function(event){
		boton = $(this);
		boton.prop("disabled", true);
		boton.find(".fa").toggleClass("fa-map-marker fa-spinner fa-spin");
		$.ajax({
			"url":"control/rows_name_update.php",
			"method": "POST",
			"data": {
				"table": "ventas",
				"id_field": "tarjeta",
				"id_value": boton.data("tarjeta"),
				"fields_value" :[{
					"name": "coordenadas",
					"value": boton.data("coordenadas")
				}]
			}
		})
		.done(function(respuesta){
			if(respuesta.estatus == "success"){
				alertify.success(respuesta.mensaje);
			}
			else{
				alertify.error(respuesta.mensaje);
			}
			
			console.log(respuesta);
			boton.find(".fa").toggleClass("fa-map-marker fa-spinner fa-spin");
			boton.prop("disabled", false);
		})
		.fail(function(xhr, error, errcode){
			alertify.error(error);
			console.error(error);
			boton.find(".fa").toggleClass("fa-map-marker fa-spinner fa-spin");
			boton.prop("disabled", false);
		}); 
	}); 
	
	//Guarda el formulario
	$('#btn_guardar').click(function(event){
		//alert("Guardadno");
		event.preventDefault();
		
		if (validar("frm_nueva_venta")){
			$.post("update_cliente.php", $( "#frm_nueva_venta" ).serialize(),   function(data_return, status){
				//alert(data_return);
				
				//regresa todos los valores a 0
				if(status =="success"){
					alertify.success(data_return);
					window.location.reload();
					//$('#div_mensaje').html(data_return);
					//$("input[type=text]").val("");
					$('#folio_venta').focus();
				}
			});
		}
	}); 
	
	$('#btn_imprimir_id').click(function(event){
		var url = "imprimir_tarjeta.php?tarjeta="+ $("#tarjeta").val();
		window.open(url, "Imprimir Tarjeta", 'height=700,width=800');
	}); 
	
	
	$('#form_devolucion').submit( function submitDevolucion(event){
		
		event.preventDefault();
		var abono = $("#saldo_actual").val();
		$btn = $("#submit_devolucion");
		$btn.prop("disabled", true);
		$icono = $btn.find(".fa");
		$icono.toggleClass("fa-save fa-spinner fa-spin");
		
		$.get("devolucion.php",
			"tarjeta=" + $("#tarjeta").val() +"&motivo=" + $("#motivo").val() +"&abono=" + $("#abono").val() +"&tipo_abono='Devolución'"+"&saldo_anterior=" + $("#saldo_actual").val()+"&saldo_restante=0"  ,  
			
			function(data_return, status){
				
				if(status =="success"){
					$btn.prop("disabled", false);
					alertify.success(data_return);
					$icono.toggleClass("fa-save fa-spinner fa-spin");
					$("#modal_devolucion").modal("hide");
				}
			});
			
	}); 
	
	$('#form_incidencia').submit( function submitIncidencia(event){
		
		event.preventDefault();
		
		$btn = $("#submit_incidencia");
		$btn.prop("disabled", true);
		$icono = $btn.find(".fa");
		$icono.toggleClass("fa-save fa-spinner fa-spin");
		
		$.ajax({ 
			"url" : "guardar_incidencia.php",
			"method": "POST",
			"data": {
				"tarjeta":  $("#tarjeta").val(),
				"comentario":  $("#comentario_inc").val(),
				"cobrador":  $("#cobrador").val()
				
			}
			}).done(function(respuesta, status){
			
			if(respuesta.estatus =="success"){
				$btn.prop("disabled", false);
				alertify.success(respuesta.mensaje);
				$icono.toggleClass("fa-save fa-spinner fa-spin");
				$("#modal_incidencia").modal("hide");
				window.location.reload();
			}
			}).fail(function(xhr, error, errno){
			
		});
		
	}); 
	
	$('#btn_descuento').click(function(event){
		var form_descuento = "Motivo <input type='text'  name='motivo' id='motivo'  />Abono<input type='text' name='abono' id='abono'  class='no_imprimir' />";
		
		alertify.prompt().set("onok", guardar_dev).setHeader("Motivos del Descuento").setContent(form_descuento).show();
		
		//if (validar("frm_devolucion")){
		function guardar_dev(){
			var saldo_restante = Number($("#saldo_actual").val()) - Number($("#abono").val());
			$.get("devolucion.php",
				"tarjeta=" + $("#tarjeta").val() +"&motivo=" + $("#motivo").val() +"&abono=" + $("#abono").val() +"&tipo_abono='Descuento'"+"&saldo_anterior=" + $("#saldo_actual").val()+"&saldo_restante="+ saldo_restante  ,  
				
				function(data_return, status){
					
					if(status =="success"){
						alertify.success(data_return);
					}
				});
				
		}
	}); 
	
	
	$(function() {
		$( "#txt_fecha_venta" ).datepicker({
			changeMonth: true,
			changeYear: true,
			//yearRange: '1920:2000'
		});
		$( "#txt_fecha_vencimiento" ).datepicker({
			changeMonth: true,
			changeYear: true,
			//yearRange: '1920:2000'
		});
		$( "#fecha_abono" ).datepicker({
			changeMonth: true,
			changeYear: true,
			//yearRange: '1920:2000'
		});
	});
	
	
	//evita el envio del formulario al presionar enter
	$('#frm_nueva_venta').keypress(function(event){   
		//event.preventDefault();
		
		if(event.which == 13){
			$('#btn_guardar').click();
		  return false;
		} 
		
	});
	
	
	$( ".borrar_inc").click(function(event) {
		if (confirm('¿Esta seguro que desea eliminar?')){
			boton= $(this);
			$.get('borrar.php', {
				"tarjeta": boton.data("tarjeta"),
				"id": boton.attr("id")}, function(data){	
				//alert(data);
				boton.closest("tr").fadeOut();
			});
		}
		else{
			return false;
		}
		return false; 
	});		
	
	$( "#abono_abono" ).keyup(function() {
		var saldo_anterior = $( "#saldo_anterior_abono" ).val();
		var abono = $( "#abono_abono" ).val();
		$( "#saldo_restante_abono" ).val(parseInt(saldo_anterior) - abono);
	});
	
	
	function cargarTablaAbonos(){
		$( "#tabla_abonos").load("get_tabla_abonos.php", "tarjeta=" + $("#tarjeta").val()+"&saldo_inicial="+$("#saldo_inicial").val() , 
			function(response, status) {
				
				$( ".borrar").click(function(event) {
					if (confirm('¿Esta seguro que desea eliminar?')){
						boton= $(this);
						$.get('borrar.php', {
							id: boton.attr("id")
							}, function(data){	
							//alert(data);
							boton.closest("tr").fadeOut();
							// window.location.reload();
						});
					}
					else{
						return false;
					}
					return false; 
				});
				
				$( ".editar_abono").click(function(event) {
					id_abono = $(this).data("id_abono");
					cargarAbono(id_abono);
					
					
				});
			}); 
			
	}
	
	$( "#update_abono").click(function(event) {
		$( "#load_update_abono").toggleClass("hide");
		$.post("update_abono.php" , $("#form_editar_abono").serialize(),
			function(response, status){
				response= JSON.parse(response);
				alertify.success(response.mensaje_saldo);
				$( "#saldo_actual").val(response.saldo_actual);
				$( "#load_update_abono").toggleClass("hide");
				console.log(response);
				cargarTablaAbonos();
				$( "#modal_editar_abono").modal("hide");
			});
	}); 
	
	
	
	function cargarAbono(id_abono){
		console.log("Cargando abono" +id_abono);
		$.get("get_abono.php", 
			{"id_abono" : id_abono}, 
			function(response,status){
				if(status == "success"){
					$response = JSON.parse(response);
					$.each($response.data , function(key , value){
						
						//console.log("key" + key + "value"+  value);
						
						$("#"+ key + "_abono").val(value);
					});
					$( "#modal_editar_abono").modal("show");
				}
			});
	}
}); 