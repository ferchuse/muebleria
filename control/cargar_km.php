<?php
include ("../conex.php");
$link = Conectarse();

$id_cobrador = $_GET["id_cobrador"];


$q_select = "SELECT
	*
FROM
	kilometrajes
WHERE
	id_cobrador = '$id_cobrador'
ORDER BY
	fecha_kilometraje DESC
LIMIT 1";

$result_select = mysql_query($q_select,$link) or die("Error en: $q_select  ".mysql_error());

while($fila = mysql_fetch_assoc($result_select)){
	
	echo $fila["kilometraje_actual"] ;
	
}
?>