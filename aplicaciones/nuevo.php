<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('APLICACIONES', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1:CREATE, 2:READ, 3:UPDATE,  4:DELETE, 5:DETAIL */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/aplicaciones/index.php";
	header("location: /quivolgo/error/index.php");
}



print_head();
print_menu();




?>
<div class="container">
	<h3 class="center">Nueva Aplicacion</h3>
	
	<form action="forms/insert.php" method="post" id="form">
		<div class="row">
			<div class="col s12">
				<div class="col s3">
					<label for="">Fecha</label>
					<input type="date" name="fecha" value="<?=$HOY?>">
				</div>
				<div class="col s3">
					<label for="">Encargado</label>
					<select name="encargado" id="">
						<?=show_option("app_instalador", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Medio</label>
					<select name="medio" id="medio">
						<?=show_option("app_medio_aplicacion", "", $mysqli)?>
					</select>
				</div>
				<div class="col s3">
					<label for="">Categoria</label>
					<select name="categoria" id="categoria" onchange="setSelectProducto(this.value)">
						<?=show_option("app_categoria_aplicacion", "", $mysqli)?>
					</select>
				</div>
			</div>
			<div class="col s12" style="margin-bottom: 52px; ">
				<div class="col s4">
					<label for="">Producto a Aplicar</label>
					<select name="producto" id="producto" onchange="setComponentes(this.value)">						
					</select>
				</div>
				<div class="col s8">
					<label for="">Componentes</label>
					<div id="componentes"></div>
				</div>
			</div>
			<hr style="margin-bottom: 40px; margin-left: 20px; margin-right: 20px; ">
			<div class="col s12">
				<div class="col s4">
					<label for="">Sector</label>
					<select name="sector" id="sector">
						<?=show_option("app_sector", "", $mysqli)?>
					</select>
				</div>
			</div>
			<div class="col s12">
				<div class="col s4">
					<label for="">Nave</label>
					<select name="nave" id="nave" onchange="showMesones()">
						<?=show_option("app_nave", "", $mysqli)?>
					</select>
				</div>
			</div>
			<div class="col s12">
				<div id="mesones"></div>
			</div>
			<div class="col s12">
				<a href="Javascript:selectAll()" class="btn teal"  style="margin-top: 20px;margin-bottom: 25px;">Seleccionar Todos</a>
				<a href="Javascript:addMesones()" class="btn blue" style="margin-top: 20px;margin-bottom: 25px; ">Agregar</a>
			</div>
			<hr style="margin-bottom: 40px; margin-left: 20px; margin-right: 20px; ">
			<div class="col s12">
				<div id="agregados">
					

				</div>
			</div>


		</div>
		
		<a href="Javascript:sendForm()" class="btn green">Confimar Aplicacion</a>
		<script>
			function sendForm(){
				swal({
			  title: "¿Estás Seguro?",
			  text: "Se agregará una aplicación según los valores específicados.",
			  type: "info",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Si, agregar",
			  closeOnConfirm: false
			},
			function(){
			  $("#form").submit();
			});	
			}
			
		</script>
		
	</form>
	
</div>
<script>
	$('#sector').change(function(){
	    $('#nave').val("");
	    $("#mesones").html("");
	});
	var flag = 1;


	function selectAll(){
		$("#mesones").find("input[type=checkbox]").each(function(index, element){
			if(flag > 0){
				$(element).prop("checked", true);
			}
			else{
				$(element).prop("checked", false);
			}

		});
		flag = flag * (-1);
	}
	function deleteElement(id){
		$("#elemento_"+id).remove();
	}
	var n_agregados = 0;
	

	function is_agregado(val){
		var res = false;
		console.log($("#agregados").find("#"+val));
		$("#agregados").find("#elemento_"+val).each(function(index, el) {
			if($(el).attr('id')=="elemento_"+val){
				res = true;
			}
		});
		return res;
	}
	function addMesones(){
		console.log("addMesones");
		$("#mesones").find("input[type=checkbox]").each(function(index, element){
			if($(element).prop("checked")==true){
				var nave = $(element).data("nave");
				var val = nave+"_"+$(element).val();
				var valido = is_agregado(val);
				var agregados = $("#agregados").find("div").length;
				var item = ''+
				'<div class="col s2" id="elemento_'+val+'">'+
					'<input type="text"  value="'+val.toUpperCase()+'" disabled>'+
					'<input type="hidden" name="'+val+'"  value="selected">'+
					'<span onclick="deleteElement(\''+val+'\')">'+
						'<i class="fa fa-trash-o" aria-hidden="true"></i>'+
					'</span>'+
				'</div>';
				if($('#'+nave).length > 0){
					if(valido==false){
						$('#'+nave).append(item);	
					}
				}
				else{
					$("#agregados").append('<div id="'+nave+'" class="col s12"><div class="col s12"><label for="">'+nave+'</label></div>');
					if(valido==false){
						$('#'+nave).append(item);	
					}
				}

				

				
			}

		});
	}
</script>
<?php
print_footer();
?>
