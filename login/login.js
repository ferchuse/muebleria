$(document).ready(function(){
		
	$("#form_login").submit(function(event){
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
		
	});
});