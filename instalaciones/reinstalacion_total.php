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

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/instalaciones/index.php";
	header("location: /quivolgo/error/index.php");
}


print_head();
print_menu();



$titulo = "Reubicacion Total de Instalacion";

?>

<div class="container_form">
	<form action="forms/reubicacion_total.php" method="post">
		<div class="row" id="form_instalacion">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				<h5 class="center">Datos Instalacion</h5>

				<div class="col s4">
					<label for="">Cod. Instalacion</label>
					<input type="text" name="cod_instalacion" id="cod_instalacion" onchange="setDatosInstalacion(this.value)">
				</div>
				<div class="col s4">
					<label for="">Fecha Reubicacion</label>
					<input type="date" name="fecha" value="<?=$HOY?>">
				</div>
				<div class="col s4">
					<label for="">Instalador</label>
					<select name="instalador" id="">
						<?=show_option("app_instalador", "", $mysqli)?>
					</select>
				</div>

				<div class="col s3">
					<label for="">Cod. Madre</label>
					<span class="dato" id="cod_madre"></span>
					
				</div>
				<div class="col s3">
					<label for="">Cod M. Genetico</label>
					<span class="dato" id="cod_mat_gen"></span>
					
					
				</div>
				<div class="col s3">
					<label for="">Especie</label>
					<span class="dato" id="especie"></span>
				</div>

				<div class="col s3">
					<label for="">Origen Genetico: </label>
					<span class="dato" id="origen_genetico"></span>
				</div>

				<div class="col s4">
					<label for="">Sector Actual</label>
					<span class="dato" id="sector"></span>
				</div>
				<div class="col s4">
					<label for="">Nave Actual </label>
					<span class="dato" id="nave"></span>
				</div>
				<div class="col s4">
					<label for="">Meson Actual </label>
					<span class="dato" id="meson"></span>
				</div>
			</div>
			<div class="row">
				<h5 class="center">Nueva Ubicacion</h5>

				<div class="col s4">
					<label for="">Codigo Sector </label>
					<select name="sector" id="">
						<?=show_option("app_sector", "", $mysqli)?>
					</select>
				</div>

				<div class="col s4">
					<label for="">Nave</label>
					<select name="nave" id="">
						<?=show_option("app_nave", "", $mysqli)?>
					</select>
				</div>
				<div class="col s4">
					<label for="">Meson</label>
					<input type="number" name="meson" >				
				</div>
				
				
				
			</div>

			
		
			<div class="col s12" style="margin-top: 50px;">
				<input type="hidden" name="parcelas_creadas" id="parcelas_creadas" value="">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
</div>

<script>
	

</script>

<?php
print_footer();
?>