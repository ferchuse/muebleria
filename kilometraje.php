<?php
	include("login/login_success.php");
	include("control/conexi.php");
	$link = Conectarse();
	$menu_activo = "cobranza";
	
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Kilometraje</title>
		<?php include("styles.php");?>
		
	</head>
  <body>
		
		<div class="container-fluid">
			<?php include("header.php");?>
			
			<div class="row hidden-print" >
				<div class="col-md-12">
					<form class="form" id="form_kilometraje">
						<h3 class="etiqueta">
							Registrar Kilometraje
						</h3>
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="col-sm-3">
									
									<div class="form-group">
										<label class="" for="fecha_kilometraje">Fecha: </label>  
										<input id="fecha_kilometraje" name="fecha_kilometraje"  class="form-control fecha" required type="text" value="<?php echo date("d/m/Y"); ?>">
									</div>
									<div class="form-group">
										<label for="id_cobrador">Cobrador:</label>  
										<select name="id_cobrador" id="id_cobrador" class="form-control" required>
											<option value="" >Elije...</option>
											<?php 
												$q_cobradores = "SELECT * FROM cobradores WHERE activo = 1 ORDER BY nombre_cobrador";
												$result_cobradores=mysqli_query($link, $q_cobradores) or die("Error en: $q_cobradores  ".mysqli_error($link));
												
												while($row = mysqli_fetch_assoc($result_cobradores)){
													$cobrador_db = $row["nombre_cobrador"];
													$id_cobrador = $row["id_cobrador"];
													
												?>
												<option value="<?php echo $id_cobrador;?>" > 
													<?php echo $cobrador_db;?> 	
												</option>
												<?php
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label" for="cobrador">Kilometraje Anterior:</label>  
										<input id="kilometraje_anterior" name="kilometraje_anterior" placeholder="" class="form-control" type="number" step="any" >
									</div>
									<div class="form-group">
										<label class="control-label" for="cobrador">Kilometraje Actual:</label>  
										<input id="kilometraje_actual" name="kilometraje_actual" placeholder="" class="form-control" required type="number" step="any" >
									</div>
									<div class="form-group">
										<label class="control-label" for="cobrador">Km Recorridos:</label>  
										<input id="diferencia_kilometraje" name="diferencia_kilometraje" placeholder="" class="form-control" required type="number" step="any" >
									</div>
									<div class="form-group">
										<label class="control-label" for="cobrador">Litros Cargados:</label>  
										<input id="litros" name="litros" placeholder="" class="form-control" required type="number" step="any" >
									</div>
									
									<div class="form-group">
										<label  for="importe_gasolina">Importe Gasolina:</label>  
										<input id="importe_gasolina" name="importe_gasolina" class="form-control" required type="number" step="any">
									</div>
									<div class="form-group">
										<label  for="rendimiento">Rendimiento:</label>  
										<input id="rendimiento" name="rendimiento" class="form-control" required type="number" step="any">
									</div>
									<button type="submit" id="submit_compra" class="btn btn-success pull-right">
										<i class="fa fa-save"></i> Guardar
									</button>
								</div>
								<div class="col-sm-8">
									<table>
										<thead>
											<tr>
												<th>Fecha</th>
												<th>KM Anterior</th>
												<th>KM Actual</th>
												<th>KM Recorridos</th>
												<th >Litros</th>
												<th >Importe Gasolina</th>
												<th >Rendimiento</th>
												<th class="hidden" >Placas</th>
											</tr>
										</thead>
										<tbody id="tabla_kilometraje">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</form>					
				</div>
			</div>
			
			
			
			<?php include("scripts.php");?>
			<script >
				
				
				$( document ).ready(function() {
					
					$("#kilometraje_actual").keyup(calculaKilometraje);
					$("#litros").keyup(calculaRendimiento);
					$("#id_cobrador").change(cargar_km);
					
					$("#form_kilometraje").submit(guardarKilometraje );
					
					cargarTabla();
					
				});
				
				
				function cargar_km(){
					id_cobrador = $(this).val();
					
					$.ajax({
						"url" : "control/cargar_km.php", 
						"method": "GET",
						data : {id_cobrador : id_cobrador}
					})
					.done(function(respuesta){
						$("#kilometraje_anterior").val(respuesta);
					})
					.fail(function(xhr, error, ernum){
						alertify.error("Error: "+ error);
					})
					
				}
				function cargarTabla(){
					
					$.ajax({
						"url" : "control/tabla_kilometraje.php", 
						"method": "GET"
					})
					.done(function(respuesta){
						$("#tabla_kilometraje").html(respuesta);
					})
					.fail(function(xhr, error, ernum){
						alertify.error("Error: "+ error);
					})
					
					
				}
				
				function calculaKilometraje (event){
					km_actual = $(this).val();
					km_anterior = $("#kilometraje_anterior").val();
					
					$("#diferencia_kilometraje").val(km_actual - km_anterior);
				}
				
				function calculaRendimiento(event){
					var litros = $(this).val();
					var diferencia_kilometraje = $("#diferencia_kilometraje").val();
					
					var rendimiento = Number(diferencia_kilometraje / litros).toFixed(2);
					$("#rendimiento").val(rendimiento);
				}
				
				function guardarKilometraje(event){
					
					event.preventDefault();
					
					var $form =  $(this);
					var $boton = $form.find(":submit"); 
					var $icono = $form.find(".fa"); 
					var data =  {
						"tabla": "kilometrajes",
						"valores": $form.serializeArray()
					};
					var url =  "control/fila_insert.php";
					
					
					$boton.prop("disabled", true);
					$icono.toggleClass("fa-save fa-spin fa-spinner");
					
					
					$.ajax({
						"url" : url, 
						"method": "POST",
						"data": data
					})
					.done(function(respuesta){
						if(respuesta["estatus"] == "success"){
							alertify.success(respuesta.mensaje);
							$("#id_cobrador").val("");
							$("#kilometraje_anterior").val("");
							$("#kilometraje_actual").val("");
							$("#diferencia_kilometraje").val("");
							$("#litros").val("");
							$("#importe_gasolina").val("");
							cargarTabla();
						}
						else{
							
							alertify.error("Error: "+ respuesta.mensaje);
						}
					})
					.fail(function(xhr, error, ernum){
						alertify.error("Error: "+ error);
					})
					
					.always(function(){
						$boton.prop("disabled", false);
						$icono.toggleClass("fa-save fa-spin fa-spinner");
					});
				}
				
			</script>
			
		</body>
	</html>			