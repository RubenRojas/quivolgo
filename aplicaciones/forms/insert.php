<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


$campos = array("fecha"=>$fecha, "encargado"=>$encargado, "medio"=>$medio, "categoria"=>$categoria, "producto"=>$producto);
$id_aplicacion = insert("aplicacion", $campos, $mysqli);

for ($i=1; $i <= 10 ; $i++) { 
	if($_POST['comp_'.$i.'_id']!= ""){
		$campos = array("id_aplicacion"=>$id_aplicacion, "componente"=>$_POST['comp_'.$i.'_id'], "cantidad"=>$_POST['comp_'.$i.'_cantidad']);
		insert("aplicacion_cantidad", $campos, $mysqli);
	}
}


$lista_naves 			= array();
$lista_mesones 			= "";
$lista_instalaciones	= array();



for ($j=1; $j <10 ; $j++) { 
	for ($i=1; $i <=200 ; $i++) { 
		if($_POST['N'.$j.'_m'.$i]!= ""){
			$campos = array("id_aplicacion"=>$id_aplicacion, "sector"=>$sector, "nave"=>$j, "meson"=>$i);
			insert("aplicacion_ubicacion", $campos, $mysqli);
			if($lista_naves[$j] == ""){
				$lista_naves[$j] = array();
			}
			array_push($lista_naves[$j], $i);
		}
	}
}

//$query = "select id from instalacion where sector='$sector' and nave in ($lista_naves) and meson in ($lista_mesones)";
foreach ($lista_naves as $key => $value) {
	foreach ($value as $val) {
		$lista_mesones.="'".$val."', ";
	}
	$lista_mesones = substr($lista_mesones, 0, -2);
	$query = "select id from instalacion where sector='$sector' and nave = '$key' and meson in ($lista_mesones) and estado='1' order by id";
	$result = $mysqli->query($query);
	while ($arr = $result->fetch_assoc()) {
		if(!in_array($arr['id'], $lista_instalaciones)){
			array_push($lista_instalaciones, $arr['id']);
		}
	}
	$lista_mesones = "";
}
$query ="insert into aplicacion_instalacion (id_aplicacion, id_instalacion) values ";
foreach ($lista_instalaciones as $key => $value) {
	 $query.= "('$id_aplicacion', '$value'), ";
}
$query = substr($query, 0, -2);
$result = $mysqli->query($query);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se ingresó el registro correctamente";

header("Location: ../index.php");

