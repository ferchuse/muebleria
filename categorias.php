<?php
	include "login/login_success.php";
	$menu_activo = "almacen";
	$table_name = "productos_categorias";
	$id_field = "id_categoria";
	$table_label = "Categorias";
	
	$columnas = array("ID", "Categoria");
?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title><?php echo $table_label;?></title>
	<?php include("styles.php");?>
	
</head>
<body>
<div class="container-fluid">

<?php include("header.php");?>

	<div class="row">
		<div class="col-sm-5">
			<div class="row" >
				<div class="col-md-4 titulo">
						<h4>
							Lista de <?php echo $table_label;?>
						</h4>
				</div>
				<div class="col-md-8">
					<button id="btn_insert" class="btn btn-success pull-right" >
						<i class="fa fa-plus"></i> Agregar
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="table" data-modal="#modal_form" data-form="#form_insert" data-tabla="<?php echo $table_name;?>" data-id_field="<?php echo $id_field;?>" >
						<thead>
							<th><?php echo $columnas[0];?>	</th>
							<th><?php echo $columnas[1];?>	</th>
							<th>	Acciones</th>
							
						</thead> 
						<tbody id="tbody_zonas">
						
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="modal_form" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agregar <?php echo $table_label;?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="form_insert" data-table_name="<?php echo $table_name;?>" data-id_field="<?php echo $id_field;?>">
							<input id="action" value="insert" class="hide"  type="text">
							<div class="form-group">
								<label class=" control-label" for="<?php echo $id_field;?>">ID:</label>  
								<input disabled id="<?php echo $id_field;?>" name="<?php echo $id_field;?>"  class="form-control id_field" type="text">
							</div>
							<div class="form-group">
								<label class=" control-label" for="categoria">Categoria:</label>  
								<input id="categoria" required name="categoria"  class="form-control" type="text">
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
	<script src="js/categorias.js"></script>
</body>
</html>