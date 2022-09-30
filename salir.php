<?php
session_start();
include("conexion.php");
if(isset($_SESSION["bd"])){

	switch($_SESSION["bd"]){
		case 'odermancom_jm_crm'; $urlRed = 'http://localhost/works-projects/softjm/'; break;
	
		case 'odermancom_orioncrm_exacta'; $urlRed = 'https://orioncrm.com.co/exactaingenieria'; break;
			
		case 'odermancom_orioncrm_asalliancesas'; $urlRed = 'https://orioncrm.com.co/asalliancesas'; break;
	
		case 'orioncrmcom_oscar'; $urlRed = 'https://orioncrm.com.co/oscar'; break;	
	
		default: $urlRed = 'http://localhost/works-projects/softjm/'; break;
	}
}

if(isset($_SESSION["id"])){
	$query = $conexionBdPrincipal->query("UPDATE usuarios SET usr_sesion=0, usr_ultima_salida=now() WHERE usr_id='".$_SESSION["id"]."'");
	
	if (!$query) {
		printf("Error message: %s\n", $conexionBdPrincipal->error);
		exit();
	}
}


session_destroy();
header("Location:".$urlRed."/index.php?s=11");
?>