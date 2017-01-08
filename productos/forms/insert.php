<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$id_producto =insert("producto", array("nombre"=>$nombre, "categoria"=>$categoria, "estado"=>$estado), $mysqli);

for ($i=1; $i <= 10; $i++) { 
	if($_POST['componente_'.$i] !=""){
		insert("producto_componente", array("id_producto"=>$id_producto, "id_componente"=>$_POST['componente_'.$i], "unidad"=>$_POST['unidad_'.$i]), $mysqli);
	}
}


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ingresó el registro correctamente";

header("Location: ../index.php");
