Exportar a excel

Ducplicar saldo en app


pronostico cobranza
reporte 

clasificacion de estatus


26-ago
	Tarjetas Cobradas
		Activas calasificar por estatus
		
	Editar estatus y actualizar todas las tarjetas
	
17 ago
	Integracions de Cuentas
		Suma de IMporte Total
		Suma de Cobradob = Importe Total - Saldo Actual

buscar_tarjeta.php
	editar abono

Tipo de bono o enganche
Devolucion

buscar por cliente

REPORTES
	Exportar a excel repore de ventas
	Reporte de Devoluciones

Pronostico de Cobranza

	Todos los Dias

	Pronostico Semanal
		

cuentas al corriente y con atraso
estatus en pronostico cobranza

devolucion abono por concepto de devolucionS



integracion de cuentas
interes 10%
sobre atraso

ventas

quincenal

nota de venta

tarjetas cobradas

APP
	buscar fecha de primier registro, si la diferencia en dias con la fecha 
	actual es mayor a 6 borrar todas las de la semana anterior
	LOG ERRORS
	Interes saldo vencido y fecha de ultimo pago importe
	
	fecha de vencimiento =  este jueves
	
	

Saldo duplicado al imprimir cobranza 2 veces

Devoluciones

impresoras  

pin 1234
00:03:7A:4D:F9:D1
Brayan:  	impresora1,	00:22:58:06:1D:4B , 
Allan: 		impresora2, 00:03:7A:4D:1C:6F, xxxx09-10-5416
Johnathan: 	impresora3, 00:03:7A:6D:C4:34, xxxx08-51-5419	
Hector: 	
Dionisio: 	impresora4(mz220-01),	00:03:7A:4D:F9:D1, xxxx09-51-0824    pin 1234 tel: 5549888367 dns4
SUPERVISOR: impresora5, 00:03:7A:4D:73:B4, xxxx09-51-0617    pin 0000	tel 
JOSAFAT

fecha de vencimiento imprimmir
4d73b4
dia_cobranza

5549889304
5549880868

fecha de ultimo abono
numero de tarjetas

agregar abono, modificar y eliminar

unificar allan y alan

tarjeta no encontrada

primary key abonos agregar cobrador

crear seccion cobradores

	reporte_incidencias
	reporte_cobranza
	reporte_cobranza_semanal
	nueva_cobranza
	nueva_venta
	ventas
	buscar_tarjeta
	PROBOstioc dario
	pronostico_smenal
	
	

no se ha sincronizado la primera vez, al presionar boton buscar 
no hay tarjetas para cargar
buscar tarjeta vacia
No modificar 
buscar por clientes
incidencias
estatus tarjeta


reactivar funcion editar abono

exportar a aexcel reporte de ventas
 SS
pronostico de cobranza por dia, por cobrador y dia de la semana
tarjeta, nombre, abono semanal,y sumatoria, cobro real, incidencias 


1e228de70e
APP

incidencias

error 502, no hay bluetooth
error 515 sin conexion a la impresora1


<form action="nueva_cobranza.php" method="get">
	<button id="<?php echo $fecha_hora_abono;?>" class="editar">
		Editar
	</button>
	<input type="hidden" value="<?php echo $tarjeta;?>" name="tarjeta"/>
	<input type="hidden" value="<?php echo $fecha_hora_abono;?>" name="fecha_hora_abono"/>
	<input type="hidden" value="<?php echo $cobrador;?>" name="cobrador"/>
	<input type="hidden" name="editar"/>
</form>


<option value="">Elige un Estatus	</option>
					<option value="Al Corriente">Al Corriente	</option>
					<option value="Atraso ( < 3 Semanas )">Atraso ( < 3 Semanas )	</option>
					<option value="Negativa de Pago">Negativa de Pago	</option>
					<option value="Localizada">Localizada	</option>
					<option value="Liquidada">Liquidada	</option>
					<option value="Devolución de Mercancia">Devolución de Mercancia	</option>
					<option value="Revisión del Supervisor">Notificada a Supervisor	</option>