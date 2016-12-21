<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

extract($_POST);

$query = "select * from app_usuario where correo='$correo' and pass='$pass' limit 1";

$result = $mysqli->query($query);

if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	$_SESSION['id'] = $arr['id'];
	$_SESSION['nombre'] = $arr['nombre'];
	$_SESSION['mensaje']['texto'] = "Bienvenido ".$arr['nombre'];
	header("Location: /quivolgo/principal.php");
}
else{
	$_SESSION['error']['location'] = "/quivolgo/login";
	$_SESSION['error']['mensaje'] = "Datos Incorrectos, intente nuevamente";
	header("Location: /quivolgo/error/index.php");
}