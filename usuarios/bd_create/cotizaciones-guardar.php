<?php
require_once("../sesion.php");
require_once("../../conexion.php");
include("../config/config.php");
require("../funciones-para-el-sistema.php");

$datosCliente = mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE cli_id='".$_POST["cliente"]."'",$conexion));

    mysql_query("INSERT INTO cotizacion(cotiz_fecha_propuesta, cotiz_cliente, cotiz_fecha_vencimiento, cotiz_vendedor, cotiz_creador, cotiz_sucursal, cotiz_contacto, cotiz_forma_pago, cotiz_fecha_creacion, cotiz_moneda, cotiz_observaciones, cotiz_envio, cotiz_proveedor)VALUES('" . $_POST["fechaPropuesta"] . "','" . $_POST["cliente"] . "','" . $_POST["fechaVencimiento"] . "','" . $_POST["influyente"] . "','" . $_SESSION["id"] . "','" . $_POST["sucursal"] . "','" . $_POST["contacto"] . "','" . $_POST["formaPago"] . "',now(),'" . $_POST["moneda"] . "','" . $_POST["notas"] . "','" . $_POST["envio"] . "','" . $_POST["proveedor"] . "')", $conexion);
    if (mysql_errno() != 0) {
        echo informarErrorAlUsuario(__LINE__, mysql_error());
        exit();
    }
    $idInsert = mysql_insert_id();

    require("guardar-productos-cotizacion.php");

    require("guardar-combos-cotizacion.php");

    require("guardar-servicios-cotizacion.php");

    echo '<script type="text/javascript">window.location.href="../cotizaciones-editar.php?id=' . $idInsert . '&msg=1";</script>';
    exit();