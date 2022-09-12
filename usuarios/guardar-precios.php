<?php include("sesion.php");?>
<?php
$consulta = mysql_query("SELECT * FROM productos", $conexion);

while($datos = mysql_fetch_array($consulta)){

	mysql_query("INSERT INTO productos_historial_precios(php_producto, php_precio_anterior, php_precio_nuevo, php_usuario, php_causa)VALUES('".$datos["prod_id"]."', '".$datos['prod_precio']."', '".$datos['prod_precio']."', '".$_SESSION["id"]."', 4)");
	if(mysql_errno()!=0){echo mysql_error(); exit();}

}

echo '<script type="text/javascript">window.location.href="productos.php?msg=12";</script>';
exit();
