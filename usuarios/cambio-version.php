<?php
session_start();
$_SESSION["id"] = $_GET["idSesion"];
echo '<script type="text/javascript">window.location.href="../v2.0/usuarios/empresa/lab-remisiones.php";</script>';
exit();
?>