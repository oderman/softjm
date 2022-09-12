<?php
//SERVICIOS
    $numero = (count($_POST["servicio"]));
    if ($numero > 0) {
        $contador = 0;
        while ($contador < $numero) {

            $productoNum = mysql_fetch_array(mysql_query("SELECT * FROM cotizacion_productos WHERE czpp_cotizacion='" . $_POST["id"] . "' AND czpp_servicio='" . $_POST["servicio"][$contador] . "'", $conexion));
            if (mysql_errno() != 0) {
                echo informarErrorAlUsuario(__LINE__, mysql_error());
                exit();
            }


            if ($productoNum['czpp_id'] == '') {
                $productoDatos = mysql_fetch_array(mysql_query("SELECT * FROM servicios WHERE serv_id='" . $_POST["servicio"][$contador] . "'", $conexion));
                if (mysql_errno() != 0) {
                    echo informarErrorAlUsuario(__LINE__, mysql_error());
                    exit();
                }

                $valorProducto = $productoDatos['serv_precio'];
                if ($_POST["moneda"] == 2) {
                    $valorProducto = round(($productoDatos['serv_precio'] / $configu['conf_trm_compra']), 0);
                }

                mysql_query("INSERT INTO cotizacion_productos(czpp_cotizacion, czpp_servicio, czpp_cantidad, czpp_impuesto, czpp_descuento, czpp_valor, czpp_orden, czpp_tipo)VALUES('" . $_POST["id"] . "','" . $_POST["servicio"][$contador] . "', 1, 19, 0, '" . $valorProducto . "', '" . $numero . "', 1)", $conexion);
                if (mysql_errno() != 0) {
                    echo informarErrorAlUsuario(__LINE__, mysql_error());
                    exit();
                }
            } else {
                if ($_POST["monedaActual"] != $_POST["moneda"]) {
                    //Si cambió a pesos colombianos
                    if ($_POST["moneda"] == 1) {
                        $valorProducto = round(($productoNum['czpp_valor'] * $configu['conf_trm_venta']), 0);
                    }
                    //Si cambió a Dolares
                    else {
                        $valorProducto = round(($productoNum['czpp_valor'] / $configu['conf_trm_compra']), 0);
                    }

                    mysql_query("UPDATE cotizacion_productos SET czpp_valor='" . $valorProducto . "' WHERE czpp_id='" . $productoNum['czpp_id'] . "'", $conexion);
                    if (mysql_errno() != 0) {
                        echo informarErrorAlUsuario(__LINE__, mysql_error());
                        exit();
                    }
                }
            }

            $contador++;
        }

        //ELIMINAR LOS SERVICIOS QUE YA NO ESTÁN EN LA COTIZACIÓN.
        $productosWebServicio = mysql_query("SELECT * FROM cotizacion_productos WHERE czpp_cotizacion='" . $_POST["id"] . "'", $conexion);
        while ($pWebServicio = mysql_fetch_array($productosWebServicio)) {

            $encontrado = 0;
            $contador = 0;
            while ($contador < $numero) {

                if ($pWebServicio['czpp_servicio'] == $_POST["servicio"][$contador]) {
                    $encontrado = 1;
                    break;
                }

                $contador++;
            }

            if ($encontrado == 0) {
                mysql_query("DELETE FROM cotizacion_productos WHERE czpp_servicio='" . $pWebServicio['czpp_servicio'] . "' AND czpp_cotizacion='" . $_POST["id"] . "'", $conexion);
                if (mysql_errno() != 0) {
                    echo informarErrorAlUsuario(__LINE__, mysql_error());
                    exit();
                }
            }
        }
    } else {
        mysql_query("DELETE FROM cotizacion_productos WHERE czpp_cotizacion='" . $_POST["id"] . "' AND czpp_combo IS NULL AND czpp_producto IS NULL", $conexion);
        if (mysql_errno() != 0) {
            echo informarErrorAlUsuario(__LINE__, mysql_error());
            exit();
        }
    }