<?php
include("sesion.php");

$idPagina = 214;

include("includes/verificar-paginas.php");
include("includes/head.php");
?>
<!-- styles -->


<link href="css/tablecloth.css" rel="stylesheet">

<!--============j avascript===========-->
<script src="js/jquery.js"></script>
<script src="js/jquery-ui-1.10.1.custom.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/accordion.nav.js"></script>
<script src="js/jquery.tablecloth.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script src="js/ZeroClipboard.js"></script>
<script src="js/dataTables.bootstrap.js"></script>
<script src="js/TableTools.js"></script>
<script src="js/custom.js"></script>
<script src="js/respond.min.js"></script>
<script src="js/ios-orientationchange-fix.js"></script>
<script type="text/javascript">
	/*$( function () {
		  // Set the classes that TableTools uses to something suitable for Bootstrap
		  $.extend( true, $.fn.DataTable.TableTools.classes, {
			  "container": "btn-group",
			  "buttons": {
				  "normal": "btn",
				  "disabled": "btn disabled"
			  },
			  "collection": {
				  "container": "DTTT_dropdown dropdown-menu",
				  "buttons": {
					  "normal": "",
					  "disabled": "disabled"
				  }
			  }
		  } );
		  // Have the collection use a bootstrap compatible dropdown
		  $.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
			  "collection": {
				  "container": "ul",
				  "button": "li",
				  "liner": "a"
			  }
		  } );
		  });
		  */
	$(function() {
		$('#data-table').dataTable({
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
			/*"oTableTools": {
			"aButtons": [
				"copy",
				"print",
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			]
		}*/
		});
	});
	$(function() {
		$('.tbl-simple').dataTable({
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
		});
	});

	$(function() {
		$(".tbl-paper-theme").tablecloth({
			theme: "paper"
		});
	});

	$(function() {
		$(".tbl-dark-theme").tablecloth({
			theme: "dark"
		});
	});
	$(function() {
		$('.tbl-paper-theme,.tbl-dark-theme').dataTable({
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
		});


	});
</script>
</head>

<body>
	<div class="layout">
		<?php include("includes/encabezado.php"); ?>
		<div class="main-wrapper">
			<div class="container-fluid">
				<?php include("includes/notificaciones.php"); ?>
				<p></p>
				<div class="row-fluid">
					<div class="span12">
						<div class="content-widgets light-gray">
							<div class="widget-head green">
								<h3><?= $paginaActual['pag_nombre']; ?></h3>
							</div>
							<div class="widget-container">
								<p></p>
								<table class="table table-striped table-bordered" id="data-table">
									<thead>
										<tr>
											<th>No</th>
											<th>Producto</th>
											<th>Precio anterior</th>
											<th>Precio nuevo</th>
											<th>Origen</th>
											<th>Actualización</th>
											<th>Responsable</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$filtro = '';
										if(isset($_GET["prod"])){
											if ($_GET["prod"] != "") {
												$filtro .= " AND php_producto='" . $_GET["prod"] . "'";
											}
										}

										$consulta = $conexionBdPrincipal->query("SELECT * FROM productos_historial_precios
										INNER JOIN productos ON prod_id=php_producto
										LEFT JOIN usuarios ON usr_id=php_usuario
										WHERE php_id=php_id $filtro
										ORDER BY php_id DESC
										");
										$no = 1;
										while ($res = mysqli_fetch_array($consulta, MYSQLI_BOTH)) {
										?>
											<tr>
												<td><?= $no; ?></td>
												<td><?= $res['prod_nombre']; ?></td>
												<td>$<?= number_format($res['php_precio_anterior'], 0, ",", "."); ?></td>
												<td>$<?= number_format($res['php_precio_nuevo'], 0, ",", "."); ?></td>
												<td><?= $origenPrecioProducto[$res['php_causa']]; ?></td>
												<td><?= $res['php_fecha_cambio']; ?></td>
												<td><?= $res['usr_nombre']; ?></td>
											</tr>
										<?php $no++;
										} ?>
									</tbody>
								</table>
							</div>
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