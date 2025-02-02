<?php
include("sesion.php"); 
$idPagina = 19;
include("includes/head.php");

$consulta = $conexionBdPrincipal->query("SELECT * FROM usuarios
WHERE usr_id='" . $_SESSION["id"] . "'");

$resultadoD = mysqli_fetch_array($consulta, MYSQLI_BOTH);
?>
<!-- styles -->

<!--[if IE 7]>
<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
<![endif]-->
<link href="css/chosen.css" rel="stylesheet">


<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/ie/ie7.css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="css/ie/ie8.css" />
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="css/ie/ie9.css" />
<![endif]-->

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
        <?php include("includes/encabezado.php"); ?>

        

        <div class="main-wrapper">
            <div class="container-fluid">
                <?php include("includes/notificaciones.php"); ?>
                <div class="row-fluid">
                    <div class="span8">
                        <div class="content-widgets gray">
                            <div class="widget-head bondi-blue">
                                <h3> <?= $paginaActual['pag_nombre']; ?></h3>
                            </div>
                            <div class="widget-container">
                                <img src="files/fotos/<?=$resultadoD['usr_foto'];?>" width="100">
                                
                                <form class="form-horizontal" method="post" action="bd_update/actualizar-perfil.php" enctype="multipart/form-data">

                                    <div class="control-group">
                                        <label class="control-label">Usuario</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="usuario" value="<?= $resultadoD['usr_login']; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Nombre</label>
                                        <div class="controls">
                                            <input type="text" class="span4" name="nombre" value="<?= $resultadoD['usr_nombre']; ?>">
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Email
                                             <button class="tooltipp">Recuperar contraseña.</button>
                                            <i class="fa-solid fa-circle-question"></i>
                                        </label>
                                        <div class="controls">
                                            <input type="email" class="span4" name="email" value="<?= $resultadoD['usr_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Roles
                                            <button class="tooltipp">Funcion a cumplir en la empresa.</button>
                                            <i class="fa-solid fa-circle-question"></i>
                                        </label>
                                        <div class="controls">
                                            <select data-placeholder="Escoja una opción..." class="chzn-select span4" multiple tabindex="2" name="tipoU" disabled>
                                                <option value=""></option>
                                                <?php
                                                foreach ($_SESSION['dataAdicional']['roles_nombre'] as $roles) {
                                                ?>
                                                    <option value="" selected><?=$roles;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Foto de perfil</label>
                                        <div class="controls">
                                            <input type="file" class="span4" name="foto">
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info"><i class="icon-save"></i> Guardar cambios</button>
                                        <button type="button" class="btn btn-danger">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="span4">
                        <div class="content-widgets gray">
                            <div class="widget-head bondi-blue">
                                <h3> Cambiar contraseña</h3>

                            </div>
                            <div class="widget-container">
                                <p>
                                    La nueva clave nueva debe cumplir con los siguiente criterios de aceptación:<br>
                                    <b>1.</b> Solo se admiten caracteres de la a-z, A-Z, números(0-9) y el simbolo punto(.).<br>
                                    <b>2.</b> El rango debe ser entre 4 y 20 caracteres de longitud.<br><br>

                                    Un ejemplo de una clave que cumpla con los anteriores criterios es: <b>M1cl4v3.8910</b> 
                                </p>

                                <form class="form-horizontal" method="post" action="bd_update/perfil-cambiar-clave.php">
                                    <input type="hidden" name="idSql" value="76">

                                    <div class="control-group">
                                        <label class="control-label">Contraseña Actual</label>
                                        <div class="controls">
                                            <input type="password" class="span12" name="claveActual" required>
                                        </div>
                                    </div>

                                    
                                    <div class="control-group">
                                        <label class="control-label">Contraseña Nueva</label>
                                        <div class="controls">
                                            <input type="password" class="span12" name="clave" required>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-info"><i class="icon-save"></i> Cambiar contraseña</button>
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