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

$query = "select * from producto where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

print_head();
print_menu();



$titulo = "Detalle Producto";

?>

<div class="container_form">
	<form action="forms/update.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				

				<div class="col s6">
					<label for="">Nombre Producto</label>
					<span class="dato">
						<?=$arr['nombre']?>
					</span>
					
				</div>
				<div class="col s3">
					<label for="">Categoría</label>
					<span class="dato">
						<?=get_campo("app_categoria_aplicacion", "nombre", $arr['categoria'], $mysqli)?>
					</span>
				</div>
				<div class="col s3">
					<label for="">Estado</label>
					<span class="dato">
						<?=get_campo("app_estado", "nombre", $arr['estado'], $mysqli)?>
					</span>
					
				</div>
								
				</div>
		</div>

		<div class="row">
			<h5 class="center">Componentes</h5>
			<div class="col s12">
				<?php
				$query = "select * from producto_componente where id_producto='$id'";
				$j= 1;
				$res = $mysqli->query($query);
				while ($arr2 = $res->fetch_assoc()) {
					?>
					<div class="col s5" style="border: 1px solid #dcdcdc; margin-bottom: 5px; margin-left: 5px; padding: 15px 5px 5px 5px;">
						<div class="col s6">
							<label for="">Componente</label>
							<span class="dato">
								<?=get_campo("app_componente", "nombre", $arr2['id_componente'], $mysqli)?>
							</span>
							
						</div>
						<div class="col s6">
							<label for="">Unidad</label>
							<span class="dato">
								<?=$arr2['unidad']?>
							</span>
							
						</div>
					</div>
					<?php
					$j++;
				}
				
				?>
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