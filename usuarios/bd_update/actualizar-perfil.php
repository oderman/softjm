<?php   
require_once("../sesion.php");
require("../funciones-para-el-sistema.php");

if( !isset($_SERVER['HTTP_REFERER']) ){
    echo "No hay pagina de referencia de origen.";
    exit();
}

if( !str_contains($_SERVER['HTTP_REFERER'], "perfil-editar.php") || !isset($_SERVER['HTTP_REFERER']) ){
    echo "No estás accediendo correctamente.";
    exit();
}


if ($_FILES['foto']['name'] != "") {
    $extensionParte1 = explode(".", $_FILES['foto']['name']);
    $extension = end($extensionParte1);
    $foto = uniqid('fp_') . "." . $extension;
    $destino = "../files/fotos";
    move_uploaded_file($_FILES['foto']['tmp_name'], $destino . "/" . $foto);

    $conexionBdPrincipal->query("UPDATE usuarios SET usr_foto='" . $foto . "' WHERE usr_id='" . $_SESSION["id"] . "'");
}

$conexionBdPrincipal->query("UPDATE usuarios SET usr_login='" . $_POST["usuario"] . "', usr_nombre='" . $_POST["nombre"] . "', usr_email='" . $_POST["email"] . "' WHERE usr_id='" . $_SESSION["id"] . "'");

echo '<script type="text/javascript">window.location.href="../perfil-editar.php?msg=2";</script>';
exit();
