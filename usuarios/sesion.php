<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/softjm/constantes.php");

if( $_SESSION["id"]=="" || !is_numeric($_SESSION["id"]) ){
	header("Location:../salir.php");
	exit();
}
	
$tiempo_inicial = microtime(true);
	
require_once(RUTA_PROYECTO."/conexion.php");
require_once(RUTA_PROYECTO."/usuarios/config/config.php");
require_once(RUTA_PROYECTO."/usuarios/includes/funciones-para-el-sistema.php");
require_once(RUTA_PROYECTO."/usuarios/includes/sesion-usuario-actual.php");