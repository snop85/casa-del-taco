<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo']) && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo']))
  {
     // Obtiene los datos del usuario
     $codigo  = $_SESSION['codigo'];
     $usuario = $_SESSION['usuario'];
     $tipo    = $_SESSION['tipo'];    

     // Verifica que el tipo sea control
     if ($tipo != "control")
     {
        // Variables para el error
        $titulo      = "Error Acceso";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
  }
  else
  {
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
  <a class="navbar-brand" href="#"> <img src="img/logo.png" alt="Logo" style="width:100px;"> </a>
  <button type="button" class="btn btn-warning">
          <?php 
            echo strtoupper($usuario);      
          ?>
    </button>
    
    <button type="button" class="btn btn-outline-warning">
          Administración
    </button>
  </nav>
  <br>

  <div class="container col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="btn-group-vertical" role="group" aria-label="Button group with nested dropdown">
        <a class="btn btn-outline-danger" href="usuarios.php" role="button">
          <h1 class="text-white" >Usuarios</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="mesas.php" role="button">
          <h1 class="text-white">Mesas</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="clases.php" role="button">
          <h1 class="text-white">Clases</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="comentarios.php" role="button">
          <h1 class="text-white">Comentarios</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="productos.php" role="button">
          <h1 class="text-white">Productos</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="venta.php" role="button">
          <h1 class="text-white">Ventas</h1>
        </a>
        <br>
        <a class="btn btn-outline-danger" href="php/salida.php" role="button">
          <h1 class="text-white">Salir</h1>
        </a>
        <br>
      </div>
    </div>
  </div>
</body>
</html>