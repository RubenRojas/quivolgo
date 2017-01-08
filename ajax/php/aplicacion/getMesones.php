<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "select meson from instalacion where sector='$sector' and nave='$nave' group by meson";
$result = $mysqli->query($query);
?>
<h5 class="center">Listado Mesones</h5>
<?php
while ($arr = $result->fetch_assoc()) {
	?>
	<div class="col s2 meson">
		<input type="checkbox" id="m<?=$arr['meson']?>"  name="m<?=$arr['meson']?>" data-nave="<?=$data_nave?>" value="m<?=$arr['meson']?>">
      	<label for="m<?=$arr['meson']?>"> M-<?=$arr['meson']?></label>
	</div>
	<?php
}
?>
