<?php
include("../sesion.php");

$search = $_GET["term"]; 

$sql = "SELECT prod_id, prod_referencia, prod_nombre, prod_existencias FROM productos WHERE prod_id_empresa='".$_SESSION["dataAdicional"]["id_empresa"]."' AND (prod_id LIKE '%$search%' OR prod_nombre LIKE '%$search%' OR prod_referencia LIKE '%$search%')";
$result = mysqli_query($conexionBdPrincipal, $sql);


$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = [

        "id" => $row["prod_id"],
        "text" => $row["prod_id"] . ". " . $row["prod_referencia"] . " " . strtoupper($row["prod_nombre"]) . " - [HAY " . $row["prod_existencias"] . "]",
    ];
}

echo json_encode($results);
?>
