<?php
header("Content-Type: application/json");
include ("conexi.php");
$link = Conectarse();
session_start();
$response = Array();
$id_usuario = $_SESSION["id_usuario"];
$mensaje = $_GET["mensaje"];

$insert =
"INSERT INTO mensajes SET 
id_usuario = '$id_usuario', 
mensaje = '$mensaje', 
fecha_mensaje = CURDATE(), 
hora_mensaje = CURTIME(), 
leido = '0' 
	";
		
$exec_query = 	mysqli_query($link, $insert);



if($exec_query){
	$response["estatus"] = "success";
	$response["mensaje"] = "Agregado";
	$response["query"] = "$insert";
}	
else{
	$response["estatus"] = "error";
	$response["mensaje"] = "Error en insert: $insert  ".mysqli_error($link);		
}

echo json_encode($response);
?>