<?php
if(is_dir("/home4/alvarube/public_html/telios/quivolgo")){
	$baseDir = "/home4/alvarube/public_html/telios/quivolgo/includes/";
}
else{
	$baseDir = "c:/wamp/www/quivolgo/includes/";
}
include($baseDir."conexion.php");
session_destroy();
print_head();
?>
<div id="loginContainer">
	<div class="container">
		<div class="row">
			<div class="col s12 m6 offset-m3" style="margin-top: 63px; background: rgba(255, 255, 255, 0.81); padding: 15px 15px 39px 15px; border-radius: 4px; ">	
				<h2 class="center">SISTEMA DE CONTROL Y ADMINISTRACION DE VIVERO</h2>
				<div id="login">
					<h5 class="center">Iniciar Sesión</h5>
					<form action="valida.php" method="post">
						<div class="input-field col s12">
				          <input id="correo" name="correo" type="text" required="required">
				          <label for="correo">Correo</label>	
				        </div>
				        <div class="input-field col s12">
				          <input id="password" name="pass" type="password" required="required">
				          <label for="password">Contraseña</label>
				        </div>
						<div class="col s12">
							<input type="submit" value="Ingresar" class="btn indigo right">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){

		$("#loginContainer").height(window.innerHeight);
	});
</script>
<?=print_footer()?>