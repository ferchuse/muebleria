<?php
	include("login/login_success.php");
	include("funciones/generar_select.php");
	include("conexi.php");
	$link = Conectarse();
	$menu_activo = "resumen";
	$egresos = 0;
	$totales = [];
	
	
	if(isset($_GET["fecha_ventas"])){
		$fecha_corte = $_GET["fecha_ventas"];
	}
	else{
		$fecha_corte = date("Y-m-d");
	}
	
	$consulta_turno = "SELECT * FROM turnos WHERE cerrado='0'";
	$result_turno = mysqli_query($link,$consulta_turno);
	while($row_turno = mysqli_fetch_assoc($result_turno)){
		extract($row_turno);
	}
	
	if($_GET["tipo_corte"] == "dia"){
		//Corte por dia
		$consulta_ventas = "SELECT * FROM ventas LEFT JOIN usuarios USING(id_usuarios) 
		WHERE fecha_ventas = '$fecha_corte' ORDER BY id_ventas DESC
		";	
		
		
		$consulta_totales = "SELECT * FROM
		
		(SELECT SUM(abono) AS suma_abonos
		FROM ingresos WHERE  DATE(fecha_hora_abonos) = '$fecha_corte' AS tabla_abonos,
		
		(SELECT SUM(cantidad_ingresos) AS entradas FROM ingresos WHERE estatus_ingresos='ACTIVO') AS tabla_entradas,
		(SELECT SUM(cantidad_egresos) AS salidas FROM egresos WHERE estatus_egresos='ACTIVO') AS tabla_salidas
		";
	}
	else{
		
		//Corte por turno
		$consulta_ventas = "SELECT * FROM ventas LEFT JOIN usuarios USING(id_usuarios) 
		WHERE id_turnos = '{$_COOKIE["id_turnos"]}' ORDER BY id_ventas DESC
		";	
		$consulta_totales = "SELECT * FROM
		
		(SELECT SUM(cantidad_ingresos) AS entradas FROM ingresos WHERE estatus_ingresos='ACTIVO' AND id_turnos = '{$_COOKIE["id_turnos"]}') AS tabla_entradas,
		(SELECT SUM(cantidad_egresos) AS salidas FROM egresos WHERE estatus_egresos='ACTIVO'  AND id_turnos = '{$_COOKIE["id_turnos"]}') AS tabla_salidas
		";
	}
	
	
	$resultadoVentas = mysqli_query($link,$consulta_ventas);
	$resultado_totales = mysqli_query($link,$consulta_totales) or die(mysqli_error($link));
	
	while($fila = mysqli_fetch_assoc($resultado_totales)){
		$totales= $fila;
		
	}
	
	
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/imprimir_pago.css" rel="stylesheet" media="all">
    <title>Resumen</title>
		
		<?php include("styles.php");?>
		
	</head>
  <body>
		<pre hidden>
			<?php 
				echo $consulta_totales;
				echo $consulta_ventas;
			echo var_dump($totales);?>
			
		</pre>
		<?php include("header.php");?>
		
		<div class="container-fluid hidden-print">
			<div class="row">
				
				<h4 class="text-center">
					
					Resumen del día <?php echo date("d/m/Y", strtotime($fecha_corte));?>
				</h4>
				<div class="col-md-6"> 
					<?php 	if ($_COOKIE["permiso_usuarios"] == "administrador") {?>
						<form class="form-inline" id="form_resumen">
							
							<div class="form-group">
								<label>Fecha: </label>
								<input type="date" class="form-control" value="<?php echo $fecha_corte;?>" name="fecha_ventas" id="fecha_ventas">
							</div>
							<div class="form-group">
								<label>Turno: </label>
								<input 
								type="number" 
								class="form-control" 
								value="<?php echo $_COOKIE["id_turnos"];?>" 
								name="id_turnos" 
								id="id_turnos" 
								<?php echo $_COOKIE["permiso_usuarios"] == "administrador" ? "": "readonly";?> 
								>
							</div>
						</form>
						<?php
						}
					?>
				</div>
				<div class="col-md-6 text-right hidden-print">
					<button class="btn btn-primary"  id="btn_ingreso">
						<i class="fa fa-arrow-right"></i> Entrada de Dinero
					</button>
					<button class="btn btn-warning"  id="btn_egreso">
						<i class="fa fa-arrow-left"></i> Egreso
					</button>
					
					<button class="btn btn-info" type="button" title="Imprimir Corte" id="btn_resumen">
						<i class="fa fa-print"></i>
						Imprimir Corte
					</button>
					
					<form>
						<button  class="btn btn-default hidden-print" type="submit" title="Corte de Cajero" name="tipo_corte" value="cajero">
							<i class="fas fa-cut"></i> Corte de Cajero
						</button>
						<button  class="btn btn-secondary hidden-print" type="submit" title="Corte del Dia" name="tipo_corte" value="dia">
							<i class="fas fa-cut"></i> Corte del Dia
						</button>
						<button class="btn btn-success " type="button" title="Cerrar Turno" id="btn_cerrar_turno">
							<i class="fa fa-history"> </i> 
							Cerrar Turno
						</button>
					</form>
				</div>
			</div>
			<hr>
			
			<form class="" id="lista_egresos">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-primary hidden-print"  id="head_ingresos">
							<div class="panel-heading text-center">
								Ingresos
							</div>
							<div style="height: 350px; overflow: auto;" class="panel-body" id="panel_ingresos">
								<div class="row">
									<div class="col-xs-2"> Folio</div>
									<div class="col-xs-2"> Hora</div>
									<div class="col-xs-2"> Total</div>
									<div class="col-xs-2"> Estatus</div>
									<div class="col-xs-4 hidden-xs"> Acciones</div>
								</div>
								
								<?php
									$total = 0;
									$tarjeta= 0;
									$total_efectivo= 0;
									
									while($row_ventas = mysqli_fetch_assoc($resultadoVentas)){
										extract($row_ventas);		
										switch($estatus_ventas){
											
											case 'CANCELADO':
											$fondo = "bg-danger";
											break;
											
											case 'PENDIENTE':
											$fondo = "bg-warning";
											break;
											
											case 'PAGADO':
											$fondo = "bg-success";
											$total_efectivo+= $efectivo;
											$total_tarjeta+= $tarjeta;	
											$total+= $total_ventas;
											break;
										}
										
									?>
									<div class="row <?php echo $fondo;?> focusable" style="border-bottom: solid 1px; margin-bottom: 10px;">
										<div class="col-xs-2"><?php echo $id_ventas;?></div>
										<div class="col-xs-2 text-center"><?php echo date("h:i", strtotime($hora_ventas));?></div>
										<div class="col-xs-2 text-right"><?php echo "$".$total_ventas ?></div>
										<div class="col-xs-2 text-center"><?php echo $estatus_ventas;?></div>
										<div class="col-xs-12 col-sm-4 text-right">
											
											<?php 
												if($estatus_ventas != "PENDIENTE" ) {
												?>
												<button class="btn btn-info btn_ticketPago" title="Reimprimir Ticket"  type="button"  data-id_ventas="<?php echo $id_ventas;?>">
													<i class="fa fa-print"></i>
												</button>
												<button type="button" title="Ver Ticket"  class="btn btn-success btn_ver" data-id_ventas="<?php echo $id_ventas;?>">
													<i class="fas fa-eye"></i>
												</button>
												
												<?php 
												}
											?>
											<?php 
												if($_COOKIE["permiso_usuarios"] == "administrador"  && $estatus_ventas != "CANCELADO") {
												?>
												<button class="btn btn-danger btn_cancelar " title="Cancelar Venta"  type="button"  data-id_ventas="<?php echo $id_ventas;?>">
													<i class="fa fa-times"></i>
												</button>
												<button  class="btn btn-warning btn_devolucion hidden" title="Devolver Venta"  type="button"  data-id_ventas="<?php echo $id_ventas;?>">
													<i class="fas fa-undo"></i>
												</button>
												<?php 
												}
											?>
										</div>
									</div>
									<?php
									}
									
								?>
							</div>
							<div class="panel-footer h4">
								
								<?php
									$saldo_final = $_COOKIE["efectivo_inicial"] + $total_efectivo + $totales["entradas"] - $totales["salidas"] - $totales["devoluciones"];
								?>
								
								<div class="row no-gutters">
									<div class="col-xs-7">Fondo de Caja</div>
									<div class="col-xs-1 text-right"></div>
									<div class="col-xs-1 text-center">$</div>
									<div class="cantidad col-xs-3 text-right"><?php echo number_format($_COOKIE["efectivo_inicial"],2)?></div>
								</div>
								<div class="row no-gutters">
									<div class="col-xs-7">Ventas de Contado</div>
									<div class="text-success col-xs-1 text-center">+</div>
									<div class="text-success col-xs-1 text-center">$</div>
									<div class="cantidad text-success col-xs-3 text-right"><?php echo number_format($total_efectivo,2) ?></div>
								</div>
								<div class="row no-gutters">
									<div class="col-xs-7">Enganches</div>
									<div class="text-success col-xs-1 text-center">+</div>
									<div class="text-success col-xs-1 text-center">$</div>
									<div class="cantidad text-success col-xs-3 text-right"><?php echo number_format($total_efectivo,2) ?></div>
								</div>
								
								<div class="row no-gutters">
									<div class="col-xs-7">Abonos</div>
									<div class="text-success col-xs-1 text-center">+</div>
									<div class="text-success col-xs-1 text-center">$</div>
									<div class="cantidad text-success col-xs-3 text-right"><?php echo number_format($suma_abonos,2) ?></div>
								</div>
								
								<div class="row no-gutters">
									<div class="col-xs-7">Entradas</div>
									<div class="text-success col-xs-1 text-center">+</div>
									<div class="text-success col-xs-1 text-center">$</div>
									<div class="cantidad text-success col-xs-3 text-right"><?php echo number_format($totales["entradas"],2);?></div>
								</div>
								<div class="row no-gutters">
									<div class="col-xs-7">Salidas</div>
									<div class="text-danger col-xs-1 text-center">-</div>
									<div class="text-danger col-xs-1 text-center">$</div>
									<div class="cantidad text-danger col-xs-3 text-right"><?php echo number_format($totales["salidas"],2);?></div>
								</div>
								<div class="row no-gutters">
									<div class="col-xs-7">Devoluciones en Efectivo</div>
									<div class="text-danger col-xs-1 text-center">-</div>
									<div class="text-danger col-xs-1 text-center">$</div>
									<div class="cantidad text-danger col-xs-3 text-right"><?php echo number_format($totales["devoluciones"],2);?></div>
								</div>
								<div class="row no-gutters border border-top" >
									<div class="col-xs-7"></div>
									<div class=" col-xs-1 text-center"></div>
									<div class=" col-xs-1 text-center">$</div>
									<div class="col-xs-3 text-right" style="border-top: solid 1px;">
									<?php echo number_format($saldo_final,2);?></div>
									<input class="hidden" id="saldo_final" value="<?php echo $saldo_final?>">
									
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="col-sm-5">
						<div class="panel panel-primary hidden-print" id="head_egresos">
							<div class="panel-heading text-center">
								Egresos
							</div>
							<div style="height: 350px; overflow: auto;" class="panel-body" id="panel_egresos">
								
								<div class="row">
									<div class="col-xs-2">Hora</div>
									<div class="col-xs-2">Nombre</div>
									<div class="col-xs-2">Area</div>
									<div class="col-xs-2">Cantidad</div>
									<div class="col-xs-2">Acciones</div>
								</div>
								<?php 
									
									while($row = mysqli_fetch_assoc($resultados)){
										extract($row);
										if($estatus_egresos == 'CANCELADO'){
										?>
										
										<?php
										}
										else{ 
											
											$egresos+= $cantidad_egresos;
										?>
										<div class="row text-center">
											<div class="col-xs-2"><?php echo $hora_egresos;?></div>
											<div class="col-xs-2"><?php echo $descripcion_egresos;?></div>
											<div class="col-xs-2"><?php echo $area_egresos;?></div>
											<div class="col-xs-2"><?php echo "$".$cantidad_egresos;?></div>
											<div class="col-xs-2">
												<button class="btn btn-danger btn-cancela" data-id_egresos="<?php echo $id_egresos;?>" title="Cancelar" type="button">
													<i class="fa fa-times"></i>
												</button>
											</div>
										</div>
										<?php		
										}
									}
								?>
								
							</div>
							<div class="panel-footer">
								<h3>
									<b>TOTAL:</b>
									<?php 
										echo "<strong>" . "$". number_format($egresos, 2) . "</strong>";
									?>
								</h3>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</form>
		
		
		
		<!-- Ticket Resumen -->
		<div id="resumen" class="visible-print">
			
			<div style="margin-top: 25px;" class="container-fluid">
				
				<div class="row">
					<div class="col-xs-7"><strong>Resumen del Día:</strong></div>
					<div class="col-xs-4 text-right"><?php echo date("d/m/Y")?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Hora:</strong></div>
					<div class="col-xs-4 text-right"><?php echo date("H:i:s")?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Usuario:</strong></div>
					<div class="col-xs-4 text-right"><?php echo $_COOKIE["nombre_usuarios"];?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Número de Ventas:</strong></div>
					<div class="col-xs-4 text-right"><?php echo $num_ventas;?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Importe de Ventas:</strong></div>
					<div class="col-xs-4 text-right"><?php echo "$". number_format($ingresos, 2);?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Egresos:</strong></div>
					<div class="col-xs-4 text-right"><?php echo "$". number_format($egresos, 2);?></div>
				</div>
				<div class="row">
					<div class="col-xs-7"><strong>Total:</strong></div>
					<div class="col-xs-4 text-right"><?php echo "$". number_format($balance, 2);?></div>
				</div>
				
			</div>
			
		</div>
		
		<div id="Pago" class="visible-print">
		</div>
		
		
		<div id="ver_venta" >
		</div>
		
		
		<?php include('egresos_modal.php');?>
		
		
		<?php  include('scripts.php'); ?>
		
		
		<script>
			$.getScript('https://luke-chang.github.io/js-spatial-navigation/spatial_navigation.js', function() {
				$('.focusable')
				.SpatialNavigation()
				.focus(function() { $(this).addClass("bg-info"); })
				.blur(function() { $(this).removeClass('bg-info'); })
				
			});
		</script>
		<script src="js/resumen.js"></script>
		<script src="js/pagos.js"></script>
		<script src="js/numerosLetras.js"></script>
		<script src="js/modal_egresos.js"></script> 
		
		
	</body>
</html>																																															