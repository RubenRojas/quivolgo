<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


$campos = array("nombre"=>$nombre, "capacidad"=>$capacidad);
$id_usuario = insert("app_contenedor", $campos, $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ingresó el registro correctamente";

header("Location: ../index.php");