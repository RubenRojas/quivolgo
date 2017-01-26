<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


deleteDB("instalacion_parcela", array("id_instalacion"=>$id), array(), $mysqli);



for ($i=1; $i <= $parcelas_creadas; $i++) { 
	$campos = array(
		"id_instalacion"=>$id,
		"codigo"=>$_POST['parcela_'.$i],
		"estado"=>"1",
		"tipo_contenedor"=>$tipo_contenedor,
		"nipla"=>$cap_contenedor
	);
	
	if($_POST['parcela_'.$i] != ""){
		insert("instalacion_parcela", $campos, $mysqli);	
	}
	
}


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se actualizó el registro correctamente";

header("Location: ../detalle.php?id=".$id);