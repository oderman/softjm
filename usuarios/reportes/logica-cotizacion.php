<?php
session_start();
if ($_GET["cte"] == 1) {
	$_GET["id"] = base64_decode($_GET["id"]);
} else {
	if ($_SESSION["id"] == "")
		header("Location:../../salir.php");
}

include("../../conexion.php");
$configu = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1", $conexion));

//CONFIGURACIÓN DEL PROGRAMA
$monedas = array("", "COP", "USD");
$simbolosMonedas = array("", "$", "USD");

$formaPago = array("", "CONTADO", "CRÉDITO");

$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1", $conexion));

$resultado = mysql_fetch_array(mysql_query("SELECT * FROM cotizacion
INNER JOIN clientes ON cli_id=cotiz_cliente
INNER JOIN sucursales ON sucu_id=cotiz_sucursal
INNER JOIN contactos ON cont_id=cotiz_contacto
INNER JOIN usuarios ON usr_id=cotiz_vendedor
WHERE cotiz_id='" . $_GET["id"] . "'", $conexion));

$total = number_format($resultado['cotiz_valor'] + ($resultado['cotiz_valor'] * ($resultado['cotiz_impuestos'] / 100)), 0, ",", ".");

if ($configu['conf_proveedor_cotizacion'] == 1) {
								$proveedor = mysql_fetch_array(mysql_query("SELECT * FROM proveedores WHERE prov_id='" . $resultado['cotiz_proveedor'] . "'", $conexion));
}