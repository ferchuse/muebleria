<?php
	include ("conex.php");
	$link = Conectarse();
	//$ruta= $_GET["ruta"];
	if(!$_POST["ruta"]){
		
		die("No hay Ruta");
	}
	else{
		$ruta = $_POST["ruta"];
	}
?>
<?php
	//echo $parametro.",";
	//echo $value;
	$q_existencia ="SELECT * FROM existencias_ruta
	 INNER JOIN productos
	 ON existencias_ruta.codigo_barras = productos.codigo_barras 
	 WHERE ruta = '$ruta' ORDER BY orden_producto ";
	 
	 
	$result=mysql_query($q_existencia,$link) or die("Error en: $q_existencia  ".mysql_error());
	
	while($row = mysql_fetch_assoc($result)){
		
		echo $row["orden_producto"], ", ".$row["nombre_producto"], ", ", $row["piezas"], " \n"  ;
	}
	
?>