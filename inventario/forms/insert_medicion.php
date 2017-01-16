<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


$inventario = select("inventario", array("id"), array("estado"=>"1"), array("order by"=>"id", "limit"=>"1"), $mysqli);
$parcela = select("instalacion_parcela", array("id, id_instalacion"), array("codigo"=>$cod_parcela), array("limit"=>"1"), $mysqli);

$campos = array(
	"id_inventario"=>$inventario['id'],
	"id_parcela"=>$parcela['id'],
	"plantas_vivas"=>$plantas_vivas,
	"plantas_muertas"=>$plantas_muertas,
	"instalador"=>$instalador,
	"hora_inicio"=>$hora_inicio,
	"hora_termino"=>$AHORA,
	"fecha"=>$fecha,
	"observacion"=>$observacion
	);
$id_medicion = insert("inventario_medicion", $campos, $mysqli);

$query = "insert into inventario_medicion_detalle(id_medicion, altura) values ";
for ($i=1; $i <= $registrados ; $i++) { 
	if($_POST["altura_".$i] != ""){
		$altura = $_POST["altura_".$i];
		$query .= "('$id_medicion', '$altura'), ";
	}
}
$query = substr($query, 0, -2);

$result = $mysqli->query($query);


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se registro la medicion correctamente";

header("Location: ../index.php");