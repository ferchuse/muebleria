<?php
header("Access-Control-Allow-Origin: *");
include ("conex.php");
include ("is_selected.php");

$dt_fecha_actual = new DateTime();

$dt_mañana = $dt_fecha_actual->modify("+1 day");
$fecha_entrega = $dt_mañana->format("d/m/Y");

$field = $_POST["field"];
$table = $_POST["table"];
$order = $_POST["order"];
?>


<option value="">Elige una opción	</option>
<?php 
include ("conex.php");
$link = Conectarse();
$q_select = "SELECT * FROM $table ORDER BY $order";
$result_select = mysql_query($q_select,$link) or die("Error en: $q_select  ".mysql_error());

while($row = mysql_fetch_assoc($result_select)){
	$value = $row["$field"];
	
?>
	<option value="<?php echo $value;?>"  > 
		<?php echo $value;?> 	
	</option>
<?php
}
?>