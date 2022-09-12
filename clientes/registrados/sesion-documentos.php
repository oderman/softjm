<?php
session_start();
if($_SESSION["idDoc"]=="")
header("Location:clave-documentos.php?sesionDoc=no");
?>