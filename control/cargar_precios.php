<?php
	
	//Carga los precios para la cotización
	//04/06/2018
include("../conexi.php");
$link=conectarse();

$id_articulo = $_GET["id_articulo"]; 

$consulta = "SELECT * 
 FROM productos 
 LEFT JOIN productos_precios USING (id_articulo)
 LEFT JOIN tipo_precio USING (id_tipo_precio)  
 WHERE id_articulo = '$id_articulo'
 AND activo = 1
 ORDER BY precio";

$result = mysqli_query($link, $consulta ) 
or die("error al ejecutar $consulta: $consulta".mysqli_error($link));


	$numero_filas = mysqli_num_rows($result);

	if($numero_filas == 0){?>
		<tr >
			<td class="text-center" colspan="9"><div class="alert alert-warning">Sin Resultados!!</div></td>
		</tr>
	<?php
	}
	else{
		while($fila = mysqli_fetch_assoc($result)) { 
		
			extract($fila); 
			
			if($nombre_precio == "Contado" || $nombre_precio == "Mayoreo"){
					$num_pagos = 1;
				?>
			<tr>
				<td class="col-md-2"><?php echo $nombre_precio;	?></td>
				<td class="col-md-2">$ <?php echo number_format($precio);?>
					<button data-precio="<?php echo $precio;?>" data-meses="" type="button"  class="btn btn-default btn-sm pull-right btn-radio" data-id_value="<?php echo $id_tipo_precio;?>" >
						<i class="fa fa-circle-o"></i> 
					</button>	
				</td>
				
			</tr>
			<?php
			
			}
			else{
				if($precio <= 1000){
							$abono = 50;
					}
				else{
				
						if($precio > 1000 && $precio <= 1500 ){
							$abono = 60;
						}else{
							if($precio > 1500 && $precio <= 2000 ){
								$abono = 70;
							}else{
								if($precio > 2000 && $precio <= 2500 ){
									$abono = 80;
								}else{
									if($precio > 2500 && $precio <= 3500 ){
										$abono = 90;
									}else{
										if($precio > 3500 && $precio <= 5000 ){
											$abono = 100;
										}else{
											$abono = floor($precio / 52);
										}
									}
								}
							}
						}
					}
				$num_pagos = floor($precio / $abono);
				$restante = $precio - ( $num_pagos * $abono );
				
				
					?>
					<tr>
						<td class="col-md-2"><?php echo $nombre_precio;	?></td>
						<td class="col-md-2">
						
							$<?php echo $precio." <br> <br> ";?>
							<?php
								echo $num_pagos ." pagos Semanales de $". number_format($abono) ;
								if($restante > 0){
									
									echo " y ultimo pago de $" . $restante;
								}
								?>
							<button data-pagos= data-precio="<?php echo $precio;?>" data-meses="" type="button"  class="btn btn-default btn-sm pull-right btn-radio" data-id_value="<?php echo $id_tipo_precio;?>" >
								<i class="fa fa-circle-o"></i> 
							</button>	
							
						
						</td>
						
					</tr>
					<?php
				
			}
		}
}
?>

