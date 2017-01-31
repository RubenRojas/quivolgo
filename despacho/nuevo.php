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

$inventario = select("inventario", array("id"), array("estado"=>"2"), array("order by"=> "id desc", "limit"=>"1"), $mysqli);

print_head();
print_menu();

?>
<div class="container">
	<h3 class="center">Nuevo Requerimiento de Despacho</h3>
	<div class="row">
		<form action="forms/ingresar_solicitud.php" method="post">
			<div class="col s12">
				<div class="col s4">
					<label for="">Fecha</label>
					<input type="date" name="fecha_ingreso" value="<?=$HOY?>">
				</div>
				<div class="col s4">
					<label for="">Encargado</label>
					<select name="encargado" id="">
						<?=show_option("app_instalador", "", $mysqli)?>
					</select>
				</div>
				<div class="col s4">
					<label for="">Predio</label>
					<select name="predio" id="">
						<?=show_option("app_predio", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Especie</label>
					<select name="especie" id="">
						<?=show_option("app_especie", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Bandeja</label>
					<select name="tipo_contenedor" id="">
						<?=show_option("app_contenedor", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Cantidad Plantas</label>
					<input type="number" name="total_plantas">
				</div>
				<div class="col s3">
					<label for="">Rango de Planta</label>
					<select name="rango" id="">
						<?=show_option_campos("inventario_rango", "", array("id, nombre") , array("id_inventario"=>$inventario['id']), array("order by"=>"id"), $mysqli)?>
					</select>
				</div>
			</div>

			<div class="col s12">
				<div class="col s4">
					<label for="">Cod. Mat. Gen</label>
					<select multiple name="cod_mat_gen[]" id="cod_mat_gen">
				      <?=show_option_multiple("cod_mat_gen", $cod_mat_gen , $mysqli, "Seleccione")?>
				    </select>				
				</div>
				<div class="col s8">
					<label for="">Material Genetico Seleccionado</label>
					<div id="listado_cod_mat"></div>
					
				</div>
			</div>
			<div class="col s12" style="margin-top: 50px;">
					
					<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
					<input type="submit" value="Siguiente" class="btn right">
				</div>
		</form>

	</div>
</div>
<script>
	var indice = 0;

	$("#cod_mat_gen").change(function(event) {
		var listado = "";
		$('#cod_mat_gen :selected').each(function(i, selected){ 
		  var texto = $(selected).text();
		  var append = '<span class="cod_mat_gen_append" id="cmg_'+indice+'" data-cmg="'+texto+'">'+texto+'<i class="fa fa-trash" aria-hidden="true" onclick="removeCMG(\'cmg_'+indice+'\')"></i></span>';
		  indice++;
		  listado+=append;
		});
		$("#listado_cod_mat").html("");
		$("#listado_cod_mat").append(listado);
	});


	function removeCMG(id){
		var cmg = $("#"+id).data('cmg');
		$("#"+id).remove();

		$('#cod_mat_gen :selected').each(function(i, selected){ 
			if($(selected).text() == cmg){
				$(selected).removeProp('selected');
				$(selected).removeAttr('selected');
				$('select').material_select('destroy');
				$('select').material_select();
			}
		});
	}
</script>

<?php
print_footer();
?>