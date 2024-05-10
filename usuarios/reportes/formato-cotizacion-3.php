<?php
error_reporting(0);
require_once("../sesion.php");
$idPagina = 50;
require_once("logica-cotizacion.php");

$consulta=$conexionBdAdmin->query("SELECT * FROM documentos_configuracion WHERE dconf_id_empresa= '".$idEmpresa."' AND dconf_id_documento='".ID_DOC_COTIZACION."';");
$configuracionDoc = mysqli_fetch_array($consulta, MYSQLI_BOTH);
$fontLink = "https://fonts.googleapis.com/css2?family=" . str_replace(' ', '+', $configuracionDoc["dconf_estilo_letra"]) . "&display=swap";

$estilos = !empty($configuracionDoc['dconf_estilo']) ? $configuracionDoc['dconf_estilo'] : "#0033a0";
$estilosLetra = !empty($configuracionDoc['dconf_estilo_letra']) ? $configuracionDoc['dconf_estilo_letra'] : "Verdana, sans-serif";
$tamañoLetra = !empty($configuracionDoc['dconf_tamano_letra']) ? $configuracionDoc['dconf_tamano_letra'] : "11";

require_once(RUTA_PROYECTO.'/librerias/TCPDF/tcpdf.php');

ob_start(); // Iniciar el buffer de salida
// Crear nueva instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información básica del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Autor');
$pdf->SetTitle('Cotización ' . $resultado['cotiz_id'] . ' (' . $resultado['cotiz_fecha_propuesta'] . ') - ' . $resultado['cli_nombre']);
$pdf->SetSubject('Cotización');
$pdf->SetKeywords('Cotización, PDF, TCPDF');

// Establecer márgenes
$pdf->SetMargins(10, 10, 10);

// Establecer fuente predeterminada
$pdf->SetFont('helvetica', '', 10);

// Agregar una nueva página
$pdf->AddPage();

// Definir contenido HTML
$html = '
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cotización ' . $resultado['cotiz_id'] . ' (' . $resultado['cotiz_fecha_propuesta'] . ') - ' . $resultado['cli_nombre'] . '</title>
	<link rel="stylesheet" href="'.$fontLink.'">
    <style>
		.container { width: 100%; }
		.text-center { text-align: center; }
		.text-left { text-align: left; }
		.text-right { text-align: right; }
		.card { border: 1px solid #000; }
		.card-title { font-size: 16px; }
		.card-subtitle { font-size: 14px; }
		.card-text { font-size: 12px; }
		.border { border: 1px solid #000; }
		.border-dark { border-color: #000; }
		.rounded { border-radius: 5px; }
		.p-2 { padding: 10px; }
		.table { width: 100%; border-collapse: collapse; }
		.table th, .table td { border: 1px solid #000; padding: 8px; }
		.thead-dark th { background-color: #0033a0; color: #fff; }
		.alinear { vertical-align: top; }
    </style>
</head>
<body style="font-family:'.$estilosLetra.'; font-size:'.$tamañoLetra.'px;">
<div style="width: 100%;">
    <div class="text-center">
        <img src="../images/' . $configuracion['conf_encabezado_cotizacion'] . '" style="width: 100%;"><br>
        <img src="0033a0.png" style="width: 100%;">
    </div>
	<div id="contenedor">
		<div style="width: 50%; text-align: left; margin-top: 10px;">
			<div class="row align-items-center">
				<div class="col-8" style="padding-left: 10px;">
					<div class="card border border-dark" style="width: 25rem;">
						<div class="card-body">
							<h5 class="card-title">'.strtoupper($resultado['cli_nombre']).'</h5>
							<h6 class="card-subtitle mb-2 text-muted">NIT: '.$resultado['cli_usuario'].'</h6>
							<p class="card-text">
								<strong>DIRECCIÓN:</strong> '.$resultado['cli_direccion'].'<br>
								<strong>EMAIL:</strong> '.$resultado['cont_email'].'<br>
								<strong>TELÉFONO:</strong> '.$resultado['cli_telefono'].'<br>
								<strong>CELULAR:</strong> '.$resultado['cli_celular'].'<br>
								<strong>CONTACTO:</strong> '.$resultado['cont_nombre'].'<br>
							</p>
						</div>
					</div>
				</div>
				<div class="col-3 text-right">
					<div class="card border border-dark" style="width: 18rem;">
						<div class="card-body">
							<h5 class="card-title">COTIZACIÓN # '.$_GET["id"].'</h5>
							<p class="card-text">
								<strong>FECHA PROPUESTA:</strong> '.$resultado['cotiz_fecha_propuesta'].'<br>
								<strong>FECHA VENCIMIENTO:</strong> '.$resultado['cotiz_fecha_vencimiento'].'<br>
								<strong>FORMA DE PAGO:</strong> '.$formaPago[$resultado['cotiz_forma_pago']].'<br>
								<strong>VENDEDOR:</strong> '.strtoupper($resultado['usr_nombre']).'<br>
								<strong>EMAIL:</strong> '.strtoupper($resultado['usr_email']).'
							</p>
							';
							if ($configuracion['conf_proveedor_cotizacion'] == 1) {
								$html .= '
								<p class="border border-warning p-2">
									<span style="font-size: 12px; font-weight: bold;">NEGOCIO EN REPRESENTACIÓN<br>COMERCIAL DE</span><br>
									'.strtoupper($proveedor['prov_nombre']).'<br>
									DNI: '.strtoupper($proveedor['prov_documento']).'
								</p>
							'; }
							$html .= '
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="border border-dark rounded p-2" style="margin: 10px; font-size: 12px;" align="center">
			<table width="100%" border="0" rules="groups">
				<thead>
					<tr style="background-color: '.$estilos.'; height: 50px; color: white;">
						<th>No</th>
						<th>&nbsp;</th>
						<th>Producto/Servicio</th>
						<th>Cant.</th>
						<th width="20%">Valor Unitario</th>
						<th>IVA</th>
						<th>Dcto.</th>
						<th>VALOR TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<!-- COMBOS -->';
					$no = 1;
					$productos = $conexionBdPrincipal->query("SELECT * FROM combos
						INNER JOIN cotizacion_productos ON czpp_combo=combo_id AND czpp_cotizacion='" . $_GET["id"] . "'
						WHERE combo_id_empresa='" . $idEmpresa . "'
						ORDER BY czpp_orden");
					$totalIva = 0;
					$subtotal = 0;
					$totalDescuento = 0;
					while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
						require("logica-cotizacion-items.php");
						$precioNormalCombo = mysqli_fetch_array($conexionBdPrincipal->query("SELECT SUM(copp_cantidad*prod_precio) FROM combos_productos
							INNER JOIN productos ON prod_id=copp_producto
							WHERE copp_combo='" . $prod['combo_id'] . "'"), MYSQLI_BOTH);
				$html .= '<tr style="height: 30px; background-color: '.$fondo.';">
							<td align="center">'.$no.'</td>
							<td align="center">';
								if ($prod['combo_imagen'] != "") { 
									$html .= '<img src="../files/combos/'.$prod['combo_imagen'].'" width="40">';
								}
								$html .= '</td>
							<td>
								'.$prod['combo_nombre'].'<br>';
								if ($prod['combo_descuento'] != "" and $resultado['cotiz_ocultar_descuento_combo'] == '0') {
									$html .= '<span><b>Precio Normal:</b> $'.number_format($precioNormalCombo[0], 0, ".", ".").'</span><br>
									<span><b>Descuento:</b> '.$prod['combo_descuento'].'%</span><br>';
								}
								$html .= '<span style="font-size: 9px; color: darkblue;">'.$prod['combo_descripcion'].'</span><br>
								<span style="font-size: 9px; color: teal;">';
									$productosCombo = $conexionBdPrincipal->query("SELECT prod_id, prod_nombre, copp_cantidad FROM productos 
											INNER JOIN combos_productos ON copp_producto=prod_id AND copp_combo='" . $prod['combo_id'] . "'
											WHERE prod_id_empresa='" . $idEmpresa . "'
											ORDER BY copp_id");
									$c = 1;
									while ($prodCombo = mysqli_fetch_array($productosCombo, MYSQLI_BOTH)) {
										if ($c == 1) {
											echo "<br><b>INCLUYE:</b><br>";
										}
										echo $prodCombo['prod_nombre'] . " (" . $prodCombo['copp_cantidad'] . " Unds.).<br>";
										$c++;
									}
									$html .= '</span>
								<span style="font-size: 9px; color: darkblue;">'.$prod['czpp_observacion'].'</span>
							</td>
							<td align="center" class="alinear">'.$prod['czpp_cantidad'].'</td>
							<td align="center" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($prod['czpp_valor'], 0, ",", ".").'</td>
							<td align="center" class="alinear">'.$prod['czpp_impuesto'].'%</td>
							<td align="center" class="alinear">
								'.$prod['czpp_descuento'].'% <br>
								<?php
								if ($dcto > 0)
									echo "$" . number_format($dcto, 0, ".", ".");
								?>
							</td>
							<td align="right" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($valorTotal, 0, ",", ".").'</td>
						</tr>';
						$no++;
					}
					$productos = $conexionBdPrincipal->query("SELECT * FROM productos 
							INNER JOIN productos_categorias ON catp_id=prod_categoria
							INNER JOIN cotizacion_productos ON czpp_producto=prod_id AND czpp_cotizacion='" . $_GET["id"] . "'
							WHERE prod_id_empresa='" . $idEmpresa . "'
							ORDER BY czpp_orden");
					while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
						require("logica-cotizacion-items.php");
						$html .= '<tr style="height: 30px; background-color: '.$fondo.';">
							<td align="center">'.$no.'</td>
							<td align="center">';
								if ($prod['prod_foto'] != "") {
									$html .= '<img src="../files/productos/'.$prod['prod_foto'].'" width="40">';
								}
								$html .= '</td>
							<td>
								'.$prod['prod_nombre'].'<br>
								<span style="font-size: 9px; color: #0033a0;">'.$prod['prod_descripcion_corta'].'</span><br>
								<span style="font-size: 9px; color: #0033a0;">'.$prod['czpp_observacion'].'</span>
							</td>
							<td align="center" class="alinear">'.$prod['czpp_cantidad'].'</td>
							<td align="center" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($prod['czpp_valor'], 0, ",", ".").'</td>
							<td align="center" class="alinear">'.$prod['czpp_impuesto'].'%</td>
							<td align="center" class="alinear">
								'.$prod['czpp_descuento'].'%<br>';
								if ($dcto > 0){
									$html .= '<span style="font-size:9px; color: blue;">$' . number_format($dcto, 0, ".", ".") . '</span>';
								}
								$html .= '</td>
							<td align="right" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($valorTotal, 0, ",", ".").'</td>
						</tr>';
						$no++;
					}
					$productos = $conexionBdPrincipal->query("SELECT * FROM servicios
							INNER JOIN cotizacion_productos ON czpp_servicio=serv_id AND czpp_cotizacion='" . $_GET["id"] . "'
							WHERE serv_id_empresa='" . $idEmpresa . "'
							ORDER BY czpp_orden");
					while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
						require("logica-cotizacion-items.php");
						$html .= '<tr style="height: 30px; background-color: '.$fondo.';">
							<td align="center">'.$no.'</td>
							<td align="center">&nbsp;</td>
							<td>
								'.$prod['serv_nombre'].'<br>
								<span style="font-size: 9px; color: darkblue;">'.$prod['czpp_observacion'].'</span>
							</td>
							<td align="center" class="alinear">'.$prod['czpp_cantidad'].'</td>
							<td align="center" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($prod['czpp_valor'], 0, ",", ".").'</td>
							<td align="center" class="alinear">'.$prod['czpp_impuesto'].'%</td>
							<td align="center" class="alinear">'.$prod['czpp_descuento'].'%</td>
							<td align="right" class="alinear">'.$simbolosMonedas[$resultado['cotiz_moneda']].''.number_format($valorTotal, 0, ",", ".").'</td>
						</tr>';
						$no++;
					}
					if ($resultado['cotiz_envio'] == '') {
						$envio = 0;
					} else {
						$envio = $resultado['cotiz_envio'];
					}
					$total = $subtotal - $totalDescuento + $totalIva + $envio;
					$html .= '</tbody>
				<tfoot>
					<tr style="font-weight: bold; font-size: 13px; height: 20px;">
						<td colspan="3" rowspan="5" class="alinear">
							<div style="height: 95px; display:block;">
								OBSERVACIONES:<br>
								<span style="font-size: 11px; font-weight: normal;">'.$resultado['cotiz_observaciones'].'</span>
							</div>
						</td>
						<td style="text-align: right;" colspan="3">SUBTOTAL '.$simbolosMonedas[$resultado['cotiz_moneda']].'</td>';
						if (isset($subtotal)){
							$html .= '<td align="right" colspan="2">'.number_format($subtotal, 0, ",", ".").'</td>';
						}else{
							$html .= '<td align="right" colspan="2"></td>';
						}
					$html .= '</tr>
					<tr style="font-weight: bold; font-size: 13px; height: 20px;">
						<td style="text-align: right;" colspan="3">DESCUENTO '.$simbolosMonedas[$resultado['cotiz_moneda']].'</td>';
						if (isset($totalDescuento)){
							$html .= '<td align="right" colspan="2">'.number_format($totalDescuento, 0, ",", ".").'</td>';
						}else{
							$html .= '<td align="right" colspan="2"></td>';
						}
					$html .= '</tr>
					<tr style="font-weight: bold; font-size: 13px; height: 20px;">
						<td style="text-align: right;" colspan="3">IVA '.$simbolosMonedas[$resultado['cotiz_moneda']].'</td>';
						if (isset($totalIva)){
							$html .= '<td align="right" colspan="2">'.number_format($totalIva, 0, ",", ".").'</td>';
						}else{
							$html .= '<td align="right" colspan="2"></td>';
						}
					$html .= '</tr>
					<tr style="font-weight: bold; font-size: 13px; height: 20px;">
						<td style="text-align: right;" colspan="3">ENVÍO '.$simbolosMonedas[$resultado['cotiz_moneda']].'</td>';
						if (isset($resultado)){
							$html .= '<td align="right" colspan="2">'.number_format(floatval($resultado['cotiz_envio']), 0, ",", ".").'</td>';
						}else{
							$html .= '<td align="right" colspan="2"></td>';
						}
					$html .= '</tr>
					<tr style="font-weight: bold; font-size: 13px; height: 20px;">
						<td style="text-align: right; background-color: '.$estilos.'; color:white;" colspan="3">TOTAL NETO '.$simbolosMonedas[$resultado['cotiz_moneda']].'</td>
						<td align="right" style="background-color:  '.$estilos.'; color:white;" colspan="2">'.number_format($total, 0, ",", ".").'</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="border border-dark rounded p-2 m-2">
		<img src="condicionesCoti.png" style="width: 100%;">
	</div>
	<p>&nbsp;</p>
	<div class="text-center" style="display:block;">
		<p><img src="../images/'.$configuracion['conf_pie_cotizacion'].'" style="width: 100%;"></p>
	</div>
</div>
</body>
</html>';

// Escribir contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Agregar una página final
$pdf->lastPage();

// Mostrar el PDF en el navegador
$pdf->Output('cotizacion.pdf', 'I');

ob_end_flush(); // Enviar la salida almacenada en el buffer