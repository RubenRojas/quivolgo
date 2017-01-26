<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('INVENTARIO', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE, 2:READ, 3:UPDATE,  4:DELETE, 5:DETAIL */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/index.php";
	header("location: /quivolgo/error/index.php");
}

extract($_GET);

print_head();
print_menu();
?>
<div class="container">
	<h3 class="center">Cerrar Inventario en Progreso</h3>
	
<?php


$query = "select id from inventario where estado='1' order by id limit 1";
$result = $mysqli->query($query);
if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$id_inventario = $arr['id'];

	$query = "select
	inventario.fecha_apertura,
	app_estado.nombre as estado,
	app_coordinador.nombre as coordinador,
	inventario.observacion 
	from inventario
	inner join app_estado on app_estado.id = inventario.estado
	inner join app_coordinador on app_coordinador.id = inventario.coordinador 
	where inventario.id = '$id_inventario' limit 1";
	$result = $mysqli->query($query);
	$inventario = $result->fetch_assoc();




	//hay un inventario activo
	?>
	<div class="row">
		<div class="col s3">
			<label for="">Fecha Apertura</label>
			<span class="dato"><?=cambiarFormatoFecha($inventario['fecha_apertura'])?></span>
		</div>
		<div class="col s4">
			<label for="">Coordinador</label>
			<span class="dato"><?=$inventario['coordinador']?></span>
		</div>
		<div class="col s12">
			<label for="">Comentario / Observacion</label>
			<span class="dato"><?=$inventario['observacion']?></span>
		</div>	
	</div>

	<div class="row">
		<div class="col s12">
			<h6 class="center">
				¿CONFIRMA QUE DESEA CERRAR EL INVENTARIO EN PROGRESO ACTUAL?

			</h6>
			<p class="center">Esta acción es irreversible</p>
			<a href="forms/cerrar_inventario.php" class="btn red" style="width: 250px; display: block; margin: auto; margin-top: 30px;">CERRAR INVENTARIO</a>
		</div>
	</div>
	<?php
}


?>

</div>
<?php


print_footer();
?>