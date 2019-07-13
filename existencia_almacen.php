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
	<title>Existencias Actuales en Almacen</title>
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
		
		$( document ).ready(function() {
			var datos = 		
				[
					["data1",  "data2"],
					["data3",  "data4"],
					["data4",  "data5"]
				];
			
			$('#tabla_reporte').DataTable({
				"paging":   false,
				"ordering": false,
				"info":     false,
				"filter": false
			});
		}); 
		
	</script>
</head>

<body>
<?php
include("header.php");
?>


<div class="contenido">

	<div class="titulo">
		Existencias de Almacen <?php echo date("d/m/Y");?>
	</div>
	<!--
	<div id="fechas">
		<form name="form_rep_mes" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validar(this.name);"	>
			<span class="">
				Fecha : <input size="10" type="text" name="fecha_reporte" id="fecha_inicial" value="<?php echo $fecha_reporte;?>" />
			</span>
			<input class="boton" type="submit" name="buscar_fecha" value="Buscar" />
		</form>
	</div>
	-->	
		
	<table border="1" id="tabla_reporte" class="display compact" >
		<thead>
		
			<th>Producto</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Existencia Inicial </th>
			<th>Entradas </th>
			<th>Salidas </th>
			<th>Existencia Final </th>
			<th>Valor Existencia </th>
			<th>Total a Pagar </th>
			<th>Ganancia </th>
		</thead>		
		<tbody>		
				
			
		<?php
			$q_existencia =
			"SELECT * FROM existencias_almacen
			INNER JOIN productos
			ON existencias_almacen.codigo_barras = productos.codigo_barras 
			LEFT JOIN (SELECT codigo_barras, SUM(piezas) as salidas, fecha as fecha_salida
						FROM detalle_salida_almacen 
						INNER JOIN salidas_almacen 
						ON salidas_almacen.id_salida = detalle_salida_almacen.id_salida
						WHERE fecha = CURDATE()
						GROUP BY codigo_barras) AS salidas
			ON salidas.codigo_barras = existencias_almacen.codigo_barras
			LEFT JOIN (SELECT codigo_barras, SUM(piezas) as entradas, fecha as fecha_entrada
						FROM detalle_entrada_almacen
						INNER JOIN entradas_almacen 
						ON entradas_almacen.id_entrada = detalle_entrada_almacen.id_entrada
						WHERE fecha = CURDATE()
						GROUP BY codigo_barras) AS entradas
			ON entradas.codigo_barras = existencias_almacen.codigo_barras
			
			";

			$result_existencia=mysql_query($q_existencia,$link) or die("Error en: $q_existencia  ".mysql_error());
				
			
		
		$sum_valor_existencia = array();
		$sum_total_pagar = array();
		$sum_ganancia = array();
		while($row = mysql_fetch_assoc($result_existencia)){
					$nombre_producto = $row["nombre_producto"];
					$precio_compra = $row["precio_compra"];
					$precio_venta = $row["precio_venta"];
					$existencia_inicial = $row["existencia_inicial"];
					$existencia_final = $row["existencia_en_piezas"];
					$valor_existencia = $precio_venta * $existencia_final;
					$total_pagar = $precio_compra *  $existencia_final;
					$ganancia = $valor_existencia -  $total_pagar;
					$salidas = $row["salidas"];
					$entradas = $row["entradas"];
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
				<?php echo  number_format($existencia_inicial,0);?>
			</td>
			<td>
				<?php echo  number_format($entradas,0);?>
			</td>
			<td>
				<?php echo  number_format($salidas,0);?>
			</td>
			<td>
				<?php echo  number_format($existencia_final,0);?>
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
		<tbody>
		
		</tfoot>
		<tr>
				<td></td>
				<td></td>
				<td></td>
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
		</tbody>
</table>

	
</div>
</body>
</html>