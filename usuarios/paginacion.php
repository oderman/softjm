<?php
$consultaTotal = mysql_query($SQL,$conexion);
$numTotal = mysql_num_rows($consultaTotal);
$limite = $configu['conf_paginacion']; 
if(!isset($_GET["inicio"]) or !is_numeric($_GET["inicio"]))
	$inicio = 0;
else{
	if($_GET["inicio"]==1)
		$inicio = 0;
	else
		$inicio = ($_GET["inicio"] - 1) * $limite;	
}	
$paginas = ceil($numTotal/$limite);
?>
<!--<div class="pagination pagination-right">-->
<div class="pagination">
    <ul>
		<?php
        if($_GET["inicio"]>1 and $paginas>1)
        	echo '<li><a href="'.$_SERVER['PHP_SELF'].'?inicio='.($_GET["inicio"]-1).'&dpto='.$_GET["dpto"].'&busqueda='.$_GET["busqueda"].'&q='.$_GET["q"].'&cte='.$_GET["cte"].'">Anterior</a></li>';
        else
        	echo '<li class="disabled"><a href="#">Anterior</a></li>';
        for($i=1; $i<=$paginas; $i++){
			if($i==$_GET["inicio"])
				echo '<li class="active"><a href="#">'.$i.'</a></li>';
			else
				echo '<li><a href="'.$_SERVER['PHP_SELF'].'?inicio='.$i.'&dpto='.$_GET["dpto"].'&busqueda='.$_GET["busqueda"].'&q='.$_GET["q"].'&cte='.$_GET["cte"].'">'.$i.'</a></li>';
        }
        if($_GET["inicio"]<$paginas)
        	echo '<li><a href="'.$_SERVER['PHP_SELF'].'?inicio='.($_GET["inicio"]+1).'&dpto='.$_GET["dpto"].'&busqueda='.$_GET["busqueda"].'&q='.$_GET["q"].'&cte='.$_GET["cte"].'">Siguiente</a></li>';
        else
        	echo '<li class="disabled"><a href="#">Siguiente</a></li>';
        ?>
    </ul>
</div>