<?php	include ("conex.php");	include ("is_selected.php");	$link = Conectarse();		$meses = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");		if($_GET["tarjeta"]){		$tarjeta  = $_GET["tarjeta"];	}?><!DOCTYPE html><html>	<head>		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		<title>Imprimir Aviso</title>		<link rel="stylesheet" type="text/css" href="font_awesome/css/font-awesome.min.css" />		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"  media="all"/>		<link rel="stylesheet" type="text/css" href="css/imprimir_aviso.css" media="all"/>							</head>	<body>						<?php 			$q_tarjeta = "SELECT * FROM ventas WHERE tarjeta = '$tarjeta'";			$result_tarjeta=mysql_query($q_tarjeta,$link) or die("Error en: $q_tarjeta  ".mysql_error());			$rowcount=mysql_num_rows($result_tarjeta);						while($row = mysql_fetch_assoc($result_tarjeta)){				$nv = $row["nv"];				$tarjeta = $row["tarjeta"];				$fecha_venta = date("d/m/Y", strtotime($row["fecha_venta"]));				$fecha_vencimiento = date("d/m/Y", strtotime($row["fecha_vencimiento"]));				if($fecha_vencimiento == '31/12/1969'){					$fecha_vencimiento = '';				}				$nombre_cliente = $row["nombre_cliente"];				$direccion = $row["direccion"];				$dia_cobranza = $row["dia_cobranza"];				$clave_vendedor = $row["clave_vendedor"];				$saldo_actual = $row["saldo_actual"];				$cobrador = $row["cobrador"];				$sector = $row["sector"];				$articulo = $row["articulo"];				$importe = $row["importe"];				$enganche = $row["enganche"];				$saldo_actual  = $row["saldo_actual"];				$cantidad_abono  = $row["cantidad_abono"];				$estatus  = $row["estatus"];				$fecha_hora_mod  = $row["fecha_hora_mod"];				$usuario_mod  = $row["usuario_mod"];											}		?>		<div class="container"> 			<div class="row hidden-print" >				<div class="col-xs-12" >					<div class="pull-right">						<button type="button" id="primer" class="btn btn-info btn-lg" >							<i class="fa fa-print"></i> PRIMER AVISO						</button>							<button type="button" id="segunoo" class="btn btn-info btn-lg" >							<i class="fa fa-print"></i> SEGUNDO AVISO						</button>					</div>				</div>			</div>			<div class="row" hidden>				<div class="col-xs-4">					<div id="logo">						<img src="img/logo.png" width="200" height="50"/>					</div>				</div>				<div class="col-xs-8">					<div id="rfc">						RFC LALH640228EK7 <br>						VENTA DE ARTICULOS PARA EL HOGAR <br>					</div>					<div id="direccion_muebleria">						AV 16 DE SEPTIEMBRE S/N </br>						SAN SEBASTIÁN,</br> 						ZUMPANGO ESTADO DE MEXICO </br>						(01591) 9185428						CEL: 5543213826					</div>				</div>			</div>			<div class="row" >				<div class="col-xs-6 col-xs-offset-6 text-right">					ZUMPANGO, ESTADO DE MEXICO a <?php echo date("d"). " de " .$meses[date("n")-1], " de ". date("Y"); ?><br>					Cuenta # <?php echo $tarjeta; ?><br>									</div>			</div>			<h3 id="aviso" style="text-align: right">				ASUNTO: SE CITA A PLATICAS			</h3>				<h4 id="">				<?php echo $nombre_cliente;?><BR>				<?php echo $direccion;?><BR>				PRESENTE<BR>							</h4>			<div id="row">				<div class="col-xs-12">					<p>						Considerando que la CONCILIACION, es el medio más eficaz para solucionar los conflictos entre usted y la Mueblería Casa Roberto, el área de Crédito y Cobranzas por este conducto le hace una atenta INVITACIÓN a usted a PLATICAS CONCILIATORIAS tendientes a solucionar el crédito número <b><?php echo $_GET["tarjeta"]?></b>, misma que se llevara a cabo en el local de la Mueblería el día _________________ a las ________________					</p>					<p>						Se hace de su conocimiento que esta Mueblería tiene su domicilio en<b> AVENIDA MORELOS NÚMERO 10, BARRIO DE SAN JUAN CENTRO, EN EL MUNICIPIO DE ZUMPANGO ESTADO DE MÉXICO. </b>					</p>										Agradeciendo de antemano su presencia, quedo de usted.					<div class="text-center" >						ATENTAMENTE 						<br>						<br>						<br>												_________________________<br>												AREA JURIDICA					</div>									</div>			</div>			<hr>									</div>						<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<br>		<hr>		<div class="container"> 						<div class="row" >				<div class="col-xs-4">					<div id="logo">						<img src="img/logo.png" width="200" height="50"/>					</div>				</div>				<div class="col-xs-8">					<div id="rfc">						RFC LALH640228EK7 <br>						VENTA DE ARTICULOS PARA EL HOGAR <br>					</div>					<div id="direccion_muebleria">						AV 16 DE SEPTIEMBRE S/N </br>						SAN SEBASTIÁN,</br> 						ZUMPANGO ESTADO DE MEXICO </br>						(01591) 9185428						CEL: 5543213826					</div>				</div>			</div>			<div class="row" >				<div class="col-xs-6 col-xs-offset-6 text-right">					San Sebastian, Zumpango a <?php echo date("d"). " de " .$meses[date("n")-1], " de ". date("Y"); ?><br>					Cuenta # <?php echo $tarjeta; ?><br>					Importe Atraso # <?php echo $importe_atraso; ?><br>				</div>			</div>			<h3 id="aviso2">				PRIMER AVISO			</h3>				<h4 id="">				Sr(a): <?php echo $nombre_cliente;?>			</h4>			<div id="row">				<div class="col-xs-12">					<p>						NOSOTROS LO CONSIDERMAOS A USTED UN BUEN CLIENTE, ES POR ESO NUESTRA PREOCUPACIÓN POR EL SALDO ATRASADO QUE REFLEJA SU CUENTA. RECUERDE QUE LA PUNTUALIDAD EN SUS PAGOS ES LA BASE PARA MANTENER SIEMPRE SU BUEN HISTORIAL DE CRÉDITO. SU COMPROMISO FUE PAGAR PUNTUALMENTE COMO LO ESTIPULA EL CONTRATO. NO DESCUIDE SU CRÉDITO.					</p>					<b>							Estimado cliente evite gastos de Cobranza. Si usted acumula 3 semanas de atraso consecutivas se le hará un cargo de $10.00 (Diez pesos m.n. 00/100) por semana de gastos de cobranza. <br>						**Exija su ticket de pago a su cobrador, ya que es la única forma de comprobar su pago para cualquier aclaración.											</b>				</div>			</div>			<hr>				<div id="row">				<div class="col-xs-6 text-center">					ATENTAMENTE <BR><BR>										___________________ <BR>					COBRANZAS				</div>				<div class="col-xs-6 text-RIGHT">					SALDO CUENTA: $ <u> <?php echo $saldo_actual;?></u><br>					ATRASOS: $ <u> <?php echo $atrasos;?></u><br>					IMPORTE ATRASO: $ <u> <?php echo $importe_atraso;?></u><br>				</div>			</div>			<hr>					</div>										<?php include("scripts.php");?>				<script type="text/javascript">			$( document ).ready(function() {								$("#primer").click(function(e){					$("#aviso").html("PRIMER AVISO");					$("#aviso2").html("PRIMER AVISO");					window.print();				});				$("#segundo").click(function(e){					$("#aviso").html("SEGUNDO AVISO");					$("#aviso2").html("SEGUNDO AVISO");					window.print();				});							}); 		</script>	</body></html>