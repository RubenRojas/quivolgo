<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

extract($_GET);

/*
rut
pass
*/

$ret = array();

$query = "select id, rut, pass from app_instalador where rut='$rut' and pass='$pass' limit 1";
$result = $mysqli->query($query);
if($result->num_rows>0){
	$arr = $result->fetch_assoc();
	$ret['result'] = "success";
	$ret['user'] = $arr;
	
}
else{
	$ret['result'] = "error";
}
echo json_encode($ret);