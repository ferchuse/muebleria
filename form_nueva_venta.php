<form >
<fieldset>



<!-- Form Name -->
<legend>Nueva Venta</legend>

<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="folio_venta" class="control-label">Folio Venta</label>
  
    <input class="input-sm form-control" id="folio_venta" placeholder="" required="" readonly="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="tarjeta" class="control-label">Tarjeta</label>
  
    <input class="form-control" id="tarjeta" placeholder="" required="" readonly="" type="number">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="fecha_venta" class="control-label">Fecha de Venta</label>
  
    <input class="input-sm form-control" id="fecha_venta" placeholder="" required="" type="date">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="nombre_cliente" class="control-label">Nombre Cliente</label>
  
    <input class="form-control" id="nombre_cliente" placeholder="" required="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="direccion" class="control-label">Dirección</label>
  
    <input class="form-control" id="direccion" placeholder="" required="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="referencias" class="control-label">Referencias</label>
  
    <input class="form-control" id="referencias" placeholder="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="entre_calles" class="control-label">Entre Calles</label>
  
    <input class="form-control" id="entre_calles" placeholder="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="celular" class="control-label">Celular</label>
  
    <input class="form-control" id="celular" placeholder="" required="" type="tel">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="telefono" class="control-label">Teléfono</label>
  
    <input class="form-control" id="telefono" placeholder="" required="" type="tel">
    
  
</div>
<!-- Fuel UX Select http://getfuelux.com/javascript.html#selectlist -->
<div class="form-group">
  <label class="control-label" for="dia_cobranza">Día de Cobro</label>
  <div class="controls text-left">
    <div class="btn-group selectlist" data-initialize="selectlist" data-resize="auto" id="dia_cobranza">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" required="">
        <span class="selected-label">&nbsp;</span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li data-value="LUNES"><a href="#">LUNES</a></li>
        <li data-value="MARTES"><a href="#">MARTES</a></li>
      </ul>
      <input class="hidden hidden-field" name="dia_cobranza" readonly="readonly" aria-hidden="true" type="text">
    </div>
    
  </div>
</div>
<!-- Fuel UX Select http://getfuelux.com/javascript.html#selectlist -->
<div class="form-group">
  <label class="control-label" for="cobrador">Cobrador</label>
  <div class="controls text-left">
    <div class="btn-group selectlist" data-initialize="selectlist" data-resize="auto" id="cobrador">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
        <span class="selected-label">&nbsp;</span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li data-value="Muebleria"><a href="#">Muebleria</a></li>
        <li data-value="Héctor"><a href="#">Héctor</a></li>
        <li data-value="Dionisio"><a href="#">Dionisio</a></li>
      </ul>
      <input class="hidden hidden-field" name="cobrador" readonly="readonly" aria-hidden="true" type="text">
    </div>
    
  </div>
</div>
<!-- Fuel UX Select http://getfuelux.com/javascript.html#selectlist -->
<div class="form-group">
  <label class="control-label" for="sector">Sector</label>
  <div class="controls text-left">
    <div class="btn-group selectlist" data-initialize="selectlist" data-resize="auto" id="sector">
      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
        <span class="selected-label">&nbsp;</span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li data-value="Elige un Sector..."><a href="#">Elige un Sector...</a></li>
      </ul>
      <input class="hidden hidden-field" name="sector" readonly="readonly" aria-hidden="true" type="text">
    </div>
    
  </div>
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="articulo" class="control-label">Artículo</label>
  
    <input class="form-control" id="articulo" placeholder="" required="" type="text">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="importe_total" class="control-label">Importe Total</label>
  
    <input class="form-control" id="importe_total" placeholder="" required="" type="number">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="enganche" class="control-label">Enganche</label>
  
    <input class="form-control" id="enganche" placeholder="" required="" type="number">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="cantidad_abono" class="control-label">Cantidad de Abono</label>
  
    <input class="form-control" id="cantidad_abono" placeholder="" required="" type="number">
    
  
</div>
<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="saldo_actual" class="control-label">Saldo Actual</label>
  
    <input class="form-control" id="saldo_actual" placeholder="" type="number">
    
   
</div>
<!-- Button Group http://getbootstrap.com/components/#btn-groups -->
<div class="row">
  
  <div class="col-sm-6">
   
    <button type="button" id="cancelar" name="cancelar" class="btn btn-danger btn-lg" >Cancelar</button>
	</div>
	<div class="col-sm-6">
    <button type="submit" id="Guardar" name="Guardar" class="btn btn-success btn-lg" aria-label="Cancelar">Guardar</button>
  </div>
</div>
    


</fieldset>
</form>
