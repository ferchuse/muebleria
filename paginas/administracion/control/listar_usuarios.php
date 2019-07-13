<?php 
	session_start();
	include('../../../conexi.php');
	$link = Conectarse();
	
	$consulta = "SELECT * FROM usuarios "; 
	 
	$result = mysqli_query($link,$consulta);
	
	if($result){
		$num_registros = mysqli_num_rows($result);
	?>
	<table class="table table-bordered" id="tabla_registros" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th class="text-center">Nombre Completo</th>
				<th class="text-center">Usuario</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody >
			<?php
				while($fila = mysqli_fetch_assoc($result)){?>
				
				<tr>
					<td><?php echo $fila["nombre_usuario"];?></td>
					<td><?php echo $fila["usuario"];?></td>
					<td>
						<button class="btn btn-warning btn_editar" data-id_registro="<?php echo $fila["id_usuario"];?>">
							<i class="fa fa-edit"></i>
						</button>
					</td>
				</tr>
				
				<?php 	
				}
			?>
		</tbody>
	</table>
	
	
	<?php
		
		
	}
	else {
		echo "Error en".$consulta. mysqli_error($link);
	}
	
	
?>	