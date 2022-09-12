<?php include("../../conexion.php");?>
<?php
$configuracion = mysql_fetch_array(mysql_query("SELECT * FROM configuracion WHERE conf_id=1",$conexion));
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Formato del boletín</title>
</head>
<?php
$fin =  '<html><body style="background-color:'.$configuracion["conf_fondo_boletin"].';">';
	$fin .= '
				<center>
					<p align="center"><img src="../files/'.$configuracion["conf_logo"].'" width="350"></p>
					<div style="font-family:arial; background:'.$configuracion["conf_fondo_mensaje"].'; width:800px; color:#000; text-align:justify; padding:15px; border-radius:5px;">
						
						<p style="color:'.$configuracion["conf_color_letra"].';">Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen.</p>
						
						<p align="center"><img src="../files/adjuntos/ejemploimagenoderman.png" width="780"></p>
						
						<p align="center"><a href="'.$configuracion["conf_url_boton"].'" target="_blank" style="height:50px; width:100%; background:'.$configuracion["conf_color_letra"].'; color:'.$configuracion["conf_fondo_mensaje"].'; padding:10px; text-decoration:none; margin:10px; border-radius:0px 5px 0px 5px;">'.$configuracion["conf_nombre_boton"].'</a></p>
						
						<p align="center" style="color:'.$configuracion["conf_color_letra"].';">
							<img src="../files/'.$configuracion["conf_logo"].'" width="80"><br>
							'.$configuracion["conf_mensaje_pie"].'<br>
							<a href="'.$configuracion["conf_web"].'" style="color:'.$configuracion["conf_color_link"].';">'.$configuracion["conf_web"].'</a>
						</p>
						
					</div>
				</center>
				<p>&nbsp;</p>
			';	
	$fin .='';						
	$fin .=  '<html><body>';
	
	echo $fin;
?>
</html>