<?php
header("Access-Control-Allow-Origin: *");

$id_field = $_POST["id_field"];
$field = $_POST["field"];
$table = $_POST["table"];
$order = $_POST["order"];
?>


<option value="">Elige una opción	</option>
<?php 
include ("conexi.php");
$link = Conectarse();
$q_select = "SELECT * FROM $table ORDER BY $order";
$result_select = mysqli_query($link, $q_select) or die("Error en: $q_select  ".mysqli_error($link));

while($row = mysqli_fetch_assoc($result_select)){
	
?>
	<option value="<?php echo $row[$field];?>"  > 
		<?php echo $row[$field];?> 	
	</option>
<?php
}
?>