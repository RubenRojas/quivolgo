<?php
/*************************************************/
//	CONFIG BASE
/*************************************************/
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
ini_set('memory_limit', '-1');
ini_set("session.cookie_lifetime","10000");
error_reporting(E_ERROR | E_WARNING | E_PARSE); 	//reporta errores ultiles
//error_reporting(-1);								//reporta todos los errores
//error_reporting(0);								//no reporta errores

date_default_timezone_set('Etc/GMT+3');
//en el horario anterior estaba en +4; //ultimo cambio: 00:00 -> 01:00 / 13-08-2016

/*************************************************/
//	INTEGRACION FUNCIONES
/*************************************************/
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."f_utilitarias.php");
include($baseDir."f_impresion.php");
include($baseDir."general.php");



include($baseDir."data/usuario.php");
include($baseDir."data/objeto.php");


/*************************************************/
//	CONEXION BASE DE DATOS
/*************************************************/
$host="localhost";
$user= "alvarube_quivolg";
$pass="ne4azU-tefu!";
$database="alvarube_quivolgo";
$mysqli = @new mysqli($host, $user, $pass, $database);
if ($mysqli->connect_errno) {
    //$mysqli = @new mysqli($host, "root", "root", "centraltaxi");
    echo' error de conexion bd<br>';
}
/*************************************************/
//	VARIABLES PARA LA APP
/*************************************************/
$HOY 	= date("Y-m-d");
$AYER 	= date('Y-m-d',strtotime("-1 days"));
$MANANA = date('Y-m-d',strtotime("+1 days"));
$AHORA 	= date('H:i');
$MESES 	= array("1"=>"Enero", "2"=>"Febrero", "3"=>"Marzo", "4"=>"Abril", "5"=>"Mayo", "6"=>"Junio", "7"=>"Julio", "8"=>"Agosto", "9"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre");
$hora 	= explode(" ", microtime());
$NOW 	= $hora[1].substr($hora[0], 1, 5);


/*
Colores app:

indigo
blue darken-4
teal
red darken-4


*/

?>
