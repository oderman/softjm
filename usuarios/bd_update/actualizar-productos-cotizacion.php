<?php
//PRODUCTOS
$numero = (count($_POST["producto"]));
if ($numero > 0) {

    $contador = 0;
    while ($contador < $numero):

        /*$productoNum = mysql_fetch_array(mysql_query("SELECT * FROM cotizacion_productos 
            WHERE czpp_cotizacion='" . $_POST["id"] . "' AND czpp_producto='" . $_POST["producto"][$contador] . "'", $conexion));*/

        //Se obtienen uno por uno los datos completos de los productos que vienen en el array y .
        $productoDatos = mysql_fetch_array(mysql_query("SELECT prod_id, prod_utilidad, prod_precio, prod_costo, prod_costo_dolar,
czpp_id, czpp_producto, czpp_valor, czpp_cotizacion 
         FROM productos
         LEFT JOIN cotizacion_productos ON czpp_producto=prod_id AND czpp_cotizacion='" . $_POST["id"] . "'
        WHERE prod_id='" . $_POST["producto"][$contador] . "'", $conexion));
        if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}


        /* 
        * Si el producto NO está asociado a la cotización.
        */
        if ($productoDatos['czpp_id'] == '') {

            //Para pesos colombianos
            $valorProducto = $productoDatos['prod_precio'];
            
            //Si la cotización ya está en USD
            if ($_POST["moneda"] == 2) {
                $valorProducto = productosPrecioListaUSD($productoDatos['prod_utilidad'], $productoDatos['prod_costo_dolar']);
            }

            mysql_query("INSERT INTO cotizacion_productos(czpp_cotizacion, czpp_producto, czpp_cantidad, czpp_impuesto, czpp_descuento, czpp_valor, czpp_orden, czpp_tipo, czpp_costo, czpp_utilidad_porcentaje)VALUES('" . $_POST["id"] . "','" . $_POST["producto"][$contador] . "', 1, 19, 0, '" . $valorProducto . "', '" . $numero . "', 1, '".$productoDatos['prod_costo']."', '".$productoDatos['prod_utilidad']."')", $conexion);
                
                if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}

            } else {
                if ($_POST["monedaActual"] != $_POST["moneda"]) {
                    
                    //Si cambió a pesos colombianos
                    if ($_POST["moneda"] == 1) {
                        $valorProducto = round(($productoDatos['czpp_valor'] * $configu['conf_trm_venta']), 0);
                    }
                    //Si cambió a Dolares
                    else {
                        
                        $valorProducto = productosPrecioListaUSD($productoDatos['prod_utilidad'], $productoDatos['prod_costo_dolar']);
                    }

                    mysql_query("UPDATE cotizacion_productos SET czpp_valor='" . $valorProducto . "' WHERE czpp_id='" . $productoDatos['czpp_id'] . "'", $conexion);
                    
                    if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}
                }
            }

            $contador++;
    endwhile;


    //ELIMINAR LOS QUE YA NO ESTÁN EN LA COTIZACIÓN.
    $productosEnCotizacion = mysql_query("SELECT * FROM cotizacion_productos 
    WHERE czpp_cotizacion='" . $_POST["id"] . "'", $conexion);
        
    while ($pec = mysql_fetch_array($productosEnCotizacion)):

        $encontrado = 0;
        $contador = 0;
        while ($contador < $numero):

            if ($pec['czpp_producto'] == $_POST["producto"][$contador]) {
                $encontrado = 1;
                break;
            }

            $contador++;

        endwhile;

        if ($encontrado == 0):
            mysql_query("DELETE FROM cotizacion_productos 
            WHERE czpp_producto='" . $pec['czpp_producto'] . "' AND czpp_cotizacion='" . $_POST["id"] . "'", $conexion);

            if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}
        endif;

    endwhile;

} else {
    mysql_query("DELETE FROM cotizacion_productos 
    WHERE czpp_cotizacion='" . $_POST["id"] . "' AND czpp_servicio IS NULL AND czpp_combo IS NULL", $conexion);
        
    if (mysql_errno() != 0) {echo informarErrorAlUsuario(__LINE__, mysql_error()); exit();}
}