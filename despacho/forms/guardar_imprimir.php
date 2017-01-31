<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);



$query = "delete from despacho_detalle where id_despacho='$id_despacho'";
$result = $mysqli->query($query);
if(count($instalaciones)>0){

	$query = "insert into despacho_detalle (id_despacho, id_instalacion, cantidad, ficha) values ";
	foreach ($instalaciones as $key => $value) {
		$cantidad = $_POST[$value."_plantas"];
		$ficha= $_POST[$value."_ficha"];
		$query .= "('$id_despacho', '$value', '$cantidad', '$ficha'), ";
	}
	$query = substr($query, 0, -2);

	$result = $mysqli->query($query);
}


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se registro el requerimiento correctamente";

header("Location: ../imprimir_despacho.php?id=".$id_despacho);
