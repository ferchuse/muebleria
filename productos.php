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
	if($_GET["order"]){
		$order  = $_GET["order"];
	}
	else{
		$fecha_reporte = date("m/d/Y");
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Productos</title>
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

</head>

<body>
<?php
include("header.php");
include("guardar_productos.php");
?>

<?php
$q_productos ="SELECT * FROM productos ORDER BY orden_producto";

$result_productos=mysql_query($q_productos,$link) or die("Error en: $q_productos  ".mysql_error());
	
?>
<div class="contenido">

	<form action="" method="POST">
	
	<input type="submit" name="guardar" value="Guardar" />
	<table border="1" id="tabla_reporte">
		
			<th>Orden</th>
			<th>Codigo Barras</th>
			<th>Nombre</th>
			<th>Precio Compra</th>
			<th>Precio Venta</th>
			<th>Piezas por Caja </th>
			<th>% Ganancia </th>
			<th> $ Ganancia </th>
				
			
		<?php
		
		while($row = mysql_fetch_assoc($result_productos)){
					$orden_producto = $row["orden_producto"];
					$codigo_barras = $row["codigo_barras"];
					$nombre_producto = $row["nombre_producto"];
					$precio_compra = $row["precio_compra"];
					$precio_venta = $row["precio_venta"];
					$piezas_por_caja = $row["piezas_por_caja"];
					$porcentaje_ganancia = ($precio_venta - $precio_compra)* 100 / $precio_venta;
					$porcentaje_ganancia = number_format($porcentaje_ganancia,1);
					$ganancia = ($precio_venta - $precio_compra) ;
					$ganancia = number_format($ganancia,2) ;
					
					
				
		?>
		<tr>
			<td>
				<input size="5" type="text" name="orden_producto[<?php echo "$codigo_barras";?>]" value="<?php echo "$orden_producto";?>"/>
			</td>
			<td>
				<input type="text" size="15" name="codigo_barras[<?php echo "$codigo_barras";?>]" value="<?php echo "$codigo_barras";?>"/>
				
			</td>
			<td>
				<?php echo "$nombre_producto";?>
			</td>
			<td align="right">
				$ <input size="8"  type="text" name="precio_compra[<?php echo "$codigo_barras";?>]" value="<?php echo "$precio_compra";?>"/>
				
			</td>
			<td align="right">
				$ <input size="8"  type="text" name="precio_venta[<?php echo "$codigo_barras";?>]" value="<?php echo "$precio_venta";?>"/>
			</td>
			<td align="right">
				<input size="10"  type="text" name="piezas_por_caja[<?php echo "$codigo_barras";?>]" value="<?php echo "$piezas_por_caja";?>"/>
			</td>
			<td align="right">
				<?php echo $porcentaje_ganancia."% ";?>
			</td>
			<td align="right">
				<?php echo "$ ".$ganancia;?>
			</td>
			
		</tr>

		<?php
		}
		?>
		
</table>
</form>
</div>
</body>
</html>