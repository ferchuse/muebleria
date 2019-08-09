<form class="form" id="form_venta" autocomplete="off">
	<div id="modal_venta" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Editar Venta</h4>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label for="fecha_abono">Folio Venta:</label>
						<input type="text" readonly value="" class="form-control" name="id_ventas" id="id_ventas" />
					</div>
					<div class="form-group">
						<label for="fecha_abono">Tarjeta:</label>
						<input type="text" readonly value="<?php echo $tarjeta;?>" class="form-control" name="tarjeta" />
					</div>	
					<div class="form-group">
						<label for="fecha_abono">Clave Vendedor:</label>
						<input type="text" required  class="form-control" name="clave_vendedor" id="clave_vendedor" />
					</div>
					<div class="form-group">
						<label for="fecha_abono">Fecha Venta:</label>
						<input type="date"  value="<?php echo date("Y-m-d");?>" class="form-control" name="fecha_venta" id="fecha_venta" />
					</div>
					<div class="form-group">
						<label for="fecha_vencimiento">Fecha Vencimiento:</label>
						<input type="date" required class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" />
					</div>
					
					<div class="form-group">
						<label for="fecha_abono">Artículo:</label>
						<input type="text" required class="form-control" name="articulo" id="articulo" />
					</div>
					<div class="form-group">
						<label for="fecha_abono">Tipo de Articulo:</label>
						<select id="tipo_articulo" name="tipo_articulo" class="form-control">
							<option value="">Elige</option>
							<option value="Caja">Caja</option>
							<option value="Mueble">Mueble</option>
						</select>
					</div>
					<div class="form-group">
						<label for="fecha_abono">Cobrador:</label>
						
						<?php echo generar_select($link, "cobradores", "nombre_cobrador","nombre_cobrador", false, false, false,0,0,"cobrador","cobrador", array(0=>array("name"=> "activo", "value"=>"1"))) ?>
						
					</div>
					<div class="form-group">
						<label for="fecha_abono">Importe:</label>
						<input type="number" required class="form-control" name="importe" id="importe" />
					</div>
					<div class="form-group">
						<label for="fecha_abono">Enganche:</label>
						<input type="number" required class="form-control" name="enganche" id="enganche" />
					</div>
					<div class="form-group">
						<label for="cantidad_abono">Abono:</label>
						<input type="number" required class="form-control" name="cantidad_abono" id="cantidad_abono" />
					</div>
					<div class="form-group">
						<label for="dia_cobranza">Dia Cobro:</label>
						<select class="form-control" name="dia_cobranza" id="dia_cobranza">
							<option value="" <?php echo is_selected("", $dia_cobranza)?> >Elige un Dia	</option>
							<option>LUNES	</option>
							<option>MARTES	</option>
							<option>MIÉRCOLES	</option>
							<option >JUEVES	</option>
							<option>VIERNES	</option>
							<option>SÁBADO	</option>
							<option>DOMINGO	</option>
							<option  >QUINCENAL	</option>
							<option  >MENSUAL	</option>
						</select>
					</div>
					<div class="form-group">
						<label for="estatus_pago">Etatus Pago:</label>
						<select class="form-control" name="estatus_pago" id="estatus_pago">
							<option value="">Elige...</option>
							<option>PAGADA</option>
							<option>PENDIENTE	</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="id_estatus">Estatus:</label>
						<select class="form-control" name="id_estatus" id="id_estatus" >
							<option value="">Elige un Estatus	</option>
							<?php 
								$q_estatus = "SELECT * FROM estatus ";
								$result_estatus=mysqli_query($link, $q_estatus) or die("Error en: $q_estatus  ".mysqli_error($link));
								
								while($row = mysqli_fetch_assoc($result_estatus)){
									$id_estatus_db = $row["id_estatus"];
									$estatus_db = $row["estatus"];
									
								?>
								<option value="<?php echo $id_estatus_db;?>"  <?php echo is_selected($id_estatus_db, $id_estatus);?> > 
									<?php echo $estatus_db;?> 	
								</option>
								<?php
								}
							?>
						</select>
					</div>
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times"></i> 	Cerrar
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fa fa-save"></i> Guardar
					</button>
				</div>
			</div><!-- modal-content -->
		</div>
	</div>
</div>
</form>