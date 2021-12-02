<?php
// Inicia o Activa Sesion
session_start();

// Carga las Funciones de Base de Datos 
include("php/func_bd.php");

// Verifico que si no hay una sesión abierta mande a error
if (
  isset($_SESSION['codigo']) &&
  isset($_SESSION['usuario']) &&
  isset($_SESSION['tipo'])
) {
  // Obtiene los datos del usuario
  $codigo  = $_SESSION['codigo'];
  $usuario = $_SESSION['usuario'];
  $tipo    = $_SESSION['tipo'];

  // Verifica que el tipo sea atencion
  if ($tipo != "atencion") {
    // Variables para el error
    $titulo      = "Error Acceso";
    $descripcion = "Intento de Violación de Acceso de Usuario";
    $enlace      = "index.php";

    // Lanzando Aplicación por Tipo
    header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
  }
} else {
  // Variables para el error
  $titulo      = "Error Acceso";
  $descripcion = "Intento de Violación de Acceso";
  $enlace      = "index.php";

  // Lanzando Aplicación por Tipo
  header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Casa del taco</title>
  <!-- // Incluye bootstrap -->
  <?php include "bootstrap.html"; ?>
  <!-- // Incluimos las reglas de estilo de la aplicación-->
  <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />
</head>

<body>
  <nav class="navbar navbar-light">
    <div class="container-fluid">
      <button type="button" class="btn btn-warning">
        <?php
        echo strtoupper($usuario);
        ?>
      </button>

      <button type="button" class="btn btn-outline-warning">
        <?php
        echo strtoupper($tipo);
        ?>
      </button>
    </div>
  </nav>
  <br>
  <div class="container col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
    <br>
    <div class="row h-100 justify-content-center align-items-center">
      <img src="img/casa del taco logo blanco.png" style="width:200px;" alt="">
      <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
        <br><br>
        <a class="btn btn-outline-danger" href="servicios.php" role="button">
          <h1 class="text-white">Nuevo servicio</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="comandas.php" role="button">
          <h1 class="text-white">Cuentas</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="entregas.php" role="button">
          <h1 class="text-white">Entregas</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="php/salida.php" role="button">
          <h1 class="text-white">Salir</h1>
        </a>
        <br>
      </div>
    </div>
  </div>
<!---comentario 4---->


</body>

</html>