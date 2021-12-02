<?php
// Activa Sesion
session_start();

// Verifica si esta iniciada para activa el modulo correspondiente
if (isset($_SESSION['codigo'])) {
	// Obtengo el Tipo
	$tipo = $_SESSION['tipo'];

	// Lanzando Aplicación por Tipo
	header("Location: $tipo.php");
}

// Se realiza la conexion
require("php/conexion.php");

?>

<!DOCTYPE html>
<html>

<head>
	<title>Comandas</title>

	<!-- // Incluye bootstrap -->
	<?php include "bootstrap.html"; ?>

	<!-- // Incluimos las reglas de estilo de la aplicación-->
	<link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />


</head>

<body>




	<!-- // Separador -->
	<br>
	<br>
	<br>

	<!-- Contenedor Principal -->
	<div class="container col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
		<body class="text-center" cz-shortcut-listen="true">
			<form action="php/login.php" method="POST">
				<img class="mb-4" src="img/casa del taco logo blanco.png" alt="" width="200" height="200">

				<!-- Encabezado  -->
				<h1 class="text-white">Inicio de Sesión prueba git</h1>
				<br>
				<div class="form-floating">
					<input type="text" class="form-control" name="codigo"> <label for="floatingInput">Nombre de usuario</label>
				</div>
				<br>
				<div class="form-floating">
					<input type="password" class="form-control" value="admin" name="clave">
					<label for="floatingPassword">Contraseña</label>
				</div>

				<br>
				<button class="w-100 btn btn-lg btn-dark" type="submit">Entrar</button>
				<p class="mt-5 mb-3 text-white">© Casa del taco 2021</p>
			</form>
			<style>
				.tb_button {
					padding: 1px;
					cursor: pointer;
					border-right: 1px solid #8b8b8b;
					border-left: 1px solid #FFF;
					border-bottom: 1px solid #fff;
				}

				.tb_button.hover {
					borer: 2px outset #def;
					background-color: #f8f8f8 !important;
				}

				.ws_toolbar {
					z-index: 100000
				}

				.ws_toolbar .ws_tb_btn {
					cursor: pointer;
					border: 1px solid #555;
					padding: 3px
				}

				.tb_highlight {
					background-color: yellow
				}

				.tb_hide {
					visibility: hidden
				}

				.ws_toolbar img {
					padding: 2px;
					margin: 0px
				}
			</style>
		</body>
	</div>
</body>
</html>