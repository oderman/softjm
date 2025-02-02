<?php 
include("sesion.php");
$idPagina = 109;

include("includes/verificar-paginas.php");
include("includes/head.php");
?>

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
<?php include("includes/texto-editor.php");?>
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
						<li><a href="proyectos.php">Proyectos</a><span class="divider"><i class="icon-angle-right"></i></span></li>
						<li class="active"><?=$paginaActual['pag_nombre'];?></li>
					</ul>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets gray">
						<div class="widget-head bondi-blue">
							<h3> <?=$paginaActual['pag_nombre'];?></h3>
						</div>
						<div class="widget-container">
							<form class="form-horizontal" method="post" action="bd_create/proyectos-guardar.php">
							<input type="hidden" class="span6" value="<?=$_SESSION["dataAdicional"]["id_empresa"]?>" name="proy_id_empresa">
							<input type="hidden" name="proy_creada_usuario" value="<?=$_SESSION["id"];?>"> 
								
								<div class="control-group">
									<label class="control-label">Titulo del proyecto</label>
									<div class="controls">
										<input type="text" class="span12" name="proy_titulo" required>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label">Descripción</label>
									<div class="controls">
										<textarea rows="10" cols="80" style="width: 80%" class="tinymce-simple" name="proy_descripcion"></textarea>
									</div>
								</div>
								
                               <div class="control-group">
									<label class="control-label">Responsable principal</label>
									<div class="controls">
										<select data-placeholder="Escoja una opción..." class="chzn-select span4" tabindex="2" name="proy_responsable_principal">
											<option value=""></option>
                                            <?php
											$conOp = $conexionBdPrincipal->query("SELECT * FROM usuarios WHERE usr_bloqueado=0 and usr_id_empresa =  '".$_SESSION["dataAdicional"]["id_empresa"]."'");
											while($resOp = mysqli_fetch_array($conOp, MYSQLI_BOTH)){
											?>
                                            	<option value="<?=$resOp[0];?>"><?=$resOp['usr_nombre'];?></option>
                                            <?php
											}
											?>
                                    	</select>
                                    </div>
                               </div>
                               
                               <div class="control-group">
									<label class="control-label">Fecha inicio</label>
									<div class="controls">
										<input type="date" class="span3" name="proy_inicio" required>
									</div>
								</div>
                                
                                <div class="control-group">
									<label class="control-label">Fecha de entrega (Ideal)</label>
									<div class="controls">
										<input type="date" class="span3" name="proy_fin" required>
									</div>
								</div>
                                
                               
                               <div class="control-group">
									<label class="control-label">Estado</label>
									<div class="controls">
										<select data-placeholder="Escoja una opción..." class="chzn-select span3" tabindex="2" name="proy_estado">
											<option value=""></option>
                                            <option value="1">En espera</option>
                                            <option value="2">En proceso</option>
                                            <option value="3">Completado</option>
                                    	</select>
                                    </div>
                               </div>
                               
                               

                              
								<div class="form-actions">
									<button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>
									<button type="button" class="btn btn-danger">Cancelar</button>
								</div>
     

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