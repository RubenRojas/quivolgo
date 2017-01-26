<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

extract($_GET);


$sectores = array();
$naves = array();


if(count($_GET)> 0){
	
	foreach ($_GET as $key => $value) {
		if(substr($key, 0, 1) == "s"){
			array_push($sectores, $value);
		}
		if(substr($key, 0, 1) == "n"){
			array_push($naves, $value);
		}
	}
}


if(count($_GET)> 0){
	$query = "select 
	instalacion.meson
	from 
	instalacion 
	where 1=1 ";

	if(count($naves)> 0){
		$query .= "and instalacion.nave in (";
		foreach ($naves as $value) {
			$query .="'$value', ";
		}
		$query = substr($query ,0 , -2);
		$query.=") ";
	}
	if(count($sectores)> 0){
		$query .= "and instalacion.sector in (";
		foreach ($sectores as $value) {
			$query .="'$value', ";
		}
		$query = substr($query ,0 , -2);
		$query.=") ";
	}
	
	$query .= "group by instalacion.meson";

	
	

}
else{
	$query = "select 
	instalacion.meson
	from instalacion 
	
	group by instalacion.meson
	";

	
}


$result = $mysqli->query($query);
if($result->num_rows > 0){
	?>
	<option value="" disabled="disabled">TODAS</option>
	<?php
	while ($arr = $result->fetch_assoc()) {
		?>
		<option value="<?=$arr['meson']?>"><?=$arr['meson']?></option>
		<?php
	}	
}
else{
	?>
	<option value="" disabled="">NO HAY REGISTROS</option>
	<?php
}

?>