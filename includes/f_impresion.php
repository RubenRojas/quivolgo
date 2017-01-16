<?php
function print_head(){
	?>
<!DOCTYPE html>
<html>
<head>
	<!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8">


	<title>QUIVOLGO</title>
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/materialize.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/notifications.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/app.css">
	<link rel="stylesheet" type="text/css" href="/quivolgo/assets/css/print.css">

	<script type="text/javascript" src="/quivolgo/assets/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="/quivolgo/assets/js/materialize.js"></script>
    <script type="text/javascript" src="/quivolgo/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/quivolgo/assets/js/notif.js"></script>
    <script type="text/javascript" src="/quivolgo/assets/js/wow.min.js"></script>
    <script type="text/javascript" src="/quivolgo/assets/js/sweetalert.min.js"></script>

    <script type="text/javascript" src="/quivolgo/ajax/ajax.js"></script>
    

    <!-- <link rel="icon" href="/quivolgo/assets/img/favicon.png" sizes="32x32"> -->
</head>
<body>
	<?php
}

function print_footer(){
	include($baseDir."notificacion.php");
?>
<div class="container">
	<div class="row">
		<br> <br> <br> <br> <br>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".dropdown-button").dropdown();
		$('select').material_select();
		$('#listado').DataTable({
					"iDisplayLength": 5000,
					"order": []
				});
	});
</script>
</body>
</html>
<?php
}

function print_menu(){
	?>
	<ul id="dropdown1" class="dropdown-content">
		<li><a href="/quivolgo/usuarios/index.php">Usuarios</a></li>		
		<li><a href="/quivolgo/app_campo_origen/index.php">Campo Origen</a></li>	
		<li><a href="/quivolgo/app_categoria_aplicacion/index.php">Categoría Aplicacion</a></li>	
		<li><a href="/quivolgo/app_componente/index.php">Componente</a></li>	
		<li><a href="/quivolgo/cod_mat_get/index.php">Codigo Mat. Gen.</a></li>	
		<li><a href="/quivolgo/app_contenedor/index.php">Contenedor</a></li>	
		<li><a href="/quivolgo/app_coordinador/index.php">Coordinador</a></li>	
		<li><a href="/quivolgo/app_especie/index.php">Especie</a></li>	
		<li><a href="/quivolgo/app_estado_planta/index.php">Estado Planta</a></li>	
		<li><a href="/quivolgo/app_instalador/index.php">Instalador</a></li>	
		<li><a href="/quivolgo/app_medio_aplicacion/index.php">Medio Aplicacion</a></li>	
		<li><a href="/quivolgo/madres/index.php">Madres</a></li>	
		<!--<li><a href="/quivolgo/app_meson/index.php">Meson</a></li>	-->
		<li><a href="/quivolgo/app_nave/index.php">Nave</a></li>	
		<li><a href="/quivolgo/app_origen_genetico/index.php">Origen Genetico</a></li>	
		<li><a href="/quivolgo/app_propagacion/index.php">Propagacion</a></li>	
		<li><a href="/quivolgo/app_sector/index.php">Sector</a></li>	
		<li><a href="/quivolgo/app_temporada/index.php">Temporada</a></li>	
		<li><a href="/quivolgo/app_tubete/index.php">Tubete</a></li>	
		<li class="divider"></li>
		<li><a href="#!">Otro</a></li>
	</ul>

	<!--
	<ul id="dropdownInventario" class="dropdown-content">
		<li><a href="/quivolgo/usuarios/index.php">Iniciar Inventario</a></li>		
		<li><a href="/quivolgo/usuarios/index.php">Cerrar Inventario</a></li>		
		<li><a href="/quivolgo/usuarios/index.php">Registrar Mediciones</a></li>		
		<li><a href="/quivolgo/usuarios/index.php">Revision Medic.</a></li>		
		<li><a href="/quivolgo/usuarios/index.php">Stock Actual</a></li>		
		<li class="divider"></li>
		<li><a href="#!">Otro</a></li>
	</ul>	
	-->

	<ul id="dropdownInstalaciones" class="dropdown-content">
		<li><a href="/quivolgo/instalaciones/registrar.php">Registrar</a></li>		
		<li><a href="/quivolgo/instalaciones/resumen_componentes.php">Resumen Componentes Aplicados</a></li>		
		<li><a href="/quivolgo/instalaciones/index.php">Vista General</a></li>		
	</ul>

	<nav>
		<div class="nav-wrapper indigo">
		<!--<a href="#" class="brand-logo right">Logo</a>-->
		<ul id="nav-mobile" class="left hide-on-med-and-down" style="width: 100%;">
			<li><a href="/quivolgo"><i class="fa fa-home" style="margin-right: 6px; "></i>Home</a></li>
			<!--
			<li><a class="dropdown-button" href="#!" data-activates="dropdownInventario">Inventarios <i class="fa fa-arrow-down" style="margin-right: 6px; "></i></a></li>
			-->
			<li><a class="dropdown-button" href="#!" data-activates="dropdownInstalaciones"><i class="fa fa-list-alt" style="margin-right: 6px; "></i>Instalaciones <i class="fa fa-arrow-down" style="margin-right: 6px; "></i></a></li>
			<li><a href="/quivolgo/aplicaciones"><i class="fa fa-check-square-o" style="margin-right: 6px; "></i>Aplicaciones</a></li>
			<li><a href="/quivolgo/productos">Productos</a></li>

			
			<!--
			<li><a href="/quivolgo/informes/index.php">Intervenciones</a></li>
			<li><a href="/quivolgo/informes/index.php">Ensayos</a></li>
			<li><a href="/quivolgo/informes/index.php">Despacho</a></li>			
			-->
			<li><a href="/quivolgo/inventario/index.php">Inventario</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="fa fa-cogs" style="margin-right: 6px; "></i>Opciones <i class="fa fa-arrow-down" style="margin-right: 6px; "></i></a></li>
			<li style="float: right; "><a href="/quivolgo/login/logout.php">Cerrar Sesion</a></li>
		</ul>
		</div>
	</nav>
	<?php
}