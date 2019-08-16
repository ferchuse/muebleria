$(document).ready(function(){
	ultimoTurno();
	
	$("#form_login").submit(iniciarSesion );
});

function iniciarSesion(event){
	event.preventDefault();
	
	$("#btn_login").prop("disabled", true);
	$("#spinner").toggleClass("hide");
	$.ajax(
		{
			"url": "login.php", 
			"method": "POST", 
			"data": $("#form_login").serialize(),
			"success" : function(response, status){
				console.log(response);
				$("#spinner").toggleClass("hide");
				$("#btn_login").prop("disabled", false);
				
				if(response.login == "valid"){
					alertify.success("Acceso Correcto");
					// return;
					if($("#redirect_url").val() != ''){
						console.log("Redirigiendo a " +  $("#redirect_url").val() )
						location.replace( "../.." +$("#redirect_url").val());
					}
					else{
						
						location.href="../nueva_cobranza.php";
					}
					
					
				}
				else{
					alertify.error(response.mensaje);
					
				}
			},
			"error": function(xhr, textStatus, errno){
				console.log(xhr);
				console.log(textStatus);
				console.log(errno);
				alertify.error("ERROR: " + textStatus);
				
			}
		});
		
}
function ultimoTurno(){
	
	$.ajax({
		"url": "ultimo_turno.php"
		}).done(function(respuesta){
		if(respuesta.pedir_efectivo == 1){	
			$("#efectivo_inicial").prop("readonly", false);
		}
		else{
			$("#efectivo_inicial").prop("readonly", true);
			$("#efectivo_inicial").val(respuesta.efectivo_inicial);
		}
		
		$("#turno").val(respuesta.ultimo_turno);
		
	});
	
}