<?php		//print json_encode($tabla);		/* 	$sth = mysqli_query("SELECT ...");		$rows = array();		while($r = mysqli_fetch_assoc($sth)) {			$rows[] = $r;		}		print json_encode($rows); */	include ("conex.php");	$link = Conectarse();	$id_abono= $_GET["id_abono"];	$response= array();?><?php	//echo $parametro.",";	//echo $value;	$query ="SELECT * FROM abonos WHERE fecha_hora_abono = '$id_abono'";		$result=mysql_query($query,$link) or die("Error en: $query  ".mysql_error());		while($row = mysql_fetch_assoc($result)){				$response["data"] = array(			"fecha" => date("d/m/Y", strtotime($row["fecha_hora_abono"])) , 			"hora" => date("H:i:s", strtotime($row["fecha_hora_abono"])) ,			"cobrador" => $row["cobrador"] ,			"tipo_abono" => $row["tipo_abono"] ,			"saldo_anterior" => $row["saldo_anterior"] ,			"abono" => $row["abono"] ,			"saldo_restante" => $row["saldo_restante"] ,			"id" => $row["fecha_hora_abono"] 			);	}	echo json_encode($response);?>