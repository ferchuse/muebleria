<?php	include "login/login_success.php";	include "is_selected.php";	include ("conexi.php");	$link = Conectarse();		$q_folio = "SELECT * FROM folios ";		$result_folio = mysqli_query($link, $q_folio) or die(mysqli_error($link));		$fila_folio = mysqli_fetch_assoc($result_folio);		$folio = $fila_folio["folio"];	// $folio++;?><!DOCTYPE html> <html><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />		<title>Venta al contado</title>	<?php include("styles.php")?>	<link rel="stylesheet" type="text/css" href="css/imprimir_abono.css"  media="all"/>			<?php include("scripts.php")?>			<style>		@media print{		.contenido{		font-size :8px !important;		width:100% !important;		}		}					</style></head><body>	<?php		include("header.php");	?>	<div class="contenido hidden-print"> 		<div class="visible-print text-center">			<img src="img/logo.png" width="200" height="50"/> <br>			<I>"LLEVANDO SATISFACCIÓN A LOS HOGARES" </I><br>			<h6 class="">				RFC LALH640228EK7 <br>				CURP LALH640228HMCGPL02 <br>				VENTA DE ARTICULOS PARA EL HOGAR <br>								(01591) 9185428<br>			</h6>		</div>				<div class="titulo text-center">			Venta de Contado		</div>						<form onsubmit="return validar();" action="" method="post" id="frm_nueva_venta" accept-charset="utf-8">						<div class="col-xs-6">								<table>					<tr>						<td>							<label >   Folio Venta:</label>						</td>						<td>							<input type="text"  name="folio_venta" id="folio_venta" size="10" value="<?php echo $folio;?>"/>													</td>					</tr>										<tr>						<td>							<label > Condiciones de Venta:</label>						</td>						<td>							<select id="tipo_venta" name="tipo_venta">								<option>CONTADO</option>								<option>SISTEMA DE APARTADO</option>							</select>						</td>					</tr>					<tr>						<td>							<label >  Fecha de Vencimiento:</label>						</td>						<td>							<input  type="date" disabled name="fecha_vencimiento" id="fecha_vencimiento" value="<?php echo date("Y-m-d", strtotime("+1 month"));?>" />						</td>					</tr>					<tr>						<td>							<label >  Fecha de Venta:</label>						</td>						<td>							<input size="10" type="date" name="fecha_venta" id="txt_fecha_venta" value="<?php echo date("Y-m-d");?>"  />						</td>					</tr>										<tr>						<td>							<label > Nombre Cliente:</label>						</td>						<td>							<input size="50" type="text" id="txt_nombre_cliente" name="nombre_cliente"   />						</td>					</tr>					<tr>						<td>							<label > Dirección:</label>						</td>						<td>							<input size="80" type="text" name="direccion"  id="direccion" />						</td>					</tr>					<tr>						<td>							<label > Referencias:</label>						</td>						<td>							<input size="80" type="text" name="referencias"   id="referencias"/>						</td>					</tr>					<tr>						<td>							<label > Entre Calles:</label>						</td>						<td>							<input size="80" type="text" name="entre_calles" id="entre_calles"  />						</td>					</tr>					<tr>						<td>							<label > Teléfono:</label>						</td>						<td>							<input size="10" type="tel" name="telefono"   id="telefono" />						</td>					</tr>					<tr>						<td>							<label > Celular:</label>						</td>						<td>							<input size="10" type="tel" name="celular"   id="celular" />						</td>					</tr>										<tr>						<td>							<label>Vendedor</label>						</td>						<td>							<select name="clave_vendedor">								<option value="">Elige...	</option>								<?php 									$q_cobradores = "SELECT * FROM vendedores ORDER BY nombre_vendedor";									$result_cobradores=mysqli_query($link, $q_cobradores) or die("Error en: $q_cobradores  ".mysqli_error($link));																		while($row = mysqli_fetch_assoc($result_cobradores)){										$cobrador_db = $row["clave_vendedor"];																			?>									<option value="<?php echo $cobrador_db;?>" 									<?php echo is_selected($cobrador_db, "01M");?> > 										<?php echo $row["clave_vendedor"];?> 										</option>									<?php									}								?>							</select>						</td>					</tr>										<tr class="hidden">						<td>							<label > Sector</label>						</td>						<td>							<select disabled name="sector">								<option value=""  > Elige un Sector	</option>								<?php 									$q_sectores = "SELECT * FROM sectores ";									$result_sectores=mysqli_query($link , $q_sectores) or die("Error en: $q_sectores  ".mysqli_error($link));																		while($row = mysqli_fetch_assoc($result_sectores)){										$sector_db = $row["sector"];														?>									<option value="<?php echo $sector_db;?>"  >										<?php echo $sector_db;?>										</option>									<?php									}								?>							</select>						</td>					</tr>					<tr>						<td>							<label > Artículo</label>						</td>						<td>							<input size="50" type="text" name="articulo" id="articulo"   />						</td>					</tr>					<tr>						<td>							<label > Tipo de Artículo</label>						</td>						<td>							<select required name="tipo_articulo">								<option value="">Elige...</option>								<option value="Mueble">Mueble</option>								<option value="Caja">Caja</option>							</select>						</td>					</tr>					<tr>						<td>							<label > Importe Total</label>						</td>						<td>							<input size="10" type="number" name="importe_total" id="importe_total"  />						</td>					</tr>					<tr>						<td>							<label > Anticipo:</label>						</td>						<td>							<input size="10" type="number"  name="enganche" id="enganche"  />						</td>					</tr>					<tr>						<td>							<label > Por Cobrar:</label>						</td>						<td>							<input size="10" type="number"  name="saldo_actual" id="saldo_actual"  />						</td>					</tr>																			</table>			</div>		</form>		<div class="botonera_derecha hidden-print">			<button  type ="button" id="btn_guardar" >				<i class="fa fa-2x fa-save"></i> Guardar			</button>			<button  type ="button" id="btn_ticket"  >				<i class="fa fa-2x fa-print"></i> Imprimir			</button>			<button  type ="button" onclick="window.location.reload(true);"> 				<i class="fa fa-2x fa-print"></i> Nueva Venta			</button>		</div>	</div>	<div id="ticket" class="visible-print">			</div>		</body><script type="text/javascript">	$( document ).ready(function() {						$("#tipo_venta").change(function(){			var tipo_venta = $(this).val();									if(tipo_venta == "CONTADO"){				$("#fecha_vencimiento").prop("disabled", true);			}			else{				$("#fecha_vencimiento").prop("disabled",false);			}			});						$("#btn_ticket").click(function(){			$("#estado_cuenta").html("");			$.ajax({ 				url: "imprimir_contado.php",				data:{					tarjeta : $("#folio_venta").val()				}				}).done(function(respuesta){				$("#ticket").html(respuesta);				window.print();							})								});								$("#fecha_venta").val(Date.today().toString("dd/MM/yyyy"));				$("#enganche").keyup(function(e){			var enganche = Number($(this).val());			var importe_total = Number($("#importe_total").val());			var saldo_actual = importe_total -enganche;			$("#saldo_actual").val(saldo_actual);					});		$("#cantidad_abono").keyup(function(e){			var cantidad_abono = Number($(this).val());			var saldo_actual = Number($("#saldo_actual").val());			var num_semanas = Math.round(saldo_actual / cantidad_abono);			$("#num_semanas").val(num_semanas);						$("#fecha_vencimiento").val(Date.today().add(num_semanas * 7).days().toString("dd/MM/yyyy"));					});						$( "#txt_nombre_cliente" ).autocomplete({			source: "search_json.php?tabla=ventas&campo=nombre_cliente&valor=nombre_cliente&etiqueta=nombre_cliente",			minLength : 2,			select: function( event, ui ) {				console.log("item",ui.item );				$( "#direccion" ).val(ui.item.extras.direccion);				$( "#referencias" ).val(ui.item.extras.referencias);				$( "#entre_calles" ).val(ui.item.extras.entre_calles);				$( "#telefono" ).val(ui.item.extras.telefono);			}		});		$( "#articulo" ).autocomplete({			source: "search_json.php?tabla=productos&campo=descripcion&valor=descripcion&etiqueta=descripcion",			minLength : 2,			select: function( event, ui ) {				console.log("item",ui.item );				$( "#importe_total" ).val(ui.item.extras.importe_total);							}		});				function getFolio(){			$.ajax({				url: "get_folio.php"				}).done(function(respuesta){								$("#frm_nueva_venta")[0].reset();				$("#folio_venta").val(respuesta.folio);							});					}				$("#txt_folio_venta").focus();				//Selecciona todo el texto al recibir el evento focus 		$("input:text").focus(function() { $(this).select(); } );				//Guarda el formulario		$('#btn_guardar').click(function(event){						$.post("control/guardar_venta_contado.php", $( "#frm_nueva_venta" ).serialize(),  			function(respuesta, status){								if(respuesta.estatus_venta == "success"){					alertify.success("Guardado Correctamente");					$("#btn_ticket").click();					getFolio();					// Popup();					// window.location.reload();				}				else{					alertify.error(respuesta.mensaje);									}				}).fail(function(xhr, error){				alertify.error(error);							});					}); 												//evita el envio del formulario al presionar enter		$('#frm_nueva_venta').keypress(function(event){   			//event.preventDefault();						if(event.which == 13){				$('#btn_guardar').click();				return false;			} 					});	}); </script></html>