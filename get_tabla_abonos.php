<?php		//print json_encode($tabla);		/* 	$sth = mysqli_query("SELECT ...");		$rows = array();		while($r = mysqli_fetch_assoc($sth)) {		$rows[] = $r;		}	print json_encode($rows); */	include ("conex.php");	$link = Conectarse();	$tarjeta= $_GET["tarjeta"];		$q_abonos ="SELECT 	fecha_hora_abono,	'' AS cargo,	abono,	cobrador,	tipo_abono AS concepto,	comentario_abono AS comentario		FROM abonos WHERE tarjeta = '$tarjeta' 		UNION		SELECT 	fecha_venta AS fecha_hora_abono,	importe AS cargo,	'' AS abono,	clave_vendedor AS cobrador,	CONCAT('VENTA #', id_ventas) AS concepto,	articulo AS comentario		FROM ventas	WHERE tarjeta = '$tarjeta'  		UNION		SELECT 	fecha_venta AS fecha_hora_abono,	'' AS cargo,	enganche AS abono,	clave_vendedor AS cobrador,	CONCAT('ENGANCHE #', id_ventas) AS concepto,	articulo AS comentario		FROM ventas	WHERE tarjeta = '$tarjeta'  		ORDER BY fecha_hora_abono  ";	$result_abonos = mysql_query($q_abonos,$link) or die("Error en: $q_abonos  ".mysql_error());		if(mysql_num_rows($result_abonos)< 1 ){				echo "<div class='titulo'> No hay abonos registrados</div>";		}else{	?> 		<pre hidden><?php 	echo $q_abonos;?>	</pre>	<table class="table table-bordered table-condensed table-striped">		<thead>			<th>FECHA</th>			<th>SALDO ANTERIOR</th>			<th>CARGOS</th>			<th>ABONOS</th>			<th>SALDO RESTANTE</th>			<th>COBRADOR/VENDEDOR</th>			<th>CONCEPTO</th>			<th>Comentarios </th>			<th>-</th>		</thead>				<tbody>			<?php 						$saldo_anterior = 0;				$total_cargos = 0;				$total_abonos = 0;								while($row = mysql_fetch_assoc($result_abonos)){					$fecha_abono =  date("d/m/Y", strtotime($row["fecha_hora_abono"]));					$fecha_hora_abono = $row["fecha_hora_abono"];					setlocale(LC_TIME, "es_ES");					$dia_numerico = date("w", strtotime($row["fecha_hora_abono"])) ;					$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");										//$dia_cobrado = strftime ("%A", 2);										if($row["cargo"] > 0){												$saldo_restante = $saldo_anterior + $row["cargo"] ;						$total_cargos+= $row["cargo"];					}										else{												$saldo_restante = $saldo_anterior - $row["abono"];						$total_abonos += $row["abono"];					}										$cobrador = $row["cobrador"];										$comentario = $row["comentario"];				?>				<tr>					<td>						<?php echo $dias[$dia_numerico], " ", $fecha_abono ;?>					</td>					<td>						<?php echo "$ ". number_format($saldo_anterior,2);?>					</td>					<td><?php echo  number_format($row["cargo"]);?></td>					<td><?php echo  number_format($row["abono"]);?></td>					<td>						<?php echo "$ ". number_format($saldo_restante,2);?>					</td>					<td>						<?php echo $cobrador;?>					</td>					<td>						<?php echo $row["concepto"];?>					</td>					<td>						<?php echo $comentario;?>					</td>					<td class="no_imprimir">						<?php 														if($_COOKIE["usuario"] != "Tienda"){?>														<button data-id_abono="<?php echo $fecha_hora_abono;?>" data-tarjeta="<?php echo $tarjeta;?>" class="editar_abono btn btn-warning ">								<i class="fa fa-edit"></i>							</button>							<button id="<?php echo $fecha_hora_abono;?>"  data-tarjeta="<?php echo $tarjeta;?>" class="borrar btn btn-danger">								<i class="fa fa-times"></i>							</button>							<?															}						?>					</td>				</tr> 				<?php										$saldo_anterior = $saldo_restante;				}			?>					</tbody>		<tfoot>			<tr>				<td></td>				<td></td>				<td>	<?php echo number_format($total_cargos)?></td>				<td><?php echo number_format($total_abonos)?></td>			</tr> 		</tfoot>	</table>	<?php	}	?>