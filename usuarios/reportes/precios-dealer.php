<?php include("../sesion.php"); ?>
<?php include("../../conexion.php"); ?>
<?php $configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1", $conexion)); ?>
<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>INFORMES - PRECIOS DEALER</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">

	<h1 style="text-align:center;">INFORMES</h1>
	<h2 style="text-align:center;">PRECIOS DEALER</h2>
	<div align="center" style="margin-bottom:5px;"><img src="../files/<?= $configuracion['conf_logo']; ?>" height="100" alt="<?= $configuracion['conf_empresa']; ?>"></div>
	<table width="100%" border="1" rules="all" align="center">
		<thead>
			<tr style="height:30px; background-color: blue; color: white;">
				<th>No</th>
				<th>ID</th>
				<th>CÓDIGO</th>
				<th>Nombre</th>
				<th>Costo</th>
				<th title="Sobre el precio de lista.">Utilidad Dealer. (%)</th>
				<th>Precio dealer</th>
				<th>Existencia</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$consulta = mysql_query("SELECT * FROM productos 
							LEFT JOIN productos_categorias ON catp_id=prod_categoria
							WHERE prod_descuento2>0
							", $conexion);

			while ($res = mysql_fetch_array($consulta)) {
				$utilidadDealer = $res['prod_descuento2'] / 100;
				$precioDealer = $res['prod_costo'] + ($res['prod_costo'] * $utilidadDealer);
			?>
				<tr>
					<td align="center"><?= $no; ?></td>
					<td align="center"><?= $res['prod_id']; ?></td>
					<td align="center"><?= $res['prod_referencia']; ?></td>
					<td><?= $res['prod_nombre']; ?></td>
					<td>$<?= number_format($res['prod_costo'], 0, ",", "."); ?></td>
					<td align="center"><?= $res['prod_utilidad']; ?></td>
					<td>$<?= number_format($precioDealer, 0, ",", "."); ?></td>
					<td align="center"><?= $res['prod_existencias']; ?></td>
				</tr>
			<?php $no++;
			} ?>
		</tbody>
	</table>

</body>

</html>