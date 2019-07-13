<?php 
	function calcularIntereses($link, $ventas){
		
		foreach($ventas AS $index => $fila_venta){?>
		
		<?php 
			
			//Ejemplo Residuo ya liquidada 3857
			//Ejemplo Liauiqdada pero con pagos antrasados 3350
			
			
			$dias=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]; 
			$dias_ingles = ["LUNES" => "monday", "MARTES" => "tuesday", "MIÉRCOLES" => "wednesday", "JUEVES" => "thursday", "VIERNES" => "friday", "SÁBADO" => "saturday", "DOMINGO" => "sunday"];
			$meses_cortos = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
			$atrasados = 0; 
			$acumulado_planeado = 0; 
			$saldo_anterior = 0; 
			
			
			// Asigna el tamaño del periodo dependiendo el dia_cobranza
			switch($fila_venta["dia_cobranza"]){
				
				case "QUINCENAL":
				$tamaño_periodo = 15;  
				$periodo = "days";
				if(date("j", strtotime($fila_venta["fecha_venta"])) > 16){
					$fecha_inicial = strtotime("first day of next month"); 
				}
				else{
					$fecha_inicial = strtotime(date("Y-m-16",strtotime($fila_venta["fecha_venta"]) ));
				}
				break;
				case "MENSUAL":
				$tamaño_periodo = 1;
				$periodo = "months";
				$fecha_inicial = strtotime("first day of next month"); 
				
				break;
				default:
				$tamaño_periodo = 1;
				$periodo = "week";
				$siguiente_dia = $dias_ingles[$fila_venta["dia_cobranza"]];
				//TODO SI el dia de la venta == $dia_cobranza no agregar 1 semana
				
				$fecha_inicial = strtotime("next $siguiente_dia + 1 week", strtotime($fila_venta["fecha_venta"]));
				
			} 
			
			$cantidad_pagos = round(($fila_venta["importe"] - $fila_venta["enganche"]) / $fila_venta["cantidad_abono"]);
			$residuo = ($fila_venta["importe"] - $fila_venta["enganche"]) % $fila_venta["cantidad_abono"];
			$incremento= $tamaño_periodo;
			$fecha_inicial = strtotime(" - $incremento $periodo" , $fecha_inicial);
			
			// Por cada pago planeado
			for ($i = 1; $i <= $cantidad_pagos; $i++) {
				//calcula la fecha del cargo 
				$segundos = strtotime(" + $incremento $periodo" , $fecha_inicial);
				
				//Si e el primer pago tomar en cuenta abonos desde la fecha de venta
				if($i == 1){
					
					$fecha_cargo = $fila_venta["fecha_venta"];
				}
				else{
					$fecha_cargo = date("Y-m-d" ,$segundos);
					
				}
				
				
				$cargos_periodo = $fila_venta["cantidad_abono"];
				
				//Si ees el ultimo pago y hay residuo los cargos del periodo es igual al residuo
				if($i == $cantidad_pagos && $residuo > 0){
					
					$cargos_periodo  = $residuo;
				}
				
				
				$acumulado_planeado+= $fila_venta["cantidad_abono"];
				$incremento+= $tamaño_periodo;
				
				$segundos_limite = strtotime(" + 6 days" , $segundos);
				$fecha_limite_pago = date('Y-m-d', $segundos_limite);
				
				//Consulta Saldo Acumulado 
				//Consulta abonos por periodo
				
				$consulta_abonos ="SELECT COALESCE(SUM(abono), 0) AS suma_abonos_real
				FROM abonos WHERE tarjeta = '$tarjeta' 
				AND DATE(fecha_hora_abono) 
				BETWEEN '$fecha_cargo' AND '$fecha_limite_pago'";
				
				$result = mysql_query($consulta_abonos,$link) or die("Error en: $consulta_abonos  ".mysql_error());
				
				while($row = mysql_fetch_assoc($result)){
					
					$abonos_periodo = $row["suma_abonos_real"] ;
					// $fila_abono = $fila_abono["suma_abonos_real"] ;
				}
				
				
				
				if($segundos_limite > strtotime("now")){
					$estatus_abono = '-';
					
				}
				else{
					if($abonos_periodo == 0  ){
						if($saldo_periodo > 0){
							
							$atrasados++;
						}
						$estatus_abono = '<i class="text-danger fa fa-times"></i>';
					}
					else{
						$estatus_abono = '<i class="text-success fa fa-check"></i>';
					}
					
					$saldo_periodo = $saldo_anterior + $cargos_periodo - $abonos_periodo ;
					
					if($saldo_periodo <=  0){ //Saldo A favor o negativo
						
						$intereses_periodo = 0;
						
						$estatus_abono = '<i class="text-success fa fa-check"></i>';
					}
					else{ // Saldo positivo, genera intereses
						
						$intereses_periodo = round($saldo_periodo * (.1 / 30 * 7), 2); 
						
					}
				}
				
				
				
				
				$saldo_periodo+= $intereses_periodo;
				$suma_intereses+= $intereses_periodo;
				
				
			?> 
			
			<tr class="<?php //echo $periodo_actual;?>"> 
				<td><?php echo $i;?></td>
				<td><?php echo  $dias[date("w", $segundos)]. " ". date("d/m/Y", $segundos);?></td>
				<td><?php echo  $dias[date("w", $segundos_limite)]. " ". date('d/m/Y', $segundos_limite);?></td>
				
				<td class="h4 text-center"><?php echo  $estatus_abono;?> </td>
				
				<?php if($estatus_abono == '-'){
					echo "<td></td><td></td>";
					
				}
				else{
				?>
				
				<td  >
					Saldo Anterior: <br> 
					+ Cargos del Periodo: <br> 
					<?php if($intereses_periodo > 0){?>
						+ Intereses del Periodo:  <br> 
					<?php }?>
					- Abonos: <br> 
					__________________<br>
					Saldo del Periodo:  <br> 
					
					
					
				</td>
				<td class="text-right">
					$ <?php echo $saldo_anterior;?><br> 
					$ <?php echo $cargos_periodo;?><br> 
					<?php if($intereses_periodo > 0){
						echo "$ ".$intereses_periodo . "</br>";
					}
					?>
					
					<?php 
						if($abonos_periodo == 0 ){
							
							$abonos_periodo =  "<span class='text-danger'> $abonos_periodo </span>";	
						}
					?>
					<?php echo "- $".$abonos_periodo;?><br> 
					___________________<br>
					$ <?php echo $saldo_periodo;?> 
				</td>
				
				<?php
				} 
				
				?>
			</tr>
			<?php
				
				$saldo_anterior = $saldo_periodo;
			}
			
			
			
			
			//************************************************* 2348 
			//*************************************************
			// SEMANAS VENCIDAS
			//*************************************************
			//*************************************************
			
			
			// Si la fecha limite  es menor a la fecha actual calcular semanas restantes desde el vencimiento
			if($segundos_limite  < strtotime("now") && $saldo_anterior > 0){
				
				echo '<thead>
				<tr>  
				<th colspan="6">PAGOS VENCIDOS</th>
				
				</tr>
				</thead>'; 
				//Calcula periodos_vencidos 
				$periodos_vencidos = floor((strtotime("now") - $segundos_limite ) / 3600 / 24 / 7);
				
				for ($i = 1; $i <= $periodos_vencidos; $i++) {
					//calcula la fecha del cargo 
					$segundos = strtotime(" + $incremento $periodo" , $fecha_inicial);
					
					//*************************** ESTAS 2 LINEAS SON DISTINTAS A LOS CARGOS NORMALES
					
					$fecha_cargo = date("Y-m-d" ,$segundos);
					$cargos_periodo = 0;
					
					
					
					
					$acumulado_planeado+= $fila_venta["cantidad_abono"];
					$incremento+= $tamaño_periodo;
					
					$segundos_limite = strtotime(" + 6 days" , $segundos);
					$fecha_limite_pago = date('Y-m-d', $segundos_limite);
					
					//Consulta Saldo Acumulado 
					//Consulta abonos por periodo
					
					$consulta_abonos ="SELECT COALESCE(SUM(abono), 0) AS suma_abonos_real
					FROM abonos WHERE tarjeta = '$tarjeta' 
					AND DATE(fecha_hora_abono) 
					BETWEEN '$fecha_cargo' AND '$fecha_limite_pago'";
					
					$result = mysql_query($consulta_abonos,$link) or die("Error en: $consulta_abonos  ".mysql_error());
					
					while($row = mysql_fetch_assoc($result)){
						
						$abonos_periodo = $row["suma_abonos_real"] ;
						// $fila_abono = $fila_abono["suma_abonos_real"] ;
					}
					
					
					
					if($segundos_limite > strtotime("now")){
						$estatus_abono = '-';
						
					}
					else{
						if($abonos_periodo == 0  ){
							if($saldo_periodo > 0){
								
								$atrasados++;
							}
							$estatus_abono = '<i class="text-danger fa fa-times"></i>';
						}
						else{
							$estatus_abono = '<i class="text-success fa fa-check"></i>';
						}
						
						$saldo_periodo = $saldo_anterior + $cargos_periodo - $abonos_periodo ;
						
						if($saldo_periodo <=  0){ //Saldo A favor o negativo
							
							$intereses_periodo = 0;
							
							$estatus_abono = '<i class="text-success fa fa-check"></i>';
						}
						else{ // Saldo positivo, genera intereses
							
							$intereses_periodo = round($saldo_periodo * (.1 / 30 * 7), 2); 
							
						}
					}
					
					
					
					
					$saldo_periodo+= $intereses_periodo;
					$suma_intereses+= $intereses_periodo;
					
					
				?> 
				
				<?php
					
					$saldo_anterior = $saldo_periodo;
				}
				
				
				
				
			}
			$respuesta["atrasados"] =$atrasados;
			$respuesta["suma_intereses"] =$suma_intereses;
			$respuesta["periodos_vencidos"] =$periodos_vencidos;
			
		?>
		
		
		<?php
		}
		
		return $respuesta;
	}
?>





