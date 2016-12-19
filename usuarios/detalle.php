<?php
if(is_dir("/home4/alvarube/public_html/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/quivolgo/includes/";
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

if(!in_array("2", $pUser)){
	$_SESSION['error']['mensaje'] = "No estás autorizado a acceder a esta pagina";
	$_SESSION['error']['location'] = "/quivolgo/index.php";
	header("location: /quivolgo/error/index.php");
}
print_head();
print_menu();
extract($_GET);

$user = getUserById($id, $mysqli);
$perm = getPermisos($user['id'], $mysqli);

$permisos	= getObjeto("permiso", $mysqli);
$arr_perm	= array();
while($row = $permisos->fetch_assoc()) {
        array_push($arr_perm, $row);
}

$titulo = $user['nombre'];

?>
<div class="container">
	<div class="row">
		<h3 class="center"><?=$titulo?></h3>
		<div class="col m4 s12">
			<label for="">Correo</label>
			<span class="dato"><?=$user['correo']?></span>
		</div>
		<div class="col m4 s12">
			<label for="">Contraseña</label>
			<span class="dato"><?=$user['pass']?></span>
		</div>
	</div>

	<h5 class="center" style="margin: 30px 0px;">Permisos</h5>
	<table class="permisos">
		<thead>
			<th>ELEMENTO</th>
			<?php
			foreach ($arr_perm as $permiso) {
				?>
				<th><?=$permiso['nombre']?></th>
				<?php
			}
			?>
		</thead>
		<tbody>
			<?php
			foreach ($perm as $objeto) {
				?>
				<tr>
				<td><?=$objeto['nombre']?></td>
					<?php
					foreach ($arr_perm as $permiso) {
						if(in_array($permiso['id'], $objeto['permisos'])){
						?>
						<td style="color: green; font-size:2em;"><i class="fa fa-check-circle-o"></i></td>
						<?php
						}
						else{
							?>
							<td style="color: grey; font-size:2em;"><i class="fa fa-times-circle-o"></i></td>
							<?php	
						}
					}					
					?>
				</tr>
				<?php
			}
		?>
		</tbody>
	</table>
	<div class="row">
		<div class="col s12" style="margin-top: 30px;">
			<a href="Javascript:window.history.back();" class="btn red left">Volver</a>
			<a href="editar.php?id=<?=$user['id']?>" class="btn btn_sys right">Editar</a>
		</div>
	</div>
</div>