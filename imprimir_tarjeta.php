<?php	include ("conex.php");	include ("is_selected.php");	include ("classes/numero_a_letras.php");	$link = Conectarse();			if($_GET["tarjeta"]){		$tarjeta  = $_GET["tarjeta"];	}?><?php 	if(isset($_GET["id_ventas"])){		$q_tarjeta = "SELECT * FROM ventas LEFT JOIN estatus USING (id_estatus) WHERE id_ventas = '{$_GET["id_ventas"]}'";					}	else{				$q_tarjeta = "SELECT * FROM ventas LEFT JOIN estatus USING (id_estatus) WHERE tarjeta = '$tarjeta'";	}	$result_tarjeta=mysql_query($q_tarjeta,$link) or die("Error en: $q_tarjeta  ".mysql_error());	$rowcount=mysql_num_rows($result_tarjeta);		while($row = mysql_fetch_assoc($result_tarjeta)){		$nv = $row["nv"];		$tarjeta = $row["tarjeta"];		$fecha_venta = date("d/m/Y", strtotime($row["fecha_venta"]));		$fecha_larga =$row["fecha_venta"];		$fecha_venc_larga =$row["fecha_vencimiento"];		$fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]));		if($fecha_vencimiento == '31/12/1969'){			$fecha_vencimiento = '';		}		$nombre_cliente = $row["nombre_cliente"];		$direccion = $row["direccion"];		$referencias = $row["referencias"];		$telefono = $row["telefono"];		$entre_calles = $row["entre_calles"];		$dia_cobranza = $row["dia_cobranza"];		$clave_vendedor = $row["clave_vendedor"];		$saldo_actual = $row["saldo_actual"];		$cobrador = $row["cobrador"];		$sector = $row["sector"];		$articulo = $row["articulo"];		$importe = $row["importe"];		$enganche = $row["enganche"];		$saldo_actual  = $row["saldo_actual"];		$cantidad_abono  = $row["cantidad_abono"];		$estatus  = $row["estatus"];		$fecha_hora_mod  = $row["fecha_hora_mod"];		$usuario_mod  = $row["usuario_mod"];			}?><!DOCTYPE html><html>	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Imprimir Tarjeta</title>						<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />		<link rel="stylesheet" type="text/css" href="css/imprimir_tarjeta.css" media="all" />						<script type="text/javascript" src="js/jquery-1.9.1.js"></script>		<script type="text/javascript" src="js/jquery-barcode.min.js"></script>		<script type="text/javascript">			$( document ).ready(function() {				// $("#pagare").hide();				$("#contrato").hide();				var codigo = $("#tarjeta").val();					var btype = "code128";				var settings = {					output: "bmp",					bgColor: "#FFFFFF",					color: "#000000",					barWidth: "1",					barHeight: "50"				};								$("#imp_cliente").click(function(e){										$("#tipo_copia").html("COPIA CLIENTE ");										// $("#barcode").barcode(codigo, btype, settings);					// $("#barcode").show();					$("#pagare").hide();					window.setTimeout(print, 1000);					//window.print();				});								$("#imp_archivo").click(function(e){					$("#tipo_copia").html("COPIA ARCHIVO ");					$("#datos_tarjeta").show();					$("#contrato").hide();					$("#barcode").hide();					$("#pagare").show();					window.print();				});				$("#imp_contrato").click(function(e){										$("#contrato").show();					$("#datos_tarjeta").hide();					$("#pagare").hide();					window.print();				});								$("#imp_cobrador").click(function(e){					$("#tipo_copia").html("COPIA COBRADOR ");					$("#barcode").hide();					window.print();				});			}); 		</script>	</head>	<body>						<div class="container-fluid" > 			<div class="row">				<div class="col-xs-12">					<div  class="hidden-print btn-group">						<button id="imp_cliente" class="btn btn-primary btn-lg" >CLIENTE</button>						<button id="imp_cobrador" class="btn btn-primary btn-lg">COBRADOR</button>						<button id="imp_archivo" class="btn btn-primary btn-lg">ARCHIVO</button>						<button id="imp_contrato" class="btn btn-primary btn-lg">CONTRATO</button>					</div>				</div>			</div>			<div id="contrato">				<?php include("imprimir_contrato.php")?>			</div>			<div class="borde" id="datos_tarjeta"> 				<div  >					<div id="encabezado" class="row">												<div  class="col-xs-4 text-center">							<div id="logo">								<img src="img/logo.png" width="200" height="50"/>																							</div>							<h5>															</h5>													</div>						<div id="rfc" CLASS="COL-XS-12">							<h6>								HILARIO ROBERTO LAGUNA LÓPEZ RFC LALH640228EK7 CURP LALH640228HMCGPL02 <br>								VENTA DE ARTICULOS PARA EL HOGAR  . TEL: (01591) 9185428<br>								AV 16 DE SEPTIEMBRE S/N SAN SEBASTIÁN, ZUMPANGO ESTADO DE MEXICO ,							</h6>						</div>					</div>										<div class="row">						<div  class="col-xs-3">							<h4 id="tipo_copia">								</h4>							</div>												<div  class="col-xs-3 text-right">						<label > NV:</label><?php echo $nv;?></span> 											</div>					<div  class="col-xs-3 text-right">						<h3><b>N°: <?php echo $tarjeta;?> </b></h3> 						</div>					<div  class="col-xs-3 ">						<div id="barcode" ></div>						</div>									</div>				<input type="hidden" id="tarjeta" value="<?php echo $tarjeta;?> ">								<div id="div_tarjeta" class="row">					<div class="col-xs-12">						<table BORDER="2" class="table table-condensed">							<tr>								<td>									<label  >  Fecha de Venta: </label>								</td>								<td>																		<?php echo $fecha_venta;?>									&nbsp;								</td>								<td>									<span >  Fecha de Vencimiento:</span>								</td>								<td>									<?php echo $fecha_vencimiento;?>									&nbsp;								</td>																							</tr>							<tr>															</tr>							<tr>															</tr>							<tr>								<td>									<span > Nombre :</span>								</td>								<td colspan="3">									<?php echo $nombre_cliente;?>								</td>							</tr>							<tr>								<td >									<span > Dirección:</span>								</td>								<td colspan="5">									<?php echo $direccion;?>								</td>							</tr>							<tr>								<td >									<span > Referencias:</span>								</td>								<td colspan="5">									<?php echo $referencias;?>								</td>							</tr>							<tr>								<td >									<span > Entre Calles:</span>								</td>								<td colspan="3">									<?php echo $entre_calles;?>								</td>							</tr>							<tr>								<td >									<span > Artículo</span>								</td>								<td colspan="3">									<?php echo $articulo;?>								</td>							</tr>							<tr>								<td>									<span > Teléfono:</span>								</td>								<td >									<?php echo $telefono;?>								</td>																<td>									<span > Estatus</span>								</td>								<td>									<?php echo $estatus;?>								</td>															</tr>							<tr>								<td>									<span > Dia de Cobro:</span>								</td>								<td>									<?php echo $dia_cobranza;?>								</td>																<td>									<span > Importe Total</span>								</td>								<td>									<?php echo $importe;?>								</td>							</tr>							<tr>								<td>									<span > Cobrador</span>								</td>								<td>									<?php echo $cobrador;?>								</td>								<td>									<span > Enganche</span>								</td>								<td>									<?php echo $enganche;?>								</td>							</tr>							<tr>								<td>									<span > Clave Vendedor</span>								</td>								<td>									<?php echo $clave_vendedor;?>								</td>								<td>									<span > Saldo Actual</span>								</td>								<td>									<?php echo $saldo_actual;?>								</td>							</tr>							<tr>								<td>									<span > Sector</span>								</td>								<td>																		<?php echo $sector;?>																		</td>								<td>									<span > Abono Semanal</span>								</td>								<td>									<?php echo $cantidad_abono;?>								</td>							</tr>						</table>					</div>				</div>				<div ID="NOTAS" class="row" style="font-size: 9px !important;">					<div class="col-xs-12">						<p>							NOTA: ACEPTO QUE MUEBLERÍA CASA ROBERTO SE RESERVE EL DOMINIO DEL ARTICULO VENDIDO MIENTRAS NO ESTE TOTALEMENTE 							PAGADO Y QUE LA FALTA DE 3 ABONOS CONSECUTIVOS DAN DERECHO A LA MISMA A RECOGER LA MERCANCIA VENDIDA. LAS CANTIDADES 							PAGADAS APLICARÁN A LOS GASTOS DE VENTA. 						</p>						<b>GRACIAS POR AVISARNOS SU CAMBIO DE DOMICILIO.</b><br>											<b> <i>APRECIABLE CLIENTE: </i> SUS PAGOS SON CADA 8 DÍAS, EN CASO DE DEVOLUCION DEL ARTICULO PAGARÁ 20% MAS POR LA CANCELACIÓN DEL CREDITO Y LAS CANTIDADES ENTREGADAS A CUENTA SON PARA CUBRIR GASTOS, POR LO TANTO NO SE DEVUELVEN. EXIJA SU RECIBO DE PAGO DE CADA ABONO, DE LO CONTRARIO NO SERAN TOMADOS EN CUENTA.</span></b>				</div>			</div>			<br>			<div ID="FIRMA">				NOMBRE COMPLETO: _______________________________________________				FIRMA DEL OTORGANTE:____________________				<BR>				<div class="text-center">					CONTRATO DE COMPRAVENTA CON RESERVA DE DOMINIO				</div>			</div>		</div>				<hr>		<div  id="pagare">			<div  class="row" > 				<div id="" style="padding-left: 2cm;" class="col-xs-4"><h3><b>PAGARÉ</b></h3></div>				<div class="col-xs-4"><label>No</label> 				<input class="form-control input_borde" value="<?php echo $tarjeta != '' ? "Único": ""; ?>"></div>				<div class="col-xs-4"><label>Bueno Por</label> 					<div class="form-group">						<span class="form-group-addon">							<i class="fa fa-dollar"></i>						</span>					<input class="form-control input_borde" value="$ <?php echo $tarjeta != ''? number_format($importe, 2): '';?>"></div>				</div>				<p>										<?php if($tarjeta != ''){?>						En San Sebastián Zumpango Estado de México, a 						<?php echo strftime("%d de %B del %Y", strtotime($fecha_larga));?>. 						Debo (emos) y pagare (mos) incondicionalmente por este Pagaré a la orden de HILARIO ROBERTO LAGUNA LÓPEZ. En cualquier plaza el:						<b><?php echo strftime("%d de %B del %Y", strtotime($fecha_venc_larga));?></b>. 						La cantidad de:												<input class="form-control input_borde" value="(<?php echo NumeroALetras::convertir($importe);?> PESOS 00/100 M.N.)">												<?php						}						else{?>						En San Sebastián Zumpango Estado de México, a 						__________________________________. 						Debo (emos) y pagare (mos) incondicionalmente por este Pagaré a la orden de HILARIO ROBERTO LAGUNA LÓPEZ. En cualquier plaza el:						_____________________________________						La cantidad de:												<input class="form-control input_borde" value="">																		<?php						}					?>										Valor recibido a mí (nuestra) entera satisfacción. Este pagaré forma parte de una serie numerada del 1 al 1 y todos están sujetos a la condición de que, al no pagarse cualquiera de ellos en su vencimiento, serán exigibles todos los que le sigan en número, además de los ya vencidos desde la fecha de vencimiento de este documento hasta el día de su liquidación causará un interés moratorio al tipo de 10% (diez por ciento) mensual, pagadero en esta ciudad conjuntamente con el principal, más los gastos que por ellos se originen.									</p>				<div class="row">					<div class="col-xs-5 doble_linea">						<div class="text-center">							Nombre y datos del deudor						</div>																		<?php							if($tarjeta != ''){?>							Nombre:							<?php echo " <b>". $nombre_cliente."</b>"; ?>							<br>							Dirección:  <?php echo $direccion;?>							<br>							<br>							Firma: ________________________________							<?php							}							else{							?>														Nombre: _______________________________							<br> ______________________________________<br>							Dirección: _____________________________<br>							_______________________________________							<br>														<br>							Firma: ________________________________																																			<?php							}						?>																													</div>					<div class="col-xs-2" id="huella">											</div>					<div class="col-xs-5 doble_linea">						<div class="text-center">							Nombre y datos del aval							</div>						Nombre: _______________________________						<br> ______________________________________<br>						Dirección: _____________________________<br>						_______________________________________						<br>												<br>						Firma: ________________________________											</div>				</div>			</div>		</div>	</div>	<div style="page-break-after:always">	</div>	<div class="borde">		<section>			<h4 class="text-center">POLÍTICAS DE COBRANZA</h4 >			<div class="small">				<br>1.	Al firmar se aceptan las condiciones de venta en la operación. Considere que el menaje adquirido es con RESERVA DE DOMINIO; es decir, mientras no esté pagado en su totalidad le pertenece a la MUEBLERÍA. A la falta de 3 pagos consecutivos, dan derecho de recoger la mercancía vendida. En caso de DEVOLUCIÓN, se paga el 20% por concepto de indemnización. Las cantidades entregadas a cuenta, se aplicarán a los Gastos de Venta.				<br>2.	El hecho de que el cliente no esté en su domicilio cuando pasa el administrador de cartera y no le den el pago no la exime de su obligación de pago de del periodo.				<br>3.	Al adquirir uno de nuestros efectos descritos en el anverso de la presente, es porque cuenta con la capacidad tanto económica como moral para pagarlos en su totalidad;				<br>4.	Realizar tratos de cualquier índole con el administrador de cartera, no tiene ninguna validez. Ellos solo pasan para recibir pagos de dinero; 				<br>5.	Usted como cliente está confiando en La Mueblería, a su vez, la Mueblería en usted, por lo tanto, existe una RELACIÓN MERCANTIL DE CRÉDITO donde se compromete a estar al corriente en sus pagos entre otras cosas;				<br>6.	“La obligación de esta operación, es estar al corriente en sus pagos; sin moras para liquidar en tiempo y forma su cuenta. Por lo tanto, los pagos son consecutivos sin dejar de pagar periodo tras periodo”;				<br>7.	Los pagos son: semanales, quincenales o mensuales según pacto con el ejecutivo de ventas sin fallar;				<br>8.	La entrega de dinero semanal… es en concepto de pago parcial y se abonara inmediatamente a su cuenta para dejar al corriente su saldo;				<br>9.	Por cada pago entregado al administrador de cartera y o la Mueblería, se entrega un ticket-recibo;				<br>10.	No mandar razones con menores de edad, sea usted o persona mayor de edad quien atienda al administrador de cartera; 				<br>11.	Solo en caso de fuerza mayor podrá suspender pagos, pero, tiene que llamar a la empresa al teléfono 591 91 8 54 28 y comprobar su problema con documento fehaciente, para firmar una carta compromiso, sino lo hace, se considerara su morosidad.				<br>12.	Cuando trabaje todo el día o todos los días de la semana sin descanso, deje los pagos con persona de su confianza. 				<br>13.	El administrador no tiene hora para pasar al domicilio; por ende, lo tiene que esperar o bien deje el pago con persona de su confianza, sí tiene que salir;				<br>14.	El administrador de cartera, no está a disposición de ningún cliente, como para decirle que regrese más tarde o a otro día, usted tiene la obligación de pagar puntualmente sin demora; ya sea semanal, quincenal o mensual, según sea el caso, de conformidad con el día de la semana para pago indicado en la nota de venta;				<br>15.	También puede acudir a la MUEBLERÍA en su domicilio fiscal, citado en su Nota de Venta; a realizar pagos o adquirir otro producto siempre que no tenga cuenta vigente o saldo pendiente con el negocio;				<br>16.	Evitar gastos de cobranza e interese moratorios por cada pago incumplido, le beneficia;				<br>17.	El interés moratorio a cobrar es del 10% mensual calculado sobre cada pago no cumplido; 				<br>18.	Por cada periodo incumplido, le sugerimos que en el siguiente trate de ponerse al corriente ya que su(s) atraso(s) estarán aumentando.				<br>19.	Cuando el crédito vence y aún tiene saldo pendiente. La mueblería se reserva el derecho de cobrarlo por otros medios.				<br>20.	El pago es siempre el mismo. Por ejemplo, si es de $100 pesos, siempre debe de ser de $100 pesos y no empezar con $100 y terminar con $50. Porque las diferencias entre uno y otro se irán acumulando y genera un interés moratorio que se sumara al saldo periódicamente.				<br>21.	La GARANTÍA es responsabilidad del fabricante y no de la mueblería; usted cuenta con un directorio con la documentación que proporciona el fabricante dentro del instructivo; entonces, debe llamarles por teléfono para hacer validad dicha garantía; por lo tanto, debe pagar en su totalidad su artículo al negocio.															</div>		</section>								<h4 class="text-center">CONTROL DE PAGOS</h4>		<table BORDER="2" class="table table-condensed">			<tr>				<th># </th>				<th>MES </th>				<th>DIA </th>				<th>PAGO</th>				<th>SALDO</th>				<th>RECIBIO</th>				<th>MES </th>				<th>DIA </th>				<th>PAGO </th>				<th>SALDO</th>				<th>RECIBIO</th>									</tr>			<?php for($i = 1; $i < 16; $i++){?>				<tr>										<td><?php echo $i?></td>					<td></td>					<td></td>					<td></td>				<td></td>				<td></td>				<td></td>				<td></td>				<td></td>				<td></td>				<td></td>				</tr>				<?php 				}			?>		</table>			</div></div></body></html>								