<?php
function getUsuarios($mysqli){
		$lista = select("app_usuario", array("*"), array(), array("order by"=>"nombre asc"), $mysqli);
		return $lista;
	}
function getPermisos($id, $mysqli){
	$perm = array();
	$obj = array();
	$objetos 	= getObjeto("objeto", $mysqli);
	
	while ($arr = $objetos->fetch_assoc()) {
		$obj['nombre']	= $arr['nombre'];
		$obj['id'] 		= $arr['id'];
		$obj['permisos']= array();
		
		$query = "select app_permiso.nombre, app_permiso.id from app_permiso inner join app_usuario_permiso on app_usuario_permiso.permiso = app_permiso.id where app_usuario_permiso.usuario='$id' and app_usuario_permiso.objeto = '$arr[id]'";
		$result = $mysqli->query($query);
		while ($arr2 = $result->fetch_assoc()) {
			array_push($obj['permisos'], $arr2['id']);
		}
		array_push($perm, $obj);
	}
	return $perm;
}
function getUserById($id, $mysqli){
	$user = select("app_usuario", array("*"), array("id"=>$id), array("limit"=>"1"), $mysqli);
	return $user;
}
function getUserLogin($correo, $pass, $mysqli){
	$user = select("app_usuario", array("*"), array("correo"=>$correo, "pass"=>$pass), array("limit"=>"1"), $mysqli);
	return $user;
}
function borrarUsuario($id, $mysqli){
	//borrar
	deleteDB("app_usuario", array("id"=>$id), array("limit"=>"1"), $mysqli);
}
function getPermisosObjeto($id, $objeto, $mysqli){
	$permisos = select("app_usuario_permiso", array("permiso"), array("usuario"=>$id, "objeto"=>$objeto), array("order by"=>"permiso asc"), $mysqli);
	$ret = array();
	while ($arr = $permisos->fetch_assoc()) {
		array_push($ret, $arr['permiso']);
	}
	return $ret;
}

