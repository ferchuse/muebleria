<?php	include "login/login_success.php";	include ("conexi.php");	include ("functions.php");	include ("is_selected.php");	$link = Conectarse();		$nombres_dias= array("LUNES", "MARTES", "MIERCOLES", "JUEVES" , "VIERNES", "SABADO", "DOMINGO");		function day_of_week($fecha){				$nombres_dias= array("LUNES", "MARTES", "MIERCOLES", "JUEVES" , "VIERNES", "SABADO", "DOMINGO");			}			$oolores = ["Crédito" => "red", "CONTADO" => "blue", "SISTEMA DE APARTADO" => "green"] ;	//$dia_inicial = $dia_semana["wday"] -1;	//$dia_final = 6 - $dia_semana["wday"] ;			if($_GET["fecha_inicial"]){				$fecha_inicial = $_GET["fecha_inicial"];		$fecha_final = $_GET["fecha_final"];			}	else{		$dia_actual = date("w");				//$dia_inicial = $dia_actual - 1; 		//$dia_final = 7 - $dia_actual ;				$dia_inicial = 6 + $dia_actual ; //Lunes de la semana pasada		$dia_final = 7 - $dia_actual ; // Domingo pasado				$fecha_inicial = date("d/m/Y",strtotime("last monday"));		$fecha_final = date("d/m/Y",strtotime("+$dia_final days"));					}		if(isset($_GET["dia_semana"])){		$dia_semana  =$_GET["dia_semana"];		}else{		$dia_semana  ='';			}	if(isset($_GET["tipo_venta"])){		$tipo_venta  =$_GET["tipo_venta"];	}	else{		$tipo_venta  ='';			}	if(isset($_GET["buscar_fecha"])){		$sector = $_GET["sector"];		$clave_vendedor = $_GET["clave_vendedor"];		$tipo_articulo = $_GET["tipo_articulo"];		$fecha_inicial = $_GET["fecha_inicial"];		$fecha_final = $_GET["fecha_final"];	}			$cons_ventas_por_dia = "SELECT dia_cobranza , COUNT(id_ventas) as cant_ventas FROM ventas 		WHERE fecha_venta BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')							AND STR_TO_DATE('$fecha_final', '%d/%m/%Y')  		GROUP BY dia_cobranza";		$result_ventas_por_dia = mysqli_query($link, $cons_ventas_por_dia);			if($result_ventas_por_dia){				while($fila = mysqli_fetch_assoc($result_ventas_por_dia)){						$ventas_por_dia[] = $fila;					}	}	else{			$error_cons_ventas_por_dia = mysqli_error($link);			}	?><!DOCTYPE html><html>	<head>		<title>Reporte de Ventas </title>		<meta charset="utf-8" />		<?php include("styles.php");?>		<style>			.Crédito{			font-color: red !important;						}			.CONTADO{			font-color: green !important;						}			.SISTEMA DE APARTADO{			font-color: blue !important;						}						@media print{			BODY{						BACKGROUND-COLOR: white !important;			}			tr{			border: 2px solid black !important;			}						}						}			tr{			border: 2px solid black !important;			}			.DOMINGO{			color: red !important;			}			.LUNES{			color: BLUE !important;						}			.MARTES{			color: BLACK !important;			color: white;			}			.MIÉRCOLES{			color: GREEN !important;			}			.JUEVES{			color: YELLOW !important;			}			.VIERNES{			color: BROWN !important;			}			.SÁBADO{			color: #e5a227 !important;			}			.MENSUAL{			color: PURPLE !important;			}			.QUINCENAL{			color: MAGENTA !important;			}			.dia_cobranza{			text-decoration: underline;			font-weight: bold;			}			table{			border: 1px solid black !important;			}		</style>	</head>	<body>		<?php			include("header.php");		?>				<style>						td{			border: solid 1px !important;			}		</style>				<div class="container-fluid">			<div class="encabezado_imprimir visible-print">				Muebleria Casa Roberto			</div>			<div class='titulo hidden-print'>Reporte de Ventas por Vendedor</div>			<div class="fechas hidden-print" >				<form class="form-inline" method="get" 	>					<div class="form-group">						<label class="etiqueta">Fecha Inicial:</label> 						<input size="10" type="text" class="form-control fecha" name="fecha_inicial" id="fecha_inicial" value="<?php echo $fecha_inicial;?>" required />					</div>					<div class="form-group">						<label class="etiqueta">Fecha Final:</label> 						<input size="10" type="text" class="form-control fecha" name="fecha_final" id="fecha_final" value="<?php echo $fecha_final;?>" required/>					</div>					<div class="form-group">						<label class="etiqueta">Sector</label>						<select name="sector" required class="form-control">							<option value="TODOS"  >TODOS</option>							<?php 								$q_sectores = "SELECT * FROM sectores ";								$result_sectores=mysqli_query($link, $q_sectores) or die("Error en: $q_sectores  ".mysqli_error($link));																while($row = mysqli_fetch_assoc($result_sectores)){									$sector_db = $row["sector"];													?>								<option <?php echo is_selected($sector_db, $sector);?> value="<?php echo $sector_db;?>"  >									<?php echo $sector_db;?>									</option>								<?php								}							?>						</select>					</div>					<div class="form-group">						<label class="etiqueta">Vendedor</label>						<select name="clave_vendedor"  class="form-control">							<option value="TODOS"  >TODOS</option>							<?php 								$q_vendedores= "SELECT * FROM vendedores ";								$result_sectores=mysqli_query($link, $q_vendedores) or die("Error en: $q_vendedores  ".mysqli_error($link));																while($row = mysqli_fetch_assoc($result_sectores)){									$clave_vendedor_db = $row["clave_vendedor"];													?>								<option <?php echo is_selected($clave_vendedor_db, $clave_vendedor);?> value="<?php echo $clave_vendedor_db;?>"  >									<?php echo $clave_vendedor_db;?>									</option>								<?php								}							?>						</select>					</div>					<div class="form-group">						<label class="etiqueta">							Cobrador: 						</label>						<select name="cobrador" id="cobrador" class="form-control">							<option value=""  >TODOS</option>							<?php 								$q_cobradores = "SELECT * FROM cobradores WHERE activo = 1 ORDER BY nombre_cobrador ";								$result_cobradores=mysqli_query($link,$q_cobradores) or die("Error en: $q_cobradores  ".mysqli_error($link));																while($row = mysqli_fetch_assoc($result_cobradores)){									$cobrador_db = $row["nombre_cobrador"];																	?>								<option value="<?php echo $cobrador_db;?>" 								<?php echo is_selected($cobrador_db, $_GET["cobrador"]);?> > 									<?php echo $cobrador_db;?> 									</option>								<?php								}							?>						</select>					</div>					<div class="form-group">						<label class="etiqueta">Tipo de Articulo</label>						<select name="tipo_articulo"  class="form-control">							<option value="TODOS" >TODOS</option>							<option value="Caja" >Caja</option>							<option value="Mueble" >Mueble</option>						</select>					</div> 										<div class="form-group">						<label class="etiqueta">DIA COBRANZA</label>						<select class="form-control" name="dia_semana" id="dia_semana" >							<option value="">TODOS	</option>							<?php foreach($nombres_dias as $index_semana=>$dia_semana_db){							?>							<option value="<?php echo $dia_semana_db;?>"  <?php echo is_selected($dia_semana_db, $dia_semana);?>  > 								<?php echo $dia_semana_db;?> 								</option>							<?php							}							?>							<option value="QUINCENAL"  <?php echo is_selected('QUINCENAL', $dia_semana);?>  > 								QUINCENAL							</option>							<option value="MENSUAL"  <?php echo is_selected('MENSUAL', $dia_semana);?>  > 								MENSUAL							</option>						</select>					</div>					<div class="form-group">						<label class="etiqueta">TIPO DE VENTA</label>						<select class="form-control" name="tipo_venta" id="tipo_venta" >							<option value="">TODOS	</option>														<option value="Crédito"  <?php echo is_selected('Crédito', $tipo_venta);?>  > 								Crédito							</option>							<option value="CONTADO"  <?php echo is_selected('CONTADO', $tipo_venta);?>  > 								CONTADO							</option>							<option value="SISTEMAS DE APARTADO"  <?php echo is_selected('SISTEMAS DE APARTADO', $tipo_venta);?>  > 								SISTEMAS DE APARTADO							</option>						</select>					</div>										<button name="buscar_fecha" class="btn btn-success">						<i class="fa fa-search"></i> Buscar					</button>				</form>			</div>			<hr class="hidden-print">			<?php 				if(isset($_GET["buscar_fecha"])){					$sector = $_GET["sector"];					$clave_vendedor = $_GET["clave_vendedor"];					$tipo_articulo = $_GET["tipo_articulo"];					$fecha_inicial = $_GET["fecha_inicial"];					$fecha_final = $_GET["fecha_final"];																			?>				<div class='titulo'>Reporte de Ventas del : <?php echo $fecha_inicial." al ".$fecha_final ;?>  </div>				<div class='etiqueta'>Sector :  <?php echo  $sector ;?>  </div> 				<div class='etiqueta'>Vendedor :  <?php echo  $clave_vendedor ;?>  </div> 				<div class='etiqueta'>Tipo de  Artículo :  <?php echo  $tipo_articulo ;?>  </div> 												<div class="btn_imprimir no_imprimir">					<button type="button" class="btn btn-primary" onclick="javascript:window.print();">						<i class="fa fa-print"> </i> Imprimir					</button>					<button type="button" class="btn btn-success btn_exportar" >						<i class="fa fa-arrow-right"> </i> Exportar					</button>				</div>				<hr>								<table border="1" id="tabla_reporte">					<thead>						<th>Fecha Venta</th>						<th>Tarjeta</th>						<th>NV</th>						<th>Nombre Cliente</th>						<th>Dirección</th>						<th>Sector</th>						<th>Artículo</th>												<th>Importe Total</th>						<th>Eng</th>						<th>Saldo Actual</th>						<th>Abono Sem</th>												<th>Ven</th>						<th>Cobrador</th>						<th>Dia de Cobro</th>											</thead>					<tbody>						<?php																					$query_reporte = "SELECT *,							importe - enganche - IF(ISNULL(total_abonado), 0, total_abonado) AS saldo_calculado 							FROM ventas 							LEFT JOIN 							(							SELECT							tarjeta,							IF(ISNULL(SUM(abono)), 0 ,SUM(abono))   AS total_abonado							FROM							abonos							GROUP BY tarjeta							) as t_abonado							USING(tarjeta)							WHERE fecha_venta BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')							AND STR_TO_DATE('$fecha_final', '%d/%m/%Y') ";														if($sector != "TODOS"){								$query_reporte.= " AND sector = '$sector'";							}							if($clave_vendedor != "TODOS"){								$query_reporte.= " AND clave_vendedor = '$clave_vendedor' ";							}							if($tipo_articulo != "TODOS"){								$query_reporte.= " AND tipo_articulo = '$tipo_articulo' ";							}							if($dia_semana != ''){								$query_reporte.= " AND dia_cobranza = '$dia_semana' ";							}							if($_GET["cobrador"] != ''){								$query_reporte.= " AND cobrador = '{$_GET["cobrador"]}' ";							}							if($tipo_venta != ''){								$query_reporte.= " AND tipo_venta = '$tipo_venta' ";							}														$query_reporte.= " ORDER BY tarjeta ";														$result_abonos=mysqli_query($link, $query_reporte) or die("Error en: $query_reporte  ".mysqli_error($link));														$sum_importes = array();							$sum_enganches = array();							$sum_saldo = array();							//$str = '24/12/2013';							$date = DateTime::createFromFormat('d/m/Y', $fecha_inicial);							$date->format('Y-m-d'); // => 2013-12-24							// $semana_inicial = date("W" , strtotime"03/08/2018");							echo console_log($date->format('W'), "Semana Inicial");							// $semana_inicial = date("W" , strtotime("2018-08-03"));							// echo console_log($semana_inicial, "Semana Inicial");														while($row = mysqli_fetch_assoc($result_abonos)){																$tarjeta = $row["tarjeta"];								$referencias = $row["referencias"];								$nv = $row["nv"];								$fecha_venta = date("d/m/Y", strtotime($row["fecha_venta"]));								$fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]));								$nombre_cliente =  $row["nombre_cliente"]; 								$direccion =  $row["direccion"]; 								$dia_cobranza =  $row["dia_cobranza"]; 								$cobrador =  $row["cobrador"]; 								$clave_vendedor =  $row["clave_vendedor"]; 								$sector = $row["sector"]; 								$articulo = $row["articulo"]; 								$tipo_articulo = $row["tipo_articulo"]; 								$importe = $row["importe"]; 								$enganche = $row["enganche"]; 								$saldo_calculado = $row["saldo_calculado"]; 								$abono_semanal = $row["cantidad_abono"]; 																$sum_importes[] = $row["importe"];								$sum_enganches[] = $row["enganche"];								$sum_saldo[] = $row["saldo_calculado"];															?>							<tr class="<?php echo $row["id_estatus"]== '10' ? 'rojo' : ''?>">								<td>									<?php echo "$fecha_venta";?>								</td>																<td>									<a class="h4" target="_blank" href="buscar_tarjeta.php?tarjeta=<?php echo "$tarjeta";?>" >										<b><?php echo "$tarjeta";?> </b>										<a/>									</td>									<td>										<?php echo "$nv";?>									</td>									<td>										<?php echo "$nombre_cliente<br> {$row['telefono']} " ;?>									</td>									<td>										<?php echo "$direccion</br></br>";?>										<?php echo $row["id_estatus"]== '10' ? '<i><b>DEVOLUCION</b></i><br>' : ''?>										<?php echo "<b>Ref: $referencias</b>";?> 									</td>									<td>										<?php echo "$sector";?>									</td>									<td> 										<?php echo  "$articulo <br>(".$tipo_articulo .")<br>";?>										<?php 										echo "<span class='".$colores[$row_tipo["tipo_venta"]]."'>".$row["tipo_venta"]."</span>";?>																			</td>																		<td>										<?php echo "$ $importe";?>									</td>									<td>										<?php echo "$ $enganche";?>									</td>									<td>										<?php echo "$ $saldo_calculado";?>									</td>									<td>										<?php echo "$". number_format($abono_semanal);?>									</td>									<td>										<?php echo "$clave_vendedor";?>									</td>									<td>										<?php echo "$cobrador";?>									</td>									<td CLASS="dia_cobranza <?PHP ECHO $dia_cobranza;?>">										<?php echo "$dia_cobranza";?>									</td>																	</tr>								<?php																	}							?>							<tr>									<td>-</td>								<td>-</td>								<td>-</td>								<td>-</td>								<td>-</td>								<td>-</td>								<td>-</td>																<td>									<b><?php echo  number_format(array_sum($sum_importes),2);?></b>								</td>								<td>									<b><?php echo  number_format(array_sum($sum_enganches),2);?></b>								</td>								<td>									<b><?php echo  number_format(array_sum($sum_saldo),2);?></b>								</td>								<td>-</td>								<td>-</td>								<td>-</td>								<td>-</td>							</tr>													</tbody>					</table>					<?php					}				?>								<div class="row">					<div class="col-xs-6">						<?php 														$q_vendedores = "SELECT 							clave_vendedor,							SUM(importe) as acumulado,							COUNT(tarjeta) as num_ventas 							FROM							ventas														WHERE DATE(fecha_venta) BETWEEN STR_TO_DATE('$fecha_inicial', '%d/%m/%Y')							AND STR_TO_DATE('$fecha_final', '%d/%m/%Y')														";														if($_GET["sector"] != "TODOS"){								$query_reporte.= " AND sector = '{$_GET["sector"]}'";							}							if($_GET["clave_vendedor"] != "TODOS"){								$query_reporte.= " AND clave_vendedor = '{$_GET["clave_vendedor"]}' ";							}							if($_GET["tipo_articulo"] != "TODOS"){								$query_reporte.= " AND tipo_articulo = '{$_GET["tipo_articulo"]}' ";							}							if($_GET["dia_semana"] != ''){								$query_reporte.= " AND dia_cobranza = '{$_GET["dia_semana"]}' ";							}							if($_GET["cobrador"] != ''){								$query_reporte.= " AND cobrador = '{$_GET["cobrador"]}' ";							}							if($_GET["tipo_venta"] != ''){								$query_reporte.= " AND tipo_venta = '{$_GET["tipo_venta"]}' ";							}														$q_vendedores.= "							GROUP BY clave_vendedor							ORDER BY clave_vendedor";																					$result_vendedores=mysqli_query($link , $q_vendedores) or die("Error en: $q_vendedores  ".mysqli_error($link));														$num_rows = mysqli_num_rows($result_vendedores);							if($num_rows == 0){								echo "<div class='titulo'>No hay registros </div>"; 								}else{															?>							<table border="1" id="tabla_reporte" class="table tabla3">								<thead>									<th>Vendedor</th>									<th>Acumulado</th>									<th># Ventas</th>								</thead>								<tbody>																		<?php																				$sum_abonos = array();																				while($row = mysqli_fetch_assoc($result_vendedores)){											$clave_vendedor = $row["clave_vendedor"];											$acumulado = $row["acumulado"] ;											$sum_abonos[] = $acumulado;											$sum_ventas[] = $row["num_ventas"];										?>										<tr>											<td>												<?php echo $clave_vendedor;?>											</td>											<td>												<?php echo number_format($acumulado, 2);?>											</td>											<td>												<?php echo $row["num_ventas"];?>											</td>										</tr>										<?php										}									?>									<tr>											<td></td>										<td>											<b><?php echo  "$ ".number_format(array_sum($sum_abonos),2);?></b>										</td>										<td>											<b><?php echo array_sum($sum_ventas);?></b>										</td>									</tr>								</tbody>									</table>														<?php							}						?>											</div>					<div class="col-xs-6">						<table border="1" id="tabla_reporte" class="table tabla3">							<thead>								<th>DIA </th>								<th># Ventas</th>							</thead>							<tbody>																<?php																		$total_ventas = 0;									foreach($ventas_por_dia AS $i => $fila){										$total_ventas+= $fila["cant_ventas"];									?>									<tr>										<td>											<?php echo $fila["dia_cobranza"];?>										</td>										<td>											<?php echo $fila["cant_ventas"];?>										</td>									</tr>									<?php									}								?>							</tbody>									<tfoot>									<tr>																					<td>										<b>TOTAL:</b>										</td>										<td>											<b><?php echo $total_ventas;?></b>										</td>									</tr>							</tfoot>								</table>					</div>				</div>			</div>			<pre hidden>				<?php print_r($cons_ventas_por_dia)?>			</pre> 									<?php include("scripts.php");?>						<script>				$( document ).ready(function() {					$(".btn_exportar").click(function(){												$('#tabla_reporte').tableExport(						{							type:'excel',							tableName:'Ventas',							escape:'false'						});					});				}); 			</script>					</body>	</html>																		