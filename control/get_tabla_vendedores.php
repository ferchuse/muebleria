<?php
include("conexi.php");
$link=conectarse();

$query ="SELECT * FROM vendedores  ";

$result=mysqli_query($link, $query) or die("Error en: $query  ".mysqli_error($link));
			

$numero_filas = mysqli_num_rows($result);

if($numero_filas == 0){?>
	<tr >
		<td class="text-center" colspan="9"><div class="alert alert-warning">NO HAY RESULTADOS!!</div></td>
	</tr>
<?php
}
else{
	
		while($row = mysqli_fetch_assoc($result)){
			
			
		?>
		<tr>
			<td><? echo $row["clave_vendedor"];?></td>
			<td><? echo $row["nombre_vendedor"];?></td>
			<td class="text-right">
				<button  type="button"  class="btn btn-warning btn-sm editar_fila " data-id_value="<?php echo $row["clave_vendedor"];?>" >
					<i class="fa fa-pencil"></i> 
				</button>
				<button  type="button"  class="btn btn-danger btn-sm borrar_fila "  data-id_value="<?php echo $row["clave_vendedor"];?>" >
					<i class="fa fa-trash"></i>  
				</button>
			</td>
		</tr>
		<?php
		}
}
?>

