function confirmaCerrar(){
	alertify.confirm("Confirmar","La compra se marcará como CERRADA y podrá dar entrada al Almacén <br> -NO se generará ningun EGRESO", cerrarCompra, function(){} );
	
}

function cerrarCompra(){
$.ajax({
	"url": "cerrarCompra.php",
	"data": {
		"id_compra": $("#id_compra").val(),
		
	},
	"method": "POST"
	
}).done().fail(ajaxError);
}

function abreArticulos(){
					
	window.open("articulos.php?codigo_barras="+ $( "#codigo_articulo").val());
	
}

function creditoCompra(){
$.ajax({
	"url": "cerrarCompra.php",
	"data": {
		"id_compra": $("#id_compra").val(),
		
		
	},
	"method": "POST"
	
}).done().fail(ajaxError);
}

	$(window).on('beforeunload', function(){
			return '¿Estás seguro que deseas salir?';
	 });
	
$( document ).ready(function() {
	

	$("#btn_cerrar").click(confirmaCerrar);
	$("#btn_credito").click(creditoCompra);
	
	
	if($("#action").val() == "editar"){
		var tabla_nota = JSON.parse($("#tabla_detalle").val());
		var tabla_totales = JSON.parse($("#tabla_totales").val());
		
		console.log("Agregando Articulos");
		console.log(tabla_nota);
		console.log(tabla_totales);
		
		agregarArticulo({
					"tabla_nota" : tabla_nota, 
					"tabla_totales" : tabla_totales,
					"folio_compra" : $("#folio_compra").val()
				});
		//cargarAbonos();
		//getSaldo();
	}
	else{
		
		var tabla_nota = [];
		var tabla_totales = {
				"articulos": 0,
				"importe_total": 0,
				"porc_desc": 0,
				"subtotal": 0,
				"iva": 0,
				"saldo_restante": 0
			}
		getNuevoFolio();
	}

	var tipo_servicio ;
	var por_pagar = 0 ;
	var	suma_abonos = 0;
	/* console.log("----tabla_nota");
	console.log(tabla_nota);
	console.log("----tabla_totales");
	console.log(tabla_totales);
	 */
	
	

	

	function getNuevoFolio(){
		console.log("getNuevoFolio()");
		icono_carga =  $("#cargar_folio");
		icono_carga.toggleClass("hide");
		$.ajax({  
			url: "control/getNuevoFolio.php", 
			dataType: "json", 
			method: "GET", 
			"data": {"table" : "compras" }
		}).done(function( respuesta ) {
					if(respuesta.filas > 0){ 
						$("#id_compra").val(respuesta.data);
						
					}
					else{ // si no lo es mostramos mensaje de error
						
						alertify.error("Ocurrio un Error, vuelve a intentar" + "Error: " +respuesta.mensaje  );
						
					}
					icono_carga.toggleClass("hide"); //Volvemos a ocultar el icono de carga
				
					console.debug(  respuesta);	// Para depuracion mostramos la respuesta del servidor
			})
		.fail(ajaxError);
		
	}
	
	
	/* function cargarAbonos(){
		console.log("cargarAbonos()");
		$.ajax({
			"url": "control/get_abonos_compra.php",
			"data" : {"id_compra" : $("#id_compra").val()}
		}).done(function(respuesta){
				
				
			
			$("#modal_abonos").find(".modal-body").html(respuesta);
			lista_abonos = $("#modal_abonos").find("tbody tr");
			
			$(".btn_imprimir_abono").click(function(){
					console.log("imprimir_compra");
					imprimir_compra($(this).data("folio_compra"),"ABONO", $(this).data("id_abono"));
			});	
			
			$(".btn_borrar_abono").click(function(){
			
			});
			
			suma_abonos = 0;
			num_abonos = lista_abonos.length;
			console.log("num_abonosss " + lista_abonos.length);
			
			
			$.each(lista_abonos, function(index, fila_abono){
					abono = Number($(fila_abono).find("td")[1].innerHTML);
					suma_abonos = suma_abonos + abono;
				
			}); 
			$("#num_abonos").html(num_abonos);
			$("#suma_abonos").html(suma_abonos);
		
		}).fail(ajaxError);
	} */
	
	/* 
	function getSaldo(){
		$.ajax({
			"url": "control/get_row_json.php",
			"data": {
				"table" : "compras",
				"id_field" :"id_compra",
				"id_value" :$("#id_compra").val()
			}
		}).done(function(respuesta){
			if(respuesta.found){
				if(respuesta.data.restante > 0 ){
					por_pagar = respuesta.data.restante;
					$("#por_pagar").html(respuesta.data.restante);
					$("#saldo_restante").val(respuesta.data.restante);
					$("#saldo_anterior").val(respuesta.data.restante);
					$("#importe_abono").val(0);
					
				}
				else{
					$("#compra_detalle").find(".borrar_fila").hide();
					$(".desc").prop("readonly", true);
					$(".porc_desc").prop("readonly", true);
					$(".cantidad").prop("readonly", true);
					$(".panel_agregar_articulo").hide();
					$("#por_pagar").closest(".row").hide();
					$("#btn_agregar_abono").prop("disabled", true).hide();
				}
			}
			
		});
	} */
	
	$( "#codigo_articulo" ).keyup(function(event){
		console.log("presionaste");
		if(event.keyCode == 13){
			console.log("presionaste enter");
		
			$( "#codigo_articulo" ).attr("disabled", true);
			$( "#codigo_articulo" ).toggleClass("ui-autocomplete-loading");
			$.ajax({
				"url": "control/get_row_json.php",
				"method": "GET",
				"data": {
					
					"table" : "productos",
					"id_field" : "codigo_barras",
					"id_value" : $( "#codigo_articulo" ).val()
				}
				
			}).done(function(respuesta){
				if(respuesta["found"] == 1){
						
						$("#id_articulo").val(respuesta["data"]["id_articulo"]);
						$("#descr_articulo").val(respuesta["data"]["descripcion"]);
						$("#costo_unitario").val(respuesta["data"]["costo_compra"]);
						
						$( "#codigo_articulo" ).closest("form").submit();
				}
				else{
					alertify.confirm("Código No Encontrado", "¿Desea crear un nuevo articulo con el código?" + $( "#codigo_articulo").val(), abreArticulos());
					
				}
				
				$( "#codigo_articulo" ).attr("disabled", false);
				$( "#codigo_articulo" ).toggleClass("ui-autocomplete-loading");
			}).fail();
		}
	});
	
	
	$(".click_to_select").focus(function(event){
		$(this).select();
		//console.log("Select all text");
	});
	
	
	
	function getSum(total, num) {
			return total + num; 
	}
		
				
	
	function guardarCompra(){
		data = "id_usuario=" + $("#id_usuario").val() 
		+ "&turno=" + $("#turno").val()
		+ "&restante=" + $("#por_pagar").html() 
		+ "&" + $("#form_compra").serialize() 
		+ "&" + $("#form_compra_detalle").serialize() ;
		loader = $("#btn_guardar").find(".fa");
		loader.toggleClass("fa-floppy-o fa-spin fa-spinner");
		
		request = 	$.ajax({
			method: "POST",
			url: "control/compras_guardar.php",
			data: data			
		});
		
		return request;
		 
	}
	
	function doneguardarCompra(response, textStatus, xhr){
		console.log("--doneguardarCompra-");
		console.log(response);
		loader.toggleClass("fa-floppy-o fa-spin fa-spinner");
		if(response.estatus == "success"){
			alertify.success(response.mensaje);
			//reset forms
			//imprimir compra 
		}
		else{
			alertify.error(response.mensaje);
		}
	}
	
	function ajaxCall( url ,data, loader){
		
		//loader.toggleClass("fa-save fa-spin fa-spinner");
		
		request = 	$.ajax({
			method: "POST",
			"url": url,
			"data": data,		
			"loader": loader			
		});
		
		return request;
		 
	}
	
	
	function ajaxError(xhr, textStatus, error){
		alertify.error("Error" + error);
		console.error(xhr);
		console.error(textStatus);
		console.error(error);
	}
	
	
	$( ".fecha" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: 0
		//yearRange: '1920:2000'
	});
	
	 
	
	/* $( "#nombre_proveedor" ).autocomplete({
		source: "control/search_json.php?tabla=pacientes&campo=razon_social&valor=razon_social&etiqueta=razon_social",
		minLength : 2,
		select: function( event, ui ) {
			$("#id_cliente").val(ui.item.extras.id_paciente);
			$("#num_expediente").val(ui.item.extras.num_exp);
			console.log(ui.item.extras.id_paciente);
			
		}
	}); */
	
	
	$( "#descr_articulo" ).autocomplete({
		autoFocus: true,
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
				});
		},       
		minLength : 2,
		select: function( event, ui ) {
			console.log("ui");
			console.log(ui);
			
			if(ui.item.extras){
				
				$("#id_articulo").val(ui.item.extras.id_articulo);
				$("#costo_unitario").val(ui.item.extras.costo_compra);
				var importe_articulo = Number($("#costo_unitario").val()) * Number($("#cant_articulo").val())
				$("#importe_articulo").val(importe_articulo);
				id_articulo = $("#id_articulo").val();
				console.log("importe_articulo");
				console.log(importe_articulo);
				
				$(this).val(ui.item.value);
				//$(this).closest("form").find("[type='submit']").click();
				$(this).closest("form").submit();
				
				
			}
		}
			
	});
	

	$("#btn_guardar").click(function(event){
		$("#submit_compra").click();
	});
	$("#btn_liquidar").click(function(){
		
		$("#monto_pago").val($("#por_pagar").html());
		$("#efectivo").val($("#por_pagar").html());
		$("#obs_liquidar").val("Abono de Liquidación");
		sumarPagos();
	});
	
	$("#btn_abonar").click(function(event){
		
		$("#saldo_anterior").val($("#por_pagar").html());
		$("#importe_abono").val(0);
		$("#saldo_restante").val($("#por_pagar").html());
	
	});
	
	//$("#ver_abonos").click(cargarAbonos);
	//$("#btn_abonar").click(cargarAbonos);
	//$("#btn_liquidar").click(cargarAbonos);
	
	

	
	
	
	$('#form_agregar_articulo').submit( function submitArticulo(event){
		event.preventDefault();
		if($("#cant_articulo").val() == ""){
			alertify.error("Ingresa una Cantidad");
			$("#cant_articulo").focus();
			return false;
		}
		var importe_articulo = Number($("#costo_unitario").val()) * Number($("#cant_articulo").val());
		console.log("importe_articulo");
		console.log(importe_articulo);
		$("#importe_articulo").val(importe_articulo.toFixed(2));
		
		fila = 
		{
			"id_articulo" : $("#id_articulo").val(),
			"descripcion" : $("#descr_articulo").val(), 
			"cantidad" : $("#cant_articulo").val(), 
			"costo_unitario" :$("#costo_unitario").val(), 
			"importe" : $("#importe_articulo").val(),
		}
		
		tabla_nota.push(fila);
		
		
		
		loader = $(this).find(".fa-spin");
		
		agregarArticulo({
					"tabla_nota" : tabla_nota, 
					"tabla_totales" : tabla_totales,
					"folio_compra" : $("#folio_compra").val()
				});
				
	});
	
		
	function sumarImportes(){
		if(tabla_totales.importe_total > 0 ){
			console.log("Ya existe importe no volver a calcular");
			return false;
		}
		console.log("sumarImportes()");
		importes = [];
		importe_total = 0;
		articulos = 0;
		$.each(tabla_nota, function(index, element){
			importes.push(Number(element.importe));
			importe_total = importes.reduce(getSum);
			articulos = importes.length ;
		
		});
		
		por_pagar = importe_total - suma_abonos;
		
		tabla_totales = {
			"articulos" : articulos,
			"subtotal" : importe_total,
			"iva" : 0,
			"porc_desc" : 0,
			"importe_total" : importe_total,
			"saldo_restante" : importe_total
			
		}
		
		console.log("Sumando Importes");
		console.log("tabla_nota");
		console.log(tabla_nota);
		console.log("tabla_totales");
		console.log(tabla_totales);
		
	}
	
		
	function agregarArticulo(data){
		console.log("agregarArticulo()");
		sumarImportes();
		$("#compras_detalle").html("<div class='text-center'><i class='fa fa-spinner fa-2x fa-spin'></i></div>");
		$.post("control/get_compras_detalle.php", data, function imprimeTablaDetalle(response){
			$("#compras_detalle").html(response);
			$(".botonera .btn ").filter(":button").prop("disabled",  false);
					
			function imprimeTotales(){
				importe_total = Number(tabla_totales.importe_total);
				$("#costo_servicio").val(Number(importe_total));
				$("#monto_pago").val(Number(importe_total.toFixed(2)));
				$("#restante").val(Number(importe_total.toFixed(2)));
				$("#total").val(Number(importe_total.toFixed(2)));
				$("#celda_articulos").html(tabla_totales.articulos);
				$("#total_articulos").val(tabla_totales.articulos);
				$("#celda_total").html(Number(importe_total.toFixed(2)));
				$("#celda_subtotal").html(Number(importe_total.toFixed(2)));
				$("#por_pagar").html(Number(importe_total.toFixed(2)));
			}
			imprimeTotales();
			//console.log("ajax articulo done");
	
			$(".cantidad").focus(function(event){
				$(this).select();
				console.log("Select all text");
			});
			
			$(".cantidad").keyup( function calcularImporte(){
				console.log("calcularImporte()");
				index = $(".cantidad").index(this);
				
				var cantidad = $(this).val();
			
				costo_unitario = Number($(this).closest("tr").find(".costo_unitario").val());
				descuento = $(this).closest("tr").find(".desc").val();
				importe = (costo_unitario * cantidad) 
				celda_importe = $(this).closest("tr").find(".celda_importe");
				celda_importe.html(importe.toFixed(2));
				
				tabla_nota[index].cantidad = cantidad; 
				tabla_nota[index].importe_articulo = importe.toFixed(2); 
				
				sumarImportes();
				imprimeTotales();
			});
			$(".porc_desc").keyup(function(){
				index = $(".porc_desc").index(this);
				
				var porc_desc = $(this).val();
				var cantidad = $(this).closest("tr").find(".cantidad").val();
				pvp = $(this).closest("td").prev().html();
				descuento = pvp * porc_desc /100;
				//imprime el descuento
				$(this).closest("tr").find(".desc").val(descuento);
				importe = (pvp * cantidad) - descuento;
				celda_importe = $(this).closest("tr").find(".celda_importe");
				celda_importe.html(importe);
				
				tabla_nota[index].importe_articulo = importe; 
				tabla_nota[index].porc_desc = porc_desc; 
				tabla_nota[index].desc_articulo = descuento; 
				
				
				sumarImportes();
				imprimeTotales();
			});
			
			$(".desc").keyup(function(){
				index = $(".desc").index(this);
				
				var descuento  = Number($(this).val());
				var pvp = Number($(this).closest("td").prev().prev().html());
				var porc_desc =  descuento * 100 / pvp;
				var cantidad = Number($(this).closest("tr").find(".cantidad").val());
				
				console.log("Descuento");
				console.log(porc_desc);
				console.log("PVP");
				console.log(pvp);
				console.log("Cantidad");
				console.log(cantidad);
				//imprime el Porc Desc
				$(this).closest("tr").find(".porc_desc").val(porc_desc);
				importe = (pvp * cantidad) - descuento;
				celda_importe = $(this).closest("tr").find(".celda_importe");
				celda_importe.html(importe);
				
				tabla_nota[index].importe_articulo = importe; 
				tabla_nota[index].porc_desc = porc_desc; 
				tabla_nota[index].desc_articulo = descuento; 
				
				
				sumarImportes();
				imprimeTotales();
			});
			
			
			$(".borrar_fila").click(function(){
				var index = $('.borrar_fila').index(this);
				tabla_nota.splice(index, 1);
				
				boton= $(this);
				var precio = Number(boton.closest("td").prev().html());
				fila = boton.closest("tr")
				
				alertify.confirm("¿Está seguro que desea borrar este artículo?", borrarFila).setHeader("Confirmar Borrado");
				
				function borrarFila(){
					fila.fadeOut(50,  function(){
						fila.remove();
						sumarImportes();
						imprimeTotales();
						
					});
					
				}
			});
			
			$("#form_agregar_articulo")[0].reset();
			sumarImportes();
				$("#cant_articulo").focus();
		});
	}
	
	
	$("#form_compra").submit(function submitcompra(event){
		event.preventDefault();
		data = "id_usuario=" + $("#id_usuario").val() + "&" +  /* + "turno=" + $("#turno").val() + "&restante=" + $("#restante").val() + "&" */  $("#form_compra").serialize() + "&" + $("#form_compra_detalle").serialize() ;
		loader = $("#btn_guardar").find(".fa");
		loader.toggleClass("fa-floppy-o fa-spin fa-spinner");
		$("#btn_guardar").prop("disabled", true);
		
		
		$.ajax({
				method: "POST",
				url: "control/compras_guardar.php",
				data: data
			}).done( function(response){
				if(response.estatus_compra == "success"){
					alertify.success(response.mensaje_compra);
					
				}
				else{
					
					alertify.error(response.mensaje_compra);
				}
				loader.toggleClass("fa-floppy-o fa-spin fa-spinner");
			}).fail(ajaxError).always(function(){
				
				$("#btn_guardar").prop("disabled", false);
			});
			
	});
	
	
	
	$("#importe_abono").keyup(calcularRestante);
	
	function calcularRestante(event){
		console.log("Calculando Restante");
		importe_abono = Number($("#importe_abono").val());
		saldo_anterior = Number($("#saldo_anterior").val());
		saldo_restante = saldo_anterior - importe_abono;
		$("#saldo_restante").val(saldo_restante);
	}
	
	$("#efectivo").keyup(function(event){
		efectivo = Number($(this).val());
		monto_pago = Number($("#monto_pago").val());
		
		debito = monto_pago - efectivo ;
		$("#debito").val(debito);
		
		sumarPagos();
	});
	
	$(".forma_pago").keyup(function(event){
		
		sumarPagos();
	});
	
	
	
	
	function sumarPagos(){
		importe_total = $("#monto_pago").val();
		importe_pagado = 0;
		$(".forma_pago").each(function(index, element){
			importe_pagado = importe_pagado + Number($(element).val());
			
		});
		restante = importe_total - importe_pagado;
		if(restante < 0){
			alertify.error("El saldo no puede set negativo");
			
			$("#restante").val(restante);
		}
		else{
			$("#restante").val(restante);
		}
		
		
	}
	 
	
	$("#form_abonar").submit(submitAbono);	
	
	function submitAbono(event){
		var btn_submit = $("#form_abonar").find("button[type='submit']");
		btn_submit.prop("disabled", true);
		event.preventDefault();
		icono_carga = $("#form_abonar").find(".fa-spinner");
		icono_carga.toggleClass("hide");
		 
		url = "control/compras_abonar.php";
		post_data = $("#form_abonar").serialize() + "&" + "id_usuario=" + $("#id_usuario").val()+ "&" + "folio_compra=" + $("#folio_compra").val()  + "&" + "turno=" + $("#turno").val();
		
		datos_compra = $("#form_compra").serialize() + "&" + "id_usuario=" + $("#id_usuario").val()+ "&" + "folio_compra=" + $("#folio_compra").val()  + "&" + "turno=" + $("#turno").val();
		url_compra = "control/compras_liquidar.php";
		
		$.when(guardarCompra()).then(function(respuesta){
			ajaxCall(url, post_data)
				.done(function(respuesta){
					if(respuesta.estatus_general == "success"){
						alertify.success(respuesta.mensaje_general);
						imprimir_compra($("#folio_compra").val(), "ABONO", respuesta.id_abono);
						//window.location.replace("compras_imprimir.php?tipo_pago=ABONO&folio_compra="+ $("#folio_compra").val() + "&id_abono="+ respuesta.id_abono);
												
					}
					else{
						alertify.error(respuesta.mensaje_general);
					}
					icono_carga.toggleClass("hide"); 
					btn_submit.prop("disabled", false);
					$("#modal_nuevo_abono").modal("hide");
					//cargarAbonos();
					
				}).fail(ajaxError);
		});
	}
	
	$("#btn_liquidar").click(function(){
		
		$("#efectivo").val($("#por_pagar").html());
		$("#obs_liquidar").val("Abono de Liquidación");
	});
	
	
	$("#form_liquidar").submit(function submitLiquidar(event){
		event.preventDefault();
		icono_carga = $(this).find(".fa-spinner");
		icono_carga.toggleClass("hide");
	
		datos_pago = $("#form_liquidar").serialize() + "&" + "id_usuario=" + $("#id_usuario").val()+ "&" + "id_compra=" + $("#id_compra").val()  + "&" + "turno=" + $("#turno").val();;
		url_pago = "control/compras_liquidar.php";
		
		$.when(guardarCompra()).then(function(respuesta){
			ajaxCall(url_pago, datos_pago)
				.done(function(respuesta){
					if(respuesta.estatus == "success"){
						alertify.success(respuesta.mensaje);
						imprimir_compra($("#folio_compra").val(), "LIQUIDACION");
					}
					else{
						alertify.error(respuesta.mensaje);
					}
					icono_carga.toggleClass("hide");
					
				}).fail(ajaxError);
			
		});	
	});
	
	
		var beforePrint = function() {
        console.log('Functionality to run before printing.');
    };
    var afterPrint = function() {
        console.log('Functionality to run after printing');
				$("#modal_liquidar").modal("hide");
				$(".modal").modal("hide");
				$("#btn_nueva").click();
				window.location.reload(true);
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;
	
}); 


function imprimir_compra(folio_compra, tipo_pago, id_abono){
	
	$.ajax({
		"url" : "control/get_ticket.php",
		"method" : "GET",
		"data" : {"folio_compra" : folio_compra, "tipo_pago" : tipo_pago, "id_abono" : id_abono }
		 
	}).done(function(respuesta){
		$("#ticket").html(respuesta);
		window.print();
	}).fail(ajaxError);
		
}
