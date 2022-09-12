<?php
$conexion = new mysqli("localhost","root","1234", 'odermancom_jm_crm');
//seleccionamos la base de datos
/*
$baseDatosSeleccionada = '';
if(!isset($_SESSION["bd"])){

	if(!isset($_POST["bd"])){
		session_start();
		session_destroy();
		//header("Location:index.php?bd=0&exit=1");
		echo "No hay bd seleccionada";
		//exit();
	}else{
		$baseDatosSeleccionada = $_POST["bd"];
	}

	//mysql_select_db($_POST["bd"],$conexion);

	
	
}else{
	//mysql_select_db($_SESSION["bd"], $conexion);
	$baseDatosSeleccionada = $_SESSION["bd"];
}
*/
//Conexion con el Servidor
//$conexion = new mysqli("localhost","root","1234", $baseDatosSeleccionada);
//$conexion=mysql_connect("localhost","softjm_crm_user",")S{q9V7hBJv;");


//mysql_select_db("odermancom_jm_crm",$conexion);
//$bdAdmin = 'orioncrmcom_crm_admin';
//$bdAdmin = 'softjm_crm_general';
?>