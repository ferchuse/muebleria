<?php
	include("login/login_success.php");
	include("control/conexi.php");
	$link = Conectarse();
	$menu_activo = "almacen";
	$action = isset($_GET["action"]) ? $_GET["action"] : "agregar";
	
	
	if($action == "editar"){
		$tabla_detalle = array();
		$tabla_totales = array();
		$id_compra =$_GET["id_compras"];
		$query_compra = 
		"SELECT * FROM compras 
		
		WHERE id_compras = '$id_compra'";
		$result_compra = mysqli_query($link, $query_compra) ;
		if(!$result_compra){
			$error = "Error al ejecutar $query_compra". mysqli_error($link);
		}
		$folio_existe = mysqli_num_rows($result_compra);
		while($row = mysqli_fetch_assoc($result_compra)){
			$fila_compra = $row;
			$fila_json = json_encode($fila_compra);
			
		}
		
		$query_detalle = 
		"SELECT
			*
		FROM
			compras_detalle
		
		WHERE
			id_compra = '$id_compra'";
		$result_detalle = mysqli_query($link, $query_detalle) ;
		if(!$result_detalle){
			$error = "Error al ejecutar $query_detalle". mysqli_error($link);
		}
		while($row = mysqli_fetch_assoc($result_detalle)){
			$tabla_detalle[] = $row;
		}
		
		$query_totales = "SELECT articulos, subtotal, iva	, importe_total
			FROM compras WHERE id_compra = '$id_compra'";
		
		$result_totales = mysqli_query($link, $query_totales) ;
		if(!$result_totales){
			$error = "Error al ejecutar $query_totales". mysqli_error($link);
		}
		while($row = mysqli_fetch_assoc($result_totales)){
			$tabla_totales = $row;
		}
		
		$query_abonos = "SELECT * FROM abonos_compras
			WHERE id_compra = '$id_compra'";
		$result_abonos = mysqli_query($link, $query_abonos) ;
		if(!$result_abonos){
			$error = "Error al ejecutar $query_abonos". mysqli_error($link);
		}
		while($row = mysqli_fetch_assoc($result_abonos)){
			$tabla_abonos[] = $row;
		}
		
		if($fila_compra["estatus_compra"] == "PENDIENTE"){
			$alert_class = "alert-warning";
		}
		elseif($fila_compra["estatus_compra"] == "LIQUIDADA"){
				$alert_class = "alert-success";
		}
		elseif($fila_compra["estatus_compra"] == "CANCELADA"){
			$alert_class = "alert-danger";
		}
			
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php if($action == "editar"){ ?>
			<title>Editar Compra</title>
		<?php 	
		}
		else{ ?>
			<title >Nueva Compra</title>
		<?php 		
		}
		
		?>
    

	<?php include("styles.php");?>
	
  </head>
  <body>

   <div class="container-fluid">
		<?php include("header.php");?>
		
		<div class="row hidden-print" id="contenido">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-2">
						 <h4 class="etiqueta">	
						 <?php echo $action == "editar" ?  "Editar Compra":  "Nueva Compra"; ?>
						 </h4>
					</div>
					<div class="col-sm-10 ">
						<div class="btn-group  botonera pull-right">
							<a class="btn btn-primary" href="compras_nueva.php" id="btn_nueva"> 
								<i class="fa fa-plus"></i> Nueva
							</a> 
							<button disabled class="btn btn-success" type="button" id="btn_guardar"> 
								<i class="fa fa-floppy-o"></i> Guardar
							</button> 
							<?php 
							if($action == "editar"){
								if($fila_compra["estatus_compra"] == "PENDIENTE"){
									
									
								}	
								if($fila_compra["estatus_compra"] == "LIQUIDADA"){
									
									
								}
							}
							
							?>
						
							<button disabled class="btn btn-info hide" type="button">
								<em class="glyphicon glyphicon-print"></em> Imprimir
							</button>
							<button disabled class="btn btn-danger hide" type="button">
								<em class="glyphicon glyphicon-remove"></em> Cancelar
							</button> 
							
						</div>
					</div>
					
				</div>
			
			<form class="form-horizontal" id="form_compra">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="col-sm-5">
								<fieldset>
								<div class="form-group">
								 <input type="hidden" id="action" value="<?php echo $action;?>">
								 <?php
								 if ($action == "editar"){ ?> 
									<input type="hidden" id="fila_json" value='<?php echo $fila_json;?>'>
									<input type="hidden" id="tabla_detalle" value='<?php echo json_encode($tabla_detalle);?>'>
									<input type="hidden" id="tabla_totales" value='<?php echo json_encode($tabla_totales);?>'>
								 <?php
								 }
								 ?>
								  <label class="col-md-4 control-label" for="id_compra">Folio Compra:</label>  
								  <div class="col-md-4">
									<input id="id_compra" readonly name="id_compra" placeholder="" class="form-control input-md" required type="number" value="<?php echo $action == "editar" ?  $id_compra:  ""; ?>">
								  
								  </div>
								  <div class="col-md-1">
									<span><i id="cargar_folio" class="fa fa-spin fa-2x fa-spinner hide"></i></span>
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-md-4 control-label" for="fecha_elab_compra">Fecha: </label>  
								  <div class="col-md-4">
									<input id="fecha_elab_compra" name="fecha_elab_compra" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $action == "editar" ?  date("d/m/Y", strtotime($fila_compra["fecha_elab_compra"])):  date("d/m/Y"); ?> " readonly>
								  </div>
								</div>

								<div class="form-group">
								  <label class="col-md-4 control-label" for="hora_elab_compra">Hora:</label>  
								  <div class="col-md-4">
									<input id="hora_elab_compra" name="hora_elab_compra" placeholder="" class="form-control input-md" required="" type="text"  value="<?php echo $action == "editar" ?  $fila_compra["hora_elab_compra"]:  date("H:i:s"); ?> " readonly>
								  </div>
								</div>
								
								</fieldset>
								
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								  <label class="col-md-4 control-label" for="usuario">Usuario:</label>  
								  <div class="col-md-6">
									<input  name="usuario" placeholder="" class="form-control input-md" required="" type="text" value="<?php echo $_SESSION["usuario"];?>" readonly>
								  </div>
								</div>
									<div class="form-group">
								  <label class="col-md-4 control-label" for="nombre_proveedor"> <i class="fa fa-user"></i> 
											Proveedor
									</label>
								  <div class="col-md-8">
									<input id="id_proveedor" name="id_proveedor"  type="hidden" value="<?php echo $action == "editar" ?  $fila_compra["IdProveedor"]:  "1"; ?>">
									<input id="nombre_proveedor" name="nombre_proveedor" placeholder="Buscar por Nombre" class="form-control input-md click_to_select" type="search" value="<?php echo $action == "editar" ?  $fila_compra["Proveedor"]:  ""; ?> " >
								  </div>
								 
								</div>
								<div class="form-group">
								  <label class="col-md-4 control-label" for="obs_compra">Observaciones</label>  
								  <div class="col-md-8">
								  <input id="obs_compra" name="obs_compra" placeholder="" class="form-control input-md" type="text">
									
								  </div>
								</div>
								
								</fieldset>
							</div>
							
							
							<div id="estatus_pago" class="col-sm-3 ">
								
								<div class="<?php echo $action == "agregar" ? "hide" : "";?> alert alert-success alert-block text-center">
									<h4><?php echo $fila_compra["estatus_compra"];?></h4>
								</div>
							</div>
							
							<div id="estatus_entrada" class="col-sm-3 <?php ?>">
								<div class="<?php echo $action == "agregar" ? "hide" : "";?>  alert alert-warning alert-block text-center">
									<h4>
										<?php echo $fila_compra["ingreso"] == 1 ? "INGRESO" : "";?>
									</h4>
								</div>
							</div>
							<button type="submit" id="submit_compra" class="hide"></button>
						</div>
					</div>
				</div>
			</div>
			</form>
			<div class="panel panel-primary panel_agregar_articulo">
				<div class="panel-body">		
					<div class="row">
						<div class="col-sm-12">
							<form class="form form-horizontal " id="form_agregar_articulo">	
								<input id="id_articulo" name="id_articulo" type="hidden">
								<input id="importe_articulo" name="importe_articulo"   type="hidden">
								<input id="costo_unitario" name="costo_unitario"   type="hidden">
								<div class=" col-sm-2">				
									<input type="number" min="1" id="cant_articulo"  required name="cantidad" placeholder="Cantidad" class="form-control numbers_only" value="1">
								</div>	
								<div class="col-sm-3">
									<div class="input-group">
											<span  class="input-group-addon"><i class="fa fa-barcode"></i></span>
											<input id="codigo_articulo" name="codigo_articulo" placeholder="Escanear Código" class="form-control col-sm-2 numbers_only" type="text">
										</div>
								</div>	
								<div class="col-sm-3">
									<input id="descr_articulo" name="descr_articulo" placeholder="Buscar por Descripción " class="form-control   col-sm-2" required="" type="text">
								</div>
								<div class="col-sm-1">
									<button type="submit" id="btn_agregar_articulo" class="btn btn-success" >
										<i class="fa fa-plus"></i> Agregar
									</button>
								</div>
							</form>
							
						</div>
					</div>
				</div>
		</div>
					
					
					
					<div class="row">
						<div class="col-sm-12 " >
							<div class="panel panel-primary" >
								<div class="panel-body" id="compras_detalle" >
									<table class="table table-condensed table-hover table-bordered" >
										<thead>
											<tr>
												<tr>
													<th>Cantidad</th>
													<th>Descripción</th>
													<th>Modelo</th>
													<th>Categoria </th>
													<th>Unidad </th>
													<th>Costo U. </th>
													<th>Importe </th>
													<th>Eliminar </th>
												</tr>
											</tr>	
											
										</thead>
											<tbody id="tbody_detalle">
											</tbody>
											<tbody>
											
											</tbody>
									</table>
								</div>
							</div>
						</div>
					</div><!-- row-->
				

		</div>
	</div>
	
	<div class="row" id="ticket">
	</div>



<div id="modal_liquidar" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content hidden-print">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Pago de Nota de compra</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						
						<?php include("form_liquidar.php");?>
								
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
<div id="modal_abonos" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content hidden-print">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Abonar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						
						<?php include("form_abono.php");?>
								
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>

	
	<?php include("scripts.php");?>
	<script src="js/compras_nueva.js"></script>
	
  </body>
</html>