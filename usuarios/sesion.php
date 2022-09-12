<?php
session_start();
if($_SESSION["id"]=="")
	header("Location:../salir.php");
else
{
	$tiempo_inicial = microtime(true);
	/*if($_SERVER['HTTP_REFERER']==""){
		echo "<span style='font-family:Arial; color:red;'>Usted no est&aacute; accediendo de manera correcta. Utilice las opciones del sistema.</samp>";
		exit();	
	}
	*/
	include("../conexion.php");
	include("config/config.php");

	
	//USUARIO ACTUAL
	$consultaUsuarioActual = mysql_query("SELECT * FROM usuarios WHERE usr_id='".$_SESSION["id"]."'",$conexion);
	$numUsuarioActual = mysql_num_rows($consultaUsuarioActual);
	$datosUsuarioActual = mysql_fetch_array($consultaUsuarioActual);
	//SABER SI ESTA BLOQUEADO
	if($datosUsuarioActual['usr_bloqueado']==1)
	{
?>		
		<span style='font-family:Arial; color:red;'>Su usuario ha sido bloqueado. Por tanto no tiene permisos para acceder al Sistema.</samp>
        <script type="text/javascript">
		function sacar(){
			window.location.href="../salir.php";
		} 
		setInterval('sacar()', 3000);
        </script>
<?php	
    	exit();		
	}
}
?>

<?php
//CONFIGURACIÓN DEL PROGRAMA
$monedas = array("","COP","USD");
$monedasExt = array("","USD","EURO");
$simbolosMonedas = array("","$","USD");
$tipoTicket = array("", "Comercial", "Soporte técnico", "Soporte Operativo");
$referenciaLlegada = array("", "Publicidad física", "Publicidad digital", "Sitio Web", "Evento", "Email", "Llamada", "Referencia Cliente", "Referencia Empleado", "WhatsApp", "Facebook", "Google", "Otro");
$negociosPerdidos = array("", "Precio", "Calidad", "Atención", "Inventario");
$negociosGanados = array("", "Precio", "Calidad", "Atención");
$estadoRegistros = array("Inactivo", "Activo");
$opcionSINO = array("NO", "SI");
$tipoDocumento = array("Desc.", "Desc.", "NIT", "Cédula");

$tipoBuzon = array("Desc.", "Portafolios", "Cotización");
$estadoBuzon = array("Desc.", "OK", "ERROR");

$tipoFactura = array("Desc.", "Venta", "Compra");
$nacionFactura = array("Nacional", "Extrajera");
$nacionEtiqueta = array("success", "warning");

$origenPrecioProducto = array("N/A", "Costo", "Utilidad", "Costo y utilidad", "Guardado de precios");
?>
