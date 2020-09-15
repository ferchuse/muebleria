function buscarTarjeta(){
	console.log("buscarTarjeta()");
	$("#txt_tarjeta").toggleClass("cargando");
	$.ajax({
		url: "funciones/fila_select.php",
		data:{
			tabla: "ventas",
			id_campo: "tarjeta",
			id_valor: $("#txt_tarjeta").val()
		}
		
		}).done(function(respuesta){
		
		if(respuesta.encontrado == 1){
			$("#txt_nombre_cliente").val(respuesta.data.nombre_cliente)
			$("#direccion").val(respuesta.data.direccion)
			$("#referencias").val(respuesta.data.referencias)
			$("#entre_calles").val(respuesta.data.entre_calles)
			$("#telefono").val(respuesta.data.telefono)
			$("#dia_cobranza").val(respuesta.data.dia_cobranza);
			$("#cobrador").val(respuesta.data.cobrador);
			// $("#cobrador").val(respuesta.data.cobrador);
			$("#clave_vendedor").val(respuesta.data.clave_vendedor);
			$("#sector").val(respuesta.data.sector);
		}
		else{
			$("#txt_nombre_cliente").val("")
			$("#direccion").val("")
			$("#referencias").val("")
			$("#entre_calles").val("")
			$("#telefono").val("");
			$("#cobrador").val(respuesta.data.cobrador);
			$("#clave_vendedor").val(respuesta.data.clave_vendedor);
			$("#sector").val(respuesta.data.sector);
			$("#dia_cobranza").val(respuesta.data.dia_cobranza);
		}
		$("#txt_tarjeta").toggleClass("cargando");
	});
	
}

$( document ).ready(function() {
	
	buscarTarjeta();
	
	$("#txt_tarjeta").blur(function(event){
		
		
		buscarTarjeta();
		
	});
	$("#fecha_venta").val(Date.today().toString("dd/MM/yyyy"));
	
	$("#enganche").keyup(function(e){
		var enganche = Number($(this).val());
		var importe_total = Number($("#importe_total").val());
		var saldo_actual = importe_total -enganche;
		$("#saldo_actual").val(saldo_actual);
		
	});
	$("#cantidad_abono").keyup(function(e){
		var cantidad_abono = Number($(this).val());
		var saldo_actual = Number($("#saldo_actual").val());
		var num_semanas = Math.round(saldo_actual / cantidad_abono);
		$("#num_semanas").val(num_semanas);
		
		$("#fecha_vencimiento").val(Date.today().add(num_semanas * 7).days().toString("dd/MM/yyyy"));
		
	});
	
	$( "#txt_nombre_cliente" ).autocomplete({
		source: "search_json.php?tabla=ventas&campo=nombre_cliente&valor=nombre_cliente&etiqueta=nombre_cliente",
		minLength : 2,
		select: function( event, ui ) {
			console.log("item",ui.item ); 
			$( "#txt_tarjeta" ).val(ui.item.extras.tarjeta);
			$( "#direccion" ).val(ui.item.extras.direccion);
			$( "#referencias" ).val(ui.item.extras.referencias);
			$( "#entre_calles" ).val(ui.item.extras.entre_calles);
			$( "#telefono" ).val(ui.item.extras.telefono);
			$( "#cobrador" ).val(ui.item.extras.cobrador);
			$( "#sector" ).val(ui.item.extras.sector);
			$( "#dia_cobranza" ).val(ui.item.extras.dia_cobranza);
			$( "#clave_vendedor" ).val(ui.item.extras.clave_vendedor);
			$( "#articulo" ).focus();
		}
	});
	
	
	$( "#articulo" ).autocomplete({
		source: "productos/autocomplete_producto.php?tabla=productos&campo=descripcion&valor=descripcion&etiqueta=descripcion",
		minLength : 2,
		select: function( event, ui ) {
			console.log("item",ui.item ); 
			// $( "#txt_tarjeta" ).val(ui.item.extras.tarjeta);
			// $( "#direccion" ).val(ui.item.extras.direccion);
			// $( "#referencias" ).val(ui.item.extras.referencias);
			// $( "#entre_calles" ).val(ui.item.extras.entre_calles);
			// $( "#telefono" ).val(ui.item.extras.telefono);
			// $( "#cobrador" ).val(ui.item.extras.cobrador);
			// $( "#sector" ).val(ui.item.extras.sector);
			// $( "#dia_cobranza" ).val(ui.item.extras.dia_cobranza);
			// $( "#clave_vendedor" ).val(ui.item.extras.clave_vendedor);
			// $( "#articulo" ).focus();
			let precios = ``;
			
			$.each(ui.item.precios, function(index, producto){
				precios+=`<option data-precio="${producto.precio}">
				${producto.nombre_precio} ${producto.precio}
				</option>`
				
				
			});
			
			$("#tipo_precios").html(precios);
		}
	});
	
	$("#tipo_precios").change(function(){
		
		$("#importe_total").val($(this).find("option:selected").data("precio"))
	})
	
	$("#txt_folio_venta").focus();
	
	//Selecciona todo el texto al recibir el evento focus 
	$("input:text").focus(function() { $(this).select(); } );
	
	//Guarda el formulario
	$('#frm_nueva_venta').submit( function guardarVenta(event){
		event.preventDefault();
		$('#btn_guardar').prop("disabled", true);
		
		$.post("guardar_venta.php", $( "#frm_nueva_venta" ).serialize(),   function(respuesta, status){
			
			if(respuesta.estatus == "success"){
				alertify.success(respuesta.mensaje);
				$('#btn_guardar').prop("disabled", false);
				$('#btn_imprimir').click();
				Popup();
				// window.location.href="nueva_venta.php";
				// $("input[type=text]").val("");
				$('#txt_folio_venta').focus();
				
				// getFolio()
			}
			else{
				alertify.error(respuesta.mensaje);
				
			}
			}).fail(function(xhr, error){
			alertify.error(error);
			
		});
		
	}); 
	
	
	function getFolio() {
		
		// $.ajax("")
	}
	function Popup(data){
		console.log("Popup");
		var tarjeta = $("#txt_tarjeta").val();
		window.open('imprimir_tarjeta.php?tarjeta='+tarjeta+"&id_ventas="+ $("#id_ventas").val(), 'Imprimir Tarjeta', 'height=600,width=700');
		return true;
	}
	
	$( "#txt_fecha_venta" ).datepicker({
		changeMonth: true,
		changeYear: true,
		
	});
	$( "#fecha_vencimiento" ).datepicker({
		changeMonth: true,
		changeYear: true,
		
	});
	
	
	$( "#btn_imprimir" ).click(function(){
		Popup("Tarjeta");
	});
	
	
	//evita el envio del formulario al presionar enter
	$('#frm_nueva_venta').keypress(function(event){   
		//event.preventDefault();
		
		if(event.which == 13){
			$('#btn_guardar').click();
			return false;
		} 
		
	});
}); 