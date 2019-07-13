<?php

include("../conexi.php"); // inicia variables de sesion
$link = Conectarse();


$query_tipo = "SELECT *  FROM productos_categorias ";
$result_tipo = mysqli_query($link, $query_tipo )
or die("Error al ejecutar $query_tipo: $query_tipo".mysqli_error($link));

$q_tipo_precio = "SELECT *  FROM tipo_precio ";
$result_tipo_precio = mysqli_query($link, $q_tipo_precio )
or die("Error al ejecutar $q_tipo_precio: $q_tipo_precio".mysqli_error($link));

/* $query_unidades = "SELECT *  FROM catalogo_unidades WHERE Activo =1";
$result_unidades = mysqli_query($link, $query_unidades )
or die("Error al ejecutar $query_unidades: $query_unidades".mysqli_error($link));
 */
$query_prov = "SELECT *  FROM proveedores ";
$result_proveedores = mysqli_query($link, $query_prov)
or die("Error al ejecutar $query_prov: $query_prov".mysqli_error($link));


$query_articulo = "SELECT *  FROM productos WHERE id_articulo =". $_GET["id_articulo"] ;
$result_articulo = mysqli_query($link, $query_articulo)
or die("Error al ejecutar $query_articulo".mysqli_error($link));

$fila_articulo = mysqli_fetch_assoc($result_articulo);
?>
<form class="form" id="form_nuevo_articulo"   data-id_field="<?php echo $id_field;?>" data-tabla="<?php echo $table_name?>">
<fieldset>

	<div class="col-sm-6 ">
		<legend>Generales</legend>
	
		<input type="number" id="id_articulo" class="hide" name="id_articulo" value="<?php echo $fila_articulo["id_articulo"]?>">
		<input  id="action" name="action" class="hidden" >
		
		
		<div class="form-group">
				<label class="col-md-4 control-label" for="codigo_barras">Código:</label>
					<input type="text" id="codigo_barras" name="codigo_barras" class="form-control" value="<?php echo $fila_articulo["codigo_barras"]?>">
			
		</div>
		<div class="form-group">
			<label class=" control-label" for="selectbasic">Categoria:</label>
			
				<select id="id_categoria" name="id_categoria" required class="form-control">
					<option value="">Elige...</option>
					<?php 
					while($fila = mysqli_fetch_assoc($result_tipo)){?>
						
						<option value="<?php echo $fila["id_categoria"];?>"><?php echo $fila["categoria"];?></option>
					<?php 	
					}
					?>
				</select>
			
		</div>
		<div class="form-group">
			<label class="control-label" for="descripcion">Descripción:</label>  
			<input id="descripcion" name="descripcion" placeholder="" required class="form-control input-md" type="text">
		</div>
		
		<div class="col-sm-6">
		
				<legend>Inventario</legend>
		
				<div class="form-group">
					<label class="control-label" for="">Mínimo:</label>  
					<input id="minimo" name="minimo"  class="form-control" type="number" value="1">
				</div>
				
				<div class="form-group">
					<label class="control-label" for="">Máximo:</label>  
					<input id="maximo" name="maximo" class="form-control" type="number" value="20">
				</div>
			
			</div>
			<div class="col-sm-4" id="div_existencias">
				
			</div>
		
	</div>

	<div class="col-sm-6">
		<legend>Precios </legend>
		
		<div class="form-group">
			<label for="">Costo Compra:</label>   
				<input id="costo_compra" name="costo_compra" placeholder="" required class="form-control" step="any" type="number">
		</div> 
		<div class="text-center col-sm-6 ">
			<label for="">% Ganancia:</label>   
				
		</div> 
		<div class="text-center form-group col-sm-6">
			<label for="">Precio:</label>   
			
		</div> 
		<?php 
		while($fila = mysqli_fetch_assoc($result_tipo_precio)){?>
			<div class="row">
				<div class="form-group col-sm-6"> 
					<label for=""><?php echo $fila["nombre_precio"];?>:</label>  
					<input name="id_tipo_precio[]" value="<?php echo $fila["id_tipo_precio"];?>" class="hidden">	
					<input name="porc_ganancia[]" value="<?php echo $fila["porc_default"];?>" required class="form-control porc_ganancia" step="any" type="number">	
				</div>	
				<div class="form-group col-sm-6">
					<label class="" for="">$
						<span class="pull-right">
							<button type="button" class="btn-danger btn btn-sm hidden">
								<i class="fa fa-times"></i>
							</button>
						</span>
					</label>  
					<input name="precio[]" value="" required class="form-control precio" step="any" type="number">	
				</div>		
			</div>			
		<?php 	
		}
		?>
		
		
	</div>


	<div class="form-group">
		<label class="col-md-8 control-label" for="button1id"></label>
		<div class="col-md-4">
			<button id="salir" type="button" data-dismiss="modal" name="salir" class="btn btn-danger btn-lg">
				<i class="fa fa-times"></i> Cancelar
			</button>
			<button id="guardar" name="guardar" type="submit" class="btn btn-success btn-lg"> 
				<i class="fa fa-save"></i> Guardar 
			</button>
		</div>
	</div>

</fieldset>
</form>
	