<?php
	include("login/login_success.php"); // inicia variables de sesion
	$menu_activo = "almacen";
	include("conexi.php");
	$link=Conectarse();
	
	?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>	Lista de Compras</title>

 
<?php include("styles.php");?>

</head>
<body>

	<div class="container-fluid">
		<?php include("header.php");?>
		
		<div class="row" >
			<div class="col-sm-2">
				<h4 class="etiqueta">
					Lista de Compras	
				</h4>
			</div>
			<div class="col-sm-2">
					<a href="compras_nueva.php" class="btn btn-success  insertar_fila "  >
							<i class="fa fa-plus"></i> Agregar
					</a>
			</div>
		</div>
		<div class="row" >
			<div class="col-sm-12">
					 <table class="table table-condensed table-hover table-bordered" id="compras"  data-tabla="compras" data-id_field="id_compra"  >
						<thead>
							<tr>
								<th>Folio Compra</th>
								<th>Fecha Elaboración</th>
								<th>Total </th>
								<th>Editar </th>
							</tr>
						
						</thead>
						<tbody>
						
						</tbody>
					</table>
				</div>
			</div>
	</div>
	
	
	<div id="modal_recibir" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Recibir Compra</h4>
				</div>
				<div class="modal-body"> 
					<div class="row">
						<div class="col-md-12">
							<form id="form_recibe_compra">
								<div class="form-group">
									<label for="fecha_factura">Folio Compra: </label>
									<input type="number" class="form-control" name="id_compra"  id="id_compra" readonly>
								</div>
								<div class="form-group">
									<label for="fecha_factura">Fecha de la Factura: </label>
									<input type="text" class="form-control fecha" name="fecha_factura"name="fecha_factura" required/>
								</div>
								<div class="form-group">
									<label for="folio_factura">Folio de la Factura: </label>
									<input type="text" class="form-control" name="folio_factura"name="folio_factura" required/>
								</div>
								<div class="form-group">
									<label for="id_almacen">Almacén: </label>
									<?php
										$query_almacen = "SELECT *  FROM almacenes";
										$result_almacen = mysqli_query($link, $query_almacen )
											or die("Error al ejecutar $query_almacen: $query_almacen".mysqli_error($link));
										?>
										<select class="form-control" required name="id_almacen" id="id_almacen">
											<option value="">Elige...</option>
												<?php 
												while($fila = mysqli_fetch_assoc($result_almacen)){?>
													
													<option value="<?php echo $fila["id_almacen"];?>"><?php echo $fila["descripcion_almacen"];?></option>
												<?php 	
												}
												?>
										</select>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">             
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times"></i>  Cancelar
					</button>
					<button type="submit" class="btn btn-success" id="ok_nuevo_paciente" form="form_recibe_compra"> 
							<i class="fa fa-save"></i> 
							Guardar 
							<i class="fa fa-spin fa-spinner hide"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<?php include("scripts.php");?>
	<script src="js/compras.js"></script>
	
  </body>
</html>