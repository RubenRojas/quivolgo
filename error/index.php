<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");

print_head();

?>
<div class="container">
	<div class="row">

		<h2 class="center">
			<i class="fa fa-exclamation-circle" aria-hidden="true" style="display: block;font-size: 5em;color: #FF9800;"></i>
			Error
		</h2>
		<h5 class="center">
			<?=$_SESSION['error']['mensaje']?>
		</h5>
		<?php
		if($_SESSION['id']==''){
			?>
			<a href="/quivolgo/index.php" class="btn teal" style="display: block; margin: auto; width: 250px; margin-top: 110px; ">Continuar</a>
			<?php
		}
		else{
			?>
			<a href="/quivolgo/index.php" class="btn teal" style="display: block; margin: auto; width: 250px; margin-top: 110px; ">Continuar</a>
			<?php	
		}
		?>
		
	</div>
</div>
