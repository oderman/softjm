<?php 
include("sesion.php");

$idPagina = 267;

include("includes/verificar-paginas.php");
include("includes/head.php");
$consulta=mysqli_query($conexionBdPrincipal,"SELECT * FROM configuracion WHERE conf_id=1 AND conf_id_empresa='".$idEmpresa."'");
$resultadoD = mysqli_fetch_array($consulta, MYSQLI_BOTH);
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
<?php 
//Son todas las funciones javascript para que los campos del formulario funcionen bien.
include("includes/js-formularios.php");
?>
</head>
<body>
<div class="layout">
	<?php include("includes/encabezado.php");?>
    
    
    
	<div class="main-wrapper">
		<div class="container-fluid">
			<div class="row-fluid ">
				<div class="span12">
					<div class="primary-head">
						<h3 class="page-header"><?=$paginaActual['pag_nombre'];?></h3>
					</div>
					<ul class="breadcrumb">
						<li><a href="index.php" class="icon-home"></a><span class="divider "><i class="icon-angle-right"></i></span></li>
						<li class="active"><?=$paginaActual['pag_nombre'];?></li>
					</ul>
				</div>
			</div>
            <?php include("includes/notificaciones.php");?>
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> <?=$paginaActual['pag_nombre'];?></h3>
						</div>
						<div class="widget-container">
							<form class="form-horizontal" method="post" action="bd_update/publicidad-actualizar.php" enctype="multipart/form-data">
                                
                                <fieldset class="default">
									<legend>Banners publicitarios</legend>
                                
									<div class="control-group">
										<label class="control-label">Banner Superior
										<button class="tooltipp">Coloca la publicidad en la parte superio de la pagina.</button>
							             <i class="fa-solid fa-circle-question"></i>
										</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input span3">
														<i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-file"><span class="fileupload-new">Seleccionar archivo</span><span class="fileupload-exists">Cambiar</span>
													<input type="file" name="bTop"/>
													</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
												</div>
											</div>
										</div>
										<?php if($resultadoD['conf_banner_top']!=""){?>
											<img src="files/publicidad/<?=$resultadoD['conf_banner_top'];?>" width="100"><br>
											<a href="bd_delete/publicidad-eliminar.php?ope=1" onClick="if(!confirm('Desea quitar este banner?')){return false;}">Quitar</a>
										<?php }?>
									</div>
										
									<div class="control-group">
										<label class="control-label">URL banner superior
										<button class="tooltipp">Coloca la URL en la parte superio y dirige al usuario a la URL asignada.</button>
							             <i class="fa-solid fa-circle-question"></i>
										</label>
										<div class="controls">
											<input type="url" class="span10" name="urlTop" value="<?=$resultadoD['conf_url_top'];?>">
										</div>
									</div>	
										
									<div class="control-group">
										<label class="control-label">Banner Lateral
										<button class="tooltipp">Coloca la publicidad en la parte lateral de la pagina.</button>
							             <i class="fa-solid fa-circle-question"></i>
										</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
												<div class="input-append">
													<div class="uneditable-input span3">
														<i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span>
													</div>
													<span class="btn btn-file"><span class="fileupload-new">Seleccionar archivo</span><span class="fileupload-exists">Cambiar</span>
													<input type="file" name="bLat"/>
													</span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
												</div>
											</div>
										</div>
										<?php if($resultadoD['conf_banner_lateral']!=""){?>
											<img src="files/publicidad/<?=$resultadoD['conf_banner_lateral'];?>" width="100"><br>
											<a href="bd_delete/publicidad-eliminar.php?ope=2" onClick="if(!confirm('Desea quitar este banner?')){return false;}">Quitar</a>
										<?php }?>
									</div>
										
									<div class="control-group">
										<label class="control-label">URL banner lateral
										<button class="tooltipp">Coloca la URL en la parte lateral y dirige al usuario a la URL asignada.</button>
							             <i class="fa-solid fa-circle-question"></i>
										</label>
										<div class="controls">
											<input type="url" class="span10" name="urlLat" value="<?=$resultadoD['conf_url_lateral'];?>">
										</div>
									</div>	
									
									
                                </fieldset>
                                   

								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>
									<button type="button" class="btn btn-danger">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php include("includes/pie.php");?>
</div>
</body>
</html>