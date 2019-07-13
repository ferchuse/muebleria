function validar(formulario){
	
	if(formulario == "frm_nueva_venta"){
		/* if ($("#fecha_venta").val() == ''){
			alert("Ingresa una Fecha");
			$("#fecha_venta").focus();
			$("#fecha_venta").css( "background","#F4BAC0" );
			return false;
		} */
		/* if ($("#txt_folio_venta").val() == ''){
			alert("Ingresa Folio de Venta");
			$("#txt_folio_venta").focus();
			$("#txt_folio_venta").css( "background","#F4BAC0" );
			return false;
		}  */
	
	
	}
	
	if(formulario == "frm_nuevo_vendedor"){
		if ($("#nuevo_nombre_vendedor").val() == ''){
			alert("Ingresa un Nombre");
			$("#nuevo_nombre_vendedor").focus();
			$("#nuevo_nombre_vendedor").css( "background","#F4BAC0" );
			return false;
		}
	}
	
	
	if(formulario == "form_nueva_cobranza"){
		if ($("#txt_tarjeta").val() == ''){
			alert("Ingresa una Tarjeta");
			$("#txt_tarjeta").focus();
			$("#txt_tarjeta").css( "background","#F4BAC0" );
			return false;
		}
		if ($("#select_cobrador").val() == ''){
			alert("Elija un Cobrador");
			$("#txt_cobrador").focus();
			$("#txt_cobrador").css( "background","#F4BAC0" );
			return false;
		}
		if ($("#txt_abono").val() == ''){
			alert("Ingresa un abono");
			$("#txt_abono").focus();
			$("#txt_abono").css( "background","#F4BAC0" );
			return false;
		}
		if ($("#txt_saldo_anterior").val() == ''){
			alert("Ingresa un ldo anterior");
			$("#txt_saldo_anterior").focus();
			$("#txt_saldo_anterior").css( "background","#F4BAC0" );
			return false;
		}
		if ($("#txt_saldo_restante").val() == ''){
			alert("Ingresa un saldo restante");
			$("#txt_saldo_restante").focus();
			$("#txt_saldo_restante").css( "background","#F4BAC0" );
			return false;
		}
	}
	
	//^([01]\d|2[0-3]):[0-5]\d:[0-5]\d$  VALIDAR HORA
	if(formulario == "reporte_producto"){
		if ($("#fecha_inicial").val() == ''){
			alert("Ingresa una fecha");
			$("#fecha_inicial").focus();
			$("#fecha_inicial").css( "background","#F4BAC0" );
			return false;
		}
		if ($("#fecha_final").val() == ''){
			alert("Ingresa una fecha");
			$("#fecha_final").focus();
			$("#fecha_final").css( "background","#F4BAC0" );
			return false;
		}
		if ($(":checked.rutas").length < 1){
			alert("Selecciona una Ruta") ;
			
			return false;
		}
	}
		
		
	return true;
}
	
	function esFechaValida(fecha){
    if (fecha != undefined && fecha.value != "" ){
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value)){
            alert("Formato de fecha no válido (DD/MM/AAAA)");
			$("#txt_fecha").focus();
            return false;
        }
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);
 
		switch(mes){
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				numDias=31;
				break;
			case 4: case 6: case 9: case 11:
				numDias=30;
				break;
			case 2:
				if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
				break;
			default:
				alert("Fecha introducida inválida");
				return false;
		}
 
        if (dia>numDias || dia==0){
            alert("Fecha introducida inválida");
            return false;
        }
        return true;
    }
}

 
/* function comprobarSiBisisesto(anio){
if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
    return true;
    }
else {
    return false;
    }
}
</script>
</head>
 
<body>
<input type="text" onBlur="esFechaValida(this);"/>
</body>
 
</html> */
	
	//onclick="return validar();"