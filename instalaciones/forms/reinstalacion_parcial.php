<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);



$instalacion = select("instalacion", array("*"), array("cod_instalacion"=>$cod_instalacion), array("limit"=>"1"), $mysqli);
$contenedor = select("app_contenedor", array("*"), array("id"=>$instalacion['tipo_contenedor']), array("limit"=>"1"), $mysqli);

$id_previa = $instalacion['id'];
$n_contenedores_anterior = $instalacion['n_contenedores'] - $cant_contenedores;
$nipla_anterior = $n_contenedores_anterior * $contenedor['capacidad'];



$query = "select (max(id) + 1) as nId from instalacion";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();
$nId = $arr['nId'];



$cod_inst = explode("-", $instalacion['cod_instalacion']);
$cod_inst[2] = $nId;

$nCodInst = implode("-", $cod_inst);



$instalacion['id_instalacion_previa']= $id_previa;
$instalacion['fecha_cambio'] = $fecha;
$instalacion['instalador_cambio'] = $instalador;
$instalacion['id'] = $nId;
$instalacion['meson'] = $meson;
$instalacion['sector'] = $sector;
$instalacion['nave'] = $nave;
$instalacion['cod_instalacion'] = $nCodInst;
$instalacion['n_contenedores'] = $cant_contenedores;
$instalacion['nipla'] = ($cant_contenedores * $contenedor['capacidad']);


/*Insert nueva instalacion*/
insert("instalacion", $instalacion, $mysqli);



/*Copio las aplicaciones*/
$query = "select * from aplicacion_instalacion where id_instalacion='$id_previa'";
$result = $mysqli->query($query);
$query = "insert into aplicacion_instalacion(id_aplicacion, id_instalacion) values ";
while ($arr = $result->fetch_assoc()) {
	$query.= "('$arr[id_aplicacion]', '$nId'), ";
}
$query = substr($query, 0, -2);
$result = $mysqli->query($query);


/*Actualizo el n bandejas de la anterior*/
$campos = array(
	"n_contenedores"=>$n_contenedores_anterior,
	"nipla"=>$nipla_anterior);
update("instalacion",$campos, array("id"=>$id_previa), array("limit"=>"1"), $mysqli);


$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Instalacion reubicada correctamente";

header("Location: ../index.php");
