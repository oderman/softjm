<?php
require_once("../sesion.php");
require_once("../class/BaseDatos.php");

$idPagina = 300;

include(RUTA_PROYECTO."/usuarios/includes/verificar-paginas.php");

	mysqli_query($conexionBdPrincipal,"DELETE FROM soporte_productos WHERE sop_padre='" . $_GET["id"] . "'");
	mysqli_query($conexionBdPrincipal,"DELETE FROM soporte_productos WHERE sop_id='" . $_GET["id"] . "'");
	
	

include(RUTA_PROYECTO."/usuarios/includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
	exit();