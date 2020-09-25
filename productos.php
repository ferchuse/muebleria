<?php
	include("login/login_success.php"); // inicia variables de sesion
	$menu_activo = "almacen";
	include("conexi.php"); 
	$link = Conectarse();
	
	$table_name = "productos";
	$id_field = "id_articulo";
	
	$query_tipo = "SELECT *  FROM productos_categorias ";
	$result_tipo = mysqli_query($link, $query_tipo )
	or die("Error al ejecutar $query_tipo: $query_tipo".mysqli_error($link));
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lista de Artículos</title>
		<?php include("styles.php");?>
		<link href="fileupload/fileupload.css" rel='stylesheet' type='text/css'>
	 
	</head>
	<body>
		<div class="container-fluid">
			<?php include("header.php");?>
			<div class="row" >
				<div class="col-md-2 etiqueta">
					<h4>
						Lista de Artículos <i id="cargador" class="fa fa-spinner fa-spin hidden"></i>
					</h4>
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-success pull-right insertar_fila"  data-modal="#modal_nuevo_articulo" data-nombre_tabla="articulos">
						<i class="fa fa-plus"></i> Nuevo
					</button>
				</div>
				<div class="col-md-7 ">
					<form class="form-inline" id="form_filtros">
						<div class="form-group hidden">
							<label class="etiqueta" for="id_almacen">
								Almacén: 
							</label>
							<?php
								$query_almacen = "SELECT *  FROM almacenes";
								$result_almacen = mysqli_query($link, $query_almacen )
								or die("Error al ejecutar $query_almacen: $query_almacen".mysqli_error($link));
							?>
							<select class="form-control" name="id_almacen" id="id_almacen">
								<option value="TODOS">TODOS</option>
								<?php 
									while($fila = mysqli_fetch_assoc($result_almacen)){?>
									<option value="<?php echo $fila["id_almacen"];?>"><?php echo $fila["descripcion_almacen"];?></option>
									<?php 	
									}
								?>
							</select>
						</div>
						<div class="form-group etiqueta hidden">
							<label for="id_almacen">
								Existencia: 
							</label>
							<select class="form-control" name="existencia" >
								<option value="">Elige...</option>
								<option value=">0">Mayor a 0</option>
							</select>
						</div>
						<div class="form-group etiqueta">
							<label for="id_almacen">
								Categoria: 
							</label>
							<select id="filtro_id_categoria" name="id_categoria" required class="form-control filtro_select" data-campo_filtro="id_categoria">
								<option value="">TODAS</option>
								<?php 
									while($fila = mysqli_fetch_assoc($result_tipo)){?>
									
									<option value="<?php echo $fila["id_categoria"];?>"><?php echo $fila["categoria"];?></option>
									<?php 	
									}
								?>
							</select>
						</div>
					</form>
					
				</div>
				<div class="col-md-2  ">
					<button type="submit" class="btn btn-sm btn-info pull-right " form="form_seleccionados" >
						<i class="fa fa-print"></i> Imprimir
					</button> 
					<button type="button" class="btn btn-sm btn-default pull-right btn_exportar" >
					<i class="fa fa-arrow-right"></i> Exportar
					</button> 
				</div>
				<div class="col-md-4 hide ">
					<ul class="pagination pull-right">
						<li>
							<a href="#">Anterior</a>
						</li>
						<li>
							<a href="#">1</a>
						</li>
						<li>
							<a href="#">Siguiente</a>
						</li>
					</ul> 
				</div>
			</div>
			<hr> 
			
			<form target="_blank" action="productos/imprimir_producto.php" id="form_seleccionados">
				<input  type="hidden" id="seleccionados" name="codigos" >
			</form>
			<div class="row" >
				<div class="col-md-12 table-responsive" >
					<table id="tabla_reporte" class="table table-condensed table-hover table-bordered" data-modal="#modal_nuevo_articulo" data-form="#form_nuevo_articulo" data-tabla="<?php echo $table_name ?>" data-id_field="<?php echo $id_field; ?>" >
						<!-- Tabla de Articulos-->
						<thead>
							<tr>
								<th></th>
								<th>Código</th>
								<th>Descripción</th>
								<th>Categoria</th>
								<th>Costo Compra</th>
								<?php
									$q_precios = "SELECT * FROM tipo_precio ORDER BY orden";
									
									$result_precios = mysqli_query($link, $q_precios) or die(mysqli_error($link));
									
									if($result_precios){
										while($fila_precios = mysqli_fetch_assoc($result_precios)){ ?>
										<th><?php echo $fila_precios["nombre_precio"];?></th>
										<?php
										}
									}
									else{
										echo mysqli_error($link);
									}
								?>
								<th>Existe</th>
								<th></th>
							</tr>
							
							<tr>
								<th><input type="checkbox" id="check_all"></th>
								<th>
									<input type="search" placeholder="Escribe para Buscar" class="filtro_buscar form-control" data-campo_filtro="id_articulo" >
								</th>
								<th>
									<input type="search" placeholder="Escribe para Buscar" class="filtro_buscar form-control" data-campo_filtro="descripcion" >
								</th>
								<th>
									
								</th>
								<th>
								</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody id="tbody">
						</tbody> 
					</table>
				</div>
			</div>
		</div>
		<div id="modal_nuevo_articulo" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Nuevo Articulo</h4>
					</div>
					<div class="modal-body"> 
						
						<?php include("productos/form_producto.php")?>
						
					</div>
				</div>
			</div> 
		</div>
		
		<?php include("scripts.php");?>
		<script src="fileupload/jquery.ui.widget.js"></script>
		<script src="fileupload/jquery.fileupload.js"></script>
		<script src="fileupload/file_upload.js"></script>
		<script src="productos/productos.js?v=<?= date("d.mYhi")?>"></script>
	</body>
</html>