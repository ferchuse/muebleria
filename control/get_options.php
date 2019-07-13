<?php	header('Content-Type: application/json');	
include("conex.php");	
$link=Conectarse();		
$response = array();	
$debug = array();			
$tabla = $_GET["tabla"];	
$campo = $_GET["campo"];		
$id_col = $_GET["id_col"];		
$order = $_GET["order"];		
$query_complete = "SELECT *  FROM $tabla ORDER BY $order";		
$result_complete = mysql_query( $query_complete, $link )	or die("Error al ejecutar consulta: $query_complete".MYSQL_ERROR());		

while($row = mysql_fetch_assoc($result_complete)) {	
	$response["data"][] = array($row["$id_col"], $row["$campo"]);	
}		
	
print(json_encode($response));
?>