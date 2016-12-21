<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('OPCIONES', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE, 2:READ, 3:UPDATE,  4:DELETE, 5:DETAIL */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/app_coordinador/index.php";
	header("location: /quivolgo/error/index.php");
}

print_head();
print_menu();



$titulo = "Nuevo Coordinador";

?>
<div class="container_form">
	<form action="forms/insert.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<div class="col s12">
				<label for="">Nombre</label>
				<input type="text" name="nombre" value="">
			</div>
			
			
		
			<div class="col s12" style="margin-top: 50px;">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
</div>

<?php
print_footer();
?>