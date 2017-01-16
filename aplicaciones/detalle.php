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

if(!in_array("5", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/productos/index.php";
	header("location: /quivolgo/error/index.php");
}
extract($_GET);

$query = "select
aplicacion.id,
aplicacion.fecha,
app_instalador.nombre as instalador,
app_medio_aplicacion.nombre as medio,
app_categoria_aplicacion.nombre as categoria,
producto.nombre as producto
from aplicacion 
inner join app_instalador on app_instalador.id = aplicacion.encargado
inner join app_medio_aplicacion on app_medio_aplicacion.id = aplicacion.medio
inner join app_categoria_aplicacion on app_categoria_aplicacion.id = aplicacion.categoria 
inner join producto on producto.id = aplicacion.producto
where aplicacion.id='$id'";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();



$query = "select app_componente.nombre as componente, app_componente.descripcion, aplicacion_cantidad.cantidad from aplicacion_cantidad inner join app_componente on app_componente.id = aplicacion_cantidad.componente where aplicacion_cantidad.id_aplicacion = '$id'";
$res = $mysqli->query($query);


$query = "select app_sector.nombre from aplicacion_ubicacion inner join app_sector on app_sector.id = aplicacion_ubicacion.sector where id_aplicacion='$id' limit 1";
$res2 = $mysqli->query($query);
$arr2 = $res2->fetch_assoc();
$sector = $arr2['nombre'];



$query = "select nave from aplicacion_ubicacion where id_aplicacion='$id' group by nave";
$naves = 	$mysqli->query($query);


print_head();
print_menu();



$titulo = "Detalle Aplicacion";

?>

<div class="container_form">
	<form action="forms/update.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				<div class="col s3">
					<label for="">Fecha Aplicacion</label>
					<span class="dato"><?=cambiarFormatoFecha($arr['fecha'])?></span>
				</div>
				<div class="col s3">
					<label for="">Encargado</label>
					<span class="dato"><?=$arr['instalador']?></span>
				</div>
				<div class="col s3">
					<label for="">Medio</label>
					<span class="dato"><?=$arr['medio']?></span>
				</div>
				<div class="col s3">
					<label for="">Categoria</label>
					<span class="dato"><?=$arr['categoria']?></span>
				</div>
				<div class="col s3">
					<label for="">Producto</label>
					<span class="dato"><?=$arr['producto']?></span>
				</div>
				<div class="col s12" style="margin-bottom: 20px;">
					<div class="col s12 m8 offset-m2">
						
						<table class="componente">
							<thead>
								<th>Componente</th>
								<th>Descripcion</th>
								<th>Cantidad</th>
								<th>Unidad</th>
							</thead>
							<tbody>
								<?php
								while ($arr2 = $res->fetch_assoc()) {
									?>
									<tr>
										<td><?=$arr2['componente']?></td>
										<td><?=$arr2['descripcion']?></td>
										<td class="numero"><?=$arr2['cantidad']?></td>
										<td>GR</td>
										
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col s12">
					<h5 class="center">Ubicacion</h5>
					<div class="col s12">
						<div class="col s3">
							<label for="">Sector</label>
							<span class="dato"><?=$sector?></span>
						</div>
					</div>
					<?php
					while ($nave = $naves->fetch_assoc()) {
						$query = "select meson from aplicacion_ubicacion where id_aplicacion='$id' and nave='$nave[nave]' order by meson";
						$result = $mysqli->query($query);
						?>
						<div class="col s12"><label for="">N<?=$nave['nave']?></label></div>
							<div class="col s12">
							<?php
							while ($arr = $result->fetch_assoc()) {
								?>
								<div class="col s1 naveMeson">
									N<?=$nave['nave']?>-<b>M<?=$arr['meson']?></b>
								</div>
								<?php
							}
							?>
							</div>
						<?php
					}
					?>
					<div class="col s12">

					</div>
				</div>
				
			</div>

		

			
			
			
		
		<div class="col s12" style="margin-top: 50px;">
			<input type="hidden" name="id" id="id" value="<?=$id?>">
			<a href="Javascript:window.history.back();" class="btn red left">Volver</a>
			
		</div>
	</form>
	
</div>

<script>
	jQuery(document).ready(function($) {
		
	});
	


</script>

<?php
print_footer();
?>