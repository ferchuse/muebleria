<?php
header("Content-Type: application/json");
include ("conexi.php");
$link = Conectarse();
$response = Array();


$table = $_POST["table"];
$arr_pairs = $_POST["fields_value"];
$str_pairs = "";
$id_field = $_POST["id_field"];
$id_value = $_POST["id_value"];


//crea un string con los campos y sus valores
foreach($arr_pairs as $arr_field_value){
	if($arr_field_value["value"] == ''){
		$str_pairs.= $arr_field_value["name"]. " = NULL,";
	}
	else{
		if (stripos($arr_field_value["name"], "fecha") !== false) {
			$str_pairs.= $arr_field_value["name"]. " = STR_TO_DATE('". $arr_field_value["value"] . "', '%d/%m/%Y'),";
			$response["hay_fecha"] = "1";
			$response["campo_fecha"] = $arr_field_value["name"];
		}
		else{
			$str_pairs.= $arr_field_value["name"]. " = '" . $arr_field_value["value"] . "',";
		}
	}
}

$str_pairs  = trim($str_pairs, ",");

$update =
"UPDATE $table SET $str_pairs
		WHERE $id_field = '$id_value'
		";
		
$exec_query = 	mysqli_query($link, $update);	

$actualizadas = mysqli_affected_rows($link);

$response["query"] = "$update";

if( $actualizadas == 0){
	$response["estatus"] = "error";
	$response["mensaje"] = "$id_field no encontrada";	
}

if($exec_query){
	$response["estatus"] = "success";
	$response["mensaje"] = "Actualizado";
	$response["query"] = "$update";
}	
else{
	$response["estatus"] = "error";
	$response["mensaje"] = "Error en update: $update  ".mysqli_error($link);		
}

echo json_encode($response);
?>