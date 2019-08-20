<?php	include "login/login_success.php";	include ("conex.php");	include ("is_selected.php");	$link = Conectarse();	$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");			if($_GET["fecha_inicial"]){				$sector = $_GET["sector"];		$fecha_inicial = $_GET["fecha_inicial"];		$fecha_final = $_GET["fecha_final"];			}	else{		$dia_semana = date("w");				$dia_inicial = 5-$dia_semana;		$dia_final = 3 - $dia_semana ;				// $fecha_inicial = date("d/m/Y",strtotime("-$dia_inicial days"));		$fecha_inicial = date("d/m/Y");		$fecha_final = date("d/m/Y");		// $fecha_final = date("d/m/Y",strtotime("+$dia_final days"));			}		if(isset($_GET["estatus"])){		$estatus = $_GET["estatus"];	}	else{		$estatus = "TODOS";	}	if(isset($_GET["cobrador"])){		$cobrador = $_GET["cobrador"];	}	else{		$cobrador = "MUEBLERIA";	}?><!DOCTYPE html><html>	<head>		<title>Reporte de Cobranza </title>		<meta charset="UTF-8" />		<?php include("styles.php");?>		<link rel="stylesheet" type="text/css" href="css/reporte_cobranza.css"  media="all"/>		</head>	<body>		<?php			include("header.php");		?>		<div class="container-fluid">			<div class="visible-print"> 				Muebleria Casa Roberto			</div>			<div class='titulo no_imprimir'>Reporte De Cobranza </div>			<div class="no_imprimir" id="div_form">				<form name="form_rep_mes"  class="form-inline" method="get" action="" onsubmit="return validar(this.name);"	>					<span class="form-group">						<label for="fecha_inicial" class="etiqueta">Fecha Inicial: </label>						<input size="10" class="form-control fecha" type="text" name="fecha_inicial" id="fecha_inicial" value="<?php echo $fecha_inicial;?>" />					</span>					<div class="form-group">						<label class="etiqueta"> Fecha Final: </label>						<input size="10" class="form-control fecha" type="text" name="fecha_final" id="fecha_final" value="<?php echo $fecha_final;?>" />					</div>					<div class="form-group">						<label class="etiqueta">							Cobrador: 						</label>						<select name="cobrador" id="cobrador" class="form-control">														<?php 								$q_cobradores = "SELECT * FROM cobradores WHERE activo = 1 ORDER BY nombre_cobrador ";								$result_cobradores=mysql_query($q_cobradores,$link) or die("Error en: $q_cobradores  ".mysql_error());																while($row = mysql_fetch_assoc($result_cobradores)){									$cobrador_db = $row["nombre_cobrador"];																	?>								<option value="<?php echo $cobrador_db;?>" 								<?php echo is_selected($cobrador_db, $cobrador);?> > 									<?php echo $cobrador_db;?> 									</option>								<?php								}							?>						</select>					</div>															<button name="buscar" class="btn btn-success">						<i class="fa fa-search"></i> Buscar					</button>				</form>			</div>			<?php 				if(isset($_GET["buscar"])){															$q_abonos = "SELECT GROUP_CONCAT(estatus.estatus) AS estatus, ventas.clave_vendedor, tipo_abono, sector,hora_sync,folio,fecha_hora_abono, abonos.tarjeta, nombre_cliente,abonos.saldo_anterior, 										SUM(abonos.abono) AS abono, 					abonos.saldo_restante, abonos.cobrador					FROM abonos 					LEFT JOIN (SELECT					DISTINCT tarjeta, id_estatus, clave_vendedor , sector, nombre_cliente										FROM ventas					GROUP BY tarjeta					) AS ventas ON					ventas.tarjeta = abonos.tarjeta 					LEFT JOIN estatus 					USING (id_estatus)					WHERE DATE(fecha_hora_abono) BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')										AND STR_TO_DATE('$fecha_final', '%d/%m/%Y')					AND tipo_abono = 'Abono'					";															if($cobrador != "TODOS" ){						$q_abonos.=  " AND abonos.cobrador= '$cobrador'";					}					if($estatus != "TODOS" ){						$q_abonos.=  " AND id_estatus= '$id_estatus'";					}										$q_abonos.= " AND tipo_abono <>'Devolución'					GROUP BY ventas.tarjeta										ORDER BY  fecha_hora_abono";															$result_abonos=mysql_query($q_abonos,$link) or die("Error en: $q_abonos  ".mysql_error());										$num_rows = mysql_num_rows($result_abonos);					if($num_rows == 0){						echo "<div class='titulo'>No hay registros </div>"; 						}else{												//echo $_SERVER["HTTP_HOST"];						$dia_inicial = date("w", strtotime(str_replace("/", ".", $fecha_inicial)));						$dia_final =  date("w",strtotime(str_replace("/", ".", $fecha_final)));																	?>					<PRE hidden >						<?php echo $q_abonos;?>					</PRE>										<h4 class="visible-print">						<div class="row">							<div class="col-sm-6">								Reporte de Cobranza del : <?php echo $dias[$dia_inicial]. " ".  $fecha_inicial." al ". $dias[$dia_final] ." " .$fecha_final;  ?>  							</div>							<div class="col-sm-6">								Cobrador :  <?php echo $cobrador;?>   							</div>						</div>						<div class="row">							<div class="col-sm-6">								Tarjetas Cobradas :  <?php echo $num_rows;?>							</div>							<div class="col-sm-6">															</div>						</div>					</h4>										<div class="btn_imprimir no_imprimir">						<button type="button" class="btn btn-primary" onclick="javascript:window.print();">							<i class="fa fa-print"> </i> Imprimir						</button>						<button type="button" class="btn btn-success btn_exportar" >							<i class="fa fa-arrow-right"> </i> Exportar						</button>					</div>										<table border="1" id="tabla_reporte" class="tabla_reporte">						<thead>							<th>Folio</th>							<th>Fecha Abono</th>							<th>Hora</th>							<th>Hora Sync</th>							<th>Tarjeta</th>							<th>Nombre Cliente</th>							<th>Saldo Anterior</th>							<th>Abono</th>							<th>Saldo Restante</th>							<th>Vendedor</th>							<th>Cobrador</th>							<th>Dia de Cobro</th>							<th>Sector</th>							<th>Estatus</th>						</thead>						<tbody>														<?php																																$sum_abonos = 0;								$contador = 1;																while($row = mysql_fetch_assoc($result_abonos)){									$fecha_hora_abono = $row["fecha_hora_abono"];											$fecha_abono = date("d/m/Y", strtotime($row["fecha_hora_abono"]));											$hora = date("H:i:s", strtotime($row["fecha_hora_abono"]));											$hora_sync = $row["hora_sync"];											$tarjeta = $row["tarjeta"];									$folio = $row["folio"];									$clave_vendedor = $row["clave_vendedor"];									$nombre_cliente = $row["nombre_cliente"];									$saldo_anterior = $row["saldo_anterior"];									$abono = $row["abono"];									$estatus = $row["estatus"];									$saldo_restante = $row["saldo_restante"];									$suma_saldo_restante+=$saldo_restante;									$sum_abonos+= $abono;									$cobrador_db = $row["cobrador"];									$dia_cobranza = $row["dia_cobranza"];									$dia_numerico = date("w", strtotime($row["fecha_hora_abono"])) ;									$sector = $row["sector"] ;									$tipo_abono = $row["tipo_abono"] ;									//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");																										?>								<tr>									<td>										<?php echo "$contador";?>									</td>									<td>										<?php echo "$fecha_abono";?>									</td>									<td>										<?php echo "$hora";?>									</td>									<td>										<?php echo "$hora_sync";?>									</td>									<td CLASS="h4">										<a target="_blank" href="buscar_tarjeta.php?tarjeta=<?php echo "$tarjeta";?>" >											<b>	<?php echo "$tarjeta";?> </b>											<a/>										</td>																				<td>											<?php echo "$nombre_cliente";?>										</td>																				<td>											<?php echo "$ $saldo_anterior";?>										</td>										<td>											<?php echo  "$ $abono";?>										</td>										<td>											<?php echo "$ $saldo_restante";?>										</td>										<td><?php echo $row["clave_vendedor"];;?></td>										<td>											<?php echo " $cobrador_db";?>										</td>										<td>											<?php echo $dias[$dia_numerico];?>										</td>										<td>											<?php echo $sector;?>										</td>										<td>											<?php echo $estatus;?>										</td>									</tr>									<?php										$contador++;									}								?>								<tr>										<td><?php $contador; 	?> </td>									<td>-</td>									<td>-</td>									<td>-</td>									<td>-</td>									<td>-</td>									<td>-</td>																		<td>										<b><?php echo  number_format(($sum_abonos),2);?></b>									</td>									<td><b><?php echo  number_format(($suma_saldo_restante),2);?></b></td>									<td>-</td>									<td>-</td>									<td>-</td>									<td>-</td>									<td>-</td>								</tr>							</tbody>								</table>																								<?php						}					}				?>				<hr>				<div class="row">					<div class="col-xs-6">						<table id="tabla_billetes" border="1" class="tabla-md">							<thead>								<tr>									<td>Denominación</td>									<td>Numero</td>									<td>Importe</td>								</tr>							</thead>														<tr>								<td>									$1000								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$500								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$200								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$100								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$50								</td>								<td>									____________								</td>								<td>									____________								</td>							</td>							<tr>								<td>									$20								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$10								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$5								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$2								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$1								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$.50								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$.20								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td>									$.10								</td>								<td>									____________								</td>								<td>									____________								</td>							</tr>							<tr>								<td colspan="3">																	</td>							</tr>							<tr>								<td colspan="2">									SUMA DE EFECTIVO:								</td>								<td>									$								</td>							</tr>							<tr>								<td colspan="2">									NOTA DE GASOLINA:								</td>								<td>									$								</td>							</tr>							<tr>								<td colspan="2">									PARCIAL:								</td>								<td>									$								</td>							</tr>							<tr>								<td colspan="2">									IMPORTE TOTAL DEL DIA:								</td>								<td>									$								</td>							</tr>							<tr>								<td colspan="2">									PARCIAL DEL DIA:								</td>								<td>									$								</td>							</tr>							<tr>								<td colspan="2">									TOTAL RECIBIDO:								</td>								<td>									$								</td>							</tr>						</table>					</div>					<div class="col-xs-6">						<?php 							if(isset($_GET["buscar"])){																$q_vendedores = "								SELECT								DISTINCT								tarjeta,								id_ventas ,								clave_vendedor,								tipo_abono,								SUM(abonos) AS acumulado																FROM								ventas								RIGHT JOIN (								SELECT								tarjeta,								tipo_abono,								SUM(abono) AS acumulado								FROM								abonos								WHERE								DATE(fecha_hora_abono) BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')								AND STR_TO_DATE('$fecha_final', '%d/%m/%Y')								AND tipo_abono = 'Abono'";																if($cobrador != "TODOS" ){									$q_vendedores.=  " AND abonos.cobrador= '$cobrador'";								}																$q_vendedores.= "								AND tipo_abono <> 'Devolución'								GROUP BY tarjeta								) AS t_cobranza USING (tarjeta)								WHERE								tipo_abono = 'Abono'								AND tipo_abono <> 'Devolución'								GROUP BY								clave_vendedor";																$q_vendedores="								SELECT								clave_vendedor,								SUM(acumulado) as acumulado								FROM								(								SELECT								tarjeta,								tipo_abono,								SUM(abono) AS acumulado								FROM								abonos								WHERE								DATE(fecha_hora_abono) BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')								AND STR_TO_DATE('$fecha_final', '%d/%m/%Y')								AND tipo_abono = 'Abono'								AND abonos.cobrador = '$cobrador'								AND tipo_abono <> 'Devolución'								GROUP BY								tarjeta								) AS tabla_acumulado								LEFT JOIN (								SELECT								tarjeta,								clave_vendedor								FROM								ventas								GROUP BY tarjeta								) AS tabla_ventas USING (tarjeta)								GROUP BY								clave_vendedor																";																								$result_vendedores=mysql_query($q_vendedores,$link) or die("Error en: $q_vendedores  ".mysql_error());																$num_rows = mysql_num_rows($result_vendedores);								if($num_rows == 0){									echo "<div class='titulo'>No hay registros </div>"; 									}else{																	?>								<a class="hidden-print" href="#" data-toggle="collapse" data-target="#consulta_comisiones">									Mostrar SQL								</a>								<PRE  class="collapse" id="consulta_comisiones">									<?php echo $q_vendedores;?>								</PRE>								<table border="1" id="tabla_reporte" class="table tabla3">									<thead>										<th>Vendedor</th>										<th>Acumulado</th>									</thead>									<tbody>																				<?php																						$sum_abonos = 0;																						while($row = mysql_fetch_assoc($result_vendedores)){												$clave_vendedor = $row["clave_vendedor"];												$acumulado= $row["acumulado"] ;												$sum_abonos+= $acumulado;											?>											<tr>												<td>													<?php echo $clave_vendedor;?>												</td>												<td>													<?php echo number_format($acumulado, 2);?>												</td>											</tr>											<?php											}										?>										<tr>												<td></td>											<td>												<b><?php echo  "$ ".number_format($sum_abonos,2);?></b>											</td>										</tr>									</tbody>										</table>																<?php								}							}																											?>											</div>					<?php 						$q_kilom = "SELECT * FROM kilometrajes LEFT JOIN cobradores USING(id_cobrador) ";												$result = mysql_query($q_kilom, $link);											?>										<div class="col-xs-6 " hidden>						<legend class="etiqueta">Kilometrajes</legend>						<table>							<thead>								<tr>									<th>Fecha</th>									<th>Cobrador</th>									<th>Placas</th>									<th>KM Inicial</th>									<th>KM Final</th>									<th>KM Recorridos</th>									<th>Litros</th>									<th>Importe</th>									<th>Rendimiento</th>								</tr>							</thead>							<tbody>								<?php									while($fila_km = mysql_fetch_assoc($result)){									?>									<tr>										<td><?php echo date("d/m/Y", strtotime($fila_km["fecha_kilometraje"]))?></td>										<td><?php echo $fila_km["nombre_cobrador"]?></td>										<td><?php echo $fila_km["placas"]?></td>										<td class="text-center"><?php echo number_format($fila_km["kilometraje_anterior"])?></td>										<td class="text-center"><?php echo number_format($fila_km["kilometraje_actual"])?></td>										<td class="text-center"><?php echo number_format($fila_km["diferencia_kilometraje"])?></td>										<td class="text-center"><?php echo number_format($fila_km["litros"])?></td>										<td class="text-center"><?php echo number_format($fila_km["importe_gasolina"])?></td>										<td class="text-center"><?php echo number_format($fila_km["rendimiento"])?></td>									</tr>									<?php																			}								?>							</tbody>						</table>					</div>				</div>			</div>						<?php include("scripts.php");?>						<script>				$( document ).ready(function() {					$(".btn_exportar").click(function(){												$('#tabla_reporte').tableExport(						{							type:'excel',							tableName:'Registros',							escape:'false'						});					});				}); 			</script>					</body>	</html>						