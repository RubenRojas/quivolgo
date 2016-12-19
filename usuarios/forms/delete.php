<?php
if(is_dir("/home4/alvarube/public_html/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


deleteDB("app_usuario", array("id"=>$id), array("limit"=>"1"), $mysqli);
deleteDB("app_usuario_permiso", array("usuario"=>$id), array(), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Usuario ".$nombre." ha sido eliminado del sistema";

header("Location: ../index.php");