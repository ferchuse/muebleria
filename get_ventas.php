<?php	header("Content-Type: application/json");	include ("conex.php");	include ("control/calcular_intereses.php");	$link = Conectarse();	$cobrador= $_GET["cobrador"];		$respuesta = array();		$query ="SELECT nombre_cliente, tarjeta, celular, telefono, entre_calles, referencias, direccion, articulo ,	clave_vendedor, fecha_vencimiento, saldo_actual, 	cantidad_abono,	fecha_venta,	dia_cobranza,	importe,	enganche	FROM ventas WHERE cobrador = '$cobrador' 		AND ventas.estatus_pago = 'PENDIENTE'	GROUP BY tarjeta 		ORDER BY tarjeta";					$result=mysql_query($query,$link) or die("Error en: $query  ".mysql_error());		while($row = mysql_fetch_assoc($result)){				$tarjeta = $row["tarjeta"];		$q_ultimos_abonos = "SELECT abono, 		DATE_FORMAT(fecha_hora_abono,'%d/%m/%y')  AS fecha_abono		FROM		abonos		WHERE		tarjeta = '$tarjeta'		ORDER BY		fecha_hora_abono DESC 		LIMIT 3";		$result_abonos = mysql_query($q_ultimos_abonos,$link) or die("Error en: $q_ultimos_abonos  ".mysql_error());		$abonos= array();		while($fila_abonos = mysql_fetch_assoc($result_abonos)){			$abonos[] = $fila_abonos;					}		$row["ultimos_abonos"] = $abonos;				$dt_fecha_venta =date_create_from_format("d/m/Y", $row["fecha_venta"]);		$dt_fecha_vencimiento =date_create_from_format("d/m/Y", $row["fecha_vencimiento"]);		// $dt_fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]))				// $intereses = calcularIntereses($link, $row); 				// $row["intereses"] = $intereses["intereses"];		// $row["pagos_atrasados"] = $intereses["pagos_atrasados"];		// $row["semanas_vencidas"] = $intereses["semanas_vencidas"];		$row["intereses"] = 0;		$row["pagos_atrasados"] = 0;		$row["semanas_vencidas"] =0;				$row["total_pago"] = $intereses["total_pago"];		$row["talonario"] = $intereses["talonario"];		$row["fecha_venta"] = date("d/m/Y", strtotime($row["fecha_venta"]));		$row["fecha_vencimiento"] = date("d/m/Y", strtotime($row["fecha_vencimiento"]));				$respuesta[] = $row;	}		echo json_encode( $respuesta );	?>