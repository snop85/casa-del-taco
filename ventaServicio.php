<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo'])  && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo'])    &&
      isset($_GET["servicio"]))
  {
     // Obtiene los datos del usuario
     $codigo   = $_SESSION['codigo'];
     $usuario  = $_SESSION['usuario'];
     $tipo     = $_SESSION['tipo'];    
     $servicio = $_GET["servicio"];

     // Verifica que el tipo sea atencion
     if ($tipo != "control")
     {
        // Variables para el error
        $titulo      = "Error Acceso Venta Servicio";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso Venta Servicio";
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

    
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <?php
              echo "<p class='bg-warning text-white'>&nbspServicio:$servicio</p>\n";
            ?>
            <table class="table table-hover table-dark">
              <thead class="thead-dark">
                <tr>
                    <th>Hora</th>
                    <th>Producto</th>
                    <th>Precio</th>                  
                    <th>Cantidad</th>
                    <th>Comentario</th>
                    <th>Estado</th>
                </tr>
              </thead>
              <tbody>

              <?php  
                  // Variable para la Suma Total
                  $sumaTotales = 0;

                  // Obtiene información del Servicio
                  $registros = fnGetServicio($conexion,$servicio);
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Coloca los datos en variables
                      $hora       = $fila["hora"];
                      $producto   = $fila["producto"];
                      $precio     = $fila["precio"];
                      $cantidad   = $fila['cantidad'];
                      $comentario   = $fila['comentario'];
                      $estado     = $fila['estado'];

                      // Agrega a la suma
                      $sumaTotales+=($precio * $cantidad);

                      // Crea un row
                      echo "<tr> \n";
                      
                      // Coloca los datos                      
                     
                      echo "<td>".substr($hora,0,5)."</td>\n";
                      echo "<td>$producto</td>\n";
                      echo "<td>$precio</td>\n";
                      echo "<td>$cantidad</td>\n";
                      echo "<td>$comentario</td>\n";
                      echo "<td>$estado</td>\n";

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
          <?php
              echo "<p align=right class='bg-warning text-white'>&nbsp&nbspTotal: ".number_format($sumaTotales,2)."&nbsp&nbsp&nbsp</p>\n";
          ?>
        <button onclick="printHTML()" class="btn btn-success">Imprimir</button>        
      
    
  </div>


</body>
</html>