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
		

		$datosUsuario = mysql_fetch_array(mysql_query("SELECT * FROM proveedores 
		WHERE (prov_documento='".$data->sheets[0]['cells'][$i][1]."' AND prov_documento!='') OR (prov_email='".$data->sheets[0]['cells'][$i][4]."' AND prov_email!='')",$conexion));
		if(mysql_errno()!=0){echo mysql_error()." - CONSULTAR PROVEEDOR<br>";}
		
		//SI EL PROVEEDOR YA EXISTE CON EL NIT
		if($datosUsuario['cli_id']!=""){
			echo 'Este proveedor ya existe';
			exit();
			
		}
		//SI EL PROVEEDOR NO EXISTE
		else{

			
			mysql_query("INSERT INTO proveedores(prov_documento, prov_clave, prov_nombre, prov_email, prov_telefono, prov_ciudad, prov_fecha_registro, prov_responsable, prov_eliminado,  prov_tipo_regimen, prov_direccion)VALUES(
			'".$data->sheets[0]['cells'][$i][1]."',
			'".$data->sheets[0]['cells'][$i][1]."',
			'".$data->sheets[0]['cells'][$i][2]."',
			'".$data->sheets[0]['cells'][$i][4]."',
			'".$data->sheets[0]['cells'][$i][5]."',
			
			'".$data->sheets[0]['cells'][$i][7]."',
			now(),
			'".$_SESSION["id"]."',
			0,
			'".$data->sheets[0]['cells'][$i][3]."',
			'".$data->sheets[0]['cells'][$i][8]."'
			)
			",$conexion);
			if(mysql_errno()!=0){echo mysql_error()." - ERROR INSERTAR<br>";}
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

echo '<script type="text/javascript">window.location.href="proveedores.php?msg=ok";</script>';
exit();


//print_r($data);
//print_r($data->formatRecords);
?>
