<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include("conex.php");
$link=Conectarse();

$respuesta = array();

$q_version = "SELECT * FROM version ";
$result_cobradores=mysqli_query($link, $q_cobradores) or die("Error en: $q_cobradores  ".mysqli_error($link));
while($row = mysqli_fetch_assoc($result_cobradores)){
	$cobrador_db = $row["nombre_cobrador"];

	$respuesta["cobradores"][] = $cobrador_db ;

}

$q_sectores = "SELECT * FROM sectores ";
$result_sectores=mysqli_query($link, $q_sectores) or die("Error en: $q_sectores  ".mysqli_error($link));
while($row = mysqli_fetch_assoc($result_sectores)){
	$sector_db = $row["sector"];					

	
	$respuesta["sectores"][] = $sector_db;
	

} */


echo json_encode($respuesta);
?>
