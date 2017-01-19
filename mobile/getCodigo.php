<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

extract($_GET);

/*
codigo
*/

$query = "select instalacion_parcela.codigo, instalacion_parcela.id from instalacion_parcela 
inner join instalacion on instalacion.id = instalacion_parcela.id_instalacion 
 where instalacion_parcela.codigo='$codigo' and instalacion.estado='1' and instalacion_parcela.id not in(select id_parcela from inventario_medicion)
 limit 1";
$result = $mysqli->query($query);
if($result->num_rows > 0){
	$arr = $result->fetch_assoc();
	echo 'true';
}
else{
	echo'La parcela indicada ya se encuentra medida. Por favor intenta con otra.';
}
