<?php include("sesion.php");?>
<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=HistorialEquipos_".date("d/m/Y").".xls");
include("../conexion.php");
?>
<?php include("head.php");?>
</head>

<body>
<table  width="100%" border="1" rules="all">
    <thead>
    	<tr>
            <th>No</th>
                                <th>Entrada</th>
								<th>Salida</th>
                                <th>Equipo</th>
                                <th>Referencia</th>
								<th>Serial</th>
								<th>Asesor</th>
        </tr>
    </thead>
    <tbody>
<?php
							$consulta = mysql_query("SELECT * FROM remisiones
							INNER JOIN usuarios ON usr_id=rem_asesor
							WHERE rem_cliente='".$_GET["cte"]."'
							",$conexion);
							$no = 1;
							while($res = mysql_fetch_array($consulta)){
							?>   
	
            <tr style="text-align: center;">
								<td><?=$no;?></td>
                                <td><?=$res['rem_fecha'];?></td>
								<td><?=$res['rem_fecha_salida'];?></td>
                                <td><?=$res['rem_equipo'];?></td>
                                <td><?=$res['rem_referencia'];?></td>
								<td><?=$res['rem_serial'];?></td>
								<td><?=$res['usr_nombre'];?></td>
							</tr>
  

<?php
	$no++;
}
?>        
    </tbody>
</table>


	
</body>