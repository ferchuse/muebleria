<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
<title>Buscar Tarjeta</title>
<link rel="stylesheet" type="text/css" href="css/movil.css" />		
<link rel="stylesheet" type="text/css" href="font_awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.css"  />
<link rel="stylesheet" type="text/css" href="css/alertify.css" />

<script type="text/javascript" src="js/jquery-1.9.1.js" charset="utf8"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/alertify.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
	$( "#txt_nombre_cliente" ).autocomplete({
		source: "search_json.php?order=nombre_cliente&tabla=ventas&campo=nombre_cliente&valor=nombre_cliente&etiqueta=nombre_cliente",
		minLength : 2,
		select: function( event, ui ) {
			
			//$( "#txt_nombre_cliente" ).val(ui.item.value);
			if(ui.item.extras.length > 1){
				console.log("Hay mas de una tarjeta");
			}
			else{
				$( "#tarjeta" ).val(ui.item.extras.tarjeta);
				$("#btn_buscar").click();
			}
			
			console.log(ui);
			console.log(ui.item.extras);
			
			//alert(ui.item.tarjeta);
			//$("#txt_cantidad").focus();
			//$('#select_zona')..attr('selected','selected');( ui.item.zona );
			
		}
	});
	
	
	
	$('#tarjeta').click(function(event){
		$('#tarjeta').select();
		
	});
	$('#txt_nombre_cliente').click(function(event){
		$('#txt_nombre_cliente').select();
		
	});
	//Guarda el formulario
	$('#btn_buscar').click(function(event){
		//alert("Guardadno");
		event.preventDefault();
		
		if ($( "#tarjeta" ).val() != ""){
			$.get("result_movil.php",{"tarjeta" :$( "#tarjeta" ).val()},   function(data_return, status){
				
				//regresa todos los valores a 0
				if(status =="success"){
					
					$('#result').html(data_return);
					if(window.AppInventor){
						//alert("tarjeta" + $( "#tarjeta" ).val());
						window.AppInventor.setWebViewString($( "#tarjeta" ).val());
						//alert("WBString " + window.AppInventor.getWebViewString());
					}
				}
			});
		}
		else{
			alertify.error("Ingrese una Tarjeta");
			
		}
	}); 
	
}); 
</script>
</head>
<body>
	
		<div class="panel panel-primary ">
			<div class="panel-heading container-fluid">
				<div class="row">
					<div class="col-xs-2">
						<label for="tarjeta">
							Tarjeta:
						</label>
					</div >
					<div class="col-xs-7 ">
						<div class="form-group">
							  <input type="number" name="tarjeta" class="form-control " id="tarjeta"  >	
						</div>
						
					</div >
					<div class="col-xs-1 ">
						<button   id="btn_buscar" type="button"  class="btn btn-default btn-md">
							
							<i class="fa fa-search fa-2x"></i> 
						</button>
					</div>
				</div>
			</div>
			
			<div class="panel-heading container-fluid">
				<div class="row">
					<div class="col-xs-2">
						<label for="tarjeta">
							Cliente:
						</label>
					</div >
					<div class="col-xs-10 ">
						<div class="form-group">
							  <input type="text" class="form-control " id="txt_nombre_cliente"  >	
						</div>
						
					</div >
					
				</div>
			</div>
		  
			<div id="result" >
				
			</div >
		  
		  
		</div>
</body>
</html>