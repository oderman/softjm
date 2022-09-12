<?php
//Servicios
    $numero = (count($_POST["servicio"]));
    if ($numero > 0) {
        $contador = 0;
        while ($contador < $numero) {
            $productoDatos = mysql_fetch_array(mysql_query("SELECT * FROM servicios WHERE serv_id='" . $_POST["servicio"][$contador] . "'", $conexion));
            if (mysql_errno() != 0) {
                echo informarErrorAlUsuario(__LINE__, mysql_error());
                exit();
            }

            $valorProducto = $productoDatos['serv_precio'];
            if ($_POST["moneda"] == 2) {
                $valorProducto = round(($productoDatos['serv_precio'] / $configu['conf_trm_compra']), 0);
            }

            mysql_query("INSERT INTO cotizacion_productos(czpp_cotizacion, czpp_servicio, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo)VALUES('" . $idInsert . "','" . $_POST["servicio"][$contador] . "', '" . $valorProducto . "', '" . $contador . "', 1, 19, 1)", $conexion);
            if (mysql_errno() != 0) {
                echo informarErrorAlUsuario(__LINE__, mysql_error());
                exit();
            }
            $contador++;
        }
    }