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
  <title>Comandas</title>
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
         Administración de mesas
    </button>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="index.php">
            <h2 class="text-white">Inicio</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="usuarios.php">
            <h2 class="text-white">Usuarios</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="clases.php">
            <h2 class="text-white">Clases</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="comentarios.php">
            <h2 class="text-white">Comentarios</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="productos.php">
            <h2 class="text-white">Productos</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="venta.php">
            <h2 class="text-white">Ventas</h2>
          </a>
        </li>
        <li class="nav-item">
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="php/salida.php">
            <h2 class="text-white">Salir</h2>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <br>

  <div class="container">
    <table class="table table-hover table-dark">
      <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="mesasABC.php?operacion=Alta">
            <h2 class="text-white">Nueva mesa</h2>
          </a>
      <thead>
        <thead class="thead-dark">
          <th>Número</th>
          <th>Nombre</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php
         // Llamo a Función que obtiene los usuarios
        $mesas = fnGetDatos($conexion,"mesas");         

         // Ciclo para procesar cada registro de usario
        while ($fila = $mesas->fetch_assoc()) 
        {
          // Crea el Enlace para Cambio 
          $enlaceCambio  = "mesasABC.php?operacion=Cambios";
          $enlaceCambio .= "&numero=".$fila['numero'];
          $enlaceCambio .= "&nombre=".$fila['nombre'];
          // Reemplaza los espacios en blanco
          $enlaceCambio = str_replace(" ", "%20", $enlaceCambio);
          

          // Crea el Enlace para la Baja
          $enlaceBaja  = "mesasABC.php?operacion=Baja";
          $enlaceBaja .= "&numero=".$fila['numero'];
          $enlaceBaja .= "&nombre=".$fila['nombre'];
          // Reemplaza los espacios en blanco
          $enlaceBaja = str_replace(" ", "%20", $enlaceBaja);

          // Crea el Row
          echo "<tr>";

          // Crea las Celdas con los datos
          echo "<td>".$fila['numero']."</td>";
          echo "<td>".$fila['nombre']."</td>";
          echo "<td>";
          echo "<a href=$enlaceCambio><img src='img/edit.png'></a>";
          echo "<a href=$enlaceBaja><img src='img/del.png'></a>";
          echo "</td>";

            // Cierra el Row
          echo '</tr>';
        }
        ?>    
      </tbody>    
    </table>    
  </div>
  <br><br>
</body>
</html>