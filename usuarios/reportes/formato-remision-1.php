<?php
session_start();
if($_GET["cte"]==1){
	$_GET["id"] = base64_decode($_GET["id"]);
}else{
	if($_SESSION["id"]=="")
	header("Location:../../salir.php");
}
?>

<?php include("../../conexion.php");?>

<?php
//CONFIGURACIÓN DEL PROGRAMA
$monedas = array("","COP","USD");
$simbolosMonedas = array("","$","USD");
?>

<?php
$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));

$resultado = mysql_fetch_array(mysql_query("SELECT * FROM remisionbdg
INNER JOIN clientes ON cli_id=remi_cliente
INNER JOIN sucursales ON sucu_id=remi_sucursal
INNER JOIN contactos ON cont_id=remi_contacto
INNER JOIN usuarios ON usr_id=remi_vendedor
WHERE remi_id='".$_GET["id"]."'",$conexion));
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Remisión <?=$resultado['remi_id'];?> (<?=$resultado['remi_propuesta'];?>) - <?=$resultado['remi_nombre'];?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<style type="text/css">
		#contenedor {
			/*max-height: 1122px;*/
			/*max-width: 793px;*/
		}

		.alinear {
			vertical-align: top;
		}
	</style>

	
</head>
<body style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<!--
<div style="text-align:left;"><img src="https://softjm.com/usuarios/files/logojm.png" width="300"></div>


<div style="width: 100%; height: 40px; background-color: #fbbd01; text-align: center; font-size: 20px; font-weight: bold;">
	<p style="padding: 10px;">COTIZACIÓN</p>
</div>
-->
<div class="container">
		<div class="text-center">
		<img src="../images/<?= $configuracion['conf_encabezado_cotizacion']; ?>" style="width: 100%;"><br>
		<img src="../images/remisionEncabezado.png" style="width: 100%;">	
		</div>
	

<?php
$formaPago = array("","CONTADO","CRÉDITO");
?>
<div style="margin: 10px;">
	<table width="100%">
		<tr>
			<td width="60%">
				<span style="font-size: 16px; font-weight: bold;">CLIENTE:</span><br>
				<?=strtoupper($resultado['cli_nombre']);?><br>
				<strong>NIT:</strong> <?=$resultado['cli_usuario'];?><br>
				<strong>DIRECCIÓN:</strong> <?=$resultado['cli_direccion'];?><br>
				<strong>EMAIL:</strong> <?=$resultado['cli_email'];?><br>
				<strong>TELÉFONO:</strong> <?=$resultado['cli_telefono'];?><br>
				<strong>CELULAR:</strong> <?=$resultado['cli_celular'];?><br>
				<strong>CONTACTO:</strong> <?=$resultado['cont_nombre'];?><br>
				
			</td>
			<td width="40%">
				<span style="font-size: 16px; font-weight: bold;">REMISIÓN # <?=$_GET["id"];?></span><br>
				<strong>FECHA PROPUESTA:</strong>  <?=$resultado['remi_fecha_propuesta'];?><br>
				<strong>FECHA VENCIMIENTO:</strong>  <?=$resultado['remi_fecha_vencimiento'];?><br>
				<strong>FORMA DE PAGO:</strong>  <?=$formaPago[$resultado['remi_forma_pago']];?><br>
				<strong>VENDEDOR:</strong>  <?=strtoupper($resultado['usr_nombre']);?><br>
				<strong>EMAIL:</strong>  <?=strtoupper($resultado['usr_email']);?>
			</td>
		</tr>
	</table>	
</div>	

<div style="margin: 10px; font-size: 10px;" align="center">
	<table width="100%" border="0" rules="groups">
		<thead>
			<tr style="background-color: #00002b; height: 50px; color: white;">
				<th>No</th>
				<th>&nbsp;</th>
                <th>Producto/Servicio</th>
                <th>Cant.</th> 
                <th>Valor</th>
                <th>IVA</th>
				<th>Dcto.</th>
                <th>SUBTOTAL</th>
			</tr>
		</thead>
		<tbody>

		<!-- COMBOS -->
		<?php
						$productos = mysql_query("SELECT * FROM combos
		INNER JOIN cotizacion_productos ON czpp_combo=combo_id AND czpp_cotizacion='" . $_GET["id"] . "' AND czpp_tipo=3
		ORDER BY czpp_orden", $conexion);


						while ($prod = mysql_fetch_array($productos)) {
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
								$fondo = 'lightgray';
							}

							$precioNormalCombo = mysql_fetch_array(mysql_query("SELECT SUM(copp_cantidad*prod_precio) FROM combos_productos
								INNER JOIN productos ON prod_id=copp_producto
								WHERE copp_combo='".$prod['combo_id']."'",$conexion));
						?>
							<tr style="height: 30px; background-color: <?= $fondo; ?>;">
								<td align="center"><?= $no; ?></td>
								<td align="center">
									<?php if ($prod['combo_imagen'] != "") { ?>
										<img src="../files/combos/<?= $prod['combo_imagen']; ?>" width="40">
									<?php } ?>
								</td>
								<td>
									<?= $prod['combo_nombre']; ?><br>

									<?php if($prod['combo_descuento']!="" and $resultado['cotiz_ocultar_descuento_combo']=='0'){?>
										<span><b>Precio Normal:</b> $<?=number_format($precioNormalCombo[0],0,".",".");?></span><br>
										<span><b>Descuento:</b> <?=$prod['combo_descuento'];?>%</span><br>
									<?php }?>

									<span style="font-size: 9px; color: darkblue;"><?= $prod['combo_descripcion']; ?></span><br>
									<span style="font-size: 9px; color: teal;">
										<?php
										$productosCombo = mysql_query("SELECT * FROM productos 
										INNER JOIN productos_categorias ON catp_id=prod_categoria
										INNER JOIN combos_productos ON copp_producto=prod_id AND copp_combo='" . $prod['combo_id'] . "'
										ORDER BY copp_id", $conexion);
										$c = 1;
										while ($prodCombo = mysql_fetch_array($productosCombo)) {
											if ($c == 1) {
												echo "<br><b>INCLUYE:</b><br>";
											}
											echo $prodCombo['prod_nombre'] . " (" . $prodCombo['copp_cantidad'] . " Unds.).<br>";
											$c++;
										}
										?>
									</span>
									<span style="font-size: 9px; color: darkblue;"><?= $prod['czpp_observacion']; ?></span>
								</td>
								<td align="center" class="alinear"><?= $prod['czpp_cantidad']; ?></td>
								<td align="center" class="alinear"><?= $simbolosMonedas[$resultado['cotiz_moneda']]; ?><?= number_format($prod['czpp_valor'], 0, ",", "."); ?></td>
								<td align="center" class="alinear"><?= $prod['czpp_impuesto']; ?>%</td>
								<td align="center" class="alinear"><?= $prod['czpp_descuento']; ?>%</td>
								<td align="right" class="alinear"><?= $simbolosMonedas[$resultado['cotiz_moneda']]; ?><?= number_format($valorTotal, 0, ",", "."); ?></td>
							</tr>
						<?php
							$no++;
						}
						?>


        <?php
		//Productos
		$no = 1;
		$productos = mysql_query("SELECT * FROM productos 
		INNER JOIN productos_categorias ON catp_id=prod_categoria
		INNER JOIN cotizacion_productos ON czpp_producto=prod_id AND czpp_cotizacion='".$_GET["id"]."' AND czpp_tipo=3
		LEFT JOIN bodegas ON bod_id=czpp_bodega
		ORDER BY czpp_orden",$conexion);
		while($prod = mysql_fetch_array($productos)){

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
						$total += $subtotal;

			
			$fondo = 'white';
			if($no%2==0){$fondo = 'lightgray';}
		?>
			<tr style="height: 30px; background-color: <?=$fondo;?>;">
				<td align="center"><?=$no;?></td>
				<td align="center">
					<?php if($prod['prod_foto']!=""){?>
						<img src="../files/productos/<?=$prod['prod_foto'];?>" width="40">
					<?php }?>
				</td>
                <td>
					<?="<b>".$prod['prod_referencia']."</b> ".$prod['prod_nombre'];?><br>
					<span style="font-size: 9px; color: darkblue;"><?=$prod['czpp_observacion'];?></span><br>
					<span style="font-size: 9px; color: tomato;"><?=$prod['bod_nombre'];?></span><br>
				</td>
                <td align="center"><?=$prod['czpp_cantidad'];?></td>
                <td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($prod['czpp_valor'],0,",",".");?></td>
                <td align="center"><?=$prod['czpp_impuesto'];?>%</td>
				<td align="center"><?=$prod['czpp_descuento'];?>%</td>
                <td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($valorTotal,0,",",".");?></td>
			</tr>
		<?php 
			$no ++;
		}
		?>
			
		<?php
		$productos = mysql_query("SELECT * FROM servicios
		INNER JOIN cotizacion_productos ON czpp_servicio=serv_id AND czpp_cotizacion='".$_GET["id"]."' AND czpp_tipo=3
		ORDER BY czpp_orden",$conexion);
		while($prod = mysql_fetch_array($productos)){
			$valorTotal += ($prod['czpp_valor'] * $prod['czpp_cantidad']);
						
			$totalIva += ($prod['czpp_cantidad'] * ($prod['czpp_valor'] * ($prod['czpp_impuesto']/100)));
									
			$valorTotal = $prod['czpp_valor'] + ($prod['czpp_valor'] * ($prod['czpp_impuesto']/100));
								
			if($prod['czpp_cantidad']>0 and $prod['czpp_descuento']>0){
				$totalDescuento += $prod['czpp_cantidad'] * ($valorTotal * ($prod['czpp_descuento']/100));
			}
								
			$valorTotal = $valorTotal - ($valorTotal * ($prod['czpp_descuento']/100));
									
			$subtotal = ($prod['czpp_cantidad'] * $valorTotal);
			$total +=$subtotal;
								
						
			$totalCantidad += $prod['czpp_cantidad'];
			
			$fondo = 'white';
			if($no%2==0){$fondo = 'lightgray';}
		?>
		<tr style="height: 30px; background-color: <?=$fondo;?>;">
				<td align="center"><?=$no;?></td>
				<td align="center">&nbsp;</td>
                <td>
					<?=$prod['serv_nombre'];?><br>
					<span style="font-size: 9px; color: darkblue;"><?=$prod['czpp_observacion'];?></span>
				</td>
                <td align="center"><?=$prod['czpp_cantidad'];?></td>
                <td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($prod['czpp_valor'],0,",",".");?></td>
                <td align="center"><?=$prod['czpp_impuesto'];?>%</td>
				<td align="center"><?=$prod['czpp_descuento'];?>%</td>
                <td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($subtotal,0,",",".");?></td>
			</tr>
		<?php 
			$no ++;
		}
		?>		
		</tbody>

		<?php
					$total = $subtotal - $totalDescuento;
					$total += $totalIva;

					?>
			
		<tfoot>
			<tr style="font-weight: bold; font-size: 13px; height: 30px;">
				<td colspan="6" rowspan="4">
						<!--
						<div style="text-align: justify; font-size: 10px; font-weight: normal;">
							<h3>Términos y condiciones</h3>
							<strong>GARANTÍA:</strong> Un año por desperfectos de fabricación para los equipos 3 meses para los accesorios.<br><br>
							<strong>TIEMPO DE ENTREGA:</strong> Si se encuentra en Stock sería inmediatamente, de lo contrario 20 días aproximadamente.
						</div>
						-->
						<?=$resultado['remi_observaciones'];?>
				</td>
				<td style="text-align: right;">SUBTOTAL</td>
				<td align="right""><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($subtotal,0,",",".");?></td>
			</tr>
			<tr style="font-weight: bold; font-size: 13px; height: 30px;">

				<td style="text-align: right;">DESCUENTO</td>
				<td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($totalDescuento,0,",",".");?></td>
			</tr>
			<tr style="font-weight: bold; font-size: 13px; height: 30px;">

				<td style="text-align: right;">IVA</td>
				<td align="right"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($totalIva,0,",",".");?></td>
			</tr>
			<tr style="font-weight: bold; font-size: 13px; height: 30px;">

				<td style="text-align: right; background-color: #3a3864; color: white;">TOTAL NETO</td>
				<td align="right" style="background-color: #3a3864; color: white;"><?=$simbolosMonedas[$resultado['remi_moneda']];?><?=number_format($total,0,",",".");?></td>
			</tr>
		</tfoot>	
								
	</table>
	
		
	
	</div>	
	


	
	<p>&nbsp;</p>
	<div class="text-center">
			<p><img src="../images/<?= $configuracion['conf_pie_cotizacion']; ?>" style="width: 100%;"></p>
		</div>

		</div>

</body>

<script type="application/javascript"> 
	print();
</script>	
</html>