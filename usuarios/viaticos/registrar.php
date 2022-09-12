<?php include("../sesion.php");?>

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
	  <form method="post" action="../sql.php">
		  <input type="hidden" name="idSql" value="69">
		  
		  <div class="form-group row">
			<label for="fecha" class="col-sm-12 col-form-label">Fecha</label>
			<div class="col-sm-4">
			  	<input type="date" class="form-control" id="fecha" name="fecha" required>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="concepto">Concepto</label>
			<input type="text" class="form-control" id="concepto" name="concepto" required>
		  </div>
		  
		  <div class="form-group row">
			<label for="valor" class="col-sm-12 col-form-label">Valor</label>
			<div class="col-sm-6">
			  	<input type="text" class="form-control" id="valor" name="valor" required>
				<small class="form-text text-info">Coloque este valor sin puntos ni comas.</small>
			</div>
		  </div>
		  
		  <button type="submit" class="btn btn-primary">Registrar</button>
		</form>
	</div>
	
	
	
	
	
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
	<script src="https://kit.fontawesome.com/e60294d763.js" crossorigin="anonymous"></script>
</body>
</html>