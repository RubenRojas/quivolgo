<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}

include($baseDir."conexion.php");
extract($_POST);

$query = "select cod_mat_gen.nombre from madre inner join cod_mat_gen on cod_mat_gen.id = madre.id_cod_mat_gen where madre.id = '$madre' limit 1";
$result = $mysqli->query($query);
$arr = $result->fetch_assoc();


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
	"instalador"=>$instalador,
	"cod_mat_gen"=>$arr['nombre']
	);
$id_instalacion = insert("instalacion", $campos, $mysqli);

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
