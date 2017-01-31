<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$inventario = select("inventario", array("id"), array("estado"=>"2"), array("order by"=> "id desc", "limit"=>"1"), $mysqli);
$campos = array(
	"id_inventario"=>$inventario['id'],
	"predio"=>$predio,
	"fecha_ingreso"=>$fecha_ingreso,
	"encargado"=>$encargado,
	"tipo_contenedor"=>$tipo_contenedor,
	"especie"=>$especie,
	"estado"=>"1",
	"rango"=>$rango,

		);

$id_despacho = insert("despacho", $campos, $mysqli);

$campos = array(
	"id_despacho"=>$id_despacho,
	"id_inventario"=>$inventario['id'],
	"total_plantas"=>$total_plantas
	);
$id_requerimiento = insert("despacho_requerimiento", $campos, $mysqli);

$query = "insert into despacho_requerimiento_detalle(id_requerimiento, cod_mat_gen) values ";
foreach ($cod_mat_gen as $value) {
	$query.="('$id_requerimiento', '$value'), ";
}
$query = substr($query, 0, -2);
$result = $mysqli->query($query);



$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se registro el requerimiento correctamente";

header("Location: ../oferta.php?id=".$id_requerimiento);