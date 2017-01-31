<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('DESPACHO', $mysqli);
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
despacho.fecha_ingreso,
app_predio.nombre as predio,
app_especie.nombre as especie,
app_contenedor.nombre as contenedor,
despacho.id,
app_instalador.nombre as encargado,
despacho_requerimiento.total_plantas
from despacho
inner join app_predio on app_predio.id = despacho.predio
inner join app_especie on app_especie.id = despacho.especie
inner join app_contenedor on app_contenedor.id = despacho.tipo_contenedor
inner join app_instalador on app_instalador.id = despacho.encargado
inner join despacho_requerimiento on despacho_requerimiento.id_despacho = despacho.id
order by fecha_ingreso;

";



?>
<div class="container">
	<h3 class="center">Despachos Pendientes</h3>
	<a href="nuevo.php" class="btn btn_sys right btn_nuevo">Registrar</a>
	<table id="listado">
		<thead>
			<th>Fecha</th>
			<th>Encargado</th>
			<th>Predio</th>
			<th>Especie</th>
			<th>Bandeja</th>
			<th>Cant. Plantas</th>
			<th>Revisar</th>
		</thead>
		<tbody>
			<?php
			$result = $mysqli->query($query);
			while ($arr = $result->fetch_assoc()) {
				?>
				<tr>
					<td><?=cambiarFormatoFecha($arr['fecha_ingreso'])?></td>
					<td><?=$arr['encargado']?></td>
					<td><?=$arr['predio']?></td>
					<td><?=$arr['especie']?></td>
					<td><?=$arr['contenedor']?></td>
					<td class="numero"><?=number_format($arr['total_plantas'])?></td>
					<td><a href="oferta.php?id=<?=$arr['id']?>">Revisar</a></td>
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