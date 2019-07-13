<?php
header("Content-Type: application/json");
include ("conexi.php");
$link = Conectarse();
$response = Array();


$table = $_POST["table"];
$arr_pairs = $_POST["fields_value"];
$str_pairs = "";
foreach($arr_pairs as $arr_field_value){
	$str_pairs.= $arr_field_value["name"]. " = '" . $arr_field_value["value"] . "',";
	
}

$str_pairs  = trim($str_pairs, ",");

$insert =
"INSERT INTO $table SET $str_pairs		";
		
$exec_query = 	mysqli_query($link, $insert);

$actualizadas = mysqli_affected_rows($link);
if( $actualizadas == 0){
	$response["estatus"] = "error";
	$response["mensaje"] = "$id_field no encontrada";	
}

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