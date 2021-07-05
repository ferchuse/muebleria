<?php 
	include "login/login_success.php";
	include("conexi.php");
	$link = Conectarse();
	
	$tarjeta = $_GET["tarjeta"];
	$q_tarjeta = "SELECT * , 
	suma_importe - suma_enganche - IF(ISNULL(total_abonado), 0, total_abonado) AS saldo_calculado
	FROM ventas 
	
	LEFT JOIN 
	(
	SELECT
	tarjeta,
	IF(ISNULL(SUM(abono)), 0 ,SUM(abono))   AS total_abonado
	FROM
	abonos
	WHERE
	tarjeta = '$tarjeta'
	) as t_abonado
	USING(tarjeta)
	
	LEFT JOIN 
	estatus
	USING(id_estatus)
	
	LEFT JOIN 
	(
	SELECT
	tarjeta,
	SUM(importe) AS suma_importe,
	SUM(enganche) AS suma_enganche
	FROM
	ventas
	WHERE
	tarjeta = '$tarjeta'
	) as t_importe
	USING(tarjeta)
	WHERE tarjeta = '{$_GET["tarjeta"]}'";
	$result = mysqli_query($link, $q_tarjeta);
	
	$venta = Array();
	while($fila = mysqli_fetch_assoc($result)){
		$venta = $fila;	
	}
?>


<div class="ticket58">
	<div class="titulo text-center">
		<div id="logo">
			<img src="img/logo.png" width="200" height="50"/>
		</div>
		
	</div>
	<div class="text-center">
		<I>"LLEVANDO SATISFACCIÓN A LOS HOGARES" </I><br>
		<small style="font-size: 8px !important;  line-height: 60%;" >
			HILARIO ROBERTO LAGUNA LÓPEZ RFC LALH640228EK7 CURP LALH640228HMCGPL02 
			Régimen de Incorporación Fiscal<br>
			VENTA DE ARTICULOS PARA EL HOGAR  <br>
			
			AV 16 DE SEPTIEMBRE S/N SAN SEBASTIÁN, ZUMPANGO ESTADO DE MEXICO , <BR>
			Tel: (01591) 9185428 <BR>
			Esta nota de venta forma parte de la factura global del dia.
		</small>
	</div>
	
	COPIA CLIENTE 	<span id="tarjeta" class="lead pull-right">
		N°:	<?php echo $venta["nv"]?>
	</span>
	<br>
	<br>
	
	-----------------------------------
	<div class="fila_ticket">
		<span class=" ">
			<strong>Tipo de Venta: </strong>
		</span>
		<span id="tarjeta" class="">
			<?php echo $venta["tipo_venta"]?>
		</span>
	</div>
	
	<div class="fila_ticket">
		<span class="">
			<strong>Fecha: </strong>
		</span>
		<span id="fecha_abono" class="pull-right">
			<?php echo date("d/m/Y", strtotime($venta["fecha_venta"]));?>
		</span>
	</div>
	
	------------------------
	
	<div class="fila_ticket">
		<span class="">
			<strong>Cliente: </strong>
		</span>
		<br>
		<span id="cliente" >
			<?php echo $venta["nombre_cliente"]?>
		</span>
	</div>
	<div class="fila_ticket">
		<span class="">
			<strong>Dirección: </strong>
		</span>
		<br>
		<span id="cliente" >
			<?php echo $venta["direccion"]?>
		</span>
	</div>
	<div class="fila_ticket">
		<span class="">
			<strong>Referencias: </strong>
		</span>
		<br>
		<span id="" >
			<?php echo $venta["referencias"]?>
		</span>
	</div>
	<div class="fila_ticket">
		<span class="">
			<strong>Entre Calles: </strong>
		</span>
		<br>
		<span id="" >
			<?php echo $venta["entre_calles"]?>
		</span>
	</div>
	<div class="fila_ticket">
		<span class="">
			<strong>Telefono: </strong>
		</span>
		<br>
		<span id="" >
			<?php echo $venta["telefono"]?> <br>
			<?php echo $venta["celular"]?> <br>
		</span>
	</div>
	<div class="fila_ticket">
		<span>
			<strong>Artículo: </strong>
		</span>
		<span id="span_articulo" >
			<?php echo $venta["articulo"]?>
		</span>
	</div>
	<div class="fila_ticket">
		<span>
			<strong>Importe: </strong>
		</span>
		<span id="span_importe" class="pull-right">
			$<?php echo number_format($venta["importe"])?>
		</span>
	</div>
	
	<div class="fila_ticket">
		<span>
			<strong>Anticipo: </strong>
		</span>
		<span id="span_anticipo" class="pull-right">
			$<?php echo number_format($venta["enganche"])?>
		</span>
	</div>
	<div class="fila_ticket">
		<span>
			<strong>Por Cobrar: </strong>
		</span>
		<span id="span_restante" class="pull-right">
			$<?php echo number_format($venta["saldo_calculado"])?>
		</span>
	</div>
	<div class="fila_ticket">
		<span class="">
			<strong>Vendedor: </strong>
		</span>
		<br>
		<span id="span_vendedor" class="pull-right">
			<?php echo $venta["nombre_vendedor"]?>
		</span>
	</div>
</div>	