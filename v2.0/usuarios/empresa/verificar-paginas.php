<?php
if(!isset($idPagina)){
	$idPagina = 251;
}

//PAGINAS A LAS QUE TIENE PERMISO EL ROL DEL USUARIO
$consultaPaginaUsuario = mysqli_query($conexionBdPrincipal,"SELECT * FROM paginas_perfiles WHERE pper_tipo_usuario='".$datosUsuarioActual[3]."' AND pper_pagina='".$idPagina."'");
$numPaginaUsuario = mysqli_num_rows($consultaPaginaUsuario);
if($numPaginaUsuario == 0 and $datosUsuarioActual[3]!=1)
{
?>
		<span style='font-family:Arial; color:red;'>No tienes permiso para acceder a este pagina. Ser&aacute;s redireccionado al inicio...</samp>
        <script type="text/javascript">
		function sacar(){
			window.location.href="index.php";
		} 
		setInterval('sacar()', 3000);
        </script>
<?php
	exit();	
}
?>