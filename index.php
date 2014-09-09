<?php
include("includes/funciones.php");
$estado_sesion=estado_sesion();
//print_r($_SESSION['us_apps']);
if($estado_sesion!=0)
{
?>
					<script>
						window.location.href="login.php";
					</script>
<?php
}			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title>Gis by Chilemap.cl</title>
	
	<link rel="shortcut icon" href="img/point.png">
	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
	<link href="css/style.css" type="text/css" rel="stylesheet" charset="utf-8"/> 
	<META http-equiv=Content-Type content="text/html; charset=utf-8">
	
  <script src="js/jquery-1.10.2.min.js"></script>
  <script src="http://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
  <script src="http://www.chilemap.cl/OpenLayers/OpenLayers.js"></script>
  
  <script type="text/javascript" src="js/heatm.js"></script>
  <script type="text/javascript" src="js/animatedcluster.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script src="js/funciones.js"></script>
  <script src="js/funciones_sitio.js"></script>
  
  <script src="js/isocro.js"></script>
  
  <script>
  	
  $j_cm(function() {
    $j_cm( "#grilla" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 $j_cm( "#lug" ).click(function() {
  enableTest("btn_lugares");
});
 $j_cm( "#dir" ).click(function() {
  disableTest("btn_lugares");
});
   
  });

  </script>
</head>	
<body onload="inicio();">

	<div id="menu">
		<div id=contenido_usuario>
			
			<img src="images/gis2.png">	
			</div>
		<div id=contenido_der>
			Bienvenido: <?=trim($_SESSION['us_nombre'])?>		
			<span><a href="javascript:salir();">Salir</a></span>
			
		</div>
	</div>
		<div id="menu2">
		<div id=contenido>
			<img src="images/iconos/local.png" id="opc_uno" name="opc_uno" class="menu_boton" width=28px height=28px onclick="javascript:opc_filtro();loadListaPoligono();" title="Abrir Filtros">
			
			<img src="images/iconos/search15.png" class="menu_boton" id="opc_dos" name="opc_dos" width=28px height=28px onclick="javascript:opc_result();" title="Ver Resultados">
			<?php
			if(in_array("7", $_SESSION['us_apps']))
			{
			?>
				<img src="images/iconos/fav.png" class="menu_boton" id="opc_cuatro" name="opc_cuatro" width=28px height=28px onclick="javascript:loadMisPoligonos();$j_cm('#categ_add').hide();loadMisPuntos();opc_capa();" title="Mis Capas">
			<?php
			}
			?>
			
			<?php
			if(in_array("2", $_SESSION['us_apps']))
			{
			?>	
				<img src="images/iconos/viral.png" class="menu_boton" id="opc_tres" name="opc_tres" width=28px height=28px onclick="javascript:opc_iso();" title="Isocronas">
			<?php
			}
			if(in_array("8", $_SESSION['us_apps']))
			{
				?>
				<img name="opc_cinco" id="opc_cinco" title="Check Antenas" src="images/iconos/antena.png" height=32px class="menu_boton" onclick="javascript:opc_antena();">
				<?php
			}
			?>
			|
			<img src="images/iconos/download24.png"  id="opener" width=28px height=28px class="menu_boton" title="Ver Datos Mapa" onclick="loadData();">
			<?php
			if(in_array("7", $_SESSION['us_apps']))
			{
			?>	
				<img id="pd" name="pd"  src="images/iconos/poli.png" class="menu_boton" width=30px height=30px title="Dibujar poligonos" onclick="javascript:activarPoligono();controlPoligono();">
			<?php
			}
			if(in_array("7", $_SESSION['us_apps']))
			{
				$categorias=getCategoriasCliente($_SESSION['us_id_cli']);
				foreach($categorias as $cat)
				{
					$id_cat[]=$cat[0];
					$nom_cat[]=$cat[1];
				}
				$id_cat=implode(",",$id_cat);
				$nom_cat=implode(",",$nom_cat);
			?>	
				<img id="md" name="md"  src="images/iconos/marker.png" class="menu_boton" width=30px height=30px title="Nuevo Registro" onclick="javascript:activarMarcador('<?=$nom_cat?>','<?=$id_cat?>');">
			<?php
			}
			
			?>
			
			<div id=centro>
				
			</div>
			
		</div>
		
			<div id=barra_mapa>
				
			<div id=barra_mapa2 class="olControlEditingToolbar"></div><img src="images/iconos/clean.png" width=25px height=25px onclick="javascript:limpiarmapa();limpiarGrilla();" class=menu_boton title="Limpiar Mapa"><img width=25px height=25px src="images/iconos/printer11.png" onclick="javascript:printMapa();" class=menu_boton title="Imprimir Mapa">
			</div>
		
	</div>
	<div id="uno">
		<div id="header_uno">
			<img src="img/close.png" class="menu_boton" onclick="javascript:esconder('uno');">
		</div>
		<font id='titulo_uno'>B&uacute;scador</font>
		<div id="contenido_uno">
			<div id="buscador">
				<strong>Buscar</strong> <input type="text" class="input_inicio" id="query" name="query" onKeyPress="enterpressalert(event, this,1)" autocomplete=off> 
				<br>
				<span class="txt_ejemplo">Ejemplo: Juan esteban montero 4550 las condes</span>
				/<span class="txt_ejemplo"> Ejemplo: Banco</span>
				
				<div id="opc_buscador">					
					<input type="radio" class="radio_orden" id="dir" name="group2" value="1" checked> Direcci&oacute;n
					<!--input type="radio" class="radio_orden" id="dat" name="group2" value="2"> Datos Cliente -->
					
					<?php
					if(in_array("1", $_SESSION['us_apps']))
					{
						?>
						<input type="radio" class="radio_orden" id="lug" name="group2" value="3"> Lugares
					<?php
					}
					
					?>
					
				</div>
				
				<?php
					if(in_array("11", $_SESSION['us_apps']))
					{
				?>
				<div id=btn_lugares>
					<span class="txt_titulo1">Filtro b&uacute;squeda de lugares</span><br>
						<strong>Mis Poligonos:</strong> <select class=input_form id=mis_poli name=mis_poli>					
					</Select> | <strong>Radio</strong> <input type="text" id='radio_fil' name='radio_fil'> Mts 
						<br>
				<span class="txt_ejemplo">Radio se considera tanto para b&uacute;squeda de lugares como datos de censales.</span>
			</div>
				<p class="btones">
				<img src="img/24.png" class="img_boton" title="Buscar!" onclick="javascript:buscar();"> | <img src="img/29.png" class=img_boton onclick="getDataManz();" title ="Buscar informacion censal!">
			</p>
				<?php
					}
				?>
				
			</div>
			<div id=load>
				<img src="img/load.gif">
			</div>
		</div>
	</div>
	<div id="dos">
		<div id="header_uno">
			<img src="img/close.png" class="menu_boton" onclick="javascript:esconder('dos');">
		</div>
		<font id='titulo_uno'>Resultados de B&uacute;squedas</font>
		<div id="contenido_dos">
			
			<ul id="list">
				<span class="txt_ejemplo">Aqu&iacute; se desplegaran los resultados de b&uacute;squeda</span>

			
		</ul>
		</div>
	</div>
	<?php
					if(in_array("11", $_SESSION['us_apps']))
					{
						
				?>
	<div id="cuatro">
		<div id="header_uno">
			<img src="img/close.png" class="menu_boton" onclick="javascript:esconder('cuatro');">
		</div>
	<div id=fav_uno>
		<font id='titulo_uno'>Mis capas/pol&iacute;gonos</font>
		<div id="contenido_cuatro">		
			<span class="txt_ejemplo">No hay pol&iacute;gonos disponibles</span>	
		</div>
	</div>
	<div id=fav_dos>
		<font id='titulo_uno'>Mis Puntos</font>
		<div id="contenido_cuatrob">		
			<span class="txt_ejemplo">No hay puntos disponibles</span>	
		</div>
	</div>
	</div>
	<?php
				}
				?>
	<?php
		if(in_array("2", $_SESSION['us_apps']))
		{
	?>	
			<div id="tres">
				<div id="header_uno">
					<img src="img/close.png" class="menu_boton" onclick="javascript:esconder('tres');">
				</div>
				<font id='titulo_uno'>Isocronas</font>
				<div id="contenido_tres">
					<div id="buscador">
					</br></br>
						Minutos <input type="text"  name="min_iso" id="min_iso" ><input type="button" value="Generar" onclick="BuscarIso();">
						<span class="txt_ejemplo">Valor n&uacute;merico no mayor a 30.</span>
						<br>
						<span class="txt_ejemplo">Minutos corresponde al valor estimado m&aacute;ximo de la b&uacute;squeda. La isocrona se basara en los minutos y el tipo de b&uacute;squeda: a pie o  en auto.</span>
					<div id="opc_buscador">					
							<input type="radio" class="radio_orden" id="ap" name="group3" value="walking" checked> A pie
							<input type="radio" class="radio_orden" id="auto" name="group3" value="driving"> En auto
							
						</div>
					</div>
					
			</div>
		</div>
	
	<?php
	}
	if(in_array("8", $_SESSION['us_apps']))
		{
	?>	
			<div id="cinco">
				<div id="header_uno">
					<img src="img/close.png" class="menu_boton" onclick="javascript:esconder('cinco');">
				</div>
				<font id='titulo_uno'>Antenas</font>
				<div id="contenido_tres">
					<div id="buscador">
							</br></br>
						Altura antena en mts <input type="text"  name="mts_antena" id="mts_antena" ><input type="button" value="Consultar" onclick="viabilidadAntena();">
						<span class="txt_ejemplo">Valor n&uacute;merico.</span>
						<br>
						
					<div id="opc_buscador">					
							<input type="button" value="Consultar Antenas en radio de 50mts" onclick="checkAntena();">		
							
						</div>
						
					
			</div>
		
	
	<?php
	}
	?>
	
			<div id=load>
				<img src="img/load.gif">
			</div>
		</div>
	</div>
	<div id="main_mapa">

	<div id="mapa">
				
	</div>
<div id=footer>
			@2014 <a target=_blank href="http://www.chilemap.cl">chilemap.cl</a>
	</div>	
</div>
	<div id="popup_web">
    <div class="content-popup">
        <div class="close_web"><a href="javascript:closeModalWeb();" id="close_web"><img src="images/cerrar.png"/></a></div>
        <div class="cont_web">Contenido POPUP</div>
    </div>
</div>
	<script>
		function inicio()
		{
			init('mapa');
			loadServicios();
			 disableTest("btn_lugares");
           
		}
	</script>
	<div id='output'></div>
	<div id="grilla" >
  
	</div>
</body>
</html>