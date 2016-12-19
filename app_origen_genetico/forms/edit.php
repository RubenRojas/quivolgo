<?php
if(is_dir("/home4/alvarube/public_html/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$campos = array("nombre"=>$nombre);

update("app_origen_genetico", $campos, array("id"=>$id), array("limit"=>"1"), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "El registro se ha sido actualizado correctamente";

header("Location: ../index.php");