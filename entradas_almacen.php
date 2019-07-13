<?php
include "login/login_success.php";
include ("conex.php");
$link = Conectarse();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="HandheldFriendly" content="true" />
<title>Nuevo Carga</title>


<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css"  media="print"/>		
<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.css"  />
<link rel="stylesheet" type="text/css" href="tablecloth/tablecloth.css" media="screen" />
<link rel="stylesheet" type="text/css" href="DataTables-1.10.4/media/css/jquery.dataTables.css" />
  
 
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/calcular_total.js"></script>
<script type="text/javascript" src="js/paquetes.js"></script>
<script type="text/javascript" src="js/validar.js"></script>
<script type="text/javascript" src="js/autorellenar.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.dataTables.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
	$('#txt_codigo_barras').focus();
	var tabla_detalle = $('#tabla_detalle_carga').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
		"filter": false
    } );
	//evita enviar el formulario el presionar enter
	/* $('#form_alta_estudio').keypress(function(e){   
		if(e.which == 13){
		  return false;
		}
		
	 }); */
	  
	 $("#txt_codigo_barras").keypress(function(e){
		if(e.which == 13){
		  var codigo = $("#txt_codigo_barras").val();
		  $.get("get_nombre_producto.php", {codigo_barras: codigo } ,function(data){
			 $('#txt_nombre_producto').val(data);
		  })
		   $('#txt_cantidad').focus();
		}
	 });
	 
	  $("#txt_cantidad").keypress(function(e){
		if(e.which == 13){
			//var input = $("#txt_codigo_barras").val();
			var txt_codigo = $("#txt_codigo_barras").val();
			var txt_producto = $('#txt_nombre_producto').val();
			var txt_cantidad = $('#txt_cantidad').val();
			tabla_detalle.row.add( [
				"<input type='text' name='codigos[]' value='" +txt_codigo+ "' />",
				"<input type='text' name='productos[]' value='" +txt_producto+ "' />",
				"<input type='text' name='cantidades[]' value='" +txt_cantidad+ "' />"
				
				
			] ).draw();
			$("#txt_codigo_barras").val("");
			$('#txt_nombre_producto').val("");
			$('#txt_cantidad').val("");
			$("#txt_codigo_barras").focus();
		}
	 });
	 
	 
	$("#datos_cliente").hide();
	$("#chk_factura").click(function(){
		$("#datos_cliente").fadeToggle(800);
	});
	
	$("#txt_fecha_entrega" ).datepicker({
		changeMonth: true,
		changeYear: true,
		inline: true
		//yearRange: '1920:2000'
	});
	
	$( "#txt_nombre_producto" ).autocomplete({
		source: "search.php?tabla=doctores&campo=nombre_doctor&valor=nombre_doctor&etiqueta=nombre_doctor",
		minLength : 2,
		 select: function( event, ui ) {
			$('#tel_doctor').val( ui.item.tel);
			$('#direccion_doctor').val( ui.item.dir );
			$('#select_zona').val( ui.item.zona );
			//$('#select_zona')..attr('selected','selected');( ui.item.zona );
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
<form onsubmit="return validar();" action="guardar_carga.php" method="post" id="form_alta_estudio" accept-charset="utf-8">
 
  <div class="form-all">
		 
		<label class="form-label-left" id="label_4" for="txt_nombre_doctor">   RUTA:</label>
        <div id="cid_4" class="form-input">
			<select name="zona_origen" id="select_zona">
				<option value="" selected="selected">Ruta	</option>
				<option value="1" >1</option>
				<option value="2">2</option >
				<option value="3">3</option >
			</select>
		</div>
		<div>
			<label class="form-label-left" id="label_1" for="txt_nombre_paciente"> Kilometraje</label>
			<div id="cid_1" class="form-input">
				<input type="text" class="form-textbox" id="txt_kilometraje" name="kilometraje" size="10" value="" />
			</div>
		</div>
		<label class="form-label-left" id="label_1" for="txt_nombre_paciente"> Código</label>
		<div id="cid_1" class="form-input">
			<input type="text" class="form-textbox" id="txt_codigo_barras" name="codigo_barras" size="10" value="" />
		</div>
        <label class="form-label-left" id="label_1" for="txt_nombre_paciente"> Producto *</label>
        <div id="cid_1" class="form-input">
          <input type="text" class="form-textbox" id="txt_nombre_producto" name="producto" size="60" value="" />
        </div>
      
        <label class="form-label-left" for="tel_paciente"> Piezas </label>
        <div id="cid_13" class="form-input">
          <input type="text" class=" form-textbox"  id="txt_cantidad"  size="10" value="" />
        </div>
     
  </div>
</form>


<form onsubmit="return validar();" action="imprimir_ticket.php" method="post" id="form_alta_estudio" accept-charset="utf-8">
 
<input type="submit" value="Guardar e imprimir" name="guardar">
<table  id="tabla_detalle_carga" class="compact">
	<thead>
		<th>
			Código
		</th>
		<th>
			Producto
		</th>
		<th>
			Cantidad
		</th>
	</thead>	
	<tbody>
		<tr>
			<td>
			
			</td>
			<td>
				
			</td>
			<td>
				
			</td>
		</tr>
	</tbody>
</table>

</form>
</div>
</body>
</html>