<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "
select 
instalacion.id,
instalacion.cod_instalacion,
instalacion.cod_mat_gen,
instalacion.n_contenedores,
app_sector.nombre as sector,
app_nave.nombre as nave,
instalacion.meson,
app_contenedor.nombre as contenedor,
app_contenedor.nombre as tipo_bandeja,
app_contenedor.capacidad as capacidad,
instalacion_parcela.nipla,
app_temporada.nombre as temporada,
app_propagacion.nombre as tipo_propagacion,
app_especie.nombre as especie,
madre.cod_desc as cod_madre,
cod_mat_gen.nombre as cod_mat_gen,
app_origen_genetico.nombre as origen_genetico

from instalacion

inner join app_sector on app_sector.id = instalacion.sector
inner join app_nave on app_nave.id = instalacion.nave
inner join app_contenedor on app_contenedor.id = instalacion.tipo_contenedor

inner join madre on madre.id = instalacion.madre
inner join app_propagacion on app_propagacion.id = madre.tipo_propagacion
inner join app_temporada on app_temporada.id = instalacion.temporada
inner join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen
inner join app_especie on app_especie.id = cod_mat_gen.especie
left join instalacion_parcela on instalacion_parcela.id_instalacion = instalacion.id
inner join app_origen_genetico on app_origen_genetico.id = madre.origen_genetico

where instalacion.cod_instalacion = '$id_parcela' limit 1
";


$result = $mysqli->query($query);
$arr = $result->fetch_assoc();	
echo json_encode($arr);

