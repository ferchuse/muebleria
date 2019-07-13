<?php
	header("Content-Type: application/json"); 
	include ("../conexi.php"); // incluimos el archivo de conexion a base de datos
	$link = Conectarse(); // ejecutamos la funcion de conexion y lo asignamos a la variable $link
	$respuesta = Array(); //declaramos la variable de respuesta del tipo Arreglo
	
	
	extract( $_POST); 
	
	$consulta = "INSERT INTO cargos SET 
	clave_vendedor = '{$_POST["clave_vendedor"]}',
	tarjeta = '{$_POST["tarjeta"]}',
	fecha_cargos = '{$_POST["fecha_cargos"]}',
	producto_cargos = '{$_POST["producto_cargos"]}',
	importe_cargos = '{$_POST["importe_cargos"]}'
	
	";
	
	$result = mysqli_query($link, $consulta ) ;
	
	if(!$result){
		$respuesta["estatus"] = "Error";
		$respuesta["mensaje"] = "Error en $consulta".mysqli_error($link);
	}
	else{
		$respuesta["estatus"] = "success";
			$respuesta["mensaje"] = "Guardado";
		
	}
	
	
	
	echo json_encode($respuesta); //convertimos a formato JSON el array de respuesta
	
?>