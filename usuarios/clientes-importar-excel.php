<?php include("sesion.php");?>
<?php
if($_FILES['planilla']['name']!=""){
	$archivo = $_FILES['planilla']['name']; $destino = "files/excel";
	move_uploaded_file($_FILES['planilla']['tmp_name'], $destino ."/".$archivo);
}
?>
<?php
//set_time_limit (0);

// Test CVS
require_once '../Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

// Set output Encoding.
$data->setOutputEncoding('CP1251');

//Read File
$data->read('files/excel/'.$archivo);

error_reporting(E_ALL ^ E_NOTICE);


$datosInsert = '';
for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	
	//echo $data->sheets[0]['cells'][$i][1]; exit();
		
	//Si nombre y codigo de la ciudad están llenos
	if(trim($data->sheets[0]['cells'][$i][2])!="" and $data->sheets[0]['cells'][$i][7]!=""){
		

		$datosUsuario = mysql_fetch_array(mysql_query("SELECT * FROM clientes 
		WHERE (cli_usuario='".$data->sheets[0]['cells'][$i][1]."' AND cli_usuario!='') OR (cli_email='".$data->sheets[0]['cells'][$i][4]."' AND cli_email!='')",$conexion));
		if(mysql_errno()!=0){echo mysql_error()." - CONSULTAR USUARIO<br>";}
		
		//SI EL CLIENTE YA EXISTE CON EL NIT
		if($datosUsuario['cli_id']!=""){
			
			if($datosUsuario['cli_usuario']=="" and $data->sheets[0]['cells'][$i][1]!=""){
				mysql_query("UPDATE clientes SET cli_usuario='".$data->sheets[0]['cells'][$i][1]."', cli_clave='".$data->sheets[0]['cells'][$i][1]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR USUARIO"; exit();}
			}
			/*
			if($datosUsuario['cli_email']=="" and $data->sheets[0]['cells'][$i][3]!=""){
				mysql_query("UPDATE clientes SET cli_email='".$data->sheets[0]['cells'][$i][3]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR EMAIL"; exit();}
			}
			
			if($datosUsuario['cli_telefono']=="" and $data->sheets[0]['cells'][$i][4]!=""){
				mysql_query("UPDATE clientes SET cli_telefono='".$data->sheets[0]['cells'][$i][4]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR TELÉFONO"; exit();}
			}
			
			if($datosUsuario['cli_direccion']=="" and $data->sheets[0]['cells'][$i][7]!=""){
				mysql_query("UPDATE clientes SET cli_direccion='".$data->sheets[0]['cells'][$i][7]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR DIRECCIÓN"; exit();}
			}
			
			if($datosUsuario['cli_celular']=="" and $data->sheets[0]['cells'][$i][8]!=""){
				mysql_query("UPDATE clientes SET cli_celular='".$data->sheets[0]['cells'][$i][8]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR CELULAR"; exit();}
			}
			
			if($datosUsuario['cli_telefonos']=="" and $data->sheets[0]['cells'][$i][9]!=""){
				mysql_query("UPDATE clientes SET cli_telefonos='".$data->sheets[0]['cells'][$i][9]."', cli_montados=2 
				WHERE cli_id='".$datosUsuario['cli_id']."'",$conexion);
				if(mysql_errno()!=0){echo mysql_error()." - ACTUALIZAR TELÉFONOS"; exit();}
			}
			*/
			
		}
		//SI EL CLIENTE NO EXISTE
		else{
			$zona = mysql_fetch_array(mysql_query("SELECT * FROM localidad_ciudades 
			WHERE ciu_id='".$data->sheets[0]['cells'][$i][7]."'",$conexion));
			if(mysql_errno()!=0){echo mysql_error()." - CONSULTAR ZONAS"; exit();}
			
			mysql_query("INSERT INTO clientes(cli_nombre, cli_categoria, cli_email, cli_telefono, cli_ciudad, cli_usuario, cli_clave, cli_direccion, cli_zona, cli_fecha_ingreso, cli_fecha_registro, cli_celular, cli_clave_documentos,  cli_responsable)VALUES(
			'".$data->sheets[0]['cells'][$i][2]."',
			1,
			'".$data->sheets[0]['cells'][$i][4]."',
			'".$data->sheets[0]['cells'][$i][5]."',
			'".$data->sheets[0]['cells'][$i][7]."',
			
			'".$data->sheets[0]['cells'][$i][1]."',
			'".$data->sheets[0]['cells'][$i][1]."',
			'".$data->sheets[0]['cells'][$i][8]."',
			'".$zona[2]."',
			now(),
			now(),
			'".$data->sheets[0]['cells'][$i][6]."',
			'1234$',
			'".$_SESSION["id"]."'
			)
			",$conexion);
			if(mysql_errno()!=0){echo mysql_error()." - ERROR INSERTAR CLIENTES<br>";}
			$clienteID = mysql_insert_id();
			
			//mysql_query("INSERT INTO clientes_categorias(cpcat_cliente, cpcat_categoria)VALUES('".$clienteID."',".$data->sheets[0]['cells'][$i][10].")",$conexion);
			//if(mysql_errno()!=0){echo mysql_error()." - ERROR CATEGORIAS<br>";}
		}
		
		/*
		echo $i.") ".$data->sheets[0]['cells'][$i][1]
			." - ".$data->sheets[0]['cells'][$i][2]
			." - ".$data->sheets[0]['cells'][$i][3]
			." - ".$data->sheets[0]['cells'][$i][4]
			." - ".$data->sheets[0]['cells'][$i][5]
			." - ".$data->sheets[0]['cells'][$i][6]
			." - ".$data->sheets[0]['cells'][$i][7]
			." - ".$data->sheets[0]['cells'][$i][8]
			." - ".$data->sheets[0]['cells'][$i][9]
			." - ".$data->sheets[0]['cells'][$i][10]
			." - ".$data->sheets[0]['cells'][$i][11]
			."<br>";
			*/
		
	}
}

//exit();

echo '<script type="text/javascript">window.location.href="clientes-importar.php?msg=ok";</script>';
exit();


//print_r($data);
//print_r($data->formatRecords);
?>
