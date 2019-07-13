<?php
header("Content-Type: application/json");
include ("conexi.php");
$link = Conectarse();
$response = Array();

$table = $_GET["table"];
$id_field = $_GET["id_field"];
$id_value = $_GET["id_value"];

$delete ="DELETE FROM $table
		WHERE $id_field = '$id_value'";
		
$exec_query = 	mysqli_query($link, $delete);	


if($exec_query){
	$response["estatus"] = "success";
	$response["mensaje"] = "Eliminado";
}	
else{
	$response["estatus"] = "error";
	$response["mensaje"] = "Error en delete: $delete  ".mysqli_error($link);		
}
$response["query"] = "$delete";

//sleep(5);


echo json_encode($response);
?>