<?php
$configu = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));

//Estaba en la barra lateral
$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));