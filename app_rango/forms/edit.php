<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


update("app_rango", $_POST, array("id"=>$id), array("limit"=>"1"), $mysqli);

$inventario = select("inventario", array("id"), array("estado"=>"1"), array("order by"=>"id", "limit"=>"1"), $mysqli);
if($inventario['id'] != ""){
	//hay un inventario activo
	$query = "delete from inventario_rango where id_inventario='$inventario[id]'";
	$result = $mysqli->query($query);

	$query = "select nombre, valor_inicial, valor_final from app_rango ";
	$result = $mysqli->query($query);
	$query = "insert into inventario_rango(id_inventario, nombre, valor_inicial, valor_final) values ";
	while ($arr = $result->fetch_assoc()) {
		$query .= "('$inventario[id]', '$arr[nombre]', '$arr[valor_inicial]', '$arr[valor_final]'), ";
	}
		$query = substr($query, 0, -2);
	$result = $mysqli->query($query);

}
$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "El registro se ha sido actualizado correctamente";

header("Location: ../index.php");
