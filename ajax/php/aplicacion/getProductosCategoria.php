<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "select id, nombre from producto where categoria='$categoria' and estado='1' order by nombre";

$result = $mysqli->query($query);
echo'<option value=""></option>';
while ($arr = $result->fetch_assoc()) {
	echo'<option value="'.$arr['id'].'">'.$arr['nombre'].'</option>';
}