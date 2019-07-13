




<?php
	
	
	$consulta_abonos ="SELECT * FROM abonos WHERE tarjeta = '$tarjeta'";
	
	$result=mysql_query($consulta_abonos,$link) or die("Error en: $consulta_abonos  ".mysql_error());
	
	while($row = mysql_fetch_assoc($result)){
		
		$fila_abono[] = $row ;
	}
	
	// echo "<pre>";
	// echo var_dump($fila_abono);
	// echo "</pre>";
	$days_week = [
	"LUNES" => "Monday" , 
	"MARTES" => "Tuesday",
	"MIÉRCOLES" => "Wednesday", 
	"JUEVES" =>"Thursday", 
	"VIERNES" => "Friday",
	"SÁBADO" => "Saturday",
	"DOMINGO" => "Sunday"
	];
	$abonado_promesa = 0;
	$semanas_atraso = 0;
	/* Code ran at 2016-04-06 */
	$date = new DateTime('first day of this month');
	// $date->modify('monday this week');
	
	// echo $date->format('Y-m-d');
	/* Output: 2016-03-28 */
	
	
	$DT_fecha_inicial = date_create_from_format("d/m/Y", $fecha_venta);
	$DT_fecha_inicial->modify("next {$days_week[$dia_cobranza]}");
	
	// echo "<pre>Primer pago: ". $DT_fecha_inicial->format('Y-m-d')."</pre>";
	
	$dt_fecha_vencimiento =  date_create_from_format("d/m/Y", $fecha_vencimiento);
	$fecha_vence_abono = $DT_fecha_inicial;
	
	$weekdays = array("Domingo" , "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
	$semana = new DateInterval('P7D');
	
	
	// echo "Fecha Nueva: " .$fecha_vence_abono->format("d/m/Y")."<br>";
	$diferencia = $fecha_vence_abono->format("w");
	// echo "diferencia:" . $diferencia."<br>";
	//$fecha_vence_abono->sub(new DateInterval('P'.$diferencia.'D'));	
	// echo "Siguente Domingo:" . $fecha_vence_abono->format("d/m/Y")."<br>";
	
	
	$saldo_inicial = $importe - $enganche ;
	$saldo_restante = $saldo_inicial; 
	$num_pagos = $saldo_inicial / $cantidad_abono; 	
	$abonado = $enganche;
	$esperado = $enganche;
	$intereses = 0;
	$suma_intereses = 0;
	$monto_pendiente = $saldo_inicial;
	$estatus = "PENDIENTE";
	
?>
<table class="table-bordered full-table table-striped">
	
	<tr>
		<th>Periodo	</th>
		<th>Fecha	</th>
		<th>Pago</th>
		<th>Cumplió	</th> 
		<th >Estatus	</th>
		<th>Cargos	</th>
		<th>Abonos	</th>
		<th>Saldo	</th>
	</tr>
	
	<?php 
		// echo "saldo_actual", $saldo_actual;
		//$fecha_venta = "21/09/2017";
		
		// echo "Fecha Venta ". $fecha_venta;
		// echo "<br> importe ". $importe;
		// echo "<br> enganche ". $enganche;
		// echo "<br> cantidad_abono ". $cantidad_abono;
		// echo "<br> saldo_inicial ". $saldo_inicial;
		// echo "<br> saldo_actual ". $saldo_actual;
		// echo "<br> num_pagos ". $num_pagos;
		
		$monto_vencido = $cantidad_abono;
		
		for($i = 1; $i <= $num_pagos; $i++){
			
			
			// echo "abonado_promesa: $abonado_promesa<br>";
			$abonado_promesa+= $cantidad_abono;
			// $fecha_vence_abono->add($semana);
			$abonado+= $cantidad_abono;
			$esperado+= $cantidad_abono;
			$estatus_pago = $abonado_promesa <= $total_abonado ? "PAGADO": "PENDIENTE";
			
			
			$semanas_vencido = floor(date_diff($fecha_vence_abono, new DateTime())->format("%r%a")/7);
			if($semanas_vencido > 0){
				
				
				$semanas_atraso++;
				
				$estatus_pago = "VENCIDO";
				$pagos_atrasados++;
				
				$intereses = round((($abonado_promesa +  $intereses) * .10 / 30 * 7 ), 2);
				$suma_intereses+=$intereses;
				
				$monto_vencido = $abonado_promesa +  $intereses;
				
				
			}
			
			
			if($abonado_promesa <= $total_abonado){
				$su_abono= $fila_abono[$i-1]["abono"] ;
				$saldo_restante-= $su_abono; 
			
			}
			else{
				$su_abono =  0;	
			
			}
			
				$monto_pendiente-= $su_abono - $intereses;
			
			
			
			switch($estatus_pago){
				case 'PENDIENTE':
				$estatus_color = "bg-primary";
				
				
				break;
				case 'VENCIDO':
				$estatus_color = "bg-danger";
				
				break;
				case 'PAGADO':
				$estatus_color = "bg-success";
				
				break;
			}
			
			// echo "monto_pendiente",$monto_pendiente;
			// echo "semanas_vencido: ". $semanas_vencido."<br>";
			// echo "Dias_vencido<pre>". var_dump($dias_vencido)."</pre><br>";
		?>
		<tr style="padding: 5px;" class="">
			<td><?php echo $i;?>	</td>
			
			<td><?php echo $fecha_vence_abono->format('d/m/Y') . "\n";?>	</td>
			<td><?php echo $cantidad_abono;?>	</td>
			<td><?php echo $estatus_pago == "PAGADO" ?  $abonado: "" ;?></td>
			<td class="hidden"><?php echo $esperado;?></td>
			<td><?php echo $estatus_pago;?></td>
			<td> 
				<?php
					if($semanas_vencido > 0){?>
					Semanas Atrasados: <span class="text-right"> <?php echo $semanas_atraso;?></span></br>
					Pago atrasado : <span class="text-right"> $<?php echo $abonado_promesa;?></span></br>
					Intereses: <span class="text-right"> $<?php echo $intereses;?></span></br>
					Monto Semana: <span class="text-right"> <?php echo $monto_vencido;?></span></br>
					Saldo: <span class="text-right"> <?php echo $saldo_restante;?></span></br>
					Su abono: <span class="text-right"> <?php echo $fila_abono[$i-1]["fecha_hora_abono"];?></span>, 
						<span class="text-danger text-right"> -<?php echo $su_abono;?></span></br>
					_____________________________<br>
					<b>Monto Pendiente: <?php echo $monto_pendiente;?></b></br>
					
					
					<?php
					} 
				?>
			</td>
			
		</tr>
		<?php
			
			$fecha_vence_abono->add(new DateInterval('P7D'));
		}
	?>
	<tr class="">
		<td><?php echo $i;?>	</td>
		<td><?php echo $fecha_vence_abono->format('d/m/Y') . "\n";?>	</td>
		<td><?php echo fmod($saldo_inicial, $cantidad_abono);;?>	</td>
		<td><?php echo $estatus_pago == "PAGADO" ?  $abonado: "" ;?></td>
		<td><?php echo $estatus_pago;?></td>
		<td></td>
	</tr>
	
	
	<tfoot>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td ></td> 
			<td></td>
			<td>
				<?php 
					$semanas_vencimiento = floor(date_diff($dt_fecha_vencimiento, new DateTime())->format("%r%a")/7);
					if($semanas_vencimiento > 0){
						
						
						$intereses = $semanas_vencimiento * $cantidad_abono * .10;
						$suma_intereses+= $intereses;
					}
					
					for($j = 1 ; $j < $semanas_vencimiento; $j++){
					
					$intereses = ceil($monto_pendiente * .10 / 30 * 7);
					
					echo $j."-".	 $monto_pendiente.", Interes: $intereses"."<br>" ;
					$suma_intereses+= $intereses;
					
					$monto_pendiente+= $intereses ;
					}
					
				?>
				Saldo Actual: <?php echo $saldo_actual;?></br>
				Pagos Atrasados: <?php echo $pagos_atrasados;?></br>
				Total Abonado: <?php echo $total_abonado;?></br>
				<?php 
					if($semanas_vencimiento > 0){
						echo "Semanas de Vencimiento: ". $semanas_vencimiento;
					} 
				?>  
				</br>			
				<?php 
					if($suma_intereses > 0){
						echo "Suma de Intereses:: ". $suma_intereses;
					}
				?>  
				</br>
				Total a Pagar: <?php echo $monto_pendiente;?></br>
			</td>
		</tr>
	</tfoot>
</table>	