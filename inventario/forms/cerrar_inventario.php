<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");


//id de inventario
$query = "select id from inventario where estado='1' order by id limit 1";
$result = $mysqli->query($query);
$inventario = $result->fetch_assoc();


//instalaciones medidas
$query ="select
instalacion.id,
instalacion.n_contenedores,
app_contenedor.capacidad
from inventario_medicion
inner join instalacion on instalacion.id = inventario_medicion.id_instalacion
inner join app_contenedor on app_contenedor.id = instalacion.tipo_contenedor
where inventario_medicion.id_inventario='$inventario[id]'
group by instalacion.id";
$instalaciones = $mysqli->query($query);
$q = "insert into inventario_resultado(id_inventario, id_instalacion, id_rango_inventario, cantidad) values ";
while ($instalacion = $instalaciones->fetch_assoc()) {

	//porcentaje plantas vivas
	$query ="select 
	((sum(inventario_medicion.plantas_vivas) / sum(instalacion_parcela.nipla)) * 100) as porcentaje_sobrevida
	from inventario_medicion
	inner join instalacion_parcela on instalacion_parcela.id = inventario_medicion.id_parcela
	where inventario_medicion.id_inventario = $inventario[id]
	and inventario_medicion.id_instalacion='$instalacion[id]'
	";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$porcentaje_sobrevida = $arr['porcentaje_sobrevida'];
	$napla = $instalacion['n_contenedores'] * $instalacion['capacidad'] * ($porcentaje_sobrevida/100);


	//cantidad de plantas medidas por instalacion
	$query = "select 
	count(inventario_medicion_detalle.id) as medidas
	from inventario_medicion_detalle
	inner join inventario_medicion on inventario_medicion_detalle.id_medicion = inventario_medicion.id
	where
	inventario_medicion.id_inventario = $inventario[id]
	and inventario_medicion.id_instalacion = '$instalacion[id]'";
	$result = $mysqli->query($query);
	$arr = $result->fetch_assoc();
	$cantidad_plantas_medidas = $arr['medidas'];


	//cantidad de plantas medidas segun rango
	$query = "select 
	inventario_medicion.id_instalacion,
	count(inventario_medicion_detalle.altura) as cantidad,
	((count(inventario_medicion_detalle.altura) / $cantidad_plantas_medidas) * 100) as porcentaje_rango,
	((count(inventario_medicion_detalle.altura) / $cantidad_plantas_medidas)* $napla ) as plantas_rango_instalacion, 
	inventario_rango.nombre,
	inventario_rango.id as id_rango_inventario
	from 
	inventario_medicion_detalle
	inner join inventario_rango on inventario_medicion_detalle.altura between inventario_rango.valor_inicial and inventario_rango.valor_final
	inner join inventario_medicion on inventario_medicion.id = inventario_medicion_detalle.id_medicion
	inner join instalacion on instalacion.id = inventario_medicion.id_instalacion
	where inventario_medicion.id_inventario='$inventario[id]' 
	and inventario_medicion.id_instalacion='$instalacion[id]'
	group by inventario_rango.nombre
	order by inventario_rango.id asc";
	$result = $mysqli->query($query);

	while ($arr = $result->fetch_assoc()) {
		$plantas_rango_instalacion = ceil($arr['plantas_rango_instalacion']);
		$q.="($inventario[id], $arr[id_instalacion], $arr[id_rango_inventario], '$plantas_rango_instalacion'),
		";
	}

}
$q = substr($q, 0, -5);

//guardo los resultados del inventario (formula aplicada)
$result = $mysqli->query($q);

//actualizo la fecha de cierre del inventario y cambio el estado
$campos = array(
	"fecha_cierre"=>$HOY,
	"estado"=>"2"
	);
update("inventario",$campos, array("id"=>$inventario['id']), array("limit"=>"1"), $mysqli);

$_SESSION['mensaje']['tipo'] = "SUCCESS";
$_SESSION['mensaje']['texto'] = "Se abrió el inventario correctamente";

header("Location: ../index.php");
