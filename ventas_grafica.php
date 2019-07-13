<?php
	include "login/login_success.php";
	include ("conex.php");
	//vinclude ("is_selected.php");
	$link = Conectarse();
	
	//$dia_inicial = $dia_semana["wday"] -1;
	//$dia_final = 6 - $dia_semana["wday"] ;
	
	
	if($_GET["fecha_inicial"]){
	
		$fecha_inicial = $_GET["fecha_inicial"];
		$fecha_final = $_GET["fecha_final"];
	
	}
	else{
		$dia_semana = date("w");
	
		$dia_inicial = $dia_semana-1;
		$dia_final = 6 - $dia_semana ;
		
		$fecha_inicial = date("d/m/Y",strtotime("-$dia_inicial days"));
		$fecha_final = date("d/m/Y",strtotime("+$dia_final days"));
	
	}
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Ventas Por Semana</title>
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
	<script type="text/javascript" src="js/jquery.ui.datepicker-es.js"></script>
	<script type="text/javascript" charset="utf8" src="DataTables-1.10.4/media/js/jquery.dataTables.js"></script>
	
	<script>
		$(function() {
			$( "#fecha_inicial" ).datepicker({
				changeMonth: true,
				changeYear: true,
				//yearRange: '1920:2000'
			});
			$( "#fecha_final" ).datepicker({
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
			if (txt_f_f == ''){
				alert("Ingresa una Fecha Final") ;
				return false;
			}
			
			//return true	;	
		
		}
	</script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
    	var datos = $.ajax({
    		url:'datosgrafica.php',
    		type:'post',
    		dataType:'json',
    		async:false    		
    	}).responseText;
    	
    	datos = JSON.parse(datos);
    	google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(dibujarGrafico);
      
      	function dibujarGrafico() {
        	var data = google.visualization.arrayToDataTable(datos);

        	var options = {
          	title: 'VENTAS DEL PRIMER BIMESTRE',
          	hAxis: {title: 'MESES', titleTextStyle: {color: 'green'}},
          	vAxis: {title: '', titleTextStyle: {color: '#FF0000'}},
          	backgroundColor:'#ffffcc',
          	legend:{position: 'bottom', textStyle: {color: 'blue', fontSize: 13}},
          	width:900,
            height:500
        	};

        	var grafico = new google.visualization.ColumnChart(document.getElementById('grafica'));
        	grafico.draw(data, options);
      	}
	</script>
</head>
<body>
<?php
include("header.php");
?>
<div class="contenido">

	
	<div class='titulo'>Reporte Semanal de Ventas </div>
	<div id="grafica" >
	
	</div>
</div>
</body>
</html>