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
$id_usuario = insert("app_usuario", $campos, $mysqli);

$permisos = $_POST["permiso"];
if(count($permisos)>0){
	foreach ($permisos as $permiso) {
		$data = explode("_", $permiso);
		
		insert("app_usuario_permiso", array("objeto"=>$data[0], "permiso"=>$data[1], "usuario"=>$id_usuario), $mysqli);
	}
}
$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Usuario ".$nombre." ha sido registrado correctamente";

header("Location: ../index.php");