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
instalacion.cod_mat_gen,
cod_mat_gen.id as id_cod_mat_gen,
app_estado.nombre as estado,
app_sector.nombre as sector,
app_temporada.nombre as temporada,
app_nave.nombre as nave,
app_especie.nombre as especie,
madre.fecha_plantacion as anio,
app_propagacion.nombre as tipo_propagacion


from instalacion 
left join madre on madre.id = instalacion.madre
left join app_estado on app_estado.id = instalacion.estado
left join app_nave on app_nave.id = instalacion.nave
left join app_sector on app_sector.id = instalacion.sector
left join app_temporada on app_temporada.id = instalacion.temporada
left join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen
left join app_especie on app_especie.id = cod_mat_gen.especie
left join app_propagacion on app_propagacion.id = madre.tipo_propagacion


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
			<th>Cod. Mat. Gen</th>
			<th>Estado</th>
			<th>NIPLA</th>
			<th>Tempo.</th>
			<th>Especie</th>
			<th>T. Prop.</th>
			<th>Sector</th>
			<th>Nave</th>
			<th>Año Madre</th>
			<th>Meson</th>
			<th>Detalle</th>			
			<th>Editar</th>
			<th>Borrar</th>
		</thead>
		<tbody>
	<?php
	
	while ($arr = $result->fetch_assoc()) {
		?>
			<tr>
				<td class="center"><?=$arr['cod_instalacion']?></td>
				<td class="center"><?=$arr['fecha']?></td>
				<td class="center"><?=$arr['cod_mat_gen']?></td>
				<td class="center"><?=$arr['estado']?></td>
				<td class="numero_tabla"><?=number_format($arr['nipla'])?></td>
				<td class="center"><?=$arr['temporada']?></td>
				<td class="center"><?=$arr['especie']?></td>
				<td class="center"><?=$arr['tipo_propagacion']?></td>
				<td class="center"><?=$arr['sector']?></td>
				<td class="center"><?=$arr['nave']?></td>
				<td class="numero_tabla"><?=$arr['anio']?></td>
				<td class="numero_tabla"><?=$arr['meson']?></td>
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