<?php
$consultaConfig = $conexionBdPrincipal->query("SELECT * FROM configuracion WHERE conf_id=1");
$configu = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

//Estaba en la barra lateral
$consultaConfig2 = $conexionBdPrincipal->query("SELECT * FROM configuracion WHERE conf_id=1");
$configuracion = mysqli_fetch_array($consultaConfig2, MYSQLI_BOTH);