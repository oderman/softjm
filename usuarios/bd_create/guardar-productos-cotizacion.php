<?php
//Productos
$numero = (count($_POST["producto"]));

if ($numero > 0):
    $contador = 0;
    while ($contador < $numero):

        $productoDatos = mysql_fetch_array(mysql_query("SELECT prod_id, prod_utilidad, prod_precio, prod_costo, prod_costo_dolar FROM productos 
            WHERE prod_id='" . $_POST["producto"][$contador] . "'", $conexion));
        if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}

        $valorProducto = $productoDatos['prod_precio'];

        if ($_POST["moneda"] == 2) {
                //$valorProducto = round(($productoDatos['prod_precio'] / $configu['conf_trm_compra']), 0);

            $valorProducto = productosPrecioListaUSD($productoDatos['prod_utilidad'], $productoDatos['prod_costo_dolar']);
        }

        mysql_query("INSERT INTO cotizacion_productos(czpp_cotizacion, czpp_producto, czpp_valor, czpp_orden, czpp_cantidad, czpp_impuesto, czpp_tipo, czpp_costo, czpp_utilidad_porcentaje)VALUES('" . $idInsert . "','" . $_POST["producto"][$contador] . "', '" . $valorProducto . "', '" . $contador . "', 1, 19, 1, '".$productoDatos['prod_costo']."', '".$productoDatos['prod_utilidad']."')", $conexion);
        if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}

        $contador++;

    endwhile;

endif;