<?php 
include("sesion.php");

$idPagina = 135;
include("includes/verificar-paginas.php");
include("includes/head.php");

$consultaResultadoD = mysqli_query($conexionBdPrincipal, "SELECT * FROM importaciones 
INNER JOIN proveedores ON prov_id=imp_proveedor
LEFT JOIN facturas ON factura_id=imp_fce
WHERE imp_id='" . $_GET["id"] . "'
AND imp_id_empresa='".$idEmpresa."'");
$resultadoD = mysqli_fetch_array($consultaResultadoD, MYSQLI_BOTH);

//Moneda a multiplicar
if ($resultadoD['factura_moneda'] == 1) {
	$trmMult = $resultadoD['factura_trm_usd'];
	$trmMultFlete = $resultadoD['factura_trm_usd_flete'];
} else {
	$trmMult = $resultadoD['factura_trm_euro'];
	$trmMultFlete = $resultadoD['factura_trm_euro_flete'];
}

$valorCostosNacConsulta = mysqli_query($conexionBdPrincipal, "SELECT SUM(factura_valor) FROM importaciones_facturas
INNER JOIN facturas ON factura_id=impf_factura AND factura_preferencia=1
WHERE impf_importacion='".$resultadoD['imp_id']."'");
$valorCostosNac = mysqli_fetch_array($valorCostosNacConsulta, MYSQLI_BOTH);

$valorCostosFletes = mysqli_query($conexionBdPrincipal, "SELECT SUM(factura_valor) FROM importaciones_facturas
INNER JOIN facturas ON factura_id=impf_factura AND factura_preferencia=2
WHERE impf_importacion='".$resultadoD['imp_id']."'");
$valorCostosFletes = mysqli_fetch_array($valorCostosFletes, MYSQLI_BOTH);

$valorFletes = mysqli_query($conexionBdPrincipal, "SELECT SUM(czpp_valor) FROM cotizacion_productos
INNER JOIN productos ON prod_id=czpp_producto AND prod_no_inventariable=1
WHERE czpp_cotizacion='".$resultadoD['imp_fce']."' AND czpp_tipo='".CZPP_TIPO_FACT."'");
$valorFletes = mysqli_fetch_array($valorFletes, MYSQLI_BOTH);

$totalFlete = ($valorFletes[0] * $trmMultFlete);

if (!empty($valorCostosNac[0])) {
	$totalCostoNac = ($resultadoD['imp_valor_nacionalizacion'] + $valorCostosNac[0]);
}

if (!empty($resultadoD['imp_otros_gastos']) && !empty($totalFlete)) {
	$totalGastos = ($totalFlete + $totalCostoNac + $resultadoD['imp_otros_gastos']);
}	

$valorTotalProductosImpConsulta = mysqli_query($conexionBdPrincipal, "SELECT SUM((czpp_cantidad*czpp_valor)) FROM cotizacion_productos
INNER JOIN productos ON prod_id=czpp_producto AND prod_no_inventariable='0'
WHERE czpp_cotizacion='".$resultadoD['imp_fce']."' AND czpp_tipo='".CZPP_TIPO_FACT."'");
$valorTotalProductosImp = mysqli_fetch_array($valorTotalProductosImpConsulta, MYSQLI_BOTH);
?>


<!-- styles -->

<link href="css/chosen.css" rel="stylesheet">


<!--============ javascript ===========-->
<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.1.custom.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap-fileupload.js"></script>
<script src="js/accordion.nav.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/chosen.jquery.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/date.js"></script>
<script src="js/daterangepicker.js"></script>
<script src="js/custom.js"></script>
<script src="js/respond.min.js"></script>
<script src="js/ios-orientationchange-fix.js"></script>
<script type="text/javascript">
	/*====TAGS INPUT====*/
	$(function() {
		$('#tags_1').tagsInput({
			width: 'auto'
		});
		$('#tags_2').tagsInput({
			width: 'auto',
			onChange: function(elem, elem_tags) {
				var languages = ['php', 'ruby', 'javascript'];
				$('.tag', elem_tags).each(function() {
					if ($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0) $(this).css('background-color', 'yellow');
				});
			}
		});
	});
	/*====Select Box====*/
	$(function() {
		$(".chzn-select").chosen();
		$(".chzn-select-deselect").chosen({
			allow_single_deselect: true
		});
	});
	/*====Color Picker====*/
	$(function() {
		$('.colorpicker').colorpicker({
			format: 'hex'
		});
		$('.pick-color').colorpicker();
	});
	/*====DATE Time Picker====*/
	$(function() {
		$('#datetimepicker1').datetimepicker({
			language: 'pt-BR'
		});
	});
	$(function() {
		$('#datetimepicker3').datetimepicker({
			pickDate: false
		});
	});
	$(function() {
		$('#datetimepicker4').datetimepicker({
			pickTime: false
		});
	});
	/*DATE RANGE PICKER*/
	$(function() {
		$('#reportrange').daterangepicker({
				ranges: {
					'Today': ['today', 'today'],
					'Yesterday': ['yesterday', 'yesterday'],
					'Last 7 Days': [Date.today().add({
						days: -6
					}), 'today'],
					'Last 30 Days': [Date.today().add({
						days: -29
					}), 'today'],
					'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
					'Last Month': [Date.today().moveToFirstDayOfMonth().add({
						months: -1
					}), Date.today().moveToFirstDayOfMonth().add({
						days: -1
					})]
				},
				opens: 'left',
				format: 'MM/dd/yyyy',
				separator: ' to ',
				startDate: Date.today().add({
					days: -29
				}),
				endDate: Date.today(),
				minDate: '01/01/2012',
				maxDate: '12/31/2013',
				locale: {
					applyLabel: 'Submit',
					fromLabel: 'From',
					toLabel: 'To',
					customRangeLabel: 'Custom Range',
					daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
					monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					firstDay: 1
				},
				showWeekNumbers: true,
				buttonClasses: ['btn-danger']
			},
			function(start, end) {
				$('#reportrange span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
			});
		//Set the initial state of the picker label
		$('#reportrange span').html(Date.today().add({
			days: -29
		}).toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy'));
	});
	$(function() {
		$('#reservation').daterangepicker();
	});
</script>
<?php include("includes/texto-editor.php"); ?>




<script type="text/javascript">
	function productos(enviada) {
		var idRemision = <?= $_GET['id']; ?>;

		var campo = enviada.title;
		var producto = enviada.name;
		var proceso = 9;
		var valor = enviada.value;
		$('#resp').empty().hide().html("Esperando...").show(1);
		datos = "producto=" + (producto) + "&proceso=" + (proceso) + "&valor=" + (valor) + "&campo=" + (campo) + "&idRemision=" + (idRemision);
		$.ajax({
			type: "POST",
			url: "ajax/ajax-productos.php",
			data: datos,
			success: function(data) {
				$('#resp').empty().hide().html(data).show(1);
			}
		});
	}
</script>


</head>

<body>
	<div class="layout">
		<?php include("includes/encabezado.php"); ?>

		

		<div class="main-wrapper">
			<div class="container-fluid">
				<div class="row-fluid ">
					<div class="span12">
						<div class="primary-head">
							<h3 class="page-header"><?= $paginaActual['pag_nombre']; ?></h3>
						</div>
						<ul class="breadcrumb">
							<li><a href="index.php" class="icon-home"></a><span class="divider "><i class="icon-angle-right"></i></span></li>
							<li><a href="importacion.php">Importaciones</a><span class="divider"><i class="icon-angle-right"></i></span></li>
							<li class="active"><?= $paginaActual['pag_nombre']; ?></li>
						</ul>
					</div>
				</div>

				<?php include("includes/notificaciones.php"); ?>


				<p>
				<?php if (Modulos::validarRol([134], $conexionBdPrincipal, $conexionBdAdmin, $datosUsuarioActual, $configuracion)) {?>
					<a href="importacion-agregar.php" class="btn btn-danger"><i class="icon-plus"></i> Agregar nuevo</a>
				<?php } ?>
					<a href="#reportes/formato-remision-1.php?id=<?= $_GET["id"]; ?>" class="btn btn-success" target="_blank"><i class="icon-print"></i> Imprimir</a>

					<!--
				<a href="sql.php?get=44&id=<?= $_GET["id"]; ?>" class="btn btn-warning" onClick="if(!confirm('Desea Enviar este mensaje al correo del contacto?')){return false;}"><i class="icon-envelope"></i> Enviar por correo</a>
				-->
				</p>


				<div class="row-fluid">
					<div class="span12">
						<div class="content-widgets gray">
							<div class="widget-head bondi-blue">
								<h3> <?= $paginaActual['pag_nombre']; ?></h3>
							</div>
							<div class="widget-container">
								<form class="form-horizontal" method="post" action="bd_update/importacion-actualizar.php">
									<input type="hidden" name="id" value="<?= $_GET["id"]; ?>">
									<input type="hidden" name="monedaActual" value="<?= $resultadoD['factura_moneda']; ?>">


									<div class="form-actions">
										<a href="javascript:history.go(-1);" class="btn btn-primary"><i class="icon-arrow-left"></i> Regresar</a>

										<button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>

									</div>


									<div class="control-group">
										<label class="control-label">Concepto</label>
										<div class="controls">
											<input type="text" class="span8" name="concepto" value="<?= $resultadoD['imp_concepto']; ?>" required>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Escoja un proveedor</label>
										<div class="controls">
											<select data-placeholder="Escoja una opción..." class="chzn-select span8" tabindex="2" name="proveedor" required>
												<option value=""></option>
												<?php
												$conOp = mysqli_query($conexionBdPrincipal, "SELECT * FROM proveedores WHERE prov_id_empresa='".$_SESSION["dataAdicional"]["id_empresa"]."'");
												while ($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)) {
												?>
													<option value="<?= $resOp[0]; ?>" <?php if ($resultadoD['imp_proveedor'] == $resOp[0]) echo "selected"; ?>><?= $resOp['prov_nombre']; ?></option>
												<?php
												}
												?>
											</select>
										</div>

										<?php if (Modulos::validarRol([125], $conexionBdPrincipal, $conexionBdAdmin, $datosUsuarioActual, $configuracion)) {?>
										<a href="proveedores-editar.php?id=<?= $resultadoD['imp_proveedor']; ?>" class="btn btn-info" target="_blank">Editar proveedor</a>
										<?php } ?>		


									</div>



									<div class="control-group">
										<label class="control-label">Fecha</label>
										<div class="controls">
											<input type="date" class="span4" name="fecha" required value="<?= $resultadoD['imp_fecha']; ?>">
										</div>
									</div>


									<div class="control-group">
										<label class="control-label">Factura de compra extranjera</label>
										<div class="controls">
											<select data-placeholder="Escoja una opción..." class="chzn-select span4" tabindex="2" name="fce" required>
												<option value=""></option>
												<?php
												$conOp = mysqli_query($conexionBdPrincipal, "SELECT * FROM facturas WHERE factura_extranjera=1 AND factura_proveedor='" . $resultadoD['imp_proveedor'] . "' AND factura_id_empresa='".$idEmpresa."'");
												while ($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)) {
												?>
													<option value="<?= $resOp[0]; ?>" <?php if ($resultadoD['imp_fce'] == $resOp[0]) echo "selected"; ?>>#<?= $resOp['factura_id'] . " - " . $resOp['factura_concepto']; ?></option>
												<?php
												}
												?>
											</select>
										</div>

										<?php if ($resultadoD['imp_fce'] != "" && Modulos::validarRol([132], $conexionBdPrincipal, $conexionBdAdmin, $datosUsuarioActual, $configuracion)) { ?>
											<a href="fce-editar.php?id=<?= $resultadoD['imp_fce']; ?>" class="btn btn-info" target="_blank">Detalles de la factura</a>
										<?php } ?>


									</div>

									<hr>

									<div class="control-group">
										<label class="control-label">TRM USD
										<button class="tooltipp">Tasa representativa del mercado dólar estadounidense.</button>
										<i class="fa-solid fa-circle-question"></i>
										</label>
										<div class="controls">
											<input type="text" class="span2" name="trmUsd" value="<?= $resultadoD['factura_trm_usd']; ?>" disabled>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">TRM EURO
										<button class="tooltipp">Tasa representativa del mercado euro.</button>
										<i class="fa-solid fa-circle-question"></i>

										</label>
										<div class="controls">
											<input type="text" class="span2" name="trmEuro" value="<?= $resultadoD['factura_trm_euro']; ?>" disabled>
										</div>
									</div>

									<hr>

								<div class="control-group">
									<label class="control-label">FLETE TRM USD
									    <button class="tooltipp">Costo del transporte dólar estadounidense.</button>
										<i class="fa-solid fa-circle-question"></i>
									</label>
									<div class="controls">
										<input type="text" class="span2" name="trmUsdFlete" value="<?=$resultadoD['factura_trm_usd_flete'];?>" disabled>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label">FLETE TRM EURO
									<button class="tooltipp">Costo del transporte euro.</button>
										<i class="fa-solid fa-circle-question"></i>
									</label>
									<div class="controls">
										<input type="text" class="span2" name="trmEuroFlete" value="<?=$resultadoD['factura_trm_euro_flete'];?>" disabled>
									</div>
								</div>	

									<div class="control-group">
										<label class="control-label">Costo nacionalización</label>
										<div class="controls">
											<input type="text" class="span4" name="nacionalizacion" value="<?= $resultadoD['imp_valor_nacionalizacion']; ?>">
											+ $<?php if(!empty($valorCostosNac[0])) echo number_format($valorCostosNac[0],0,".",".");?>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label">Otros costos</label>
										<div class="controls">
											<input type="text" class="span4" name="otrosCostos" value="<?= $resultadoD['imp_otros_gastos']; ?>">
										</div>
									</div>

									<hr>


									<div class="control-group">
										<label class="control-label">Otras Facturas asociadas</label>
										<div class="controls">
											<select data-placeholder="Escoja una opción..." class="chzn-select span10" tabindex="2" name="facturas[]" multiple>
												<option value=""></option>
												<?php
												$conOp = mysqli_query($conexionBdPrincipal, "SELECT * FROM facturas WHERE factura_tipo=2 AND factura_preferencia='0' AND factura_id_empresa='".$idEmpresa."'
												");
												while ($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)) {
													$facturasNConsulta = mysqli_query($conexionBdPrincipal, "SELECT * FROM importaciones_facturas 
													WHERE impf_factura='" . $resOp[0] . "' AND impf_importacion='" . $resultadoD['imp_id'] . "'");
													$facturasN = mysqli_num_rows($facturasNConsulta);
												?>
													<option <?php if ($facturasN > 0) {
																echo "selected";
															} ?> value="<?= $resOp['factura_id']; ?>">#<?= $resOp['factura_id'] . " - " . $resOp['factura_concepto']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>


									<div class="control-group">
										<label class="control-label">Costos de nacionalización</label>
										<div class="controls">
											<select data-placeholder="Escoja una opción..." class="chzn-select span10" tabindex="2" name="facturasNac[]" multiple>
												<option value=""></option>
												<?php
												$conOp = mysqli_query($conexionBdPrincipal, "SELECT * FROM facturas
												LEFT JOIN proveedores ON prov_id=factura_proveedor  
												WHERE factura_tipo='".FACTURA_TIPO_COMPRA."' AND factura_preferencia=1 AND factura_id_empresa='".$idEmpresa."'
												");
												while ($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)) {
													$facturasNConsulta = mysqli_query($conexionBdPrincipal, "SELECT * FROM importaciones_facturas 
													WHERE impf_factura='" . $resOp[0] . "' AND impf_importacion='" . $resultadoD['imp_id'] . "' AND impf_preferencia=1");
													$facturasN = mysqli_num_rows($facturasNConsulta);
												?>
													<option <?php if ($facturasN > 0) {
																echo "selected";
															} ?> value="<?= $resOp['factura_id']; ?>">#<?= $resOp['factura_id'] . " - " . $resOp['factura_concepto']." ($".number_format($resOp['factura_valor'],0,".",".").") - ".$resOp['prov_nombre']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>

									

									<div class="control-group">
										<label class="control-label">Liquidada</label>
										<div class="controls">
											<select data-placeholder="Escoja una opción..." class="chzn-select span3" tabindex="2" name="liquidada">
												<option value=""></option>
												<option value="1" <?php if ($resultadoD['imp_liquidada'] == 1) echo "selected"; ?>>SI</option>
												<option value="0" <?php if ($resultadoD['imp_liquidada'] == '0') echo "selected"; ?>>NO</option>
											</select>
										</div>
										<span style="color: tomato;"> Una vez liquidada ya no podrá hacer más cambios.</span>
									</div>

									<div class="form-actions">
										<a href="javascript:history.go(-1);" class="btn btn-primary"><i class="icon-arrow-left"></i> Regresar</a>

										<button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>

									</div>

							</div>
						</div>
					</div>
				</div>

				<!-- LISTADO DE LO QUE SE ESTÁ COTIZANDO -->
				<div class="row-fluid">
					<div class="span12">

						<span id="resp"></span>

						<div class="content-widgets light-gray" id="productos">
							<div class="widget-head orange">
								<h3>PRODUCTOS</h3>
							</div>
							<div class="widget-container">
								<p></p>
								<table class="table table-striped table-bordered" id="data-table">
									<thead>
										<tr>
											<th>No</th>
											<th>Orden</th>
											<th>Artículo</th>
											<th>Cant.</th>
											<th>Valor Unitario (<?= $monedasExt[$resultadoD['factura_moneda']]; ?>)</th>
											<th>Valor Unitario (COP)</th>
											<th>SUBTOTAL (<?= $monedasExt[$resultadoD['factura_moneda']]; ?>)</th>
											<th>SUBTOTAL (COP)</th>
											<th>COSTO CON NAC. (COP)</th>
											<th>Utilidad</th>
											<th>Valor (COP)</th>
										</tr>
									</thead>
									<tbody>



										<!-- PRODUCTOS -->
										<?php
										$no = 1;
										$productos = mysqli_query($conexionBdPrincipal, "SELECT * FROM productos 
										INNER JOIN productos_categorias ON catp_id=prod_categoria
										INNER JOIN cotizacion_productos ON czpp_producto=prod_id AND czpp_cotizacion='" . $resultadoD['imp_fce'] . "' AND czpp_tipo='".CZPP_TIPO_FACT."'
										WHERE prod_id_empresa='".$idEmpresa."'
										ORDER BY prod_no_inventariable DESC, czpp_orden");
										while ($prod = mysqli_fetch_array($productos, MYSQLI_BOTH)) {
											$dcto = 0;
											$valorTotal = 0;
											$costoNacionalizacion = 0;

											$valorTotal = ($prod['czpp_valor'] * $prod['czpp_cantidad']);

											if ($prod['czpp_cantidad'] > 0 and $prod['czpp_descuento'] > 0) {
												$dcto = ($valorTotal * ($prod['czpp_descuento'] / 100));
												$totalDescuento += $dcto;
											}

											$subtotal += $valorTotal;


											$totalCantidad += $prod['czpp_cantidad'];

											

											$colorPNI = '';
											if ($prod['prod_no_inventariable'] == 1) {
												$colorPNI = 'yellow';
											}

											$vlrUniCop = ($prod['czpp_valor'] * $trmMult);

											$costoNacionalizacion = ((($valorTotal * $totalGastos)/$valorTotalProductosImp[0])/$prod['czpp_cantidad']) + $vlrUniCop;

											$utilidad = ($costoNacionalizacion*$prod['czpp_utilidad']);


										?>
											<tr>
												<td><?= $no; ?></td>
												<td><input type="number" title="czpp_orden" name="<?= $prod['czpp_id']; ?>" value="<?= $prod['czpp_orden']; ?>" onChange="productos(this)" style="width: 50px; text-align: center;"></td>
												<td style="background-color: <?= $colorPNI; ?>;">
													<a href="sql.php?get=43&idItem=<?= $prod['czpp_id']; ?>" onClick="if(!confirm('Desea eliminar este registro?')){return false;}"><i class="icon-trash"></i></a>
													<?php if (Modulos::validarRol([38], $conexionBdPrincipal, $conexionBdAdmin, $datosUsuarioActual, $configuracion)) {?>
													<a href="productos-editar.php?id=<?= $prod['prod_id']; ?>" target="_blank"><?= $prod['prod_nombre']; ?></a>
													<?php } ?>
												</td>
												<td><input type="number" title="czpp_cantidad" name="<?= $prod['czpp_id']; ?>" value="<?= $prod['czpp_cantidad']; ?>" onChange="productos(this)" style="width: 50px; text-align: center;" disabled></td>
												<td><input type="text" title="czpp_valor" name="<?= $prod['czpp_id']; ?>" value="<?= $prod['czpp_valor']; ?>" onChange="productos(this)" style="width: 200px;" disabled></td>

												<td>$<?= number_format($vlrUniCop, 0, ",", "."); ?></td>


												<td><?= $simbolosMonedas[$resultadoD['factura_moneda']]; ?><?= number_format($valorTotal, 0, ",", "."); ?></td>

												<td><?= $simbolosMonedas[$resultadoD['factura_moneda']]; ?><?= number_format(($valorTotal * $trmMult), 0, ",", "."); ?></td>

												<?php if ($prod['prod_no_inventariable'] == 1) { ?>

													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>

												<?php } else { ?>

													<td><span style="color:tomato; font-weight: bold;">$<?= number_format($costoNacionalizacion, 0, ",", "."); ?></span></td>

													<td><input type="text" title="czpp_utilidad" name="<?= $prod['czpp_id']; ?>" value="<?= $prod['czpp_utilidad']; ?>" onChange="productos(this)" style="width: 50px; text-align: center;"></td>
													<td>$<?= number_format($utilidad, 0, ",", "."); ?></td>
												<?php } ?>
											</tr>
										<?php
											$no++;
										}
										?>


										<!-- FACTURAS -->  
										<?php
										$no = 1;
										$fletesOtros = 0;
										$facturas = mysqli_query($conexionBdPrincipal, "SELECT * FROM importaciones_facturas 
							INNER JOIN facturas ON factura_id=impf_factura
							WHERE impf_importacion='".$_GET["id"]."'");
										while ($fact = mysqli_fetch_array($facturas, MYSQLI_BOTH)) {

											$vlrUniCop = ($fact['factura_valor'] * $trmMult);
											$valorTotal = ($fact['factura_valor']);

											if($fact['factura_preferencia']==1){
												$vlrUniCop = ($fact['factura_valor']);
											}

											if($fact['factura_preferencia']==2){
												$fletesOtros += $fact['factura_valor'];
											}

										?>
											<tr>
												<td><?= $no; ?></td>
												<td>-</td>
												<td style="background-color: yellow;">
												<?php if (Modulos::validarRol([130], $conexionBdPrincipal, $conexionBdAdmin, $datosUsuarioActual, $configuracion)) {?>
													<a href="facturas-compra-editar.php?id=<?= $fact['factura_id']; ?>#productos" target="_blank"><?= $fact['factura_concepto']; ?></a>
												<?php } ?>
												</td>
												<td>-</td>
												<?php if($fact['factura_preferencia']!=1){?>
													<td>$<?= number_format($fact['factura_valor'], 0, ",", "."); ?></td>
												<?php }else{?>
													<td>-</td>
												<?php }?>

												<td>$<?= number_format($vlrUniCop, 0, ",", "."); ?></td>

												<?php if($fact['factura_preferencia']!=1){?>
													<td><?= $simbolosMonedas[$resultadoD['factura_moneda']]; ?><?= number_format($valorTotal, 0, ",", "."); ?></td>

												<td><?= $simbolosMonedas[$resultadoD['factura_moneda']]; ?><?= number_format(($valorTotal * $trmMult), 0, ",", "."); ?></td>
												<?php }else{?>
													<td>-</td>
													<td>-</td>
												<?php }?>

													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>

												
											</tr>
										<?php
											$no++;
										}
										?>

									</tbody>
									<tfoot>
									<tr style="font-weight: bold; font-size: 16px;">
											<td style="text-align: right;" colspan="6">TOTAL (<?= $monedasExt[$resultadoD['factura_moneda']]; ?>)</td>
											<td><?= number_format(($subtotal - $valorFletes[0]), 0, ",", "."); ?></td>
											<td colspan="4">&nbsp;</td>
										</tr>
										<tr style="font-weight: bold; font-size: 16px;">
											<td style="text-align: right;" colspan="6">TOTAL + FLETE (<?= $monedasExt[$resultadoD['factura_moneda']]; ?>)</td>
											<td><?= number_format($subtotal + $fletesOtros, 0, ",", "."); ?></td>
											<td colspan="4">&nbsp;</td>
										</tr>
										<!--
										<tr style="font-weight: bold; font-size: 16px;">
											<td style="text-align: right;" colspan="7">TOTAL (COP)</td>
											<td><?= number_format(($subtotal * $trmMult), 0, ",", "."); ?></td>
											<td colspan="3">&nbsp;</td>
										</tr>-->
									</tfoot>

								</table>


								<div class="form-actions">

									<a href="javascript:history.go(-1);" class="btn btn-primary"><i class="icon-arrow-left"></i> Regresar</a>

									<button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>



									<a href="#reportes/formato-remision-1.php?id=<?= $_GET["id"]; ?>" class="btn btn-success" target="_blank"><i class="icon-print"></i> Imprimir</a>
								</div>
								</form>

							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<?php include("includes/pie.php"); ?>
	</div>
</body>

</html>