<?php 
include("conexi.php");
$link = Conectarse();
$tabla_nota  = $_POST["tabla_nota"];
$totales  = $_POST["tabla_totales"];
$index = 0;
$arr_precios = array();

if(isset($_POST["saldo_restante"])){
	
	$saldo_restante = $_POST["saldo_restante"];
 
}
else{
	
	$saldo_restante = $totales["importe_total"];

}


?>
<form id="form_compra_detalle">
<table id="compra_detalle" class="table table-bordered table-condensed table-hover">
	<thead>
		<tr>
			<th>Cantidad</th>
			<th>Descripción</th>
			<th>Categoría</th>
			<th>Costo U.</th>
			<th>Importe </th>
			<th>Eliminar </th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($tabla_nota as $fila){
		$id_articulo = $fila["id_articulo"];
		
		
		$q_articulo = "SELECT * FROM productos 
			LEFT JOIN catalogo_unidades USING (id_unidad) 
			LEFT JOIN productos_categorias USING (id_categoria) 
		
			WHERE id_articulo ='$id_articulo'" ;
		
		if( mysqli_query( $link, $q_articulo )){

			
			$result_articulo = mysqli_query(  $link, $q_articulo );
		
			while($row = mysqli_fetch_assoc($result_articulo)) {
			
				extract($row);
			}
			
			if(isset($fila["precio_unitario"])){
				
				$precio_unitario = $fila["precio_unitario"];
			}else{
				
				$precio_unitario = $Pvp;
			} 
			?>
			
			<tr>
				<td class="col-sm-1">
					<input class="cantidad form-control input-sm" size="3" type="number" name="cantidad[]" value="<?php echo $fila['cantidad'];?>">
				</td>
				<td><?php echo $descripcion;?></td>
				<td><?php echo $categoria;?></td>
				<td><?php echo $costo_compra;?></td>
				<td class="celda_importe">
					<?php 
					if( $fila["importe"] != null ){
						
						echo $fila["importe"];
					}
					else{
						
						echo $costo_compra * $fila['cantidad'];
					}
						
					?>
					</td>
				<td>
					<button  type="button"  class="btn btn-danger btn-sm borrar_fila" >
						<i class="fa fa-times"></i> 
					</button>
					<input type="hidden" name="id_articulo[]" value="<?php echo $fila['id_articulo'];?>">
					<input type="hidden" name="importe_articulo[]" value="<?php echo $fila["importe"];?>">
					<input type="hidden" name="costo_unitario[]" value="<?php echo  $costo_compra;?>"  class="costo_unitario" >
				</td>
								
				
				<?php
				$index++;
				$arr_precios[] = $costo_compra;
				
		
			} 
		else{
			die("Error al ejecutar consulta: $q_articulo".mysqli_error( $link));
		}
	}
	?>
	
	</tbody>
</table>

	<div class=" col-sm-4">
		<div class="row">
			<div class="col-sm-6"> 
				<label>ARTICULOS:  </label>  
			</div>
			<div class="col-sm-6" id="celda_articulos" > 
			<?php echo $index;?> 
			</div>
			<input type="hidden" name="total_articulos" id="total_articulos" value="<?php echo $index;?>" />

		</div>
		
		<div class="row">
			<div class="col-sm-8"> 
				<h1>POR PAGAR:  </h1>  
			</div>
			<div class="col-sm-4" > 
				<h1 id="por_pagar"> <?php echo "$".number_format($saldo_restante,2);?> </h1> 
			</div>
		</div>
	</div>
	<div class="pull-right col-sm-4 col-offset-4">
		<div class="row">
			<div class ="col-sm-6">
				<label>SUBTOTAL:  </label> 
			</div>
			<div class ="col-sm-6 text-right" id="celda_subtotal">
				<?php echo $totales['subtotal'];?>
				
			</div>
			<input type="hidden" name="subtotal" id="subtotal" value="<?php echo $totales['subtotal'];?>">
		</div>
		
		<div class="row">
			<div class ="col-sm-6">
				<label>IVA:  </label>  
			</div>
			<div class ="col-sm-6 text-right">
				<?php echo $totales['iva'];?>
			</div>
			<input type="hidden" name="iva" id="iva" value="<?php echo $totales['iva'];?>">
		</div>
		
		<div class="row">
			<div class ="col-sm-6">
				<label>TOTAL:  </label>   
			</div>
			<div class ="col-sm-6 text-right" id="celda_total" >
				<?php echo  number_format($totales["importe_total"],2);?> 
			</div>
			<input type="hidden" name="importe_total" id="total" value="<?php echo  number_format(array_sum($arr_precios),2);?> ">
		</div>
	</div> 
</form> 
	