<?php
require_once("../sesion.php");

$idPagina = 52;
include(RUTA_PROYECTO."/usuarios/includes/verificar-paginas.php");

if ($_FILES['foto']['name'] != "") {
    $destino = RUTA_PROYECTO."/usuarios/files/fotos";
    $fileName = subirArchivosAlServidor($_FILES['foto'], 'fp', $destino);

    $conexionBdPrincipal->query("UPDATE usuarios SET usr_foto='" . $fileName . "' WHERE usr_id='" . $_POST["id"] . "'");
}
$usuario = $_POST["usuario"] . $_POST["dominio"];
$conexionBdPrincipal->query("UPDATE usuarios SET usr_login='" . $usuario . "', usr_nombre='" . $_POST["nombre"] . "', usr_email='" . $_POST["email"] . "', usr_tipo='" . $_POST["tipoU"] . "', usr_ciudad='" . $_POST["ciudad"] . "', usr_area='" . $_POST["area"] . "', usr_bloqueado='" . $_POST["bloqueado"] . "', usr_intentos_fallidos='" . $_POST["fallidos"] . "', usr_sucursal='" . $_POST["sucursal"] . "', usr_meta_ventas='" . $_POST["metaVentas"] . "'
WHERE usr_id='" . $_POST["id"] . "'");

// Actualizar roles del usuario
$idUsuario = $_POST["id"];
$rolesSeleccionados = $_POST['tipoU'];
$upr_fec = date("Y-m-d H:i:s");
$upr_responsable = $_SESSION["id"];
$conexionBdAdmin->query("DELETE FROM usuarios_roles WHERE upr_id_usuario = '$idUsuario'");
foreach ($rolesSeleccionados as $rol) {
    $conexionBdAdmin->query("INSERT INTO usuarios_roles (upr_id_usuario, upr_id_rol, upr_fec, upr_responsable) VALUES ('$idUsuario', '$rol', '$upr_fec', '$upr_responsable')");
}


include(RUTA_PROYECTO."/usuarios/includes/guardar-historial-acciones.php");

echo '<script type="text/javascript">window.location.href="../usuarios-editar.php?id=' . $_POST["id"] . '&msg=2";</script>';
exit();