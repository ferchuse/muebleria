<?php
include("conexi.php");
$link=Conectarse();
$llave_primaria = "id_mensaje";
$name_tabla = "mensajes";
$query ="SELECT * FROM $name_tabla  LEFT JOIN usuarios USING(id_usuario) ORDER BY fecha_mensaje, hora_mensaje DESC";

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
			
			<td><?php echo $row["id_mensaje"];?>	</td>
			<td><?php echo date("d/m/Y", strtotime($row["fecha_mensaje"]));?>	</td>
			<td><?php echo $row["hora_mensaje"];?>	</td>
			<td><?php echo $row["nombre_usuario"];?>	</td>
			<td><?php echo $row["mensaje"];?>	</td>						
				
			<td class="text-right">
				<button  type="button"  class="btn btn-default btn-sm btn_leido " data-id_value="<?php echo $row[$llave_primaria];?>" >
					<i class="fa fa-flag"></i> 
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

