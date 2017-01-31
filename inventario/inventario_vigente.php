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
	<h3 class="center">Inventario Vigente</h3>
	
<?php


$query = "select id from inventario where estado='2' order by id desc limit 1";
$result = $mysqli->query($query);
if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$id_inventario = $arr['id'];
	$query = "select
	inventario.fecha_apertura,
	inventario.fecha_cierre,
	app_estado.nombre as estado,
	app_coordinador.nombre as coordinador,
	inventario.observacion 
	from inventario
	inner join app_estado on app_estado.id = inventario.estado
	inner join app_coordinador on app_coordinador.id = inventario.coordinador 
	where inventario.id = '$id_inventario' limit 1";
	$result = $mysqli->query($query);
	$inventario = $result->fetch_assoc();

	


$query = "select 
instalacion.cod_instalacion,
instalacion.id as id_instalacion,
cod_mat_gen.nombre as cod_mat_gen,
app_contenedor.nombre as contenedor,
app_especie.nombre as especie,
app_propagacion.nombre as tipo_propagacion,
app_sector.nombre as sector,
app_nave.nombre as nave,
instalacion.meson,
app_temporada.nombre as temporada,
";
$q = "select id, nombre from inventario_rango where id_inventario='$id_inventario' order by id ";
$result = $mysqli->query($q);
while ($arr = $result->fetch_assoc()) {
	$query .= "sum( if( inventario_resultado.id_rango_inventario = '$arr[id]', inventario_resultado.cantidad, 0 ) ) AS R_$arr[id],
	";
}
$query .= "sum( if( 1=1, inventario_resultado.cantidad, 0 ) ) AS TOTAL
from 
inventario_resultado
inner join instalacion on instalacion.id = inventario_resultado.id_instalacion
inner join madre on madre.id = instalacion.madre
inner join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen
inner join app_contenedor on app_contenedor.id = instalacion.tipo_contenedor
inner join app_especie on app_especie.id = cod_mat_gen.especie
inner join app_propagacion on app_propagacion.id = madre.tipo_propagacion
inner join app_sector on app_sector.id = instalacion.sector
inner join app_nave on app_nave.id = instalacion.nave
inner join app_temporada on app_temporada.id = instalacion.temporada
where
inventario_resultado.id_inventario='$id_inventario'
";

if(count($especie)>0){
	$query.="and cod_mat_gen.especie in(";
	foreach ($especie as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($cod_mat_gen)>0){
	$query.="and cod_mat_gen.id in(";
	foreach ($cod_mat_gen as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($app_contenedor)>0){
	$query.="and instalacion.tipo_contenedor in(";
	foreach ($app_contenedor as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($app_propagacion)>0){
	$query.="and madre.tipo_propagacion in(";
	foreach ($app_propagacion as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($app_sector)>0){
	$query.="and instalacion.sector in(";
	foreach ($app_sector as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($app_nave)>0){
	$query.="and instalacion.nave in(";
	foreach ($app_nave as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}
if(count($app_temporada)>0){
	$query.="and instalacion.temporada in(";
	foreach ($app_temporada as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}

if(count($meson)>0){
	$query.="and instalacion.meson in(";
	foreach ($meson as $value) {
		$query.="'$value', ";
	}
	$query = substr($query, 0, -2);
	$query.=")
	";
}

$query.="
group by instalacion.cod_instalacion";




	?>
	<div class="row">
		<div class="col s4">
			<label for="">Fecha Apertura</label>
			<span class="dato"><?=cambiarFormatoFecha($inventario['fecha_apertura'])?></span>
		</div>
		<div class="col s4">
			<label for="">Fecha Cierre</label>
			<span class="dato"><?=cambiarFormatoFecha($inventario['fecha_cierre'])?></span>
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
	<hr>
	<div class="row">
		<div class="col s12 lista_filtros">
			<form action="">
				<div class="col s3">
					<label for="">Especie</label>
					<select multiple name="especie[]" id="especie" onchange="setCodMatGenFiltro()">
				      <?=show_option_multiple("app_especie", $especie, $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Cod. Mat. Gen</label>
					<select multiple name="cod_mat_gen[]" id="cod_mat_gen">
				      <?=show_option_multiple("cod_mat_gen", $cod_mat_gen , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Bandeja</label>
					<select multiple name="app_contenedor[]" id="app_contenedor">
				      <?=show_option_multiple("app_contenedor", $app_contenedor , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Propagacion</label>
					<select multiple name="app_propagacion[]" id="app_propagacion">
				      <?=show_option_multiple("app_propagacion", $app_propagacion , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Sector</label>
					<select multiple name="app_sector[]" id="app_sector" onchange="setNavesFiltro(); setMesonesFiltro();">
				      <?=show_option_multiple("app_sector", $app_sector , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Nave</label>
					<select multiple name="app_nave[]" id="app_nave" onchange="setMesonesFiltro();">
				      <?=show_option_multiple("app_nave", $app_nave , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s3">
					<label for="">Meson</label>
					<select multiple name="meson[]" id="meson">

					</select>
				</div>
				<div class="col s3">
					<label for="">Temporada</label>
					<select multiple name="app_temporada[]" id="app_temporada">
				      <?=show_option_multiple("app_temporada", $app_temporada , $mysqli, "TODAS")?>
				    </select>
				</div>
				<div class="col s12">

					<input type="submit" value="Aplicar" class="btn right">
					<a href="inventario_vigente.php" class="btn right indigo" style="margin-right: 8px;">Reiniciar Filtros</a>
				</div>
			</form>
		</div>
	</div>
</div> <!-- container -->
<div class="contenedor_tabla">
	<table id="listado" class="inventario">
		<thead>
			<th>Cod.Inst</th>
			<th>Espe.</th>
			<th>Cod.M.Gen</th>
			<th>Band</th>
			<th>Prop.</th>
			<th>Sect.</th>
			<th>Nave</th>
			<th>Meson</th>
			<th>Temp.</th>
			<?php
			$q = "select id, nombre from inventario_rango where id_inventario='$id_inventario' order by id ";
			$res_rango = $mysqli->query($q);
			while ($arr = $res_rango->fetch_assoc()) {
				?>
				<th><?=$arr['nombre']?></th>
				<?php
			}
			?>
			<th>Total</th>
			<th>Desp.</th>
			<th>Disponibles</th>
			<th>% Desp.</th>
		</thead>
		<tbody>

			<?php
			$suma = array();
			$result = $mysqli->query($query);
			while ($arr = $result->fetch_assoc()) {
				?>
				<tr>
					<td><a href="/quivolgo/instalaciones/detalle.php?id=<?=$arr['id_instalacion']?>"><?=$arr['cod_instalacion']?></a></td>
					<td><?=$arr['especie']?></td>
					<td><?=$arr['cod_mat_gen']?></td>
					<td><?=$arr['contenedor']?></td>
					<td><?=$arr['tipo_propagacion']?></td>
					<td><?=$arr['sector']?></td>
					<td class="numero"><?=$arr['nave']?></td>
					<td class="numero"><?=$arr['meson']?></td>
					<td class="numero"><?=$arr['temporada']?></td>
					<?php
					$res_rango->data_seek(0);
					while ($arr2 = $res_rango->fetch_assoc()) {
						?>
						<td class="numero"><?=number_format($arr["R_".$arr2['id']])?></td>

						<?php
						$suma["R_".$arr2['id']] += $arr["R_".$arr2['id']];
					}
					?>
					<td class="numero"><?=number_format($arr['TOTAL'])?></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php
					$suma['TOTAL'] += $arr['TOTAL'];
			}
			?>
			<tr>
				<td><b>TOTALES</b></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<?php
				$res_rango->data_seek(0);
				while ($arr2 = $res_rango->fetch_assoc()) {
					?>
					<td class="numero"><b><?=number_format($suma["R_".$arr2['id']])?></b></td>

					<?php
					
				}
				?>
				<td class="numero"><b><?=number_format($suma['TOTAL'])?></b></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>

	
<script>
	jQuery(document).ready(function($) {
		setCodMatGenFiltro();
		setMesonesFiltro();
	});


	
</script>
	
	<?php
}
else{
	//no hay inventario activo
	?>
		<div class="h5 center">No hay un inventario Vigente.</div>
		<a href="nuevo.php" class="btn teal center" style="display: block; margin: auto; width: 250px; margin-top: 20px;">Abrir Inventario</a>		
	<?php
}


?>


<?php


print_footer();
?>