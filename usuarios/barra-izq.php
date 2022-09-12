<?php
//$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));
/*$facturacion = mysql_fetch_array(mysql_query("SELECT sum(fpab_valor) FROM facturacion_abonos INNER JOIN facturacion ON fact_id=fpab_factura AND fact_estado!=3 AND fact_tipo=1 WHERE MONTH(fpab_fecha_abono)=".date("m")." AND YEAR(fpab_fecha_abono)=".date("Y"),$conexion));
$porcentaje = round(($facturacion[0]/$configuracion[1])*100,2);*/
?>

<!--
<div class="leftbar leftbar-close clearfix">
		<div class="admin-info clearfix">
			<div class="admin-thumb">
				<img src="files/fotos/<?=$datosUsuarioActual['usr_foto'];?>" width="50">
			</div>
			<div class="admin-meta">
				<ul>
					<li class="admin-username"><?=$datosUsuarioActual[4];?></li>
					<li><a href="perfil-editar.php">Editar Perfil</a></li>
					<li><a href="configuracion.php">Configuración </a><a href="../salir.php"><i class="icon-lock"></i> Salir</a></li>
				</ul>
			</div>
		</div>
		<div class="left-nav clearfix" style="color:#CCC">
			<div class="left-primary-nav">
				<ul id="myTab">
					<li class="active"><a href="#main" class="icon-desktop" title="ORIÓN"></a></li>
				</ul>
			</div>
			<div class="responsive-leftbar">
				<i class="icon-list"></i>
			</div>
			<div class="left-secondary-nav tab-content">
				<div class="tab-pane active" id="main">
					<h4 class="side-head">ORIÓN</h4>
					<p></p> 
				
 
				</div>
				
			</div>
		</div>
	</div>
-->