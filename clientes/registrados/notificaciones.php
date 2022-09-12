<?php if($_GET["msg"]==1){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>Exito!</strong> La solicitud fue enviada correctamente. Pronto se le dará respuesta.
	</div>
<?php }?>

<?php if($_GET["msg"]==2){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>Exito!</strong> Los cambios ya se guardaron y todo está bien.
	</div>
<?php }?>

<?php if($_GET["msg"]==3){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>Exito!</strong> El registro fue eliminado correctamente.
	</div>
<?php }?>

<?php if($_GET["msg"]==4){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>Exito!</strong> Acción completada 1.
	</div>
<?php }?>

<?php if($_GET["msg"]==5){?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<i class="icon-exclamation-sign"></i><strong>Exito!</strong> Acción completada 2.
	</div>
<?php }?>