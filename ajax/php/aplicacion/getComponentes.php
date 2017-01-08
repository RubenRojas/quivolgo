<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
extract($_GET);

$query = "select
app_componente.id,
app_componente.nombre,
app_componente.descripcion
from producto_componente 
inner join app_componente on producto_componente.id_componente = app_componente.id


where producto_componente.id_producto='$producto'";

?>
<div class="col s12">
	<div class="col s2">
		<label for="">Comp.</label>
	</div>
	<div class="col s4">
		<label for="">Desc.</label>
	</div>
	<div class="col s3">
		<label for="">Unidad</label>
	</div>
	<div class="col s3">
		<label for="">Cant.</label>
	</div>
</div>
<?php
$result = $mysqli->query($query);
$i = 1;
while ($arr = $result->fetch_assoc()) {
	?>
	<div class="col s12 lista_componente">
		<div class="col s2">
			<input type="text"  value="<?=$arr['nombre']?>" disabled="disabled">
		</div>
		<div class="col s4">
			<input type="text" value="<?=$arr['descripcion']?>" disabled="disabled">
		</div>
		<div class="col s3">
			<input type="text" name="" value="GR" disabled="disabled">
		</div>
		<div class="col s3">
			<input type="hidden" name="comp_<?=$i?>_id" value="<?=$arr['id']?>">
			<input type="text" name="comp_<?=$i?>_cantidad" value="">
		</div>
	</div>
	<?php
	$i++;
}