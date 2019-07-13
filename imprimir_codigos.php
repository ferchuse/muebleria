<html>
<head>
	<meta charset="utf-8" />
		<link rel="shortcut icon" href="favicon.ico" />
		<title>
			Imprimir Códigos de Barras
		</title>
		
		<!-- <link rel="stylesheet" href="css/layout.css" type="text/css"/>-->
		
		
		<link rel="stylesheet" type="text/css" href="css/layout.css" />
		<link rel="stylesheet" type="text/css" href="css/layout.css"  media="print"/>		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"  />		
		<link rel="stylesheet" type="text/css" href="font_awesome/css/font-awesome.min.css"  />		
		
		<link rel="stylesheet" href="css/imprimir_codigos.css" type="text/css" media="all"/>
		
		<script type="text/javascript" src="js/validar.js" charset="utf-8"></script>
		<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
		
		<script type="text/javascript" src="js/jquery-barcode.min.js"></script>
		<script type="text/javascript">
		$( document ).ready(function() {
			var cantidad = 0;		 
			$("#txt_codigo").keypress(function(e){
				if(e.which == 13){
					
					$("#btn_agregar_codigo").click();
				}
			});
			var index = 0;
			
			
			$("#btn_agregar_codigo").click(function(e){
				index++;
				
				if(index > 30){
					alert("Solo se Pueden imprimir 30 coóigos por página")
					
				}
				else{
						var codigo = $("#txt_codigo").val();
						
					var btype = "code128";

					var settings = {
					  output: "bmp",
					  bgColor: "#FFFFFF",
					  color: "#000000",
					  barWidth: "2",
					  barHeight: "50"
					  
					};
					
					$("#div_codigos").append("<div class='grid'><DIV class='barras'></div><div class='codigo_texto'>MCR - "+codigo+"</div><button type='button' class='btn btn-danger no_imprimir btn_delete'><i class='fa fa-times'></i></button></div>");
					$(".grid").last().find(".barras").barcode(codigo, btype, settings);
					//alert($("#div_codigos:last-child").
					
					$("#cantidad").html(index);
					$("#txt_codigo").val("");
					
					$(".btn_delete").click(function(e){
						//console.log($(this).closest(".grid"));
						div = $(this).closest(".grid")
						div.fadeOut(200,  function(){
							div.remove();
						});
					});
						
					
				}
				
			});
			
			$("#btn_imprimir").click(function(e){
				window.print();
				
			});
			
		}); 
		</script>
			 
</head> 
<body>
<?php
include("header.php");
?>
<div id="hoja_codigos" class="wrapper">
	<div id="div_nuevo_codigo" class="no_imprimir">	
		<div >
			<span class="etiqueta">Agregar Tarjeta: </span><input type="text" id="txt_codigo"/>
			
			<button class="btn btn-success" id="btn_agregar_codigo">
				<i class="fa fa-plus"></i> Agregar
			</button>
			<span class="etiqueta"> Cantidad:</span>
			<span class="etiqueta" id="cantidad">0 </span>
			
			<button class="btn btn-danger" id="btn_clear">
				<i class="fa fa-trash"></i> Limpiar
			</button>
			<button class="btn btn-primary" id="btn_imprimir">
				<i class="fa fa-print"></i> Imprimir
			</button>
		</div>
		<hr>
	</div>
	<div id="div_codigos">
		
	</div>
</div>


	
</body>
</html>