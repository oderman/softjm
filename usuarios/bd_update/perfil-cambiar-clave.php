<?php
require_once("../sesion.php");
require_once("../../conexion.php");
require("../funciones-para-el-sistema.php");

$rst_usr = mysql_query("SELECT * FROM usuarios 
    WHERE usr_id='" . $_SESSION["id"] . "' AND usr_clave=SHA1('" . $_POST["claveActual"] . "')", $conexion);
if (mysql_errno() != 0) {
    echo informarErrorAlUsuario(__LINE__, mysql_error());
    exit();
}
$fila = mysql_fetch_array($rst_usr);
$num = mysql_num_rows($rst_usr);

if ($num > 0) {

    $validarClave = validarClave($_POST["clave"]);
    if($validarClave == '0'){
        echo '<script type="text/javascript">window.location.href="../perfil-editar.php?error=2";</script>';
        exit();
    }

    mysql_query("UPDATE usuarios SET  usr_clave=SHA1('" . $_POST["clave"] . "') WHERE usr_id='" . $_SESSION["id"] . "'", $conexion);
    if (mysql_errno() != 0) {
        echo informarErrorAlUsuario(__LINE__, mysql_error());
        exit();
    }

    echo '<script type="text/javascript">window.location.href="../perfil-editar.php?msg=2";</script>';
    exit();
} else {
    echo '<script type="text/javascript">window.location.href="../perfil-editar.php?error=1";</script>';
    exit();
}