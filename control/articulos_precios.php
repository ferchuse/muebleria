<?php

include("../conexi.php"); 
$link = Conectarse();


$query_precios = "SELECT *  FROM productos_precios 
LEFT JOIN tipo_precio
USING (id_tipo_precio)
WHERE id_articulo =  ".$_GET["id_articulo"];
$result_precios = mysqli_query($link, $query_precios )
or die("Error al ejecutar $query_tipo: $query_tipo".mysqli_error($link));
		while($fila = mysqli_fetch_assoc($result_precios)){
			
			$activo = $fila["activo"] == 1 ? '' : "disabled" ;
			$activo_button = $fila["activo"] == 0 ? 'btn-success' : "btn-danger" ;
			$activo_icon = $fila["activo"] == 0 ? 'fa-check' : "fa-ban" ;
			?>
			<div class="row">
					<div class="form-group col-sm-6"> 
						<label for=""><?php echo $fila["nombre_precio"];?>:</label>  
						<input name="id_tipo_precio[]" value="<?php echo $fila["id_tipo_precio"];?>" class="hidden">	
						<input name="activo[]"  value="<?php echo $fila["activo"];?>" class="activo hidden">	
						<input name="porc_ganancia[]" <?php echo $activo;?> value="<?php echo $fila["porc_ganancia"];?>" required class="form-control porc_ganancia" step="any" type="number">	
					</div>	
					<div class="form-group col-sm-6">
						<label class="" for="">$</label>  
						<div class="input-group">
							<input name="precio[]" <?php echo $activo;?> value="<?php echo $fila["precio"];?>" required class="form-control precio" step="any" type="number">	
								
							<div class="input-group-btn">
								<button type="button" class="<?php echo $activo_button;?> btn btn-sm btn_toggle">
									<i class="fa <?php echo $activo_icon?>"></i>
								</button>
							</div>
						</div>
						
					</div>		
				</div>				
		<?php 	
		}
		?>
		
	