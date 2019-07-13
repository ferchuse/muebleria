<?php
	include "login/login_success.php";
	include ("conex.php");
	//include ("is_selected.php");
	$link = Conectarse();
	
	
	if($_GET["fecha_reporte"]){
		$fecha_reporte  = $_GET["fecha_reporte"];
	}
	else{
		$fecha_reporte = date("m/d/Y");
	}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Reportes de Existencias</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css"  media="print"/>		
	<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.css"  />
	<link rel="stylesheet" type="text/css" href="tablecloth/tablecloth.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css" />
	  
	 
	<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
	<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/validar.js"></script>
	<script type="text/javascript" src="js/autorellenar.js"></script>
	<script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.dataTables.js"></script>

	<script>
		$(function() {
			$( "#fecha_inicial" ).datepicker({
				changeMonth: true,
				changeYear: true,
				//yearRange: '1920:2000'
			});
			
		});
		
		function validar(){
		txt_f_i= $("#fecha_inicial").val();
		txt_f_f= $("#fecha_final").val();
		
			if (txt_f_i == ''){
				alert("Ingresa una Fecha Inicial") ;
				return false;
			}
			
			//return true	;	
		
		}
	</script>
</head>

<body>
<?php
include("header.php");
?>

<?php

?>
<div class="contenido">

	<?php 

		$q_rutas = "SELECT * FROM vendedores";

		$result_rutas=mysql_query($q_rutas,$link) or die("Error en: $q_rutas  ".mysql_error());



	while($row = mysql_fetch_assoc($result_rutas)){
					$ruta = $row["ruta"];
					$nombre_vendedor = $row["nombre_vendedor"];
					
					
	$q_existencia ="SELECT * FROM existencias_ruta
	 INNER JOIN productos
	 ON existencias_ruta.codigo_barras = productos.codigo_barras 
	 WHERE ruta = '$ruta' ORDER BY orden_producto ";

	$result_existencia=mysql_query($q_existencia,$link) or die("Error en: $q_existencia  ".mysql_error());
	?>
	
	<div class="titulo">
		RUTA:  <?php echo $ruta;?> <br>
		VENDEDOR:  <?php echo $nombre_vendedor;?>
	</div >

	
	<table border="1" >
		
			<th>Producto</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Piezas en Existencia </th>
			<th>Valor Existencia </th>
			<th>Total a Pagar </th>
			<th>Ganancia </th>
				
			
		<?php
		
		$sum_valor_existencia = array();
		$sum_total_pagar = array();
		$sum_ganancia = array();
		while($row = mysql_fetch_assoc($result_existencia)){
					$nombre_producto = $row["nombre_producto"];
					$precio_compra = $row["precio_compra"];
					$precio_venta = $row["precio_venta"];
					$existencia = $row["piezas"];
					$valor_existencia = $precio_venta * $existencia;
					$total_pagar = $precio_compra *  $existencia;
					$ganancia = $valor_existencia -  $total_pagar;
					$sum_valor_existencia[] = $valor_existencia;
					$sum_total_pagar[] = $total_pagar;
					$sum_ganancia[] = $ganancia;
		?>
		<tr>
			<td>
				<?php echo "$nombre_producto";?>
			</td>
			<td align="right">
				<?php echo "$"." $precio_compra";?>
			</td>
			<td align="right">
				<?php echo "$"." $precio_venta";?>
			</td>
			<td>
				<?php echo "$existencia";?>
			</td>
			<td>
				<?php echo "$ ". number_format($valor_existencia,2);?>
			</td>
			<td>
				<?php echo "$ ". number_format($total_pagar,2);?>
			</td>
			<td>
				<?php echo "$ ". number_format($ganancia,2);?>
			</td>
		</tr>

		<?php
		}
		?>
		<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<b><?php echo  "$ ".number_format(array_sum($sum_valor_existencia),2);?></b>
				</td>
				<td>
					<b><?php echo  "$ ".number_format(array_sum($sum_total_pagar),2);?></b>
				</td>
				<td>
					<b><?php echo  "$ ".number_format(array_sum($sum_ganancia),2);?></b>
				</td>
			</tr>
</table>


<?php }?>
</div>
</body>
</html>