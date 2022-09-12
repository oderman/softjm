<?php
$conexion = mysql_connect("localhost", "odermancom_jm_crm", ")S{q9V7hBJv;");
mysql_select_db("odermancom_jm_crm", $conexion);


$consulta = mysql_query("SELECT * FROM usuarios_tipos WHERE utipo_id=7", $conexion);
if (mysql_errno() != 0) {
	echo mysql_error();
}

while ($resultado = mysql_fetch_array($consulta)) {

	$consultaDos = mysql_query("SELECT * FROM paginas", $conexion);
	if (mysql_errno() != 0) {
		echo mysql_error();
		exit();
	}


	while ($resultadoDos = mysql_fetch_array($consultaDos)) {

		$resultadoTres = mysql_fetch_array(mysql_query("SELECT * FROM paginas_perfiles WHERE pper_tipo_usuario='".$resultado['utipo_id']."' AND pper_pagina='".$resultadoDos['pag_id']."'", $conexion));
		if (mysql_errno() != 0) {
			echo mysql_error();
			exit();
		}

		if($resultadoTres[0]!=""){
			mysql_query("DELETE FROM paginas_perfiles WHERE pper_tipo_usuario='".$resultado['utipo_id']."' AND pper_pagina='".$resultadoDos['pag_id']."'", $conexion);
			if (mysql_errno() != 0) {
				echo mysql_error();
				exit();
			}
		}else{
			mysql_query("INSERT INTO paginas_perfiles (pper_tipo_usuario, pper_pagina)VALUES('".$resultado['utipo_id']."', '".$resultadoDos['pag_id']."')", $conexion);
			if (mysql_errno() != 0) {
				echo mysql_error();
				exit();
			}	
		}


	}

}	

/*
$consulta = mysql_query("SELECT * FROM productos",$conexion);
if(mysql_errno()!=0){echo mysql_error();}

while($resultado = mysql_fetch_array($consulta)){
	mysql_query("INSERT INTO productos_bodegas(prodb_producto, prodb_bodega, prodb_existencias, prodb_fecha_actualizacion, prodb_usuario_actualizacion)VALUES('".$resultado['prod_id']."', 1, '".$resultado['prod_existencias']."', now(), 7)",$conexion);
	if(mysql_errno()!=0){echo mysql_error(); exit();}
}*/



/*
$seguimientos = mysql_query("SELECT * FROM cliente_seguimiento group by cseg_cliente",$conexion);
if(mysql_errno()!=0){echo mysql_error();}

while($seg = mysql_fetch_array($seguimientos)){
	mysql_query("INSERT INTO clientes_tikets(tik_asunto_principal, tik_tipo_tiket, tik_fecha_creacion, tik_usuario_responsable, tik_estado, tik_cliente, tik_prioridad)VALUES('".substr($seg[3],0,200)."','".$seg['cseg_tipo']."','".$seg['cseg_fecha_contacto']."','".$seg['cseg_usuario_responsable']."',1,'".$seg['cseg_cliente']."',1)",$conexion);
	if(mysql_errno()!=0){echo mysql_error(); exit();}
	$idInsertU = mysql_insert_id();
	
	mysql_query("UPDATE cliente_seguimiento SET cseg_tiket='".$idInsertU."' WHERE cseg_cliente='".$seg['cseg_cliente']."'",$conexion);
	if(mysql_errno()!=0){echo mysql_error();}
}*/
/*
$productos = mysql_query("SELECT * FROM productos
INNER JOIN proveedores ON prov_documento=prod_proveedor
",$conexion);
if(mysql_errno()!=0){echo mysql_error();}

while($prod = mysql_fetch_array($productos)){
	mysql_query("UPDATE productos SET prod_proveedor='".$prod['prov_id']."' WHERE prod_proveedor='".$prod['prov_documento']."'",$conexion);
	if(mysql_errno()!=0){echo mysql_error();}
}
*/