<?php
session_start();
$_SESSION["bd"] = $_POST["bd"];
include("../conexion.php");
$rst_usr = mysql_query("SELECT * FROM clientes 
WHERE cli_usuario='".trim($_POST["Usuario"])."' AND cli_clave='".$_POST["Clave"]."' AND TRIM(cli_usuario)!='' AND cli_categoria!=1",$conexion);
$num = mysql_num_rows($rst_usr);
$fila = mysql_fetch_array($rst_usr);
if($num>0)
{
	//INICIO SESION
	//session_start();
	$_SESSION["id"] = $fila[0];
	
	switch($_POST["refe"]){
		case 1:	$url = 'registrados/'; break;
		case 2: $url = 'https://jmequipos.com/clientes-certificados.php?cte='.$fila[0]; break;
		
			
		default: $url = 'registrados/'; break;	
	}
	
	if(!isset($_POST["idseg"]) or !is_numeric($_POST["idseg"])){$url = 'registrados/';}
	else{$url = 'registrados/notificaciones-lista.php?idSeg='.$_POST["idseg"];}
	
	mysql_query("UPDATE clientes SET cli_sesion=1, cli_ultimo_ingreso=now() WHERE cli_id='".$fila[0]."'",$conexion);
	if(mysql_errno()!=0){echo mysql_error();exit();}
	
	header("Location:".$url);	
	exit();
}else{
	header("Location:http://jmequipos.com/clientes.php?6=current-menu-item&error=3&msg=esProspecto");
	exit();
}
?>