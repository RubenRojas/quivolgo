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
	/* 1:CREATE, 2:READ, 3:UPDATE,  4:DELETE, 5:DETAIL */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/app_contendor/index.php";
	header("location: /quivolgo/error/index.php");
}

$query  = "select max(id) as max from madre ";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$nId = $arr['max'] + 1;
if($nId<10){
	$nId = "0".$nId;
}


print_head();
print_menu();



$titulo = "Nueva Madre";

?>
<script>
	var nId = "<?=$nId?>";
</script>
<div class="container_form">
	<form action="forms/insert.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<div class="col s3">
				<label for="">Cod. Material Gen.</label>
				<select name="id_cod_mat_gen" id="id_cod_mat_gen" onchange="setCodigo(this)">
					<?=show_option("cod_mat_gen", "", $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Codigo Madre</label>
				<input type="text" name="cod_desc" id="cod_desc">
			</div>
			<div class="col s3">
				<label for="">Campo Origen</label>
				<select name="campo_origen" id="">
					<?=show_option("app_campo_origen", "", $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Fecha Plantacion</label>
				<input type="date" name="fecha_plantacion">
			</div>
			<div class="col s3">
				<label for="">Origen Genetico</label>
				<select name="origen_genetico" id="">
					<?=show_option("app_origen_genetico", "", $mysqli)?>
				</select>
			</div>
			<div class="col s3">
				<label for="">Tipo Propagación</label>
				<select name="tipo_propagacion" id="">
					<?=show_option("app_propagacion", "", $mysqli)?>
				</select>
			</div>

			
		
			<div class="col s12" style="margin-top: 50px;">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
</div>

<script>
	function setCodigo(select){
		var $sel = $(select);
		var value = $sel.val();
		var text = $("option:selected",$sel).text(); 
		$("#cod_desc").val("M"+nId+text);
	}
</script>

<?php
print_footer();
?>