<?php
header("Content-Type: application/json"); 
include ("conexi.php"); // incluimos el archivo de conexion a base de datos
$link = Conectarse(); // ejecutamos la funcion de conexion y lo asignamos a la variable $link
$respuesta = Array(); //declaramos la variable de respuesta del tipo Arreglo


extract( $_POST); 

foreach($canidad_abono as $index=> ){
	$update = "UPDATE compras SET 
				
				id_proveedor = $id_proveedor,
				id_usuario = $id_usuario,
				fecha_compra = str_to_date( '$fecha_compra', '%d/%m/%Y' ),
				hora_compra = '$fecha_compra',
				articulos = '$total_articulos',
				subtotal = '$subtotal',
				importe_total = '$importe_total',
				obs_compra = '$obs_compra'
				WHERE id_compras = $id_compra";
				
	$result = mysqli_query($link, $buscar_compra ) ;

	if(!$result){
		
		$respuesta["buscar_compra"] = "Error".mysqli_error($link);
	}
	
}

 
	
	if($exec_query){
		$respuesta["estatus_compra"] = "success";
		$respuesta["mensaje_compra"] = "compra Actualizada";
		
	}
	else{
		$respuesta["estatus_compra"] = "error";
		$respuesta["mensaje_compra"] = "Error en update: $update  ".mysqli_error($link);		
	}


	$respuesta["query_detalle"] = $insert_detalle; // agregamos la consulta para motivos de depuración o debugging

 
echo json_encode($respuesta); //convertimos a formato JSON el array de respuesta

?>