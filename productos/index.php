<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('PRODUCTOS', $mysqli);
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

$query = "select 
producto.nombre, 
producto.id,
app_estado.nombre as estado,
app_categoria_aplicacion.nombre as categoria
from producto 
inner join app_estado on app_estado.id = producto.estado
inner join app_categoria_aplicacion on app_categoria_aplicacion.id = producto.categoria
order by producto.nombre ";


$result = $mysqli->query($query);


?>
<div class="container">
	<h3 class="center">Productos</h3>
	<a href="registrar.php" class="btn btn_sys right btn_nuevo">Registrar</a>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>Nombre</th>
			<th>Categoría</th>
			<th>Estado</th>
			<th>Detalle</th>
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php	
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td class="center"><?=$arr['nombre']?></td>
				<td class="center"><?=$arr['categoria']?></td>
				<td class="center"><?=$arr['estado']?></td>
				<td class="center"><a href="detalle.php?id=<?=$arr['id']?>">Detalle</a></td>
				<td class="center"><a href="editar.php?id=<?=$arr['id']?>">Editar</a></td>
				<td class="center"><a href="borrar.php?id=<?=$arr['id']?>">Borrar</a></td>
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