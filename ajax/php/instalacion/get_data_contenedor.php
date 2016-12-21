<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "select capacidad from app_contenedor where id='$id' limit 1";


$result = $mysqli->query($query);

$arr = $result->fetch_assoc();

echo json_encode($arr);