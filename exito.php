<?php
  // Obtiene las Variables para el error
  if (isset($_GET["titulo"]))
     $titulo = $_GET["titulo"];
  else
  	 $titulo = "Exito Titulo";

  if (isset($_GET["descripcion"]))	
     $descripcion = $_GET["descripcion"];
  else
  	 $descripcion = "Descripción del Exito";

  if (isset($_GET["enlace"]))	
     $enlace = $_GET["enlace"];  
  else
  	 $enlace = "index.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Comandas-Error</title>
	<!-- // Incluye bootstrap -->
	<?php include "bootstrap.html"; ?>
</head>
<body>
	<!-- Objeto Navbar de BootStrap -->
	<nav class="navbar navbar-light">
		<a class="navbar-brand" href="#">Comandas-Sesion-Exito</a>
		<!-- <button class="navbar-toggler" type="button" 
		        data-toggle="collapse" data-target="#collapsibleNavbar">
			    <span class="navbar-toggler-icon"></span>
		</button> -->
	</nav>

    <!-- // Separador -->
    <br>

	<div class="container">
		
		<!-- The Modal -->
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">
					<?php
					   echo $titulo;
					?>
				</h4>				
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<?php
				  echo $descripcion;
				?>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<?php
				   echo "<a href='$enlace'' class='btn btn-success' role='button'>Continuar</a>";
				?>
			</div>

		</div>
	
	</div>
</body>
</html>