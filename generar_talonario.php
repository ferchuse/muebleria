<table class="table-bordered full-table"><tr>	<th>Num	</th>	<th>Fecha	Vencimiento</th>	<th>Cantidad Pagada	</th> 	<th>Saldo Restante	</th>	<th>Estatus	</th>	<th>Intereses	</th>	</tr>	<?php 	//$fecha_venta = "21/09/2017";	$DT_fecha_inicial = date_create_from_format("d/m/Y", $fecha_venta);	$fecha_vence_abono= $DT_fecha_inicial;		$weekdays = array("Domingo" , "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");	$semana = new DateInterval('P7D');		$fecha_vence_abono->add(new DateInterval('P7D'));	// echo "Fecha Nueva: " .$fecha_vence_abono->format("d/m/Y")."<br>";	$diferencia = $fecha_vence_abono->format("w");	// echo "diferencia:" . $diferencia."<br>";	$fecha_vence_abono->sub(new DateInterval('P'.$diferencia.'D'));		// echo "Siguente Domingo:" . $fecha_vence_abono->format("d/m/Y")."<br>";		$saldo_inicial = $importe - $enganche ;	$saldo_restante = $saldo_inicial; 	$num_pagos = $saldo_inicial / $cantidad_abono; 		$abonado = $enganche;	$suma_intereses = 0;	$estatus = "PENDIENTE";	// echo "Fecha Venta ". $fecha_venta;	// echo "<br> importe ". $importe;	// echo "<br> enganche ". $enganche;	// echo "<br> cantidad_abono ". $cantidad_abono;	// echo "<br> saldo_inicial ". $saldo_inicial;	// echo "<br> saldo_actual ". $saldo_actual;	// echo "<br> num_pagos ". $num_pagos;			for($i = 1; $i < $num_pagos; $i++){		$saldo_restante-= $cantidad_abono; 		$fecha_vence_abono->add($semana);		$abonado+= $cantidad_abono;		$estatus_pago = $saldo_restante > $saldo_actual ? "PAGADO": "PENDIENTE";				if($estatus_pago != "PAGADO"){			$semanas_vencido = intval(abs((date_diff($fecha_vence_abono, new DateTime())->format("%a"))/7));			if($semanas_vencido > 0){								$estatus_pago = "VENCIDO";								//Calcular INtereses				$intereses = $saldo_restante * .10;				$suma_intereses+=$intereses;			}		}		else{						$semanas_vencido = "";		}				switch($estatus_pago){			case 'PENDIENTE':				$estatus_color = "bg-primary";			break;			case 'VENCIDO':				$estatus_color = "bg-danger";			break;			case 'PAGADO':				$estatus_color = "bg-success";			break;		}		// echo "semanas_vencido: ". $semanas_vencido."<br>";		// echo "Dias_vencido<pre>". var_dump($dias_vencido)."</pre><br>";		?>		<tr class="<?php echo $estatus_color; ?>">			<td><?php echo $i;?>	</td>			<td><?php echo $fecha_vence_abono->format('d/m/Y') . "\n";?>	</td>			<td><?php echo $abonado;?></td>			<td><?php echo $saldo_restante;?></td>			<td><?php echo $estatus_pago;?></td>			<td>				<?if($intereses > 0){?>										Intereses: <?php echo $intereses;?></br>					Total a Pagar: <?php echo $saldo_restante + $intereses;?></br>				<?php				} 				?>			</td>								</tr>	<?php				}	?>	<tr>		<td></td>		<td></td>		<td></td>		<td></td>		<td></td>		<td>			<?php 			$semanas_vencimiento = intval(abs((date_diff($fecha_vence_abono, new DateTime())->format("%a"))/7));			?>			Saldo Actual: <?php echo $saldo_actual;?></br>			Semanas de Vencimiento:  <?php echo $semanas_vencimiento;?></br>			Suma de Intereses: <?php echo $suma_intereses;?></br> 			Total a Pagar: <?php echo $suma_intereses + $saldo_actual;?></br>				</td>	</tr>	</table>	