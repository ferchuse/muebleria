<?php
include "login/login_success.php";
include ("conex.php");
$link = Conectarse();
?>
<!DOCTYPE html> 
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="HandheldFriendly" content="true" />
<title>Nueva Carga</title>


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

<script type="text/javascript">
$( document ).ready(function() {
	
	var id_formulario = "form_nueva_carga";
	
	//Selecciona todo el texto al recibir el evento focus 
	$("input:text").focus(function() { $(this).select(); } );
	
	//Guarda el formulario
	$('#btn_guardar').click(function(event){
		//alert("Guardadno");
		event.preventDefault();
		
		if (validar("registro_venta")){
			$.post("guardar_carga.php", $( "#form_nueva_carga" ).serialize(),   function(data_return, status){
				alert(data_return);
				
				//regresa todos los valores a 0
				if(status =="success"){
					$('.subtotales').each(function(index) {
						$(this).val(0);
					});
					$('.cantidades').each(function(index) {
						$(this).val(0);
					});
					$("#txt_importe_total").val(0);
				}
			});
		}
	}); 
	
	function calcular_importe(){
		var importe_total = 0;
		$('.subtotales').each(function(index) {
			importe_total += Number($(this).val());
		});
		//alert(importe_total);	
		$("#txt_importe_total").val(importe_total.toFixed(2));
	} 
	 
	$(".cantidades").keydown(function(event){
			var cantidad = $(this).val();
			var index = $( ".cantidades" ).index( this );
			var pu = $(".pus").eq(index).val();
			
			var nuevo_subtotal = cantidad * pu;
			
			 $(".subtotales").eq(index).val(nuevo_subtotal.toFixed(2));
			 
			 if(event.which == 13){
			
				//Pasa al siguiente cuadro de texto al presionar enter
				$('.cantidades').eq(index +1).focus();
			 }
			 if(event.which == 40){
				//Pasa al siguiente cuadro de texto al presionar enter
				$('.cantidades').eq(index +1).focus();
			 }
			 if(event.which == 38){
			
				//Pasa al siguiente cuadro de texto al presionar enter
				$('.cantidades').eq(index -1).focus();
			 }
			 
			 calcular_importe();
	}); 
	 
	 
	$(function() {
		$( "#fecha_carga" ).datepicker({
			changeMonth: true,
			changeYear: true,
			//yearRange: '1920:2000'
		});
	});
	
	
	//evita el envio del formulario al presionar enter
	$('#form_nueva_carga').keypress(function(event){   
		if(event.which == 13){
		  return false;
		}
		
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
		Nueva Carga 
	</div>
<form onsubmit="return validar();" action="" method="post" id="form_nueva_carga" accept-charset="utf-8">
 
  <div class="form-all">
		  
		<div id="cid_4" class="form-input">
			<label class="label" id="label_4" for="txt_nombre_doctor">   RUTA:</label>
			
			<?php 
			$q_rutas ="SELECT ruta FROM vendedores ";
			$result_rutas=mysql_query($q_rutas,$link) or die("Error en: $q_rutas  ".mysql_error());
			while($row = mysql_fetch_assoc($result_rutas)){
				$ruta = $row["ruta"];
				$nombre_vendedor = $row["nombre_vendedor"];
					
			?>
				<input type="radio" class="rutas" name="ruta" value="<?php echo $ruta; ?>"/><?php echo $ruta; ?>
			<?php
			}
			?>
		</div>
		<div class="fechas">
			<span >
				Fecha de Carga: <input size="10" type="text" name="fecha_carga" id="fecha_venta"  />
			</span>
		</div>
		
		<div id="cid_1" class="form-input">
			<label class="form-label-left" id="label_1" for="txt_nombre_paciente"> Kilometraje Inicial</label>
		
			<input type="text" class="form-textbox" id="txt_kilometraje_final" name="kilometraje_final" size="10" value="" />
		</div>
  </div>



<button   id="btn_guardar" >
	Guardar
</button>




<table  id="tabla_detalle_carga" class="compact">
	<thead>
		
		<th>
			Producto
		</th>
		<th>
			Piezas
		</th>
	</thead>	
	<tbody>
	
	<?php
		$q_productos ="SELECT * FROM productos ORDER BY orden_producto";

		$result_productos=mysql_query($q_productos,$link) or die("Error en: $q_productos  ".mysql_error());
		
		
		while($row = mysql_fetch_assoc($result_productos)){
					$orden_producto = $row["orden_producto"];
					$codigo_barras = $row["codigo_barras"];
					$nombre_producto = $row["nombre_producto"];
					
					$piezas_por_caja = $row["piezas_por_caja"];
		?>
		<tr>
			<input type="hidden" value="<?php echo "$codigo_barras";?>" name="codigos[]" />
			
			<td>
			<input type="hidden" value="<?php echo "$nombre_producto";?>" name="productos[]">
			
				<?php echo "$nombre_producto";?>
			</td>
			<td align="right">
				<input type='text' class='cantidades'  name='cantidades[]' value='0' size="10" />
			</td>
			
		</tr>
		<?php 
		}
		?>
	</tbody>
</table>



</form>
</div>
</body>
</html>