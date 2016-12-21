<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);


$campos = array(
	"cod_instalacion"=>$cod_instalacion,
	"fecha"=>$fecha,
	"madre"=>$madre,
	"estado"=>$estado,
	"sector"=>$sector,
	"nave"=>$nave,
	"meson"=>$meson,
	"nipla"=>$nipla,
	"tipo_contenedor"=>$tipo_contenedor,
	"temporada"=>$temporada,
	"n_contenedores"=>$n_contenedores,
	"instalador"=>$instalador
	);
$id_instalacion = insert_dev("instalacion", $campos, $mysqli);

for ($i=1; $i <= $parcelas_creadas; $i++) { 
	$campos = array(
		"id_instalacion"=>$id_instalacion,
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
$_SESSION['mensaje']['texto'] = "Se ingresó el registro correctamente";

header("Location: ../index.php");
