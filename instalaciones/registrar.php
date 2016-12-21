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

$query  = "select max(id) as max from instalacion ";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$nId = $arr['max'] + 1;
if($nId<10){
	$nId = "0".$nId;
}

print_head();
print_menu();



$titulo = "Registrar Instalacion";

?>
<script>
	var nId = "<?=$nId?>";
</script>
<div class="container_form">
	<form action="forms/insert.php" method="post">
		<div class="row" id="form_instalacion">
			<h3 class="center"><?=$titulo?></h3>

			<div class="row">
				<h5 class="center">Datos Instalacion</h5>

				<div class="col s3">
					<label for="">Cod. Instalacion</label>
					<input type="text" name="cod_instalacion" id="cod_instalacion" value="">
				</div>
				<div class="col s3">
					<label for="">Fecha</label>
					<input type="date" name="fecha" value="<?=$HOY?>">
				</div>
				<div class="col s3">
					<label for="">Cod M. Genetico</label>
					<select name="cod_mat_gen" id="" onchange="get_data_madre(this.value)">
						<?=show_option("cod_mat_gen", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Especie</label>
					<input type="text" id="especie" disabled="disabled">
				</div>
				<div class="col s3">
					<label for="">Cod. Madre</label>
					<input type="text" id="cod_madre" disabled="disabled">
					<input type="hidden" name="madre" id="cod_madre_2">
				</div>

				<div class="col s3">
					<label for="">Estado</label>
					<select name="estado" id="">
						<?=show_option("app_estado", "", $mysqli)?>
					</select>
				</div>

				<div class="col s12">
					<div class="col s3">
						<label for="">Origen Genetico: </label>
						<span class="info" id="origen_genetico"></span>
					</div>
					<div class="col s3">
						<label for="">Tipo Propagacion: </label>
						<span class="info" id="tipo_propagacion"></span>
					</div>
					<div class="col s3">
						<label for="">Campo Origen: </label>
						<span class="info" id="campo_origen"></span>
					</div>
					<div class="col s3">
						<label for="">Fecha Madre: </label>
						<span class="info" id="fecha_plantacion"></span>
					</div>
					
				</div>


			</div>
			<div class="row">
				<h5 class="center">Ubicacion y Cantidades</h5>

				<div class="col s3">
					<label for="">Codigo Sector </label>
					<select name="sector" id="">
						<?=show_option("app_sector", "", $mysqli)?>
					</select>
				</div>

				<div class="col s3">
					<label for="">Nave</label>
					<select name="nave" id="">
						<?=show_option("app_nave", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Meson</label>
					<input type="number" name="meson" >
				
				</div>
				<div class="col s3">
					<label for="">Contendor</label>
					<select name="tipo_contenedor" id="tipo_contenedor" onchange="set_capacidad_contendor(this.value)">
						<?=show_option("app_contenedor", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Cap. Contenedor</label>
					<input type="text" id="cap_contenedor" disabled="disabled">
					<input type="hidden" name="cap_contenedor" id="cap_contenedor_2">
				</div>
				<div class="col s3">
					<label for="">N° Contenedores</label>
					<input type="text" id="n_contenedores" name="n_contenedores" onchange="setNipla();" >
				</div>
				<div class="col s3">
					<label for="">NIPLA</label>
					<input type="text" id="NIPLA" name="nipla" >
				</div>
				<div class="col s3">
					<label for="">Temporada</label>
					<select name="temporada" id="">
						<?=show_option("app_temporada", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Instalador</label>
					<select name="instalador" id="">
						<?=show_option("app_instalador", "", $mysqli)?>
					</select>
				</div>
				
			</div>

			<div class="row">
				<h5 class="center">Parcelas</h5>
				<div class="col s12">
					
					<div class="col s8">
						<a href="Javascript:crearParcelas();" class="btn">Agregar Parcela</a>
					</div>
				</div>
				<div class="col s12">
					<table id="listado_no_dataTable" >
						<thead>
							<th>Cod. Parcela</th>
							<th>Tipo Conten</th>
							<th>NIPLA</th>
							<th>Estado</th>
							<th>Borrar</th>
						</thead>
						<tbody id="contenedor_parcelas"></tbody>
					</table>
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
	jQuery(document).ready(function($) {
		$("#cod_instalacion").val("IN<?=date('Y')?>"+nId);
	});
	var parcelas_creadas = 0;
	function setNipla(){
		var cant_cont = parseInt($("#n_contenedores").val());
		var cap_cont = parseInt($("#cap_contenedor_2").val())
		$("#NIPLA").val( cap_cont * cant_cont);
	}  
	function crearParcelas(){
		var $sel = $("#tipo_contenedor");
		var value = $sel.val();
		var Contenedor = $("option:selected",$sel).text(); 
		var NIPLA = $("#cap_contenedor").val();
		var n_parcelas = 1;
		var p_creadas_tmp = parcelas_creadas;

		if(Contenedor == ""){
			swal("Error", "Debe seleccionar un tipo de contenedor", "error");
		}
		else{
			if(n_parcelas==""){
				swal("Error", "Debe ingresar un número de parcelas a crear.", "error");	
			}
			else{
				for(var i=(p_creadas_tmp+1); i<=(parseInt(p_creadas_tmp)+ parseInt(n_parcelas));i++){
					if(i<10){
						var idParcela = "PA0"+i+"IN"+nId;
					}
					else{
						var idParcela = "PA"+i+"IN"+nId;
					}
					parcelas_creadas++;
					
					var row = '<tr id="'+idParcela+'" class="hoverable">'+
					'<td class="center">'+idParcela+'</td>'+
					'<td class="center">'+Contenedor+'</td>'+
					'<td class="center">'+NIPLA+'</td>'+
					'<td class="center">ACTIVO</td>'+
					'<td class="center"><i class="fa fa-trash-o" aria-hidden="true" onclick="remove_row(\''+idParcela+'\')"></i></td>'+
					'</td>'+
					'<input type="hidden" name="parcela_'+i+'" value="'+idParcela+'"';
					$("#contenedor_parcelas").append(row);

				}
			}
		}
		$("#parcelas_creadas").val(parcelas_creadas);


		
		
	}
	function remove_row(id){
		$("#"+id).remove();
	}


</script>

<?php
print_footer();
?>