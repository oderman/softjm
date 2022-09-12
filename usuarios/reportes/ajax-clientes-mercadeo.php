<?php
include("../sesion.php");
include("../../conexion.php");

$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));

if($_POST["em"]==5){
	mysql_query("UPDATE clientes SET cli_terminado=1, cli_terminado_por='".$_SESSION["id"]."', cli_terminado_fecha=now() WHERE cli_id='".$_POST["cliente"]."'",$conexion);
	if(mysql_errno()!=0){echo mysql_error(); exit();}
}

if($_POST["em"]!=6){
	mysql_query("UPDATE clientes SET cli_papelera=0 WHERE cli_id='".$_POST["cliente"]."'",$conexion);
	if(mysql_errno()!=0){echo mysql_error(); exit();}	
}

mysql_query("UPDATE clientes SET cli_estado_mercadeo='".$_POST["em"]."', cli_estado_mercadeo_fecha=now(), cli_estado_mercadeo_usuario='".$_SESSION["id"]."' WHERE cli_id='".$_POST["cliente"]."'",$conexion);
if(mysql_errno()!=0){echo mysql_error(); exit();}else{
	echo "Acción realizada";
}

?>