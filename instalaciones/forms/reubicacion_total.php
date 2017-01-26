<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$query = "select id, nave, meson, sector from instalacion where cod_instalacion='$cod_instalacion' limit 1";
$result = $mysqli->query($query);
$instalacion = $result->fetch_assoc();

$campos = array(
	"id_instalacion"=>$instalacion['id'],
	"fecha"=>$fecha,	
	"n_meson"=>$meson,
	"n_sector"=>$sector,
	"n_nave"=>$nave,
	"o_meson"=>$instalacion['meson'],
	"o_sector"=>$instalacion['sector'],
	"o_nave"=>$instalacion['nave'],
	"instalador"=>$instalador
	
	);

insert("instalacion_reubicacion", $campos, $mysqli);

$campos = array(	
	"meson"=>$meson,
	"sector"=>$sector,
	"nave"=>$nave
	);

update("instalacion",$campos, array("id"=>$instalacion['id']), array("limit"=>"1"), $mysqli);


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Instalacion reubicada correctamente";

header("Location: ../index.php");
