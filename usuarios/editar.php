<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

if(isset($_SESSION['id'])){
	$objeto = getObjetoByNombre('USUARIOS', $mysqli);
	$pUser = getPermisosObjeto($_SESSION['id'], $objeto['id'], $mysqli);
	/* 1: CREATE 2: READ 3: UPDATE 4: DELETE */
}
else{
	header("Location: /quivolgo/index.php");
}

if(!in_array("3", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/usuarios/index.php";
	header("location: /quivolgo/error/index.php");
}
print_head();
print_menu();
extract($_GET);

$titulo ="Editar Usuario";
$user = getUserById($id, $mysqli);

$objetos 	= getObjeto("objeto", $mysqli);
$permisos	= getObjeto("permiso", $mysqli);
$permisos_usuario = getPermisos($user['id'], $mysqli);

$arr_obj 	= array();
$arr_perm	= array();

while($row = $objetos->fetch_assoc()) {
        array_push($arr_obj, $row);
}
while($row = $permisos->fetch_assoc()) {
        array_push($arr_perm, $row);
}
?>

<div class="container_form">
	<form action="forms/edit.php" method="post">
		<div class="row">
			<h3 class="center"><?=$titulo?></h3>
			<div class="col s12">
				<label for="">Nombre</label>
				<input type="text" name="nombre" value="<?=$user['nombre']?>">
			</div>
			<div class="col s3">
				<label for="">Correo</label>
				<input type="email" name="correo" value="<?=$user['correo']?>">
			</div>
			<div class="col s3">
				<label for="">Contraseña</label>
				<input type="text" name="pass" value="<?=$user['pass']?>">
			</div>
		

			<div class="col s12">
				<h5>Permisos De Usuario</h5>
			</div>
			<div id="selects">
				<?php
					foreach ($permisos_usuario as $objeto) {
						?>
					<div class="col s12" style="margin-bottom: 20px;">
						<h6><?=$objeto['nombre']?></h6>
							<?php
							foreach ($arr_perm as $permiso) {
								if(in_array($permiso['id'], $objeto['permisos'])){
								?>
							<div class="col s2">
								<input type="checkbox" name="permiso[]" value="<?=$objeto['id']?>_<?=$permiso['id']?>" id="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>" checked="true"><label for="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><?=$permiso['nombre']?></label>
							</div>
							<?php
								}
								else{
									?>
							<div class="col s2">
								<input type="checkbox" name="permiso[]" value="<?=$objeto['id']?>_<?=$permiso['id']?>" id="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><label for="<?=$objeto['nombre']?>_<?=$permiso['nombre']?>"><?=$permiso['nombre']?></label>
							</div>
							<?php
								}
							}					
							?>
						</div>
						<?php
					}
				?>
				
				<div class="col s2">
					<a href="#" onclick="checkAll('CREATE')" class="btn" style="width: 100%; margin-bottom: 5px; ">check</a>
					<a href="#" onclick="unCheckAll('CREATE')" class="btn" style="width: 100%; margin-bottom: 5px; ">unCheck</a>
				</div>
				<div class="col s2">
					<a href="#" onclick="checkAll('DELETE')" class="btn" style="width: 100%; margin-bottom: 5px; ">check</a>
					<a href="#" onclick="unCheckAll('DELETE')" class="btn" style="width: 100%; margin-bottom: 5px; ">unCheck</a>
				</div>
				<div class="col s2">
					<a href="#" onclick="checkAll('DETAIL')" class="btn" style="width: 100%; margin-bottom: 5px; ">check</a>
					<a href="#" onclick="unCheckAll('DETAIL')" class="btn" style="width: 100%; margin-bottom: 5px; ">unCheck</a>
				</div>
				<div class="col s2">
					<a href="#" onclick="checkAll('READ')" class="btn" style="width: 100%; margin-bottom: 5px; ">check</a>
					<a href="#" onclick="unCheckAll('READ')" class="btn" style="width: 100%; margin-bottom: 5px; ">unCheck</a>
				</div>
				
				<div class="col s2">
					<a href="#" onclick="checkAll('UPDATE')" class="btn" style="width: 100%; margin-bottom: 5px; ">check</a>
					<a href="#" onclick="unCheckAll('UPDATE')" class="btn" style="width: 100%; margin-bottom: 5px; ">unCheck</a>
				</div>
			</div>
		
			<div class="col s12" style="margin-top: 50px;">
				<input type="hidden" name="id" value="<?=$user['id']?>">
				<a href="Javascript:window.history.back();" class="btn red left">Cancelar</a>
				<input type="submit" value="Guardar" class="btn btn_sys right">
			</div>
		</div>
	</form>
	
	<script>
		function checkAll(tipo){
			$("#selects").find($("[id*='"+tipo+"']")).each(function(index,element){
				$(element).prop('checked', true);
			});
		}
		function unCheckAll(tipo){
			$("#selects").find($("[id*='"+tipo+"']")).each(function(index,element){
				$(element).prop('checked', false);
			});	
		}
	</script>
</div>