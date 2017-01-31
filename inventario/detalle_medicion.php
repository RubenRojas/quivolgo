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

if(!in_array("5", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/index.php";
	header("location: /quivolgo/error/index.php");
}

extract($_GET); //id_medicion
print_head();
print_menu();
$query = "select 
		inventario_medicion.id, 
		inventario_medicion.plantas_vivas,
		inventario_medicion.plantas_muertas,
		inventario_medicion.observacion,
		inventario_medicion.fecha,
		app_instalador.nombre as instalador,
		instalacion_parcela.nipla,
		instalacion_parcela.codigo as cod_parcela

		from inventario_medicion
		inner join app_instalador on app_instalador.id = inventario_medicion.instalador
		
		inner join instalacion_parcela on instalacion_parcela.id = inventario_medicion.id_parcela
		where inventario_medicion.id = '$id_medicion'";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();	
?>
<div class="container">
	<div class="row">
		<div class="col s12">
			<h3 class="center">Detalle Medición</h3>
		</div>
		<div class="col s12">
			<div class="col s3">
				<label for="">Fecha Medicion</label>
				
				<span class="dato"><?=$arr['fecha']?></span>				
			</div>
			<div class="col s3">
				<label for="">Instalador</label>
				<span class="dato"><?=$arr['instalador']?></span>
				
			</div>
			<div class="col s3">
				<label for="">COD Parcela</label>
				
				<span class="dato"><?=$arr['cod_parcela']?></span>				
			</div>
			<div class="col s3">
				<label for="">NIPLA Parcela</label>
				
				<span class="dato"><?=$arr['nipla']?></span>				
			</div>
		</div>	
		<div class="col s12">
			<div class="col s6">
				<label for="">Cod. Instalacion</label>
				<span class="dato" id="cod_instalacion"></span>
			</div>
			<div class="col s6">
				<label for="">Cod. Mat. Gen.</label>
				<span class="dato" id="cod_mat_gen"></span>
			</div>
			<div class="col s4">
				<label for="">Contendor</label>
				<span class="dato" id="contenedor"></span>
			</div>
			<div class="col s4">
				<label for="">Tipo Propagacion</label>
				<span class="dato" id="tipo_propagacion"></span>
			</div>
			<div class="col s4">
				<label for="">Especie</label>
				<span class="dato" id="especie"></span>
			</div>
			<div class="col s4">
				<label for="">Sector</label>
				<span class="dato" id="sector"></span>
			</div>
			<div class="col s4">
				<label for="">Nave</label>
				<span class="dato" id="nave"></span>
			</div>
			<div class="col s4">
				<label for="">Meson</label>
				<span class="dato" id="meson"></span>
			</div>

		</div>

		<div class="col s12">
			<div class="col s3">
				<label for="">Plantas Vivas</label>
				
				<span class="dato"><?=$arr['plantas_vivas']?></span>					
			</div>
			<div class="col s3">
				<label for="">Plantas Muertas</label>
			
				<span class="dato"><?=$arr['plantas_muertas']?></span>					
			</div>
			<div class="col s12">
				<label for="">Observacion</label>
			
				<span class="dato"><?=$arr['observacion']?></span>					
			</div>
		</div>
		<div class="col s3">
			<h5 class="center">Medidas</h5>
			
				<table>
					<thead>
						<th width="25%">N°</th>
						<th>Altura</th>
					</thead>
					<tbody id="listado_alturas">
					
				
		<?php
		$query = "select altura from inventario_medicion_detalle where id_medicion='$id_medicion' order by id";
		$result = $mysqli->query($query);
		$i=1;
		while ($arr2 = $result->fetch_assoc()) {
			?>
			<tr>
				<td class="center"><?=$i?></td>
				<td class="center"><?=$arr2['altura']?> CM</td>
			</tr>
			<?php
			$i++;
		}
		?>

					</tbody>
				</table>
			
		</div>
		<div class="col s12" style="margin-top: 50px;">
			<a href="Javascript:window.history.back();" class="btn red left">Volver</a>
		</div>
	</div>	
</div>
<script>
	jQuery(document).ready(function($) {
		show_datos_instalacion('<?=$arr['cod_parcela']?>');
	});
</script>

<?php


print_footer();
?>