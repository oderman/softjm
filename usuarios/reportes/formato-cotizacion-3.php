<?php
include("../sesion.php");
require_once(RUTA_PROYECTO . '/librerias/TCPDF/tcpdf.php');

$idPagina = 50;
require_once("logica-cotizacion.php");

$consulta = $conexionBdAdmin->query("SELECT * FROM documentos_configuracion WHERE dconf_id_empresa= '" . $idEmpresa . "' AND dconf_id_documento='" . ID_DOC_COTIZACION . "';");
$configuracionDoc = mysqli_fetch_array($consulta, MYSQLI_BOTH);
$fontLink = "https://fonts.googleapis.com/css2?family=" . str_replace(' ', '+', $configuracionDoc["dconf_estilo_letra"]) . "&display=swap";


class CustomPDF extends TCPDF {
    // Encabezado de la página
    public function Header() {
        // Puede agregar un encabezado personalizado aquí si es necesario
    }

    // Pie de página de la página
    public function Footer() {
        $footerImage = 'C:/xampp/htdocs/softjm/assets-login/images/auth/imagenfooter.png'; // Ruta de la imagen del footer
        $this->SetY(-30); // Posición a 30 mm desde el fondo
        $this->Image($footerImage, 40, $this->GetY(),140, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
    }
}

// Crear nuevo documento PDF
$pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alexis Romero');
$pdf->SetTitle('Cotización');
$pdf->SetSubject('Cotización');
$pdf->SetKeywords('TCPDF, PDF, cotización');

// No imprimir el encabezado
$pdf->setPrintHeader(false);

// Configurar fuente del pie de página
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Márgenes
$pdf->SetMargins(15, 50, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(5);

// Saltos de página automáticos
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Factor de escala de imagen
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Añadir una página
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

$headerImage1 = 'C:/xampp/htdocs/softjm/assets-login/images/auth/headertres.png';

// Comprobar si la imagen del encabezado existe y agregarla al PDF
if (file_exists($headerImage1)) {
    $pdf->Image($headerImage1, 15, 10, 180, 70, '', '', '', false, 300, '', false, false, 0, false, false, false);
} else {
    error_log("Header image not found: $headerImage1");
}

// Add the HTML content
$html = '
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cotización ' . htmlspecialchars($resultado['cotiz_id'] ?? '') . ' (' . htmlspecialchars($resultado['cotiz_fecha_propuesta'] ?? '') . ') - ' . htmlspecialchars($resultado['cli_nombre'] ?? '') . '</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="' . htmlspecialchars($fontLink) . '">
</head>
<body style="font-family:' . htmlspecialchars($configuracionDoc['dconf_estilo_letra'] ?? 'Verdana, sans-serif') . '; font-size:' . htmlspecialchars($configuracionDoc['dconf_tamano_letra'] ?? '11') . 'px;">

<div class="container text-center">
    <div class="row">
        <!-- Primer contenedor a la izquierda -->
        <div class="col-md-8">
            <div class="card border border-dark mt-2" style="width: 100%;">
            </div>
        </div>

    </div>
</div>

<div class="border border-dark rounded p-2" style="margin: 10px; font-size: 12px;" align="center">
    <table width="100%" border="0" rules="groups">
        <thead>
            <tr style="background-color: ' . htmlspecialchars($configuracionDoc['dconf_estilo'] ?? '#0033a0') . '; height: 50px; color: white;">
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
        <tbody>';
// Combos
$no = 1;
$productos = $conexionBdPrincipal->query("SELECT * FROM combos
    INNER JOIN cotizacion_productos ON czpp_combo=combo_id AND czpp_cotizacion='" . htmlspecialchars($_GET["id"]) . "'
    WHERE combo_id_empresa='" . htmlspecialchars($idEmpresa) . "'
    ORDER BY czpp_orden");
$totalIva = 0;
$subtotal = 0;
$totalDescuento = 0;
while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
    require("logica-cotizacion-items.php");
    $precioNormalCombo = mysqli_fetch_array($conexionBdPrincipal->query("SELECT SUM(copp_cantidad*prod_precio) FROM combos_productos
        INNER JOIN productos ON prod_id=copp_producto
        WHERE copp_combo='" . htmlspecialchars($prod['combo_id']) . "'"), MYSQLI_BOTH);
    $html .= '
            <tr style="height: 30px; background-color: ' . htmlspecialchars($fondo) . ';">
                <td align="center">' . htmlspecialchars($no) . '</td>
                <td align="center">
                    <img src="../files/productos/' . htmlspecialchars($prod['combo_foto']) . '" width="40">
                </td>
                <td>
                    <b>' . htmlspecialchars($prod['combo_nombre']) . '</b>';
    if ($prod['combo_descuento'] != "0") {
        $html .= '
                    <span class="badge badge-warning" style="font-size: 9px; color: white;"><b>Descuento:</b> ' . number_format((float)$prod['combo_descuento'], 0, ".", ".") . '%</span><br>';
    }
    $html .= '
                    <span style="font-size: 9px; color: darkblue;">' . htmlspecialchars($prod['combo_descripcion']) . '</span>
                </td>
                <td align="center">' . htmlspecialchars($prod['czpp_cantidad'] ?? '') . '</td>
                <td align="right">$' . number_format((float)$prod['czpp_valor'], 0, ".", ".") . '</td>
                <td align="right">' . htmlspecialchars($prod['czpp_iva'] ?? '') . '%</td>
                <td align="center">' . htmlspecialchars($prod['czpp_descuento'] ?? '') . '%</td>
                <td align="right">$' . number_format((float)$valorNeto ?? 0, 0, ".", ".") . '</td>
            </tr>';
    $no++;
}
$html .= '
        </tbody>
        <tfoot>';
if ($resultado['cotiz_observaciones'] != "") {
    $html .= '
            <tr>
                <td colspan="8" style="font-size: 10px;">
                    <b>OBSERVACIONES:</b> ' . htmlspecialchars($resultado['cotiz_observaciones']) . '
                </td>
            </tr>';
}
$html .= '
            <tr style="font-size: 12px; font-weight: bold;">
                <td colspan="6" rowspan="4">
                    <div align="left">
                        ' . strtoupper(htmlspecialchars($configuracion['conf_mensaje_cotizacion'] ?? '')) . '<br><br>';
if ($resultado['cotiz_fletes'] != "0") {
    $html .= '
                        <span style="color: darkblue;">Flete Incluido en el Precio.</span>';
}
$html .= '
                    </div>
                </td>
                <td align="right">SUBTOTAL</td>
                <td align="right">$' . number_format((float)$subtotal, 0, ".", ".") . '</td>
            </tr>
            <tr style="font-size: 12px; font-weight: bold;">
                <td align="right">DESCUENTO</td>
                <td align="right">$' . number_format((float)$totalDescuento, 0, ".", ".") . '</td>
            </tr>
            <tr style="font-size: 12px; font-weight: bold;">
                <td align="right">IVA</td>
                <td align="right">$' . number_format((float)$totalIva, 0, ".", ".") . '</td>
            </tr>
            <tr style="font-size: 12px; font-weight: bold;">
                <td align="right">TOTAL</td>
                <td align="right">$' . number_format((float)($totalIva + $subtotal), 0, ".", ".") . '</td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>';

if (file_exists($footerImage)) {
    echo "Header image found: $footerImage";
    $pdf->Image($footerImage, 15, 10, 180, 70, '', '', '', false, 300, '', false, false, 0, false, false, false);
} else {
    echo "Header image not found: $footerImage";
    error_log("Header image not found: $footerImage");
}

// Eliminar cualquier salida previa del buffer
if (ob_get_length()) {
    ob_end_clean();
}

$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('cotizacion.pdf', 'I');