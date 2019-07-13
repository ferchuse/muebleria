<?php
	
	
?>



<form id="form_edicion" autocomplete="off">
	<div class="modal " id="modal_edicion">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edición de Usuario</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
					
					<input hidden name="id_usuarios" id="edicion_id_usuarios" value="">
					<input hidden name="fecha_creacion" id="fecha_creacion" value="<?php echo date("Y-m-d");?>">
					<div class="form-group">
						<div class="col-2">
							<label>Nombre Completo		</label>				
						</div>	 
						<div class="col-5">			
							<input class="form-control" name="nombre_usuario" id="nombre_usuario" required>
						</div>
					</div>
				<div class="form-group">
						<div class="col-2">
							<label>Usuario		</label>				
						</div>	 
						<div class="col-5">			
							<input class="form-control" name="usuario" id="usuario" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-2">
							<label >Contraseña:</label>
						</div>	
						<div class="col-5">			
							<input class="form-control" type="password" required name="pass" id="pass">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-2">
							<label >Estatus:</label>
						</div>	
						<div class="col-5">			
							<select class="form-control" id="estatus_usuarios" name="estatus_usuarios" required>
								<option value="">Seleccione</option>
								<option selected value="Alta">Alta</option>
								<option value="Baja">Baja</option>
								<option value="Inactivo">Inactivo</option>
							</select>
						</div>
					</div>
					
					<?php 
						$categorias=["Clientes", "Cobranza", "Catálogos", "Almacen", "Ventas", "Reportes"];
						
						foreach($categorias as $i=> $categoria){
							$paginas =Array();
							$consulta = "SELECT * FROM paginas WHERE categoria_paginas = '$categoria'"; 
							
							$result = mysqli_query($link,$consulta);
							
							if($result){
								while($fila = mysqli_fetch_assoc($result)){
									$paginas[] = $fila;
								}
							}
							else{
								echo("error". mysqli_error($link));
							}
							
							$permisos=["Sin Acceso", "Lectura", "Escritura", "Supervisor"];
							
						?>
						<legend><?php echo $categoria;?></legend>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Página</th>
									<th>Sin Acceso</th>
									<th>Lectura</th>
									<th>Escritura</th>
									<th>Supervisor</th>
								</tr>
							</thead>
							<tbody class="text-center">
								<?php foreach($paginas as  $j=> $pagina){?>
									<tr>
										<td>
											<?php echo $pagina["nombre_paginas"]?>
											<input hidden class="id_paginas" name="id_paginas[<?php echo $pagina["id_paginas"];?>]" value="<?php echo $pagina["id_paginas"];?>">	
										</td>
										
										<?php
											foreach($permisos as $k => $permiso){?>
											<td>
												<input type="radio"  class="permiso" name="permisos[<?php echo $pagina["id_paginas"];?>]" value="<?php echo $permiso;?>">
											</td>
											<?php
											}?>
									</tr>
									<?php 
									}
								?>
							</tbody>
						</table>
						<?php	
						}
					?>
					
					
					
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fas fa-times"></i> Cancelar</button>
						<button type="submit" class="btn btn-success " >
						<i class="fas fa-save"></i> Guardar </button>
					</div>
				</div>
			</div>
		</div>
	</form>		
