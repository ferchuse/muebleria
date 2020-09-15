<?php
include("../conexi.php");
$link=Conectarse();

$query_med = "SELECT * 
 FROM productos 
LEFT JOIN productos_categorias USING (id_categoria)
#LEFT JOIN almacen_existencias USING (id_articulo)
#LEFT JOIN almacenes USING (id_almacen)
WHERE 1
";

if(isset($_POST["campo_filtro"])){
	
	$campo_filtro = $_POST["campo_filtro"];
	$valor_filtro = $_POST["valor_filtro"];
	$query_med.= " WHERE $campo_filtro LIKE '%$valor_filtro%' ";
}
if($_GET["id_categoria"] != "" ){
	
	
	$query_med.= " AND id_categoria = '{$_GET["id_categoria"]}' ";
}
// if(isset($_POST["id_almacen"])){
	// if($_POST["id_almacen"] != "TODOS"){
		// if(isset($_POST["campo_filtro"])){
			// $query_med.= " AND id_almacen = ".$_POST["id_almacen"];
		// }else{
			// $query_med.= " WHERE id_almacen = ".$_POST["id_almacen"];
		// }
	// }
// }


if(isset($_GET["order_field"])){
	$query_med.= " ORDER BY ".$_GET["order_field"]. $_GET["order"] ;
}else{
	$query_med.= " ORDER BY Descripcion ASC";
}

if(isset($_GET["pagina_actual"])){
	
}

$query_med.= " LIMIT 100";

$result_articulos = mysqli_query($link, $query_med )
or die("Error al ejecutar $query_med: $query_med".mysqli_error($link));


	$numero_filas = mysqli_num_rows($result_articulos);

	if($numero_filas == 0){?>
		<tr >
			<td class="text-center" colspan="9">
				<div class="alert alert-warning text-center">No hay resultados!! <?php //echo $query_med;?></div>
			</td>
		</tr>
	<?php
	}
	else{
		while($fila = mysqli_fetch_assoc($result_articulos)) { //iteramos por cada fila del resultado de la consulta
			
			extract($fila); // convierte en variables los elementos del Array $fila, en este caso los nombres de cada campo 
			
			// if($existencia <= $Min   ){
				
				// $semaforo = "danger";
			// }
			// else{
				// $semaforo = " ";
				
			// }
			
		?>
			
			<tr class="<?php echo $semaforo;?>">
				<td ><input value="<?php echo $id_articulo;?>" class="seleccionar"  type="checkbox"></td>
				<td ><?php echo  $id_articulo; ?></td>
				<td ><?php echo $descripcion; ?></td>
				<td><?php echo $categoria;?></td>	
				<td><?php echo number_format($costo_compra);?></td>	
				<?php
					
						$q_precios = "SELECT * FROM productos_precios WHERE id_articulo = '$id_articulo'";
						

						$result_precios = mysqli_query($link, $q_precios) or die(mysqli_error($link));
							
						if($result_precios){
							while($fila_precios = mysqli_fetch_assoc($result_precios)){ 
								if($fila_precios["activo"] == 1){
								?>
								
								<td class="text-right"><?php echo number_format($fila_precios["precio"]);?></td>
			
							<?php
								}
								else{ ?>
									<td>-</td>
			
									<?php	
								}
							}
							
						}
						else{
								echo mysqli_error($link);
						}
				?>
				
				
				<td><?php echo number_format($existencia);?></td>
			
				<td>
					<button  type="button"  class="btn btn-danger btn-sm borrar_fila pull-right"  data-id_value="<?php echo $id_articulo;?>" >
						<i class="fa fa-trash"></i>  
					</button>
					<button  type="button"  class="btn btn-warning btn-sm editar_fila pull-right" data-id_value="<?php echo $id_articulo;?>" >
						<i class="fa fa-pencil"></i> 
					</button>
				</td>
			</tr>	
		<?php
			}

}
?>
<tr class="hide">
	<td id="num_rows"><?php echo $numero_filas;?> </td>
</tr>
