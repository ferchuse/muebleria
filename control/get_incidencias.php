<?php
include("conexi.php");
$link=conectarse();

$q_estatus ="SELECT * FROM estatus  ";

$result_estatus=mysqli_query($link, $q_estatus) or die("Error en: $q_estatus  ".mysqli_error($link));
			

$numero_filas = mysqli_num_rows($result_estatus);

if($numero_filas == 0){?>
	<tr >
		<td class="text-center" colspan="9"><div class="alert alert-warning">no hay resultados!!</div></td>
	</tr>
<?php
}
else{
	
		while($row = mysqli_fetch_assoc($result_estatus)){
			
			
		?>
		<tr>
			<td><? echo $row["id_estatus"];?></td>
			<td><? echo $row["estatus"];?></td>
			<td><? echo $row["grupo_estatus"];?></td>
			<td class="text-right">
				<button  type="button"  class="btn btn-warning btn-sm editar_fila " data-id_value="<?php echo $row["id_estatus"];?>" >
					<i class="fa fa-pencil"></i> 
				</button>
				<button  type="button"  class="btn btn-danger btn-sm borrar_fila "  data-id_value="<?php echo $row["id_estatus"];?>" >
					<i class="fa fa-trash"></i>  
				</button>
			</td>
		</tr>
		<?php
		}
}
?>

