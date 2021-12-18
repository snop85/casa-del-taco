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

     // Verifica que el tipo sea atencion
     if ($tipo != "control")
     {
        // Variables para el error
        $titulo      = "Error Acceso Venta";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso Venta";
     $descripcion = "Intento de Violación de Acceso. Falta de Datos";
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
  <script type="text/javascript">
    function printHTML() 
    { 
      if (window.print) 
      { 
        window.print();
      }
    }
  </script>
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
         Registro de ventas 
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
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="mesas.php">
            <h2 class="text-white">Mesas</h2>
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


  <div class="card text-white bg-dark mb-3">
  <div class="card-header">Registro de ventas</div>
  <div class="card-body">
    <h5 class="card-title">Seleccione un rango de fechas</h5>
    <div class="row">
      


    <form class="form-inline" method="POST" action="">
   
    <div class="col-md-4">  <input type="date" class="form-control" placeholder="Start"  name="date1"/></div>
            <div class="col-md-4">  <input type="date" class="form-control" placeholder="End"  name="date2"/> </div>
            <div class="col-md-4">  <button class="btn btn-primary pro-button w-100" name="search">Buscar<i class="fa fa-plane ml-2"></i></button> </div>
      
    </form>
        </div>
        <br>
         <form class='was-validated'>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <table class="table table-striped table-light">
              <thead class="thead-dark">
                <tr>
                    <th>Servicio</th>
                    <th>Hora</th>
                    <th>Mesa</th>
                    <th>Mesero</th>
                    <th>Personas</th>
                    <th style="text-align: right">Total</th>
                </tr>
              </thead>
              <tbody>

              <?php  
                  // Variable para la Suma Total
                  $sumaTotales = 0;

                  // Obtiene los Productos de Cocina a Preparar
                  $registros = fnGetVentaDia($conexion,$codigo);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Coloca los datos en variables
                      $servicio   = $fila["numero"];
                      $fecha       = $fila["fecha"];
                      $mesa       = $fila["mesa"];
                      $mesero     = $fila['mesero'];
                      $comensales = $fila['comensales'];
                      $total      = $fila['total'];

                      // Agrega a la suma
                      if (is_numeric($total))
                        $sumaTotales+=$total;

                      // Crea un row
                      echo "<tr> \n";
                      
                      // Coloca los datos                      
                      echo "<td>";
                      echo "<a class='btn btn-success' href='ventaServicio.php?servicio=$servicio'>";
                      echo $servicio;
                      //echo "</a>";
                      echo "</td>\n";
                      
                      echo "<td>$fecha</td>\n";
                      echo "<td>$mesa</td>\n";
                      echo "<td>$mesero</td>\n";
                      echo "<td>$comensales</td>\n";
                      echo "<td align=right>$total</td>\n";

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
          <?php
              echo "<p align=right class='bg-dark text-white'>&nbsp&nbspTotal: ".number_format($sumaTotales,2)."&nbsp&nbsp&nbsp</p>\n";
          ?>
        <button onclick="printHTML()" class="btn btn-success">Imprimir</button>        
      </form>
  </div>
</div>
  </div>
</body>
</html>