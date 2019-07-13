<?php
	include ("conex.php");
	$link = Conectarse();
	
	
	$id_cliente = $_POST["id_cliente"];
	$nombre_cliente = $_POST["nombre_cliente"];
	$tel_cliente = $_POST["tel_cliente"];
	$nombre_tienda = $_POST["nombre_tienda"];
	$direccion_tienda = $_POST["direccion_tienda"];
	$coordenadas_tienda = $_POST["coordenadas_tienda"];
	$ruta = $_POST["ruta"];
	$counter = 0
	foreach($id_cliente as $key => $value){
		if($value){
			$insert_clientes ="INSERT INTO clientes
					SET 
					id_cliente = '$id_cliente[$key]',  
					nombre_cliente = '$nombre_cliente[$key]', 
					tel_cliente = '$tel_cliente[$key]', 
					nombre_tienda = '$nombre_tienda[$key]',
					direccion_tienda = '$direccion_tienda[$key]',
					coordenadas_tienda = '$coordenadas_tienda[$key]',			
					ruta = '$ruta[$key]'				
					";
			//echo $insert_venta ;		
			mysql_query($insert_clientes) or die("Error insertando detalle $insert_clientes: ".mysql_error());
			
			$counter++;
			/* foreach($detalle_venta as $key2 => $value2){
				if($value2){
					$insert_detalle ="INSERT INTO detalle_venta
					SET 
					folio_venta = '$folio_venta[$key]',  
					cantidad = '$cantidad[$key]', 
					producto = '$producto[$key]',
					pu = '$pu[$key]',
								
					";
				//echo $insert_venta ;		
				mysql_query($insert_detalle) or die("Error insertando detalle $insert_detalle: ".mysql_error());
			
				
				}
			} */
			
		}
	}
	
	echo $counter , " Clientes agregados correctamente"; 
	
?>
<?php

	
	/* //echo $parametro.",";
	//echo $value;
	$query ="SELECT precio_prietos FROM productos";
	
	$result=mysql_query($query,$link) or die("Error en: $query  ".mysql_error());
	
	while($row = mysql_fetch_assoc($result)){
		
		echo $row["precio_prietos"], ",";
	} */
	
?>