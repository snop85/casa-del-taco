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
  if ($tipo != "caja") {
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
      <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Logo" style="width:100px;"></a>
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="php/salida.php">
              <h2 class="text-white">Salir</h2>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>

  <div class="container">
    <form action='comandasAgregar.php' class='' method='GET'>

      <div class="form-group">
        <label for="idMesas">
          <h1 class="text-white">Selecciona la mesa para cobrar:</h1>
        </label>
        <br> <br>
        <select class="form-select form-select-lg mb-3" id="idMesas" name="servicio-mesa" required aria-label=".form-select-lg example">
          <?php
          // ejecuta la Consulta de Mesas Libres
          $mesasUsuario = fnGetMesasUsuario($conexion, $codigo);

          // Ciclo para procesar cada registro de usario
          while ($fila = $mesasUsuario->fetch_assoc()) {
            // Crea el elemento del Select
            echo "<option value=" . $fila['numero'] . "-";
            echo $fila['mesa'] . ">";
            echo "[" . $fila['mesa'] . "]-" . $fila['nombre'];
            echo "</option>";
          }
          ?>

        </select>



      </div>
      

      <button type="submit" class="btn btn-warning btn-lg" name="proceso" value="cobrar" name="Cobrar">Cobrar
      </button>
    </form>

  </div>
</body>

</html>