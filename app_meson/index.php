<?php
if(is_dir("/home4/alvarube/public_html/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/quivolgo/includes/";
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

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/index.php";
	header("location: /quivolgo/error/index.php");
}



print_head();
print_menu();
$query = "select * from app_meson order by nombre asc";

$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Meson</h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Nuevo</a>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th>Estado</th>
			
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php
	
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td><?=$arr['id']?></td>
				<td><?=$arr['nombre']?></td>
				<td><?=get_campo("app_estado", "nombre", $arr['estado'], $mysqli)?></td>
				
				<td><a href="editar.php?id=<?=$arr['id']?>">Editar</a></td>
				<td><a href="borrar.php?id=<?=$arr['id']?>">Borrar</a></td>
			</tr>
		<?php
	}
	?>
		</tbody>
	</table>
	
</div>

<?php
print_footer();
?>