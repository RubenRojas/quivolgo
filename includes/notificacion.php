<?php 
if(isset($_SESSION['mensaje'])){
	?>
	<div class="notificacion ">
		<div class="<?=$_SESSION['mensaje']['tipo']?> ">
			<!--<div class="icono  valign-wrapper">
				<img src="/demotron/Assets/img/icons/<?=$_SESSION['mensaje']['tipo']?>.png" alt="" class="valign">
			</div> -->
			<div class="mensaje valign-wrapper">
				<p class="valign"><?=$_SESSION['mensaje']['texto']?></p>
			</div>
			<a href="Javascript:notif_close();" style="    position: absolute; top: 6px; right: 6px; color: #fff;"><i class="fa fa-times"></i></a>
		</div>
	</div>
	<?php
	unset($_SESSION['mensaje']);
}