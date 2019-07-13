<?php
	
function calculaIntereses($fecha_venta, $importe, $enganche, $cantidad_abono){
	$weekdays = array("Domingo" , "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
	$DT_fecha_inicial = date_create_from_format("d/m/Y", $fecha_venta);
	$fecha_vencimiento = $DT_fecha_inicial;
	
	$semana = new DateInterval('P7D');
		$fecha_vencimiento->add(new DateInterval('P7D'));
	
	$diferencia = $fecha_vencimiento->format("w");
	$fecha_vencimiento->sub(new DateInterval('P'.$diferencia.'D'));	
	

	$saldo_inicial = $importe - $enganche ;
	$saldo_restante = $saldo_inicial; 
	$num_pagos = $saldo_inicial / $cantidad_abono; 	
	$abonado = $enganche;
	$suma_intereses = 0;
	$estatus = "PENDIENTE";
	
}

	
?>