<?php 	include ("conex.php");	$link = Conectarse();		$nombre_usuario = $_SESSION["nombre_usuario"];	$tarjeta = $_POST["tarjeta"];	$folio_venta = $_POST["folio_venta"];	$fecha_venta = $_POST["fecha_venta"];	$fecha_vencimiento = $_POST["fecha_vencimiento"];	$nombre_cliente =  $_POST["nombre_cliente"]; 	$direccion =  $_POST["direccion"]; 	$referencias =  $_POST["referencias"]; 	$entre_calles =  $_POST["entre_calles"]; 	$telefono =  $_POST["telefono"]; 	$dia_cobranza =  $_POST["dia_cobranza"]; 	$cobrador =  $_POST["cobrador"]; 	$clave_vendedor =  $_POST["clave_vendedor"]; 	$sector = $_POST["sector"]; 	$articulo = $_POST["articulo"]; 	$importe = $_POST["importe"]; 	$enganche = $_POST["enganche"]; 	$saldo_actual = $_POST["saldo_actual"]; 	$cantidad_abono = $_POST["cantidad_abono"]; 	$id_estatus = $_POST["id_estatus"]; 	$tipo_articulo = $_POST["tipo_articulo"];		if(empty($cantidad_abono)){	   $cantidad_abono = 'NULL';	}		if(empty($saldo_actual)){	   $saldo_actual = 'NULL';	}	  	if(empty($fecha_venta)){		$fecha_venta = 'NULL';	}else{		$fecha_venta = "'$fecha_venta'";	}	  	if(empty($fecha_vencimiento)){		$fecha_vencimiento = 'NULL';	}else{		$fecha_vencimiento = "'$fecha_vencimiento'";	}		$update_venta ="UPDATE ventas					SET 									tarjeta = '$tarjeta',  									nombre_cliente = '$nombre_cliente',					direccion = '$direccion',					referencias = '$referencias',					entre_calles = '$entre_calles',					telefono = '$telefono',					sector = '$sector',					fecha_hora_mod = NOW(),					usuario_mod = '$nombre_usuario',					id_estatus = '$id_estatus'									WHERE tarjeta='$tarjeta'																								";			// echo $update_venta ;					mysql_query($update_venta) or die("Error insertando venta $update_venta: ".mysql_error());						echo "Tarjeta $tarjeta Actualizada Correctamente \n";			?>