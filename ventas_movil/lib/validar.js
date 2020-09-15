/* function validar_form(){
	campos = $(".requerido");
	//console.log(campos);
	campos.each(function(){
		
	
	})
	
	if (campos.length > 5){
	
		return true;
	}
	else{
		
		return false;
	}
}
	 */

function validar(form){
	//alert("validando");
	var valid = true;
	var campos_faltantes = 0;
	//alert("'"+form+"'");
	
	$(form).find(".requerido").each(function(index,element){
		//alert.log($(element));
		
		if($(element).attr('type') == "checkbox"){
				console.log($(element).prop('checked'));
			if($(element).prop('checked') == false){
			
				alertify.error($(element).data("invalid"));
				campos_faltantes ++;
			
			}
		}
		
		
		texto = $(element).val().trim();
		if( texto == ""){
			if($(element).data("invalid")){
				
				alertify.error($(element).data("invalid"));
				$(element).css( "background","#F4BAC0" );
				campos_faltantes ++;
			}
			else{
				$(element).css( "background","#F4BAC0" );
				campos_faltantes ++;
				
			}
			
			//return false;
		}
		else {
			$(element).css( "background","white" );
		}
	});
	if(campos_faltantes > 0){
		
		alertify.error(campos_faltantes + " Campo(s) Requerido(s)");
		valid = false;
	}
	
	return valid;
}
	
$(".numbers_only").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	
	
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