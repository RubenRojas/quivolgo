<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

extract($_GET);
// id_especie

if(count($_GET)> 0){
	$query = "select 
	app_nave.id,
	app_nave.nombre 
	from 
	instalacion 
	inner join app_nave on app_nave.id = instalacion.nave
	where 
	instalacion.sector in (";
	
	foreach ($_GET as $key => $value) {
		$query .="'$value', ";

	}
	$query = substr($query, 0, -2);
	$query .=")group by instalacion.nave";	

	
}
else{
	$query = "select 
	app_nave.id, 
	app_nave.nombre 
	from instalacion 
	inner join app_nave on app_nave.id = instalacion.nave
	group by instalacion.nave
	";
}


$result = $mysqli->query($query);
if($result->num_rows > 0){
	?>
	<option value="" disabled="disabled">TODAS</option>
	<?php
	while ($arr = $result->fetch_assoc()) {
		?>
		<option value="<?=$arr['id']?>"><?=$arr['nombre']?></option>
		<?php
	}	
}
else{
	?>
	<option value="" disabled="">NO HAY REGISTROS</option>
	<?php
}

?>