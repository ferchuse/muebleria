
$( document ).ready(function() {
	
		
	function syncVentas(){
		btn_sync = $("#btn_sync");
		btn_sync.prop("disabled", true);
		//btn_sync.html("Espere...");
		icono_carga = $("#btn_sync").find(".fa");
		icono_carga.toggleClass("fa-refresh fa-spinner fa-spin");
		localforage.getItem('ventas').then(function (value) {
			if(value){
				$.ajax({
					"url": "http://sync-sistemas.com/muebleria/ventas/sync_ventas.php",
					"data" : {"ventas" : value, "id_usuario": $("#id_usuario").val() }, 
					"method":  "POST"
				}).done(function (respuesta){
					btn_sync.prop("disabled", false);
					icono_carga.toggleClass("fa-refresh fa-spinner fa-spin");
					alertify.success(respuesta["cant_ventas"] + " Ventas Sincronizadas");
					console.log("respuesta");
					console.log(respuesta);
					localforage.setItem('folios_disponibles', respuesta.folios_asignados).then(function () {
							damefolioActual();
					});	
					
				}).fail(ajaxError);
				}else{
						alertify.error("No hay ventas para sincronizar");
					
				}
			
			}).catch(function (err) {
				alertify.error("Error");
				alertify.error(err);
			});
		
	}
	
	
	function damefolioActual(){
		console.log("damefolioActual");
		localforage.getItem('folios_disponibles').then(function (folios_disponibles) {
			if(!folios_disponibles ){
				alertify.error("no hay folios_disponibles , sincronizar");
				syncVentas();
			}
			else{
				$("#tarjeta").val(folios_disponibles[0]);
				console.log(folios_disponibles[0]);
			}
			
		}).catch(function (err) {
			alertify.error("Error");
			alertify.error(err);
		});
		
	}
	
	function nuevaVenta(){
			
			localforage.getItem('folios_disponibles').then(function(folios_disponibles) {
				console.log("nueva venta folio" + folios_disponibles[0]);
				existe_tarjeta  = buscarTarjeta(folios_disponibles[0]);
				console.log("existe_tarjeta");
				console.log(existe_tarjeta);
				
				if(existe_tarjeta !== false){
					console.log("La tarjeta " + folios_disponibles[0] + " Ya existe, borrar de los folios");
						folios_disponibles.shift();
						localforage.setItem('folios_disponibles', folios_disponibles).then(function () {
								
							console.log("folios disponibles");
							damefolioActual();
						});
				}else{
						console.log("La tarjeta " + folios_disponibles[0] +"no existe");
						damefolioActual();
				}
			
				
			});	
		}
	var ventas = [];
	
	iniciaVentas();
	
		
		$("#btn_cancelar").on("click", function(event){
			borrar();
		});
		$("#btn_ventas").click(function(event){
			ver_ventas();
		});
		$("#btn_sync").click(function(event){
			syncVentas();
		});
		$("#btn_imprimir").click(function(event){
			imprimirVenta($("#tarjeta").val());
			console.log("imprimirVenta()" + $('#tarjeta').val());
		});
		$("#btn_nueva").click(function(event){
			nuevaVenta();
		});
		
		$("#btn_guardar").click(function(event){
			array_nueva_venta = $("#form_nueva_venta").serializeArray();
			
			localforage.getItem('ventas').then(function (value) {
				value.push(array_nueva_venta);
				console.log("guardarVenta()");
				localforage.setItem('ventas', value).then(function() {
						alertify.success('Venta Guardada!');
					}).catch(function(err) {
							alertify.error(err);
					});
			}).catch(function (err) {
				alertify.error("No hay Ventas");
				alertify.error(err);
			});
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
		
		
	/* 	$("#form_nueva_venta").submit(function(e){
			e.preventDefault();
			console.log("submit()");
			
			array_nueva_venta = $(this).serializeArray();
			console.log("DB.ventas");
			DB.ventas.push(array_nueva_venta);
			DB.write("folio_actual", DB.folio_actual + 1);
			
			alertify.success("Guardado Localmente");
		
		});
		 */
		
		//verifica si hay ventas
		function iniciaVentas(){
			localforage.getItem('ventas').then(function (value) {
			if(!value){
					alertify.error("No hay Ventas");
					
					localforage.setItem('ventas', ventas).then(function() {
						alertify.success('Ventas Iniciadas');
					}).catch(function(err) {
							alertify.error(err);
					});
				}else{
					console.log("Ya hay "+value.length+ " Ventas");
					
				}
				ventas = value;
				damefolioActual();
			}).catch(function (err) {
				alertify.error("Error");
				alertify.error(err);
			});
			
		}
		
		
		function borrar() {
			localforage.removeItem('ventas').then(function() {
					// Run this code once the key has been removed.
					alertify.success('Ventas Borradas!');
			}).catch(function(err) {
					// This code runs if there were any errors
					alertify.error(err);
			});
		}
		function ver_ventas() {
			localforage.getItem('ventas').then(function(ventas) {
					// Run this code once the key has been removed.
					alertify.success(ventas.length + 'Ventas ');
					
					alertify.confirm("<pre>" +  JSON.stringify(ventas) + "</pre>");
			}).catch(function(err) {
					// This code runs if there were any errors
					alertify.error(err);
			});
		}
		
		function buscarTarjeta(tarjeta){
			if(!isNaN(tarjeta)){
				
				tarjeta.toString();
			}
			var arrayVenta = false;
			console.log(typeof(tarjeta));
			localforage.getItem('ventas').then(function (value) { 
				console.log("buscarTarjeta() " + tarjeta +  " en ventas")
				console.log(value);
			
				
				$.each(value, function(index, item){
					
					if(item[0]["value"] == tarjeta){
						arrayVenta = item;
							
						}
				});
					
				
					
			}).catch(function(err) {
					// This code runs if there were any errors
					alertify.error(err);
			});
			
		}

		function imprimirVenta(tarjeta){
			$bold = '! U1 SETBOLD 1 ';
			$unbold = '! U1 SETBOLD 0 ';
			$font1 = ' ! U1 SETLP 1 0 20';
			$font2 = ' ! U1 SETLP 2 0 40'; 
			$font3 = ' ! U1 SETLP 3 0 40'; 
			$font4 = ' ! U1 SETLP 4 0 20'; 
			$font5 = ' ! U1 SETLP 5 0 20'; 
			$font6 = ' ! U1 SETLP 6 0 20'; 
			$font7 = ' ! U1 SETLP 7 0 20'; 
			$br = ' ! U1 RY 40 ! U1 X 0'; 
			$tab = ' ! U1 X 20'; 
			$tab4 = '! U1 X 200';
			$tab5 = '! U1 X 300';
			
			 
			
			if(buscarTarjeta(tarjeta) !== false){
				$(document).attr('title', 'Imprimir');
				alertify.message("creandoTicket");
				$encabezado = " ! U1 BEGIN-PAGE ! U1 LMARGIN 1 ! U1 SETLP 4 0 50 ! U1 X 80 MUEBLERIA ! U1 RY 40 ! U1 X 20 CASA ROBERTO ";
				$ticket = $encabezado;
				$ticket = $ticket + $br +$bold +"Tarjeta :"+ $unbold+ $("#tarjeta").val();
				$ticket = $ticket + $br +$bold +"Fecha :"+ $unbold+ $("#fecha_venta").val();
				$ticket = $ticket + $br +$bold +"Vendedor :"+ $unbold+ $("#vendedor").val();
				$ticket = $ticket + $br +$bold +"Cliente :"+ $unbold+ $("#nombre_cliente").val();
				
				if(window.AppInventor){
					window.AppInventor.setWebViewString($ticket);
				}
				
				alertify.confirm($ticket);

			}
			else{
				
				alertify.error("No se encontró tarjeta: " + tarjeta );
			}
			
		}		
			
}); 


