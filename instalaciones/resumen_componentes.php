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

extract($_GET);



$query = "select instalacion.cod_instalacion, instalacion.id as id_instalacion, ";
	  

$q = "select id from app_componente";
$result = $mysqli->query($q);
while ($arr = $result->fetch_assoc()) {
	$query .= "sum( if( aplicacion_cantidad.componente = '$arr[id]', aplicacion_cantidad.cantidad, 0 ) ) AS c_$arr[id], ";
}
$query = substr($query, 0, -2);

$query .=" from aplicacion_instalacion
	inner join aplicacion_cantidad on aplicacion_cantidad.id_aplicacion = aplicacion_instalacion.id_aplicacion
	inner join app_componente on app_componente.id = aplicacion_cantidad.componente
	inner join instalacion on instalacion.id = aplicacion_instalacion.id_instalacion
	inner join aplicacion on aplicacion_instalacion.id_aplicacion = aplicacion.id
	where instalacion.estado='1' ";
if($sector != ""){
	$query .="and instalacion.sector='$sector' ";
}
if($nave != ""){
	$query .="and instalacion.nave='$nave' ";
}
if($fecha_inicio != "" and $fecha_final!= ""){
	$query.= "and aplicacion.fecha between '$fecha_inicio' and '$fecha_final' ";
}

$query.= "group by aplicacion_instalacion.id_instalacion";

?>
<div class="container">
	<h3 class="center">Resumen Componentes Aplicados</h3>
	<div class="row">
		<div class="col s12 filtros">
			<h5 class="center">Filtros</h5>
			<form action="">
				<div class="col s3">
					<label for="">Fecha Inicial</label>
					<input type="date" name="fecha_inicio" value="<?=$fecha_inicio?>">
				</div>
				<div class="col s3">
					<label for="">Fecha Final</label>
					<input type="date" name="fecha_final" value="<?=$fecha_final?>">
				</div>
				<div class="col s3">
					<label for="">Sector</label>
					<select name="sector" id="sector">
						<?=show_option("app_sector", $sector, $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Nave</label>
					<select name="nave" id="nave" onchange="showMesones()">
						<?=show_option("app_nave", $nave, $mysqli)?>
					</select>
				</div>
				<div class="col s12">
					<input type="submit" value="Aplicar Filtros" class="btn teal right">
				</div>
			</form>
		</div>
	</div>
	<table id="listado" style="font-size: 0.82em;">
		<thead>
			<th>Cod.</th>
			<?php
			$q = "select id, nombre from app_componente";
			$result = $mysqli->query($q);
			while ($arr = $result->fetch_assoc()) {
				?>
				<th><?=$arr['nombre']?></th>
				<?php
			}
			?>
			<th>Detalle</th>			
		</thead>
		<tbody>
	<?php

		$result = $mysqli->query($query);
		while ($arr = $result->fetch_assoc()) {
			?>
			<tr>
				<td><?=$arr['cod_instalacion']?></td>
				<?php
				$re = $mysqli->query($q);
				while ($ar = $re->fetch_assoc()) {
				?>
				<td><?=$arr['c_'.$ar['id']]?></td>
				<?php
				}
			?>
				<td><a href="detalle.php?id=<?=$arr['id_instalacion']?>">Detalle </a></td>
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