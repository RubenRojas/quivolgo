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

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/productos/index.php";
	header("location: /quivolgo/error/index.php");
}

$query  = "select max(id) as max from instalacion ";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$nId = $arr['max'] + 1;
if($nId<10){
	$nId = "0".$nId;
}

print_head();
print_menu();



$titulo = "Registrar Producto";

?>
<script>
	var nId = "<?=$nId?>";
</script>
<div class="container_form">
	<form action="forms/insert.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				

				<div class="col s6">
					<label for="">Nombre Producto</label>
					<input type="text" name="nombre" id="nombre" value="">
				</div>
				<div class="col s3">
					<label for="">Categoría</label>
					<select name="categoria" id="">
						<?=show_option("app_categoria_aplicacion", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Estado</label>
					<select name="estado" id="">
						<?=show_option("app_estado", "1", $mysqli)?>
					</select>
				</div>
								
				</div>
		</div>

		<div class="row">
			<h5 class="center">Componentes</h5>
			<div class="col s12">
				<?php
				for ($i=1; $i <= 10; $i++) { 
					?>
					<div class="col s5" style="border: 1px solid #dcdcdc; margin-bottom: 5px; margin-left: 5px; padding: 15px 5px 5px 5px;">
						<div class="col s6">
							<label for="">Componente</label>
							<select name="componente_<?=$i?>" id="">
								<?=show_option("app_componente", "", $mysqli)?>
							</select>
						</div>
						<div class="col s6">
							<label for="">Unidad</label>
							<select name="unidad_<?=$i?>" id="">
								<?=show_option_campos("app_unidad", "", array("nombre, nombre"), array(), array("order by"=>"nombre asc"), $mysqli)?>
							</select>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>

			
			
			
		
		<div class="col s12" style="margin-top: 50px;">
			<input type="hidden" name="parcelas_creadas" id="parcelas_creadas" value="">
			<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
			<input type="submit" value="Guardar" class="btn btn_sys right">
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