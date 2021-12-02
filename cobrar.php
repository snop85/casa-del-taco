<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo'])  && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo']))
  {
     // Obtiene los datos del usuario
     $codigo   = $_SESSION['codigo'];
     $usuario  = $_SESSION['usuario'];
     $tipo     = $_SESSION['tipo'];             

     // Verifica que el tipo sea atencion
     if ($tipo != "atencion")
     {
        // Variables para el error
        $titulo      = "Error Acceso";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
     else
     {
        // Verifico que venga servicio y mesa por GET
        if (!isset($_GET["servicio"]) ||
            !isset($_GET["mesa"]))
        {
           // Variables para el error
           $titulo      = "Error Acceso";
           $descripcion = "Intento de Violación de Acceso por Información";
           $enlace      = "index.php";

           // Lanzando Aplicación por Tipo
           header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
        }
        else
        {
           // Obtiene la Mesa y El Servicio
          $servicio = $_GET["servicio"];
          $mesa     = $_GET["mesa"];
        }
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
          <a class="nav-link" href="comandas.php">
            Comandas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="entregas.php">
            Entregas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="php/salida.php">Salida</a>
        </li>  
      </ul>
    </div>
  </div>
</nav>
  <br>

  <div class="container">
    <form action='php/servicioCobro.php' class='was-validated' method='POST'>
      <!-- Coloco datos ocultos-->
      <div class="form-group">
        

<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
          <img class="me-3" src="img/logo.png" alt="" width="48" height="48">
          <div class="lh-1">
          <?php
               echo "<input type='hidden' name='servicio' value='$servicio'>";
               echo "<input type='hidden' name='mesa' value='$mesa'>";
               echo "<h1 class='text-white'>&nbsp&nbspCuenta: $servicio Mesa: $mesa </p>\n";                            
            ?>
          </div>
        </div>

        <table class="table table-dark table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Codigo</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Importe</th>
            </tr>
          </thead>
          <tbody>

            <?php  
                  // Variable para el Total
                  $total = 0;

            

                  // Obtiene los registros
                  $registros = fnGetServicioCobrar($conexion,$codigo,$servicio);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Crea un row
                      echo "<tr> \n";
                    
                      // Coloca los datos
                      echo "<td>".$fila['producto']."</td>\n";
                      echo "<td>".$fila['nombre']."</td>\n";
                      echo "<td>".$fila['cantidad']."</td>\n";
                      echo "<td>".$fila['precio']."</td>\n";
                      echo "<td>".$fila['importe']."</td>\n";

                      // Incremento el Total
                      $total += $fila['importe'];

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }

              ?>
          </tbody>
        </table>
        <?php

             // Variable para el Total
               echo "<input type='hidden' name='total' value='$total'>";
               echo "<p align=right class='bg-dark text-white'>&nbsp&nbspTotal: ".number_format($total,2)."&nbsp&nbsp&nbsp</p>\n";
               $registros = fnGetServicioCobrar($conexion,$codigo,$servicio);
            ?>
      </div>
      <button type="submit" class="btn btn-success">Aceptar</button>
      <a class="btn btn-warning" href="atencion.php" role="button">Regresar</a>
  </div>
  <br><br><br>

</body>

</html>