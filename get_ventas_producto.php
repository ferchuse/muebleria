<?php
	include ("conex.php");
	$link = Conectarse();
	$ruta= $_POST["ruta"];
	$fecha_inicial= $_POST["fecha_inicial"];
	$fecha_final= $_POST["fecha_final"];
	//$columna= $_GET["columna"];
?>

<br>
<br>
<?php
	echo "VENTAS DE LA RUTA $ruta DEL $fecha_inicial AL $fecha_final";
	//echo $value;
	
?>
<br>
<br>
<br>
<table  id="tabla_detalle_carga" class="compact">
	<thead>
		
		<th>
			Producto
		</th>
		<th>
			Piezas
		</th>
		<th>
			Importe
		</th>
	</thead>	
	<tbody>
	
	<?php
	
		$importe_total = array();
		
		$query ="SELECT orden_producto, producto, pu, SUM(cantidad) AS total_piezas FROM detalle_venta
		INNER JOIN ventas_camionetas 
		ON detalle_venta.folio_venta = ventas_camionetas.folio_venta
		INNER JOIN productos 
		ON productos.codigo_barras = detalle_venta.codigo_barras
		WHERE ruta = '$ruta'
		AND fecha_venta BETWEEN str_to_date('$fecha_inicial','%d/%m/%Y') AND str_to_date('$fecha_final','%d/%m/%Y')
		GROUP BY detalle_venta.codigo_barras
		ORDER BY orden_producto";
			
		$result=mysql_query($query,$link) or die("Error en: $query  ".mysql_error());
		
		while($row = mysql_fetch_assoc($result)){
			
		$nombre_producto = $row["producto"];
		$total_piezas = $row["total_piezas"];
		$pu = $row["pu"];
		$subtotal = $pu * $total_piezas;
		$importe_total[] = $subtotal;
		?>
		<tr>
			<td>
				<?php echo "$nombre_producto";?>
			</td>
			<td class="derecha">
				<?php echo "$total_piezas";?>
			</td>
			<td align="right" class="dinero">
				$ <?php echo number_format($subtotal, 2);?>
			</td>
		</tr>
		<?php 
		}
		?>
		<tr class="totales">
			<td class="totales">
				TOTAL
			</td>
			<td class="totales">
				
			</td>
			<td class="dinero totales">
				<?php echo number_format(array_sum($importe_total), 2);?>
			</td>
		</tr>
	</tbody>
</table>