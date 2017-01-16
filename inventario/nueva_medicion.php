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

if(!in_array("1", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/inventario/index.php";
	header("location: /quivolgo/error/index.php");
}

$query = "select valor from app_parametro where nombre ='PORCENTAJE_MEDICION' limit 1 ";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$PORCENTAJE_MEDICION = $arr['valor'];

print_head();
print_menu();
?>
<script>
	var PORCENTAJE_MEDICION = <?=$PORCENTAJE_MEDICION?>;
</script>
<?php


$titulo = "Nueva Medicion";
$query = "select id from inventario where estado='1' order by id limit 1";
$result = $mysqli->query($query);
if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$id_inventario = $arr['id'];
	?>
	<div class="container_form">
		<form action="forms/insert_medicion.php" method="post">
			<div class="row">
				<h3 class="center"><?=$titulo?></h3>
				<div class="col s3">
					<label for="">Fecha Medicion</label>
					<input type="date" name="fecha" value="<?=$HOY?>">
				</div>
				<div class="col s3">
					<label for="">Instalador</label>
					<select name="instalador" id="enargado" >
						<?=show_option("app_instalador", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">COD Parcela</label>
					<input type="text" name="cod_parcela" onchange="show_datos_instalacion(this.value)">
				</div>
				<div class="col s3">
					<label for="">NIPLA Parcela</label>
					<input type="text" name="nipla" id="nipla" >
				</div>
				
				<div class="col s12 datos_medicion">
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
						<input type="number" name="plantas_vivas" onchange="setPlantasMuertas(this.value)">
					</div>
					<div class="col s3">
						<label for="">Plantas Muertas</label>
						<input type="number" name="plantas_muertas" id="plantas_muertas">
					</div>
					<div class="col s12">
						<label for="">Observacion</label>
						<input type="text" name="observacion">
					</div>
				</div>
					
				<div class="col s12">
					<h5>Ingreso de Medidas</h5>
					<div class="col s6">
						<div class="col s12">
							<label for="">Altura (CM)</label>
							<input type="text" id="altura">
						</div>
						<div class="col s1">
							<a href="Javascript:addAltura()"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 2em; color: green; line-height: 3; "></i></a>
						</div>
					</div>
					<div class="col s6">

						<div class="col s12">
							<p><span id="restantes"></span> mediciones restantes.</p>
							<table>
								<thead>
									<th>Altura (CM)</th>
									<th>Quitar</th>
								</thead>
								<tbody id="listado_alturas"></tbody>
							</table>
						</div>
					</div>
				</div>

				
				

				
			
				<div class="col s12" style="margin-top: 50px;">
					<input type="hidden" name="hora_inicio" id="hora_inicio">
					<input type="hidden" name="registrados" id="registrados">
					<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
					<div id="guardar"></div>
				</div>
			</div>
		</form>
		
	</div>
<?php

}
else{
?>
<div class="container_form">

			<div class="row">
				<h3 class="center"><?=$titulo?></h3>
				<div class="col s12"><h5 class="center">No existe un inventario abierto, por lo que no se pueden registrar mediciones.</h5></div>
				<div class="col s12" style="margin-top: 50px;">
					
					<a href="Javascript:window.history.back();" class="btn red left">Volver</a>
					
				</div>
			</div>
	
		
	</div>
<?php
}

?>

<script>
	var registrados = 0;
	var por_registrar = 0;
	jQuery(document).ready(function($) {
		var d = new Date();
		var hrs = d.getHours();
		var min = d.getMinutes();
		if(min < 10){
			min = "0"+min;
		}

		$("#hora_inicio").val(hrs+":"+min);
		$(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
		  });
	});

	function setPlantasMuertas(val){
		var nipla = $("#nipla").val();
		$("#plantas_muertas").val(nipla - val);
		por_registrar = parseInt((PORCENTAJE_MEDICION /100) * val);
		
		$("#restantes").html(por_registrar);
	}

	$("#altura").keydown(function(event){
	    if(event.keyCode == 13) {
	    	registrados++;
	    	var alturaPlanta = $(this).val();
	      	event.preventDefault();
	      	if(alturaPlanta != ""){
	      		var fila = '<tr id="fila_altura_'+registrados+'">'+
		      	'<td>'+alturaPlanta+'</td>'+
		      	'<td><a href="Javascript:quitarFila(\''+registrados+'\')">Quitar</a></td>'+
		      	'<input type="hidden" name="altura_'+registrados+'" value="'+alturaPlanta+'"> />'+
		      	'</tr>';
		      	por_registrar--;
		      	$("#restantes").html(por_registrar);
		      	$("#listado_alturas").append(fila);
		      	$(this).val("");
		      	$(this).focus();
		      	$("#registrados").val(registrados);
	      	}
	      	if(por_registrar <= 0){
	      		$("#guardar").html('<input type="submit" value="Guardar" class="btn btn_sys right">');
	      	}
	      	return false;
	    }
	  });

	function addAltura(){
		var alturaPlanta = $("#altura").val();
	    registrados++;
      	if(alturaPlanta != ""){
      		var fila = '<tr id="fila_altura_'+registrados+'">'+
	      	'<td>'+alturaPlanta+'</td>'+
	      	'<td><a href="Javascript:quitarFila(\''+registrados+'\')">Quitar</a></td>'+
	      	'<input type="hidden" name="altura_'+registrados+'" value="'+alturaPlanta+'"> />'+
	      	'</tr>';
	      	por_registrar--;
	      	$("#restantes").html(por_registrar);
	      	$("#listado_alturas").append(fila);
	      	$("#altura").val("");
	      	$("#altura").focus();
	      	$("#registrados").val(registrados);
      	}
      	if(por_registrar <= 0){
      		$("#guardar").html('<input type="submit" value="Guardar" class="btn btn_sys right">');
      	}
      	else{
      		$("#guardar").html("");	
      	}
	}
	function quitarFila(id){
		$("#fila_altura_"+id).remove();
		por_registrar++;
		$("#restantes").html(por_registrar);
		if(por_registrar <= 0){
      		$("#guardar").html('<input type="submit" value="Guardar" class="btn btn_sys right">');
      	}
      	else{
      		$("#guardar").html("");	
      	}
	}
</script>


<?php
print_footer();
?>