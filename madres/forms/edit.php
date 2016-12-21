<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$campos = array(
	"id_cod_mat_gen"=>$id_cod_mat_gen, 
	"cod_desc"=>$cod_desc, 
	"campo_origen"=>$campo_origen, 
	"fecha_plantacion"=>$fecha_plantacion, 
	"origen_genetico"=>$origen_genetico, 
	"tipo_propagacion"=>$tipo_propagacion
	);


update("madre", $campos, array("id"=>$id), array("limit"=>"1"), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "El registro se ha sido actualizado correctamente";

header("Location: ../index.php");