<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


deleteDB("cod_mat_gen", array("id"=>$id), array("limit"=>"1"), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "El registro se ha sido eliminado del sistema";

header("Location: ../index.php");