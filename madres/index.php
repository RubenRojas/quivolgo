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

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/index.php";
	header("location: /quivolgo/error/index.php");
}



print_head();
print_menu();
$query = "select 
cod_mat_gen.nombre as cod_mat_gen,
madre.cod_desc, 
madre.id, 
app_campo_origen.nombre as campo_origen,  
madre.fecha_plantacion,
app_origen_genetico.nombre as origen_genetico,
app_propagacion.nombre as tipo_propagacion 

from madre 
inner join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen
inner join app_campo_origen on app_campo_origen.id = madre.campo_origen
inner join app_origen_genetico on app_origen_genetico.id = madre.origen_genetico
inner join app_propagacion on app_propagacion.id = madre.tipo_propagacion

order by cod_desc asc";

$result = $mysqli->query($query);

?>
<div class="container">
	<h3 class="center">Madres</h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Nuevo</a>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>Cod.</th>
			<th>Campo Origen</th>
			<th>Fecha Plantacion</th>
			<th>Cod. Mat. Gen</th>
			<th>Origen Genetico</th>
			<th>Tipo Propagacion</th>
			
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php
	
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td><?=$arr['cod_desc']?></td>
				<td><?=$arr['campo_origen']?></td>
				<td><?=$arr['fecha_plantacion']?></td>
				<td><?=$arr['cod_mat_gen']?></td>
				<td><?=$arr['origen_genetico']?></td>
				<td><?=$arr['tipo_propagacion']?></td>
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