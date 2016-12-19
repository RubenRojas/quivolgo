<?php
function getObjeto($objeto, $mysqli){
	$lista = select("app_".$objeto, array("id, nombre"), array(), array("order by"=>"nombre asc"), $mysqli);
	return $lista;
}

function getObjetoByNombre($objeto, $mysqli){
	$lista = select("app_objeto", array("*"), array("nombre"=>$objeto), array("limit"=>"1"), $mysqli);
	return $lista;
}