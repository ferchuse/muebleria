<?php
	header("Content-Type: application/json"); 
	include ("conexi.php"); // incluimos el archivo de conexion a base de datos
	$link = Conectarse(); // ejecutamos la funcion de conexion y lo asignamos a la variable $link
	$respuesta = Array(); //declaramos la variable de respuesta del tipo Arreglo
	
	
	extract( $_POST); 
	
	$insert_venta = "INSERT INTO  ventas SET 
	
	nv = '$folio_venta',
	tarjeta = '$folio_venta',
	fecha_venta = '$fecha_venta',
	nombre_cliente = '$nombre_cliente',
	celular = '$celular',
	telefono = '$telefono',
	entre_calles = '$entre_calles',
	referencias = '$referencias',
	direccion = '$direccion',
	articulo = '$articulo',
	cobrador = 'MATRIZ',
	tipo_articulo = '$tipo_articulo',
	enganche = '$enganche',
	importe= '$importe_total',
	saldo_actual= '$saldo_actual',
	clave_vendedor = '$clave_vendedor',
	tipo_venta = '$tipo_venta'
	";
	
	$result = mysqli_query($link, $insert_venta ) ;
	
	if(!$result){
		$respuesta["estatus_venta"] = "Error";
		$respuesta["mensaje_venta"] = "Error en $insert_venta".mysqli_error($link);
	}
	else{
		$respuesta["estatus_venta"] = "success";
		
	}
	
	
	//actualiza el folio actual del vendedor
	$folio_venta++;
	$actualiza_folio = "UPDATE folios SET folio = '$folio_venta'" ;
	$result_folio = mysqli_query($link, $actualiza_folio ) ;
	
	if(!$result_folio){
		
		$respuesta["actualiza_folio"] = "Error".mysqli_error($link);
	}
	
	
	
	echo json_encode($respuesta); //convertimos a formato JSON el array de respuesta
	
?>