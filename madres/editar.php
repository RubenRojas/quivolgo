<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('OPCIONES', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1: CREATE 2: READ 3: UPDATE 4: DELETE */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("3", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/app_contendor/index.php";
	header("location: /quivolgo/error/index.php");
}
print_head();
print_menu();
extract($_GET);

$titulo ="Editar Madre";

$query = "select * from madre  where id='$id' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();

$nId = $arr['id'];
if($nId<10){
	$nId = "0".$nId;
}
?>
<script>
	var nId = "<?=$nId?>";
</script>

<div class="container_form">
	<form action="forms/edit.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<div class="col s3">
				<label for="">Cod. Material Gen.</label>
				<select name="id_cod_mat_gen" id="id_cod_mat_gen" onchange="setCodigo()">
				<?=show_option("cod_mat_gen", $arr['id_cod_mat_gen'], $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Codigo Madre</label>
				<input type="text" name="cod_desc" value="<?=$arr['cod_desc']?>" id="cod_desc">
			</div>
			<div class="col s3">
				<label for="">Campo Origen</label>
				<select name="campo_origen" id="campo_origen" onchange="setCodigo()">
					<?=show_option("app_campo_origen", $arr['campo_origen'], $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Año Plantacion</label>
				<input type="number" name="fecha_plantacion" id="anio" onchange="setCodigo()" value="<?=$arr['fecha_plantacion']?>">
			</div>
			<div class="col s3">
				<label for="">Origen Genetico</label>
				<select name="origen_genetico" id="">
					<?=show_option("app_origen_genetico", $arr['origen_genetico'], $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Tipo Propagación</label>
				<select name="tipo_propagacion" id="">
					<?=show_option("app_propagacion", $arr['tipo_propagacion'], $mysqli)?>
				</select>
			</div>

			
		
			<div class="col s12" style="margin-top: 50px;">
				<input type="hidden" name="id" value="<?=$arr['id']?>">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
</div>

<script>
	function setCodigo(){
		var $sel = $("#id_cod_mat_gen");
		var value = $sel.val();
		var cod_mat_gen = $("option:selected",$sel).text(); 

		var $sel = $("#campo_origen");
		var value = $sel.val();
		var campo_origen = $("option:selected",$sel).text(); 

		var anio = $("#anio").val();




		$("#cod_desc").val(cod_mat_gen + "-"+campo_origen+"-"+anio);
	}
</script>
<?php
print_footer();
?>