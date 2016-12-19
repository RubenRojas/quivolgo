<?php
if(is_dir("/home4/alvarube/public_html/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$campos = array("nombre"=>$nombre, "correo"=>$correo, "pass"=>$pass);

update("app_usuario", $campos, array("id"=>$id), array("limit"=>"1"), $mysqli);
deleteDB("app_usuario_permiso", array("usuario"=>$id), array(), $mysqli);


$permisos = $_POST["permiso"];
if(count($permisos)>0){
	foreach ($permisos as $permiso) {
		$data = explode("_", $permiso);
		
		insert("app_usuario_permiso", array("objeto"=>$data[0], "permiso"=>$data[1], "usuario"=>$id), $mysqli);
	}
}
$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Usuario ".$nombre." ha sido actualizado correctamente";

header("Location: ../index.php");