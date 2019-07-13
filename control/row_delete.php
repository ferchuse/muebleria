<?php
header("Content-Type: application/json");
include ("conexi.php");
$link = Conectarse();
$respuesta = Array();

$table = $_GET["table"];
$id_field = $_GET["id_field"];
$id_value = $_GET["id_value"];

$delete ="DELETE FROM $table
		WHERE $id_field = '$id_value'";
		
$exec_query = 	mysqli_query($link, $delete);	


if($exec_query){
	$respuesta["estatus"] = "success";
	$respuesta["mensaje"] = "Eliminado";
}	
else{
	$respuesta["estatus"] = "error";
	$respuesta["mensaje"] = "Error en delete: $delete  ".mysqli_error($link);		
}
$respuesta["query"] = "$delete";

echo json_encode($respuesta);
?>