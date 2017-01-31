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

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/despacho/index.php";
	header("location: /quivolgo/error/index.php");
}


extract($_GET);

$query = "select
despacho.fecha_ingreso,
app_predio.nombre as predio,
app_especie.nombre as especie,
app_contenedor.nombre as contenedor,
despacho.id,
app_instalador.nombre as encargado,
despacho_requerimiento.total_plantas,
despacho.tipo_contenedor as tipo_contenedor,
inventario_rango.nombre as rango,
inventario_rango.id as id_rango,
despacho.id_inventario
from despacho
inner join app_predio on app_predio.id = despacho.predio
inner join app_especie on app_especie.id = despacho.especie
inner join app_contenedor on app_contenedor.id = despacho.tipo_contenedor
inner join app_instalador on app_instalador.id = despacho.encargado
inner join despacho_requerimiento on despacho_requerimiento.id_despacho = despacho.id
inner join inventario_rango on inventario_rango.id = despacho.rango
where despacho.id='$id' limit 1;
";

$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$query = "select id_instalacion from despacho_detalle where id_despacho='$id'";
$result = $mysqli->query($query);
$chequeados = array();
while ($inst = $result->fetch_assoc()) {
	array_push($chequeados, $inst['id_instalacion']);
}

print_head();
print_menu();

?>
<div class="container">
	<h3 class="center">Gestion de Despacho</h3>
	<div class="row">
		<div class="col s12">
			<div class="col s4">
				<label for="">Fecha Ingreso</label>
				<span class="dato"><?=cambiarFormatoFecha($arr['fecha_ingreso'])?></span>
			</div>
			<div class="col s4">
				<label for="">Predio</label>
				<span class="dato"><?=$arr['predio']?></span>
			</div>
			<div class="col s4">
				<label for="">Responsable</label>
				<span class="dato"><?=$arr['encargado']?></span>
			</div>
			<div class="col s3">
				<label for="">Bandeja</label>
				<span class="dato"><?=$arr['contenedor']?></span>
			</div>
			<div class="col s3">
				<label for="">Especie</label>
				<span class="dato"><?=$arr['especie']?></span>
			</div>
			<div class="col s3">
				<label for="">Rango de Pantas</label>
				<span class="dato"><?=$arr['rango']?></span>
			</div>
			<div class="col s3">
				<label for="">Plantas Totales</label>
				<span class="dato"><?=$arr['total_plantas']?></span>
			</div>
		</div>
		<div class="col s12">
			
				<table class="tabla_oferta_impresion">
					<thead>
						<th width="18%">CMG</th>
						<th width="18%">Cod. I.</th>
						<th width="18%">Sector</th>
						<th>Nave</th>
						<th>Meson</th>
						<th>P. Disp.</th>
			
						<th width="10%">Cant.</th>
						<th>FICHA</th>

					</thead>
					<tbody>
						<?php
						$query = "select 
						cod_mat_gen.nombre as cod_mat_gen,
						instalacion.id as id_instalacion,
						instalacion.cod_instalacion,
						app_sector.nombre as sector,
						app_nave.nombre as nave,
						instalacion.meson,
						inventario_resultado.cantidad

						from inventario_resultado
						inner join instalacion on instalacion.id = inventario_resultado.id_instalacion
						inner join cod_mat_gen on cod_mat_gen.nombre = instalacion.cod_mat_gen
						inner join app_nave on app_nave.id = instalacion.nave
						inner join app_sector on app_sector.id = instalacion.sector

						where 
						inventario_resultado.id_inventario = '$arr[id_inventario]'
						and inventario_resultado.id_rango_inventario = '$arr[id_rango]'
						and instalacion.tipo_contenedor = '$arr[tipo_contenedor]'
						and instalacion.id in (";

						$q = "select id_instalacion from despacho_detalle where id_despacho='$id'";
						$result = $mysqli->query($q);
						while ($cmg = $result->fetch_assoc()) {
							$query .="'$cmg[id_instalacion]', ";
						}
						$query = substr($query,0, -2);
						$query.= ") 
						order by inventario_resultado.cantidad desc, cod_mat_gen.nombre ";
						$total = 0;
						$result = $mysqli->query($query);
						if($result->num_rows > 0){
							while ($row = $result->fetch_assoc()) {
								if(in_array($row['id_instalacion'], $chequeados)){
									$oferta = select("despacho_detalle", array("cantidad, ficha"), array("id_despacho"=>$id, "id_instalacion"=>$row['id_instalacion']), array("limit"=>"1"), $mysqli);
								}
								?>
								<tr id="<?=$row['id_instalacion']?>_fila" >
									<td><?=$row['cod_mat_gen']?></td>
									<td><?=$row['cod_instalacion']?></td>
									<td><?=$row['sector']?></td>
									<td class="center"><?=$row['nave']?></td>
									<td class="center"><?=$row['meson']?></td>
									<td class="numero"><?=$row['cantidad']?></td>
								
									<td class="numero"><?=number_format($oferta['cantidad'])?></td>
									<td></td>
								
								</tr>
								<?php
								$total += $oferta['cantidad'];
							}

						}
						
							for ($i=0; $i < 5; $i++) { 
								?>
								<tr>
									<td></td>							
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php
							}
						?>

							<tr>
								<td><b>TOTALES</b></td>							
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td class="numero"><?=number_format($total)?></td>
								<td></td>
								
							</tr>

					</tbody>
				</table>

				<div class="col s12" style="position: absolute; bottom: 0; width: 900px; ">
					<div class="col s6">	
						<p class="center">______________________________<br>
						<b>Firma 1</b></p>

					</div>
					<div class="col s6">
						<p class="center">______________________________<br>
						<b>Firma 2</b></p>
					</div>
				</div>


				<div class="col s12" style="margin-top: 25px;">
					<a href="Javascript:window.print();" class="btn right">Imprimir</a>
				</div>
			
		</div>

	</div>
	
</div>

<script>
	jQuery(document).ready(function($) {
		window.print();
	});
</script>
<?php
print_footer();
?>