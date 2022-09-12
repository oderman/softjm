<?php include("../sesion.php");?>
<?php include("../../conexion.php");?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Viáticos</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
</head>

<body>
	
	<?php include("menu.php");?>
	
		<div class="container" style="margin-top: 70px;">
			
			<p><a href="registrar.php" class="btn btn-danger"><i class="fas fa-folder-plus"></i> Nuevo gasto</a></p>
			
			<?php if($_SESSION["id"]==7 or $_SESSION["id"]==15){?>
			<p>
			<form action="index.php" method="get">	
				<div class="form-group row">
					<div class="col-sm-4">
						<select class="form-control" name="user">
						  <option value="0">--Usuario Responsable--</option>
						  <?php
							$opciones = mysql_query("SELECT * FROM usuarios");
							while($datosOpciones = mysql_fetch_array($opciones)){
							?>
								<option value="<?=$datosOpciones[0];?>" <?php if($datosOpciones[0]==$_GET["user"]){echo "selected";}?> ><?=strtoupper($datosOpciones['usr_nombre']);?></option>
							<?php }?>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Filtrar</button>
				  </div>
			</form>
			</p>
			<?php }?>
			
		  <table class="table">
			  <thead>
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">Fecha</th>
				  <th scope="col">Concepto</th>
				  <th scope="col">Valor</th>
				  <th scope="col">Responsable</th>
				  <th scope="col">&nbsp;</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				  $filtro = '';
				  if($_GET["user"]!=""){$filtro .= " AND gasv_responsable='".$_GET["user"]."'";}
				 $consulta = mysql_query("SELECT * FROM gastos 
				 INNER JOIN usuarios ON usr_id=gasv_responsable
				 WHERE gasv_responsable='".$_SESSION["id"]."' $filtro
				 ",$conexion);
				 while($datos = mysql_fetch_array($consulta)){
				 ?>
				<tr>
				  <th scope="row"><?=$datos['gasv_id'];?></th>
				  <td><?=$datos['gasv_fecha'];?></td>
				  <td><?=$datos['gasv_concepto'];?></td>
				  <td>$<?=number_format($datos['gasv_valor'], 0, "," , ".");?></td>
				  <td><?=$datos['usr_nombre'];?></td>
				   <td>
					   <a href="../sql.php?get=60&id=<?=$datos['gasv_id'];?>" onClick="if(!confirm('Desea Eliminar este registro')){return false;}">
					   	<i class="fas fa-backspace" style="color: Tomato;"></i>
					</td>
				</tr>
				  <?php }?>
			  </tbody>
			</table>
		</div>
	
	
	
	
	
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
	<script src="https://kit.fontawesome.com/e60294d763.js" crossorigin="anonymous"></script>
</body>
</html>