<?php
	include("conexi.php");
	$link=conectarse();
	$llave_primaria = "id_kilometraje";
	$campos_names = array("I", "");
	$name_tabla = "sectores";
	$query ="SELECT * FROM kilometrajes LEFT JOIN cobradores USING(id_cobrador) ORDER BY $llave_primaria";
	
	$result = mysqli_query($link, $query) or die("Error en: $query  ".mysqli_error($link));
	
	
	$numero_filas = mysqli_num_rows($result);
	
	if($numero_filas == 0){?>
	<tr >
		<td class="text-center" colspan="9"><div class="alert alert-warning">No hay resultados!!</div></td>
	</tr>
	<?php
	}
	else{
		
		while($row = mysqli_fetch_assoc($result)){
			
			
		?>
		<tr>
			
			<td><? echo date("d/m/Y", strtotime($row["fecha_kilometraje"]));?></td>
			<td><? echo number_format($row["kilometraje_anterior"]);?></td>
			<td><? echo number_format($row["kilometraje_actual"]);?></td>
			<td><? echo number_format($row["diferencia_kilometraje"]);?></td>
			<td><? echo number_format($row["litros"],2);?></td>
			<td>$ <? echo number_format($row["importe_gasolina"], 2);?></td>
			<td><? echo $row["rendimiento"];?></td>
			<td class="hidden"><? echo $row["placas"];?></td>
			<td class="text-right">
				<button  type="button"  class="btn btn-warning btn-sm editar_fila " data-id_value="<?php echo $row[$llave_primaria];?>" >
					<i class="fa fa-pencil"></i> 
				</button>
				<button  type="button"  class="btn btn-danger btn-sm borrar_fila "  data-id_value="<?php echo $row[$llave_primaria];?>" >
					<i class="fa fa-trash"></i>  
				</button>
			</td>
		</tr>
		<?php
		}
	}
?>

