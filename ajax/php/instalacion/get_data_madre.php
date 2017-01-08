<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "select 
cod_mat_gen.nombre as cod_mat_gen,
madre.cod_desc, 
madre.id as id_madre, 
madre.id_cod_mat_gen,
madre.id, 
app_campo_origen.nombre as campo_origen,  
madre.fecha_plantacion,
app_origen_genetico.nombre as origen_genetico,
app_propagacion.nombre as tipo_propagacion,
app_especie.nombre as especie

from madre 
left join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen
left join app_campo_origen on app_campo_origen.id = madre.campo_origen
left join app_origen_genetico on app_origen_genetico.id = madre.origen_genetico
left join app_propagacion on app_propagacion.id = madre.tipo_propagacion
left join app_especie on app_especie.id = cod_mat_gen.especie

where madre.id='$id' limit 1";


$result = $mysqli->query($query);

$arr = $result->fetch_assoc();

echo json_encode($arr);