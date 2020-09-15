<?php
	
	$query_tipo = "SELECT *  FROM productos_categorias ";
	$result_tipo = mysqli_query($link, $query_tipo )
	or die("Error al ejecutar $query_tipo: $query_tipo".mysqli_error($link));
	
	$q_tipo_precio = "SELECT *  FROM tipo_precio ";
	$result_tipo_precio = mysqli_query($link, $q_tipo_precio )
	or die("Error al ejecutar $q_tipo_precio: $q_tipo_precio".mysqli_error($link));
	
	
	$query_prov = "SELECT *  FROM proveedores ";
	$result_proveedores = mysqli_query($link, $query_prov)
	or die("Error al ejecutar $query_prov: $query_prov".mysqli_error($link));
	
	
	
?>
<form class="form" id="form_nuevo_articulo"   data-id_field="<?php echo $id_field;?>" data-tabla="<?php echo $table_name?>">
	<fieldset>
		
		<div class="col-sm-6 ">
			<legend>Generales</legend>
			
			<input type="number" id="id_articulo" class="hidden" name="id_articulo">
			<input  id="action" name="action" class="hidden" >
			
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="codigo_barras">Código:</label>
				<input type="text" id="codigo_barras" name="codigo_barras" class="form-control">
				
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
			
			
			
			<div class="form-group">
				<label class="control-label" for="">Mínimo:</label>  
				<input id="minimo" name="minimo"  class="form-control" type="number" value="1">
			</div>
			
			<div class="form-group">
				<label class="control-label" for="">Existencia:</label>  
				<input id="existencia" name="existencia" class="form-control" type="number" value="20">
			</div>
			<div class="form-group">
				
				<div>
					<span class="btn btn-success fileinput-button">
						
						<span>Cargar Foto</span>
						<input id="fileupload" type="file" accept="image/*" name="files[]" data-url="fileupload/server_upload.php" >
						<input id="url_foto" type="hidden" name="url_foto" data-invalid="No has agregado ninguna foto" >
						<input id="url_thumb" type="hidden" name="url_thumb" >
					</span> 
					
					<div id="mensaje_carga" hidden class=" alert alert-success">
						<strong>Archivo <span id="nombre_archivo"> </span> cargado correctamente</strong> 
					</div>
					<img class="img-responsive " hidden alt="Vista Previa" id="vista_previa" >
					<div class="progress " id="barra_carga">
						<div class="progress-bar progress-bar-striped active" >
						</div>
					</div>					 
				</div>					 
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
			<div id="articulos_precios">
				<?php 
					while($fila = mysqli_fetch_assoc($result_tipo_precio)){?>
					<div class="row">
						<div class="form-group col-sm-6"> 
							<label for=""><?php echo $fila["nombre_precio"];?>:</label>  
							<input name="id_tipo_precio[]" value="<?php echo $fila["id_tipo_precio"];?>" class="hidden">	
							<input name="activo[]" value="1" class="activo hidden">	
							<input name="porc_ganancia[]" value="<?php echo $fila["porc_default"];?>" required class="form-control porc_ganancia" step="any" type="number">	
						</div>	
						<div class="form-group col-sm-6">
							<label class="" for="">$</label>  
							<div class="input-group">
								<input name="precio[]" value="" required class="form-control precio" step="any" type="number">	
								
								<div class="input-group-btn">
									<button type="button" class="btn-danger btn btn-sm btn_toggle">
										<i class="fa fa-ban"></i>
									</button>
								</div>
							</div>
							
						</div>		
					</div>			
					<?php 	
					}
				?>
			</div>
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
