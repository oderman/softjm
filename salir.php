<?php
session_start();
include("conexion.php");

switch($_SESSION["bd"]){
	case 'odermancom_jm_crm'; $urlRed = 'https://softjm.com'; break;

	case 'odermancom_orioncrm_exacta'; $urlRed = 'https://orioncrm.com.co/exactaingenieria'; break;
		
	case 'odermancom_orioncrm_asalliancesas'; $urlRed = 'https://orioncrm.com.co/asalliancesas'; break;

	case 'orioncrmcom_oscar'; $urlRed = 'https://orioncrm.com.co/oscar'; break;	

	default: $urlRed = 'https://softjm.com'; break;
}

mysql_query("UPDATE usuarios SET usr_sesion=0, usr_ultima_salida=now() WHERE usr_id='".$_SESSION["id"]."'",$conexion);
if(mysql_errno()!=0){echo mysql_error();exit();}
session_destroy();
header("Location:".$urlRed."/index.php?s=11");
?>