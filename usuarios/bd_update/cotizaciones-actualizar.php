<?php
require_once("../sesion.php");

$idPagina = 25;
include(RUTA_PROYECTO."/usuarios/includes/verificar-paginas.php");

$consultaCli=$conexionBdPrincipal->query("SELECT * FROM clientes WHERE cli_id='".$_POST["cliente"]."'");
$datosCliente = mysqli_fetch_array($consultaCli, MYSQLI_BOTH);

$conexionBdPrincipal->query("UPDATE cotizacion SET 
cotiz_fecha_propuesta='" . $_POST["fechaPropuesta"] . "', 
cotiz_cliente='" . $_POST["cliente"] . "', 
cotiz_sucursal='" . $_POST["sucursal"] . "', 
cotiz_contacto='" . $_POST["contacto"] . "', 
cotiz_fecha_vencimiento='" . $_POST["fechaVencimiento"] . "', 
cotiz_vendedor='" . $_POST["influyente"] . "', 
cotiz_forma_pago='" . $_POST["formaPago"] . "', 
cotiz_moneda='" . $_POST["moneda"] . "', 
cotiz_ultima_modificacion=now(), 
cotiz_usuario_modificacion='" . $_SESSION["id"] . "', 
cotiz_observaciones='" . $conexionBdPrincipal->real_escape_string($_POST["notas"]) . "', 
cotiz_envio='" . $_POST["envio"] . "', 
cotiz_ocultar_descuento_combo='" . $_POST["dctoCombos"] . "', 
cotiz_descuentos_especiales='" . $_POST["dctoEspecial"] . "' 
WHERE cotiz_id='" . $_POST["id"] . "' AND  cotiz_id_empresa='".$_SESSION["dataAdicional"]["id_empresa"]."'");

if($_POST["monedaActual"] != $_POST["moneda"]){
    require('actualizar-productos-cotizacion-2.php');
    require('actualizar-combos-cotizacion-2.php');
    require('actualizar-servicios-cotizacion-2.php');
}

include(RUTA_PROYECTO."/usuarios/includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../cotizaciones-editar.php?id=' . $_POST["id"] . '&msg=2";</script>';
exit();
