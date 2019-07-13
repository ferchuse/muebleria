<?php
header("Content-Type: application/json"); // escecifica el encabezado del tipo de respuesta
//header("Access-Control-Allow-Origin:*"); COORS // para permitir conexiones desde diferentes dominios
include ("conexi.php"); // incluimos el archivo de conexion a base de datos
$link = Conectarse(); // ejecutamos la funcion de conexion y lo asignamos a la variable $link
$respuesta = Array(); //declaramos la variable de respuesta del tipo Arreglo

//asignamos las variables que nos da el $_POST
extract( $_POST); 


$buscar_compra = "SELECT * FROM compras WHERE id_compras = '$id_compra'";

$result = mysqli_query($link, $buscar_compra ) ;

if(!$result){
	
	$respuesta["buscar_compra"] = "Error".mysqli_error($link);
}
 
$existe_folio = mysqli_num_rows($result);

$respuesta["existe_folio"] = $existe_folio;
if(!isset($restante)){
	$restante = $importe_total;
	
}
if(!isset($estatus_compra)){
	
	$estatus_compra= "PENDIENTE";
}
if($existe_folio){
	//actualizar compra
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
		
	$exec_query = 	mysqli_query( $link ,$update ); 

	// si la consulta se ejecuto correctamente mandamos mensaje de exito sino un error
	if($exec_query){
		$respuesta["estatus_compra"] = "success";
		$respuesta["mensaje_compra"] = "compra Actualizada";
		
	}
	else{
		$respuesta["estatus_compra"] = "error";
		$respuesta["mensaje_compra"] = "Error en update: $update  ".mysqli_error($link);		
	}

	$respuesta["update_compra"] = $update; // agregamos la consulta para motivos de depuración o debugging
	
	$delete = "DELETE FROM compras_detalle
				WHERE id_compras = $id_compra";
	
	$exec_query = 	mysqli_query($link, $delete); 

	// si la consulta se ejecuto correctamente mandamos mensaje de exito sino un error
	if($exec_query){
		$respuesta["estatus_delete"] = "success";
		$respuesta["mensaje_delete"] = "Detalle Actualizado";
		
	}
	else{
		$respuesta["estatus_delete"] = "error";
		$respuesta["mensaje_delete"] = "Error en delete: $delete  ".mysqli_error($link);		
	}

	$respuesta["delete_detalle"] = $delete; // agregamos la consulta para motivos de depuración o debugging

	
	//insertar detall---------tus_compra"] = "success";
	$respuesta["mensaje_compra"] = "compra Actualizada";
	
	
}
else{
	if($restante > 0 ){
		$estatus_compra = "PENDIENTE";
	}
	else{
		$estatus_compra = "LIQUIDADA";
	}
	$insert =
	"INSERT INTO compras SET 
				
				id_proveedor = $id_proveedor,
				id_usuario = $id_usuario,
				fecha_compra = str_to_date( '$fecha_elab_compra', '%d/%m/%Y' ),
				hora_compra = '$hora_elab_compra',
			
				total_articulos = '$total_articulos',
			
				importe_total = '$importe_total',
				obs_compra = '$obs_compra'
				
				"; //creamos la consulta a ejecutar
			
		
	$exec_query = 	mysqli_query($link, $insert); 

	// si la consulta se ejecuto correctamente mandamos mensaje de exito sino un error
	if($exec_query){
		$respuesta["estatus_compra"] = "success";
		$respuesta["mensaje_compra"] = "Compra Guardada";
		$id_compra = mysqli_insert_id($link);
		$respuesta["insert_id"] = $id_compra;
		
	}
	else{
		$respuesta["estatus_compra"] = "error";
		$respuesta["mensaje_compra"] = "Error en insert: $insert  ".mysqli_error($link);		
	}

	$respuesta["query_compra"] = $insert; // agregamos la consulta para motivos de depuración o debugging



	
}



	foreach($cantidad as $index => $value){
		
		$insert_detalle =
		"INSERT INTO compras_detalle SET 
					id_compra = '$id_compra',
					id_articulo = '$id_articulo[$index]',
					cantidad = '$value'
					
					
					"; //creamos la consulta a ejecutar
				
		
		$exec_query = 	mysqli_query($link, $insert_detalle); 

		// si la consulta se ejecuto correctamente mandamos mensaje de exito sino un error
		if($exec_query){
			$respuesta["estatus_detalle"] = "success";
			$respuesta["mensaje_detalle"] = "Detalle Guardado";
			
		}
		else{
			$respuesta["estatus_detalle"] = "error";
			$respuesta["mensaje_detalle"] = "Error en $insert_detalle".mysqli_error($link);		
		}
	}

	$respuesta["query_detalle"] = $insert_detalle; // agregamos la consulta para motivos de depuración o debugging

 
echo json_encode($respuesta); //convertimos a formato JSON el array de respuesta

?>