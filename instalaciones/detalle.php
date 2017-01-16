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

if(!in_array("5", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/instalaciones/index.php";
	header("location: /quivolgo/error/index.php");
}

extract($_GET);
$query  = "select * from instalacion where id='$id'";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$nId = $arr['id'];
if($nId<10){
	$nId = "0".$nId;
}


$query = "select * from madre where id= '$arr[madre]' limit 1";
$result = $mysqli->query($query);
$madre = $result->fetch_assoc();

$cod_mat_gen = select("cod_mat_gen", array("*"), array("id"=>$madre['id_cod_mat_gen']), array("limit"=>"1"), $mysqli);


print_head();
print_menu();



$titulo = "Detalle Instalacion";

?>
<script>
	var nId = "<?=$nId?>";
</script>
<div class="container_form">

		<div class="row" id="form_instalacion">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				<h5 class="center">Datos Instalacion</h5>

				<div class="col s3">
					<label for="">Cod. Instalacion</label>
					<span class="dato"><?=$arr['cod_instalacion']?></span>
					
				</div>
				<div class="col s3">
					<label for="">Fecha</label>
					
					<span class="dato"><?=cambiarformatoFecha($arr['fecha'])?></span>
				</div>
				<div class="col s3">
					<label for="">Cod. Madre</label>
					<span class="dato">
						<?=get_campo("madre", "cod_desc", $arr['madre'], $mysqli)?>
				</div>
				<div class="col s3">
					<label for="">Cod M. Genetico</label>
					<span class="dato"><?=get_campo("cod_mat_gen", "nombre", $madre['id_cod_mat_gen'], $mysqli)?></span>
					
					
				</div>
				<div class="col s3">
					<label for="">Especie</label>
					<span class="dato"><?=get_campo("app_especie", "nombre", $cod_mat_gen['especie'], $mysqli)?></span>
					
				</div>
				

				<div class="col s3">
					<label for="">Estado</label>
					<span class="dato"><?=get_campo("app_estado", "nombre", $arr['estado'], $mysqli)?></span>
					
					
				</div>

				<div class="col s12">
					<div class="col s3">
						<label for="">Origen Genetico: </label>
						<span class="dato" id="origen_genetico"><?=get_campo("app_origen_genetico", "nombre", $madre['origen_genetico'], $mysqli)?></span>
					</div>
					<div class="col s3">
						<label for="">Tipo Propagacion: </label>
						<span class="dato" id="tipo_propagacion"><?=get_campo("app_propagacion", "nombre", $madre['tipo_propagacion'], $mysqli)?></span>
					</div>
					<div class="col s3">
						<label for="">Campo de Setos: </label>
						<span class="dato" id="campo_origen"><?=get_campo("app_campo_origen", "nombre", $madre['campo_origen'], $mysqli)?></span>
					</div>
					<div class="col s3">
						<label for="">Fecha Madre: </label>
						<span class="dato" id="fecha_plantacion"><?=cambiarFormatoFecha($madre['fecha_plantacion'], $mysqli)?></span>
					</div>
					
				</div>


			</div>
			<div class="row">
				<h5 class="center">Ubicacion y Cantidades</h5>

				<div class="col s3">
					<label for="">Codigo Sector </label>
					<span class="dato"><?=get_campo("app_sector", "nombre", $arr['sector'], $mysqli)?></span>
					
				</div>

				<div class="col s3">
					<label for="">Nave</label>
					<span class="dato"><?=get_campo("app_nave", "nombre", $arr['nave'], $mysqli)?></span>
					
				</div>
				<div class="col s3">
					<label for="">Meson</label>
					
					<span class="dato"><?=$arr['meson']?></span>
				</div>
				<div class="col s3">
					<label for="">Tipo Bandeja</label>
					<span class="dato"><?=get_campo("app_contenedor", "nombre", $arr['tipo_contenedor'], $mysqli)?></span>
					
				</div>
				<div class="col s3">
					<label for="">Cap. Contenedor</label>
					<span class="dato"><?=get_campo("app_contenedor", "capacidad", $arr['tipo_contenedor'], $mysqli)?></span>
					
				</div>
				<div class="col s3">
					<label for="">N° Contenedores</label>
					<span class="dato"><?=$arr['n_contenedores']?></span>
					
				</div>
				<div class="col s3">
					<label for="">NIPLA</label>
					<span class="dato"><?=$arr['nipla']?></span>
					
				</div>
				<div class="col s3">
					<label for="">Temporada</label>
					<span class="dato"><?=get_campo("app_temporada", "nombre", $arr['temporada'], $mysqli)?></span>
					
				</div>
				<div class="col s3">
					<label for="">Platabanda</label>
					<span class="dato"><?=$arr['platabanda']?></span>
					
				</div>
				<div class="col s3">
					<label for="">Instalador</label>
					<span class="dato"><?=get_campo("app_instalador", "nombre", $arr['instalador'], $mysqli)?></span>
				</div>
				
			</div>
			
			<div class="row">
				<h5 class="center">Parcelas</h5>
				<?php
				$query = "select 
				instalacion_parcela.codigo, 
				app_contenedor.nombre as contenedor,
				instalacion_parcela.nipla,
				app_estado.nombre as estado
				from instalacion_parcela 
				inner join app_contenedor on app_contenedor.id = instalacion_parcela.tipo_contenedor
				inner join app_estado on app_estado.id = instalacion_parcela.estado
				 where id_instalacion='$id'";

				$result = $mysqli->query($query);
				$parcelas_creadas = $result->num_rows;
				$i = 1;
				?>
				<div class="col s12">
					<table id="listado_no_dataTable" >
						<thead>
							<th>Cod. Parcela</th>
							<th>Tipo Conten</th>
							<th>NIPLA</th>
							<th>Estado</th>
						</thead>
						<tbody id="contenedor_parcelas">
							<?php
							while ($arr = $result->fetch_assoc()) {
								?>
								<tr>
									<td><?=$arr['codigo']?></td>
									<td><?=$arr['contenedor']?></td>
									<td><?=$arr['nipla']?></td>
									<td><?=$arr['estado']?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
				
			</div>
			<div class="row">
				<div class="col s12">
					<h5>Resumen componentes</h5>
					<table id="listado_no_dataTable" >
						<thead>
							<th>Componente</th>
							<th>Decripcion</th>
							<th>Cantidad</th>
							<th>Unidad</th>
						</thead>
						<tbody>
							<?php
							$query = "select
							sum(aplicacion_cantidad.cantidad) as cantidad,
							app_componente.nombre,
							app_componente.descripcion
							from aplicacion_instalacion
							inner join aplicacion_cantidad on aplicacion_cantidad.id_aplicacion = aplicacion_instalacion.id_aplicacion
							inner join app_componente on app_componente.id = aplicacion_cantidad.componente
							where aplicacion_instalacion.id_instalacion = '$id'
							group by app_componente.nombre ";
							$result = $mysqli->query($query);
							while ($arr = $result->fetch_assoc()) {
								?>
								<tr>
									<td><?=$arr['nombre']?></td>
									<td><?=$arr['descripcion']?></td>
									<td class="numero"><?=number_format($arr['cantidad'])?></td>
									<td>GR</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<h5>Historial Aplicaciones</h5>
				
					<?php
					$query = "select id_aplicacion from aplicacion_instalacion where id_instalacion='$id' order by id_aplicacion";
					$result = $mysqli->query($query);
					while ($arr = $result->fetch_assoc()) {
						$query = "select
							aplicacion.id,
							aplicacion.fecha,
							app_instalador.nombre as instalador,									
							producto.nombre as producto,
							app_medio_aplicacion.nombre as medio,
							app_categoria_aplicacion.nombre as categoria
							from aplicacion 
							inner join app_instalador on app_instalador.id = aplicacion.encargado
							inner join app_medio_aplicacion on app_medio_aplicacion.id = aplicacion.medio
							inner join app_categoria_aplicacion on app_categoria_aplicacion.id = aplicacion.categoria 
							inner join producto on producto.id = aplicacion.producto
							where aplicacion.id='$arr[id_aplicacion]' order by aplicacion.categoria, aplicacion.fecha desc";
							
						$res1 = $mysqli->query($query);
						$app = $res1->fetch_assoc();

						$query = "select app_componente.nombre as componente, app_componente.descripcion, aplicacion_cantidad.cantidad from aplicacion_cantidad inner join app_componente on app_componente.id = aplicacion_cantidad.componente where aplicacion_cantidad.id_aplicacion = '$app[id]'";
						$res = $mysqli->query($query);
						?>
						<div class="aplicacion_historial">
							

							<div class="col s12 m6">
								<div class="col s6">
									<label for="">Fecha Aplicacion</label>
									<span class="dato"><?=cambiarFormatoFecha($app['fecha'])?></span>
								</div>
								<div class="col s6">
									<label for="">Encargado</label>
									<span class="dato"><?=$app['instalador']?></span>
								</div>
								<div class="col s6">
									<label for="">Medio</label>
									<span class="dato"><?=$app['medio']?></span>
								</div>
								<div class="col s6">
									<label for="">Categoria</label>
									<span class="dato"><?=$app['categoria']?></span>
								</div>
								<div class="col s8">
									<label for="">Producto</label>
									<span class="dato"><?=$app['producto']?></span>
								</div>
								<div class="col s4">
									<label for="">Ver Detalle</label>
									<span class="dato"><a href="http://telios.cl/quivolgo/aplicaciones/detalle.php?id=<?=$app['id']?>">Ver Detalle Aplicacion</a></span>
								</div>
								
							
							</div>
							<div class="col s12 m6">
								<div class="col s12" style="margin-bottom: 20px;">
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
							
						</div>


						<?php				
					}

					?>
				</div>
			</div>
			<div class="row">
				<div class="col s12" style="margin-top: 50px;">					
					<a href="Javascript:window.history.back();" class="btn red left">Volver</a>					
				</div>
			</div>
		</div>
	</div>



<?php
print_footer();
?>