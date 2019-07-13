<?php 
	include_once("../login/login_check.php");
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	
	$link = Conectarse();
	
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Usuarios</title>
		<?php include('../../styles2.php')?>
	</head>
	<body id="page-top">
		
		<?php include("../../header.php")?>	
		<div id="content-wrapper">		
			<div class="container-fluid">		
				<!-- Breadcrumbs-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Administración</a>
					</li>
					<li class="breadcrumb-item active">Usuarios</li>
				</ol>
				
				<div class="row mb-2">
					<div class="col-12">
						
						
						<button type="button" class="btn btn-success nuevo" >
							<i class="fas fa-plus"></i> Nuevo
						</button>
					</div>
				</div>
				<hr>
				
				
				<div class="card mb-3">
				
					<div class="card-body">
						<div class="table-responsive" id="lista_registros">
							<h3 >Cargando...</h3>
						</div>
					</div>
				
				</div>
			</div>
			<!-- /.container-fluid -->
			
			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright © Glifo Media 2019</span>
					</div>
				</div>
			</footer>
			 
		</div>
		<!-- /.content-wrapper -->
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>		
		
		
		<!-- The Modal -->
		
		
		
		<?php include("forms/form_usuarios.php")?>
		<?php include("../../scripts2.php")?>
		<script src="js/usuarios.js" ></script>
		
	</body>
</html>
