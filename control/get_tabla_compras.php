<?php
include("conexi.php");
$link=Conectarse();

$query_med = "SELECT * 
 FROM compras 
LEFT JOIN almacenes USING (id_almacen)

";

if(isset($_POST["campo_filtro"])){
	
	$campo_filtro = $_POST["campo_filtro"];
	$valor_filtro = $_POST["valor_filtro"];
	$query_med.= " WHERE $campo_filtro LIKE '%$valor_filtro%' ";
}
if(isset($_POST["id_almacen"])){
	if($_POST["id_almacen"] != "TODOS"){
		if(isset($_POST["campo_filtro"])){
			$query_med.= " AND id_almacen = ".$_POST["id_almacen"];
		}else{
			$query_med.= " WHERE id_almacen = ".$_POST["id_almacen"];
		}
	}
}


if(isset($_POST["order_field"])){
	$query_med.= " ORDER BY ".$_POST["order_field"]. $_POST["order"] ;
}else{
	$query_med.= " ORDER BY id_compras ASC";
}

if(isset($_POST["pagina_actual"])){
	
}

$query_med.= " LIMIT 100";

$result_med = mysqli_query($link, $query_med )
or die("Error al ejecutar $query_med: $query_med".mysqli_error($link));


	$numero_filas = mysqli_num_rows($result_med);

	if($numero_filas == 0){?>
		<tr >
			<td class="text-center" colspan="9">
				<div class="alert alert-warning text-center">No hay resultados!! <?php //echo $query_med;?></div>
			</td>
		</tr>
	<?php
	}
	else{
		while($fila = mysqli_fetch_assoc($result_med)) { //iteramos por cada fila del resultado de la consulta
			
			
			
		?>
			
			<tr class="">
				<td ><?php echo $fila["id_compras"]; ?></td>
				<td ><?php echo date("d/m/Y", strtotime($fila["fecha_compra"])); ?></td>
				<td ><?php echo $fila["importe_total"]; ?></td>
				<td>
					<a  href="compras_nueva.php?id_compras=<?php echo $fila["id_compras"]; ?>&action=editar"  class="btn btn-warning btn-sm" >
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
