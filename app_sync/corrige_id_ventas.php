<?php
	include("../conexi.php");
	
	$link = Conectarse();
	
	
	$consulta = "SELECT * FROM ventas ORDER BY fecha_venta ";
	
	$result = mysqli_query($link, $consulta);
	
	$i= 0;
	
	while($fila = mysqli_fetch_assoc($result)){
		// echo var_dump($fila);
		$id_ventas_ant = $fila["id_ventas"];
		
		$año_siguiente = date("Y", strtotime($fila["fecha_venta"]));
		
		if($año_anterior == $año_siguiente){
			
			$i++;
			
		}
		else{
			$i= 1;
			
		}
		
		$i = str_pad($i, 4, 0, STR_PAD_LEFT); 
		
		
		$id_ventas_nueva = $año_siguiente.$i; 
		
		
		$update = "UPDATE ventas SET id_ventas = $id_ventas_nueva WHERE id_ventas = $id_ventas_ant";
		
		
		
		$año_anterior = $año_siguiente;
		
		mysqli_query($link, $update);
	}
	
	
?>