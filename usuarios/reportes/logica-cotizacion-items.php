<?php
$dcto = 0;
$valorTotal = 0;

$valorTotal = ($prod['czpp_valor'] * $prod['czpp_cantidad']);

if ($prod['czpp_cantidad'] > 0 and $prod['czpp_descuento'] > 0) {
	$dcto = ($valorTotal * ($prod['czpp_descuento'] / 100));
	$totalDescuento += $dcto;
}

$valorConDcto = $valorTotal - $dcto;

$totalIva += ($valorConDcto * ($prod['czpp_impuesto'] / 100));

$subtotal += $valorTotal;

$totalCantidad += $prod['czpp_cantidad'];

$fondo = 'white';
if ($no % 2 == 0) {
	$fondo = '#f8f9fa';
}