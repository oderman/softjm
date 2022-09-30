<?php
$consultaConfig = $conexionBdPrincipal->query("SELECT * FROM configuracion WHERE conf_id=1");
$configu = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);

//Estaba en la barra lateral
$configuracion = mysqli_fetch_array($consultaConfig, MYSQLI_BOTH);