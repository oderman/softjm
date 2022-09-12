<?php
session_start();
include("../../conexion.php");
$rst_usr = mysql_query("SELECT * FROM clientes WHERE cli_id='".$_SESSION["id"]."' AND cli_clave_documentos='".$_POST["claveDoc"]."'",$conexion);
$num = mysql_num_rows($rst_usr);
$fila = mysql_fetch_array($rst_usr);
if($num>0)
{
	//INICIO SESION
	$_SESSION["idDoc"] = $fila[0];
	header("Location:documentos.php");	
	exit();
}else{
	header("Location:clave-documentos.php?error=1");
	exit();
}
?>