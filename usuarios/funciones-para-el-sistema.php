<?php
function subirArchivosAlServidor($archivoCargado, $prefijo, $destino){
	$extension = end(explode(".", $archivoCargado['name']));
	$nombreArchivoFinal = uniqid($prefijo."_") . "." . $extension;
	$rutaCompleta = $destino . "/" . $nombreArchivoFinal;
	move_uploaded_file($archivoCargado['tmp_name'], $rutaCompleta);

	return $nombreArchivoFinal;
}

function validarClave($clave) {
    $regex = "/^[a-zA-Z0-9\.\*]{4,20}$/";
    return preg_match($regex, $clave);
}

function generarClaves(){
	return rand(10000, 99999);
}

function informarErrorAlUsuario($linea, $error){
	date_default_timezone_set('America/Bogota');
	$DateAndTime = date('m-d-Y h:i:s a', time());

	return "
	<div style='background-color:tomato; color: black; padding:10px; font-family:Arial;'>
		<p>Ha ocurrido un error al ejecutar esta acción.<br>
		Por favor informe al webmaster sobre este asunto.</p>

		<p>
		DETALLES:<br>
		<b>URL:</b> ".$_SERVER[REQUEST_URI]."<br>
		<b>Linea:</b> $linea<br>
		<b>Fecha y hora:</b> $DateAndTime
		</p>

		<p>
			<pre>".$error."</pre>
		</p>
	</div>
	";
}

function productosPrecioListaUSD($porcentajeUtilidad, $costoEnDolares){
	$utilidadPrincipal = $porcentajeUtilidad / 100;
	$utilidadDelProducto = ($costoEnDolares * $utilidadPrincipal);
	$precioListaUSD = $costoEnDolares + $utilidadDelProducto;

	return $precioListaUSD;
}
