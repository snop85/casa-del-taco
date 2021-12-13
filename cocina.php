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
     if ($tipo != "cocina")
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
  <a class="navbar-brand" href="#">
    <img src="img/logo.png" alt="Logo" style="width:100px;">
  </a>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="php/salida.php">Salida</a>
        </li>    
      </ul>
    </div>
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
    <a class="btn btn-outline-danger text-white" href="php/salida.php" role="button">Salir</a>
  </nav>
  <br>

  <div class="container">
<div class="alert alert-success" role="alert">
<strong>Por preparar</strong> Lista de pedidos.
</div>
    <form>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <table class="table table-bordered table-danger">
              <thead class="thead-danger">
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Comentario</th>
                </tr>
              </thead>
              <tbody>
              <?php  
                  // Obtiene los Productos de Cocina a Preparar
                  $registros = fnGetProductosDeCocina($conexion,$codigo);

                  
               
                  // Ciclo para procesar cada registro de Clase
                  while ($fila = $registros->fetch_assoc()) 
                  {
                      // Coloca los datos en variables
                      $servicio = $fila["servicio"];
                      $comanda  = $fila["numero"];
                      $producto = $fila["producto"];
                      $nombre   = $fila['nombre'];
                      $cantidad = $fila['cantidad'];
                      $comentario = $fila['comentario'];
                   

                      // Crea un row
                      echo "<tr>\n";
                      
                      // Coloca los datos                      
                      echo "<td>";
                      echo "<a class='btn btn-success' href='php/productoPreparado.php?servicio=$servicio&comanda=$comanda&producto=$producto'>";
                      echo "Hecho";
                      //echo "</a>";
                      echo "</td>\n";
                      
                      echo "<td>$nombre</td>\n";
                      echo "<td>$cantidad</td>\n";
                      echo "<td>$comentario</td>\n";
                     
                     

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
        
        <a class="btn btn-warning btn-lg" href="cocina.php" role="button">Actualizar</a>
      </form>
    
  </div>
</body>
</html>