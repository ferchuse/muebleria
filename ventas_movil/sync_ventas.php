<?php 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include("conex.php");
$link=Conectarse();

$respuesta = array();
$ventas = $_POST["ventas"];
$id_usuario = $_POST["id_usuario"];
$str_pairs = "";


foreach ($ventas as $fila_venta){
	
	foreach($fila_venta as $arr_field_value){
		if($arr_field_value["value"] == ''){
			$str_pairs.= $arr_field_value["name"]. " = NULL,";
		}
		elseif(strpos($arr_field_value["name"], "fecha") !== FALSE){ 
			$str_pairs.= $arr_field_value["name"]. " = str_to_date('".$arr_field_value["value"]. "', '%d/%m/%Y'),"; 
		}
		else{
			$str_pairs.= $arr_field_value["name"]. " = '" . $arr_field_value["value"] . "',";
		}
	} 

$str_pairs  = trim($str_pairs, ",");

} 
$respuesta["cant_ventas"] = count($ventas);
$respuesta["str_pairs"] ="$str_pairs";
$respuesta["estatus"] ="success";
$respuesta["mensaje"] ="Ventas Syncronizadas ";


$q_folios = "SELECT * FROM folios_disponibles WHERE id_vendedor = '$id_usuario'";

$result_folios = mysqli_query($link, $q_folios) or die("Error en: $q_folios  ".mysqli_error($link));
while($row = mysqli_fetch_assoc($result_folios)){


	$respuesta["folios_asignados"][] = $row["folio"];

}



/* $q_cobradores = "SELECT * FROM cobradores ORDER BY nombre_cobrador";
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
