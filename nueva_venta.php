<?php	include "login/login_success.php";	include "is_selected.php";	include ("conex.php");	$link = Conectarse();			$q_folio = "SELECT * FROM folios ";		$result_folio = mysql_query( $q_folio, $link) or die(mysql_error($link));		$fila_folio = mysql_fetch_assoc($result_folio);			$consulta_id_ventas = "SELECT `AUTO_INCREMENT` AS id_ventas	FROM  INFORMATION_SCHEMA.TABLES	WHERE TABLE_SCHEMA = 'syncsis_muebleria'	AND   TABLE_NAME   = 'ventas'; ";	$result_id_ventas = mysql_query( $consulta_id_ventas, $link) or die(mysql_error($link));	$fila_id_ventas = mysql_fetch_assoc($result_id_ventas);		if(isset($_GET["tarjeta"])){		$folio = $_GET["tarjeta"];				$consulta_cliente = "SELECT * FROM ventas WHERE tarjeta = '{$_GET["tarjeta"]}' LIMIT 1 ";				$result_cliente = mysql_query( $consulta_cliente, $link) or die(mysql_error($link));				$fila_cliente = mysql_fetch_assoc($result_cliente);			}	else{		$folio = $fila_folio["folio"];			}		// $folio++;	?><!DOCTYPE html> <html><head>	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />		<title>Registro de Venta</title>	<?php include("styles.php")?>			<?php include("scripts.php")?>				<script >				function buscarTarjeta(){			console.log("buscarTarjeta()");			$("#txt_tarjeta").toggleClass("cargando");			$.ajax({				url: "funciones/fila_select.php",				data:{					tabla: "ventas",					id_campo: "tarjeta",					id_valor: $("#txt_tarjeta").val()				}								}).done(function(respuesta){								if(respuesta.encontrado == 1){					$("#txt_nombre_cliente").val(respuesta.data.nombre_cliente)					$("#direccion").val(respuesta.data.direccion)					$("#referencias").val(respuesta.data.referencias)					$("#entre_calles").val(respuesta.data.entre_calles)					$("#telefono").val(respuesta.data.telefono)					$("#dia_cobranza").val(respuesta.data.dia_cobranza);					$("#cobrador").val(respuesta.data.cobrador);					$("#cobrador").val(respuesta.data.cobrador);					$("#clave_vendedor").val(respuesta.data.clave_vendedor);					$("#sector").val(respuesta.data.sector);				}				else{					$("#txt_nombre_cliente").val("")					$("#direccion").val("")					$("#referencias").val("")					$("#entre_calles").val("")					$("#telefono").val("");					$("#cobrador").val(respuesta.data.cobrador);					$("#clave_vendedor").val(respuesta.data.clave_vendedor);					$("#sector").val(respuesta.data.sector);					$("#dia_cobranza").val(respuesta.data.dia_cobranza);				}				$("#txt_tarjeta").toggleClass("cargando");			});					}				$( document ).ready(function() {						buscarTarjeta();						$("#txt_tarjeta").blur(function(event){												buscarTarjeta();							});			$("#fecha_venta").val(Date.today().toString("dd/MM/yyyy"));						$("#enganche").keyup(function(e){				var enganche = Number($(this).val());				var importe_total = Number($("#importe_total").val());				var saldo_actual = importe_total -enganche;				$("#saldo_actual").val(saldo_actual);							});			$("#cantidad_abono").keyup(function(e){				var cantidad_abono = Number($(this).val());				var saldo_actual = Number($("#saldo_actual").val());				var num_semanas = Math.round(saldo_actual / cantidad_abono);				$("#num_semanas").val(num_semanas);								$("#fecha_vencimiento").val(Date.today().add(num_semanas * 7).days().toString("dd/MM/yyyy"));							});						$( "#txt_nombre_cliente" ).autocomplete({				source: "search_json.php?tabla=ventas&campo=nombre_cliente&valor=nombre_cliente&etiqueta=nombre_cliente",				minLength : 2,				select: function( event, ui ) {					console.log("item",ui.item ); 					$( "#tarjeta" ).val(ui.item.extras.tarjeta);					$( "#direccion" ).val(ui.item.extras.direccion);					$( "#referencias" ).val(ui.item.extras.referencias);					$( "#entre_calles" ).val(ui.item.extras.entre_calles);					$( "#telefono" ).val(ui.item.extras.telefono);					$( "#cobrador" ).val(ui.item.extras.cobrador);					$( "#sector" ).val(ui.item.extras.sector);					$( "#dia_cobranza" ).val(ui.item.extras.dia_cobranza);					$( "#clave_vendedor" ).val(ui.item.extras.clave_vendedor);					$( "#articulo" ).focus();				}			});						$("#txt_folio_venta").focus();						//Selecciona todo el texto al recibir el evento focus 			$("input:text").focus(function() { $(this).select(); } );						//Guarda el formulario			$('#frm_nueva_venta').submit(function(event){				event.preventDefault();				$('#btn_guardar').prop("disabled", true);								$.post("guardar_venta.php", $( "#frm_nueva_venta" ).serialize(),   function(respuesta, status){										if(respuesta.estatus == "success"){						alertify.success(respuesta.mensaje);						$('#btn_guardar').prop("disabled", false);						$('#btn_imprimir').click();						Popup();						window.location.href="nueva_venta.php";						// $("input[type=text]").val("");						$('#txt_folio_venta').focus();												// getFolio()					}					else{						alertify.error(respuesta.mensaje);											}					}).fail(function(xhr, error){					alertify.error(error);									});							}); 									function getFolio() {								// $.ajax("")			}			function Popup(data){				console.log("Popup");				var tarjeta = $("#txt_tarjeta").val();        window.open('imprimir_tarjeta.php?tarjeta='+tarjeta+"&id_ventas="+ $("#id_ventas").val(), 'Imprimir Tarjeta', 'height=600,width=700');				return true;			}						$( "#txt_fecha_venta" ).datepicker({				changeMonth: true,				changeYear: true,							});			$( "#fecha_vencimiento" ).datepicker({				changeMonth: true,				changeYear: true,							});									$( "#btn_imprimir" ).click(function(){				Popup("Tarjeta");			});									//evita el envio del formulario al presionar enter			$('#frm_nueva_venta').keypress(function(event){   				//event.preventDefault();								if(event.which == 13){					$('#btn_guardar').click();					return false;				} 							});		}); 	</script></head><body>	<?php		include("header.php");	?>	<div class="contenido"> 						<div class="div_mensaje">					</div>		<div class="titulo">			Registro de Venta		</div>		<form method="post" id="frm_nueva_venta" accept-charset="utf-8">						<div class="tabla_mitad">				<table>					<tr>						<td>							<label >   Tarjeta:</label>						</td>						<td>							<input required type="text"  name="tarjeta" id="txt_tarjeta" size="10" value="<?php echo $folio;?>"/>						</td>					</tr>					<tr>						<td>							<label >   Folio Venta:</label>						</td>						<td>							<input autofocus type="text"  name="folio_venta" id="txt_folio_venta" size="10" /> 							<input class="bg-primary" type="number" readonly  name="id_ventas" id="id_ventas" size="10" value="<?php echo $fila_id_ventas["id_ventas"]?>" /> 						</td>					</tr>										<tr>						<td>							<label >  Fecha de Venta:</label>						</td>						<td>							<input size="10" type="text" name="fecha_venta" id="txt_fecha_venta" value="<?php echo date("d/m/Y");?>"  />						</td>					</tr>										<tr>						<td>							<label > Nombre Cliente:</label>						</td>						<td>							<input required size="50" type="text" id="txt_nombre_cliente" name="nombre_cliente"  value="<?php echo $fila_cliente["nombre_cliente"]?>" />						</td>					</tr>					<tr>						<td>							<label > Dirección:</label>						</td>						<td>							<input size="80" type="text" name="direccion" id="direccion"  value="<?php echo $fila_cliente["direccion"]?>" />						</td>					</tr>					<tr>						<td>							<label > Referencias:</label>						</td>						<td>							<input size="80" type="text" name="referencias" id="referencias" value="<?php echo $fila_cliente["referencias"]?>"  />						</td>					</tr>					<tr>						<td>							<label > Entre Calles:</label>						</td>						<td>							<input size="80" type="text" name="entre_calles"  id="entre_calles" value="<?php echo $fila_cliente["entre_calles"]?>"  />						</td>					</tr>					<tr>						<td>							<label > Teléfono:</label>						</td>						<td>							<input size="10" type="text" name="telefono" id="telefono"  value="<?php echo $fila_cliente["telefono"]?>"  />						</td>					</tr>					<tr>						<td>							<label > Dia de Cobro:</label>						</td>						<td>							<select name="dia_cobranza" id="dia_cobranza">								<option value="LUNES">LUNES	</option>								<option value="MARTES">MARTES	</option>								<option value="MIÉRCOLES">MIÉRCOLES	</option>								<option value="JUEVES">JUEVES	</option>								<option value="VIERNES">VIERNES	</option>								<option value="SÁBADO">SÁBADO	</option>								<option value="DOMINGO">DOMINGO	</option>								<option value="QUINCENAL">QUINCENAL	</option>								<option value="MENSUAL">MENSUAL	</option>							</select>						</td>					</tr>					<tr>						<td>							<label > Cobrador</label>						</td>						<td>							<select name="cobrador" id="cobrador">								<option value="">Elige un Cobrador	</option>								<?php 									$q_cobradores = "SELECT * FROM cobradores ORDER BY nombre_cobrador";									$result_cobradores=mysql_query($q_cobradores,$link) or die("Error en: $q_cobradores  ".mysql_error());																		while($row = mysql_fetch_assoc($result_cobradores)){										$cobrador_db = $row["nombre_cobrador"];																			?>									<option value="<?php echo $cobrador_db;?>" 									<?php echo is_selected($cobrador_db, $cobrador);?> > 										<?php echo $cobrador_db;?> 										</option>									<?php									}								?>							</select>						</td>					</tr>					<tr>						<td>							<label > Clave Vendedor</label>						</td>						<td>							<input size="10" type="text" name="clave_vendedor" id="clave_vendedor"   />						</td>					</tr>					<tr>						<td>							<label > Sector</label>						</td>						<td>							<select name="sector" id="sector">								<option value=""  > Elige un Sector									</option>																<?php 									$q_sectores = "SELECT * FROM sectores ORDER BY sector";									$result_sectores=mysql_query($q_sectores,$link) or die("Error en: $q_sectores  ".mysql_error());																		while($row = mysql_fetch_assoc($result_sectores)){										$sector_db = $row["sector"];																								?>									<option value="<?php echo $sector_db;?>"  >										<?php echo $sector_db;?>										</option>																											<?php									}								?>							</select>						</td>					</tr>					<tr>						<td>							<label > Artículo</label>						</td>						<td>							<input size="50" type="text" name="articulo"  id="articulo"   />						</td>					</tr>					<tr>						<td>							<label > Tipo de Artículo</label>						</td>						<td>							<select required name="tipo_articulo">								<option value="">Elige...</option>								<option value="Mueble">Mueble</option>								<option value="Caja">Caja</option>							</select>						</td>					</tr>					<tr>						<td>							<label > Importe Total</label>						</td>						<td>							<input required size="10" type="text" name="importe" id="importe_total"  />						</td>					</tr>					<tr>						<td>							<label > Enganche</label>						</td>						<td>							<input required size="10" type="text" name="enganche"  id="enganche" />						</td>					</tr>					<tr>						<td>							<label > Cantidad Abono</label>						</td>						<td>							<input size="10" type="text" name="cantidad_abono" id="cantidad_abono"   />						</td>					</tr>					<tr>						<td>							<label > Saldo Actual</label>						</td>						<td>							<input size="10" type="text" name="saldo_actual" id="saldo_actual"   />						</td>					</tr>					<tr>						<td>							<label >  Fecha de Vencimiento:</label>						</td>						<td>							<input size="10" type="text" name="fecha_vencimiento" id="fecha_vencimiento" value=""  />						</td>					</tr>					<tr>						<td>							<label > Estatus</label>						</td>						<td>							<select name="id_estatus" id="id_estatus" >								<option value="">Elige un Estatus	</option>								<?php 									$q_estatus = "SELECT * FROM estatus ";									$result_estatus=mysql_query($q_estatus,$link) or die("Error en: $q_estatus  ".mysql_error());																		while($row = mysql_fetch_assoc($result_estatus)){										$id_estatus_db = $row["id_estatus"];										$estatus_db = $row["estatus"];																			?>									<option value="<?php echo $id_estatus_db;?>"  <?php echo is_selected($id_estatus_db, 13);?> > 										<?php echo $estatus_db;?> 										</option>									<?php									}								?>							</select>						</td>					</tr>				</table>			</div>						<div class="botonera_derecha">				<button  type ="submit" id="btn_guardar" >					<i class="fa fa-2x fa-save"></i> Guardar				</button>				<button  type ="button" id="btn_imprimir" >					<i class="fa fa-2x fa-print"></i> Imprimir				</button>			</div>		</form>	</div></body></html>