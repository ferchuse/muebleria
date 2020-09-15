<?php
	header("Content-Type: application/json"); // escecifica el encabezado del tipo de respuesta
	include ("../conexi.php"); // incluimos el archivo de conexion a base de datos
	$link = Conectarse(); // ejecutamos la funcion de conexion y lo asignamos a la variable $link
	$respuesta = Array(); //declaramos la variable de respuesta del tipo Arreglo
	
	
	if($_POST["action"] == "insert"){
		$insertar = "
		INSERT INTO productos 
		SET 
		codigo_barras = '{$_POST["codigo_barras"]}',
		id_categoria = '{$_POST["id_categoria"]}',
		costo_compra = '{$_POST["costo_compra"]}',
		minimo = '{$_POST["minimo"]}',
		existencia = '{$_POST["existencia"]}',
		url_foto = '{$_POST["url_foto"]}',
		descripcion = '{$_POST["descripcion"]}'
		
		
		";
		
		
		if(mysqli_query($link, $insertar)){
			$respuesta["estatus_insert"]= "success";
			$respuesta["mensaje_insert"] = "Artículo Guardado";
			$id_articulo = mysqli_insert_id($link);
			
			foreach($_POST["id_tipo_precio"] as $i => $id_tipo_precio){
				$insertar_precios = "INSERT INTO productos_precios SET
				activo = '".$_POST["activo"][$i]."',
				id_articulo = '".$id_articulo ."',
				id_tipo_precio = '".$id_tipo_precio."',
				porc_ganancia = '".$_POST["porc_ganancia"][$i]."',
				precio = '".$_POST["precio"][$i]."'	";
				
				if(mysqli_query($link, $insertar_precios)){
					
					$respuesta["estatus_insert_precios"][] = "success";
				}
				else{
					$respuesta["estatus_insert_precios"][] = "error";
					$respuesta["mensaje_insert_precios"] = "Error en insertar: $insertar_precios  ".mysqli_error($link);	
				}
			}
		}
		else{
			$respuesta["estatus_insert"] = "error";
			$respuesta["mensaje_insert"] = "Error en insertar: $insertar  ".mysqli_error($link);		
		}
	}
	else{
		
		
		$insertar = "UPDATE productos 
		SET codigo_barras = '".$_POST["codigo_barras"]."',
		id_categoria = '".$_POST["id_categoria"]."',
		costo_compra = '".$_POST["costo_compra"]."',
		url_foto = '{$_POST["url_foto"]}',
		existencia = '".$_POST["existencia"]."',
		minimo = '".$_POST["minimo"]."',
		descripcion = '".$_POST["descripcion"]."'
		WHERE id_articulo = '".$_POST["id_articulo"]."'
		";
		
		$respuesta["consulta"] = $insertar ;
		
		if(mysqli_query($link, $insertar)){
			$respuesta["estatus_update"]= "success";
			$respuesta["mensaje_update"] = "Artículo Guardado";
			$id_articulo = mysqli_insert_id($link);
			
			foreach($_POST["id_tipo_precio"] as $i => $id_tipo_precio){
				$update_precios = "UPDATE productos_precios SET
				activo = '".$_POST["activo"][$i]."',
				porc_ganancia = '".$_POST["porc_ganancia"][$i]."',
				precio = '".$_POST["precio"][$i]."'
				WHERE id_articulo = '". $_POST["id_articulo"] ."'
				AND id_tipo_precio = '".$id_tipo_precio."'
				";
				
				if(mysqli_query($link, $update_precios)){
					
					$respuesta["estatus_update_precios"][] = "success";
					$respuesta["query_update_precios"][] = $update_precios;
				}
				else{
					$respuesta["estatus_insert_precios"][] = "error";
					$respuesta["mensaje_insert_precios"] = "Error en insertar: $update_precios  ".mysqli_error($link);	
				}
			}
		}
		else{
			$respuesta["estatus_update"] = "error";
			$respuesta["mensaje_update"] = "Error en insertar: $insertar  ".mysqli_error($link);		
		}
		
		
	}
	
	
	
	echo json_encode($respuesta); 
?>