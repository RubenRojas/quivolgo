<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('INSTALACION', $mysqli);
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
instalacion.id,
instalacion.cod_instalacion,
instalacion.fecha,
instalacion.nipla,
instalacion.meson,
madre.cod_desc, 
app_estado.nombre as estado,
app_sector.nombre as sector,
app_nave.nombre as nave,


from instalacion 

left join app_estado on app_estado.id = instalacion.estado
left join app_nave on app_nave.id = instalacion.nave
left join app_sector on app_sector.id = instalacion.sector

left join madre on madre.id = instalacion.madre

order by madre.id asc";

$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Instalaciones</h3>
	<a href="registrar.php" class="btn btn_sys right btn_nuevo">Registrar</a>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>Cod.</th>
			<th>Fecha</th>
			<th>Cod. Madre</th>
			<th>Estado</th>
			<th>NIPLA</th>
			<th>Sector</th>
			<th>Nave</th>
			<th>Meson</th>			
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php
	
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td><?=$arr['cod_instalacion']?></td>
				<td><?=$arr['fecha']?></td>
				<td><?=$arr['cod_desc']?></td>
				<td><?=$arr['estado']?></td>
				<td><?=$arr['nipla']?></td>
				<td><?=$arr['sector']?></td>
				<td><?=$arr['nave']?></td>
				<td><?=$arr['meson']?></td>
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