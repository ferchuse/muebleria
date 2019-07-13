<?php
	include("login/login_success.php"); // inicia variables de sesion
	$menu_activo="almacen";
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Almacenes</title>
    
	<?php include("styles.php");?>
	
</head>
<body>
<div class="container-fluid">
	<?php include("header.php");?>
	<hr>
	<div class="row" >
		<div class="col-md-2">
				<h4>
					Lista de Almacenes
				</h4>
		</div>
		<div class="col-md-1">
			<button id="btn_insert" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal_doctor">
				<i class="fa fa-plus"></i> Agregar
			</button>
		</div>
	</div>
	<hr>
	<div class="row" >
		<div class="col-md-3" id="div_almacenes">
			<table class="table table-condensed table-hover table-bordered" data-modal="#modal_form" data-form="#form_insert" data-tabla="almacenes" data-id_field="id_almacen">
				<thead>
					<tr>
						<th>ID</th>
						<th>Descripción</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="tbody">
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<div id="modal_form" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Nuevo Almacen</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" id="form_insert" data-table_name="almacenes" data-id_field="id_almacen">
							<input id="action" value="insert" class="hide"  type="text">
							<div class="form-group">
								<label class="col-md-4 control-label" for="id_almacen">Id:</label>  
								<div class="col-md-4">
								<input id="id_almacen" name="id_almacen" placeholder=""  readonly class="form-control" type="number">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="textinput">Descripción:</label>  
								<div class="col-md-8">
									<input id="descripcion_almacen" name="descripcion_almacen" placeholder="" required class="form-control input-md" type="text">
								</div>
							</div>
							<div class="modal-footer">
									<button id="cerrar" type="button" data-dismiss="modal" class="btn btn-danger ">
										<i class="fa fa-times"> </i> Cancelar
									</button> 
									<button type="submit" id="guardar"  class="btn btn-success">
											<i class="fa fa-check"> </i> Guardar <i class="fa fa-spinner fa-spin hide"> </i>
									</button>
							</div>
						</form>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
	<?php include("scripts.php");?>
	<script src="js/almacenes.js"></script>
  </body>
</html>