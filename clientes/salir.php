<?php
session_start();
include("../conexion.php");
mysql_query("UPDATE clientes SET cli_sesion=0, cli_ultima_salida=now() WHERE cli_id='".$_SESSION["id"]."'",$conexion);
if(mysql_errno()!=0){echo mysql_error();exit();}
session_destroy();
header("Location:http://jmequipos.com/clientes.php?6=current-menu-item");
?>