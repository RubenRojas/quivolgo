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
	<h3 class="center">Inventarios</h3>
	
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



	/*********************
	PROGRESO MEDICIONES
	*********************/
	$query = "select 
	count(inventario_medicion.id) as realizadas
	from inventario_medicion where inventario_medicion.id_inventario='$id_inventario'";
	$result = $mysqli->query($query);
	$realizadas = $result->fetch_assoc();

	$query = "select 
	count(instalacion_parcela.id) as totales
	from instalacion_parcela 
	inner join instalacion on instalacion.id = instalacion_parcela.id_instalacion where instalacion.estado='1'";
	$result = $mysqli->query($query);
	$totales = $result->fetch_assoc();

	$realizadas = $realizadas['realizadas'];
	$totales  =$totales['totales'];

	$porc_completado = ($realizadas * 100) / $totales;
	$porc_restante = 100 - $porc_completado;
	$porc_total = $porc_completado + $porc_restante;


	/*********************
	AGRUPACION POR RANGO
	*********************/

	$query = "select 
	count(inventario_medicion_detalle.altura) as cantidad,
	inventario_rango.nombre 
	from 
	inventario_medicion_detalle
	inner join inventario_rango on inventario_medicion_detalle.altura between inventario_rango.valor_inicial and inventario_rango.valor_final
	inner join inventario_medicion on inventario_medicion.id = inventario_medicion_detalle.id_medicion
	where inventario_medicion.id_inventario='$id_inventario' 
	group by inventario_rango.nombre
	order by inventario_rango.id asc";
	$result = $mysqli->query($query);

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
		<div class="col s6">
			<div class="bloque">
				<h5 class="center">Progreso Medicion</h5>
				<table class="tabla_chica">
					<thead>
						<th>Item</th>
						<th>Porc.</th>
						<th>Num.</th>
					</thead>
					<tbody>
						<tr>
							<td>Completado</td>
							<td class="numero"><?=number_format($porc_completado,1)?>%</td>
							<td class="numero"><?=$realizadas?></td>
						</tr>
						<tr>
							<td>Restante</td>
							<td class="numero" class="numero"><?=number_format($porc_restante,1)?>%</td>
							<td class="numero"><?=$totales - $realizadas?></td>
						</tr>
						<tr>
							<td>Total</td>
							<td class="numero"><?=$porc_total?>%</td>
							<td class="numero"><?=$totales?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col s6 ">
			<div class="bloque">
				<h5 class="center">Distribucion según alturas</h5>
				<table class="tabla_chica">
					<thead>
						<th>Rango</th>
						<th>Cantidad</th>
					</thead>
					<tbody>
						<?php
						while ($arr = $result->fetch_assoc()) {
							?>
							<tr>
								<td><?=$arr['nombre']?></td>
								<td class="numero"><?=$arr['cantidad']?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="col s12"><hr></div>
		
		<?php
		$query = "select 
		inventario_medicion.id, 
		inventario_medicion.plantas_vivas,
		inventario_medicion.plantas_muertas,
		inventario_medicion.fecha,
		app_instalador.nombre as instalador,
		instalacion_parcela.codigo as cod_parcela,
		count(inventario_medicion_detalle.id) as detalle

		from inventario_medicion
		inner join app_instalador on app_instalador.id = inventario_medicion.instalador
		inner join inventario_medicion_detalle on inventario_medicion_detalle.id_medicion = inventario_medicion.id
		inner join instalacion_parcela on instalacion_parcela.id = inventario_medicion.id_parcela
		where inventario_medicion.id_inventario = '$id_inventario'";
		if($fecha_inicial != "" and $fecha_final!=""){
			$query .= "and inventario_medicion.fecha between '$fecha_inicial' and '$fecha_final' ";
		}
		$query.= "
		group by inventario_medicion.id
		order by inventario_medicion.fecha 
		";
		$result = $mysqli->query($query);
		
		?>
		<div class="col s12">
			<h5 class="center">Mediciones</h5>
			<a href="nueva_medicion.php" class="btn right teal" style="margin-bottom: 25px;">Nueva Medicion</a>
			<div class="col s12 filtros">
				<form action="">
				<div class="col s3">
					<label for="">Fecha Inicial</label>
					<input type="date" name="fecha_inicial" value="<?=$fecha_inicial?>">
				</div>
				<div class="col s3">
					<label for="">Fecha Final</label>
					<input type="date" name="fecha_final" value="<?=$fecha_final?>">
				</div>
				<div class="col s12">
					<input type="submit" value="Aplicar Filtros" class="btn right">
				</div>
				</form>
			</div>
			<table id="listado">
				<thead>
					<th>Fecha</th>
					<th>Parcela</th>
					<th>Plantas Vivas</th>
					<th>Plantas Muertas</th>
					<th>Instalador</th>
					<th>Reg. Medidos</th>
					<th>Detalle</th>
				</thead>
				<tbody>
					<?php
					while ($arr = $result->fetch_assoc()) {
						?>
						<tr>
							<td class="center"><?=cambiarFormatoFecha($arr['fecha'])?></td>
							<td class="center"><?=$arr['cod_parcela']?></td>
							<td class="numero"><?=$arr['plantas_vivas']?></td>
							<td class="numero"><?=$arr['plantas_muertas']?></td>
							<td class="center"><?=$arr['instalador']?></td>
							<td class="numero"><?=$arr['detalle']?></td>
							<td class="center"><a href="detalle_medicion.php?id_medicion=<?=$arr['id']?>">Detalle</a></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			
		</div>
	</div>



	<?php
}
else{
	//no hay inventario activo
	?>
	<div class="col s12">
		<div class="h5 center">No hay un inventario activo.</div>
		<a href="nuevo.php" class="btn teal center" style="display: block; margin: auto; width: 250px; margin-top: 20px;">Abrir Inventario</a>
		
	</div>
	<?php
}


?>

</div>
<?php


print_footer();
?>