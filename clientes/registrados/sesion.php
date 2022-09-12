<?php
session_start();
if($_SESSION["id"]=="")
header("Location:../salir.php");
else
{
	include("../../conexion.php");
	//USUARIO ACTUAL
	$consultaUsuarioActual = mysql_query("SELECT * FROM clientes WHERE cli_id='".$_SESSION["id"]."'",$conexion);
	$numUsuarioActual = mysql_num_rows($consultaUsuarioActual);
	$datosUsuarioActual = mysql_fetch_array($consultaUsuarioActual);

	$configu = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));
}
?>
