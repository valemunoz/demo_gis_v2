<?php
include("includes/funciones.php");

cerrar_sesion();

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/login.css" />
		
		<!--<link type="text/css" rel="stylesheet" href="/ws/sites/css/blitzer/jquery-ui-1.10.3.custom.min.css" />-->
		<link href="http://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="img/point.png">
		<title>Gis By Chilemap.cl</title>
		<!--<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->

		
	<link rel="stylesheet" href="css/jquery-ui.css">
 		<script src="js/jquery-1.10.2.min.js"></script>
	 	<script src="js/jquery-ui.js"></script>
	 	
	
		<script>
			function validarEmail( email ) {
	  var valido=true;
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        valido=false;
        
   return valido;     
}
			function login()
			{
				var clave=$.trim(document.getElementById("clv").value);
	var mail=document.getElementById("mail").value;
	
	var msg="";
	var valida=true;
	if($.trim(clave)=="" || $.trim(mail)=="")
	{		
		valida=false;
		msg="<strong>Todos los campos son obligatorios.</strong><br>";
	}
	if(!validarEmail(mail))
	{		
		msg=""+msg+" <strong>E-mail debe tener formato correcto.</strong><br>";
		valida=false;
	}
	if(!valida)
	{
		
		$( "#msg_error" ).html(msg);
	}else
	{
		
		
		$("#msg_error").load("includes/query.php", 
			{tipo:14, clave:""+clave+"", mail:""+mail+""} 
				,function(){	
				}
		);
		
	}
			}
			</script>
	
		</head>
	<body>
		<div class="img_left"><a target=BLANK_ href="http://www.chilemap.cl"><img src="images/gis.png"></a></div>
			
		<div id="contenido">
			<table id="tabla_cont">
				<tr>
					<td align=right>Mail</td>
					<td><input id=mail name=mail class="input_txt" type="text" ></td>
				</tr>
				<tr>
					<td align=right>Contrase&ntilde;a</td>
					<td><input id=clv name=clv  class="input_txt" type="password" ></td>
				</tr>
				<tr>
					<td></td>
					<td align=right><br><input onclick="javascript:login();" class="boton_txt" type="button" value="Login"></td>
				</tr>
			</table>
			<div id="msg_error"></div>
		</div>
	
	
	</body>
</html>
