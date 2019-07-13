<?php
include("conexi.php");
$link=conectarse();

$query_med = "select * 
 from almacenes ";

$result_med = mysqli_query($link, $query_med )
or die("error al ejecutar $query_med: $query_med".mysqli_error($link));


	$numero_filas = mysqli_num_rows($result_med);

	if($numero_filas == 0){?>
		<tr >
			<td class="text-center" colspan="9"><div class="alert alert-warning">no hay resultados!!</div></td>
		</tr>
	<?php
	}
	else{
		while($fila = mysqli_fetch_assoc($result_med)) { //iteramos por cada fila del resultado de la consulta
			
			extract($fila); // convierte en variables los elementos del array $fila, en este caso los nombres de cada campo 
			
			
			
		?>
			<tr class="">
				<td class="col-md-2"><?php echo $id_almacen?></td>
				<td class="col-md-2"><?php echo $descripcion_almacen?></td>
				<td class="text-right">
					<button  type="button"  class="btn btn-warning btn-sm editar_fila " data-id_value="<?php echo $id_almacen;?>" >
						<i class="fa fa-pencil"></i> 
					</button>
					<button  type="button"  class="btn btn-danger btn-sm borrar_fila "  data-id_value="<?php echo $id_almacen;?>" >
						<i class="fa fa-trash"></i>  
					</button>
					
				</td>
			</tr>	
		<?php
			}
}
?>

