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
        $titulo      = "Error de Acceso: Entregas";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }     
  }
  else
  {
     // Variables para el error
     $titulo      = "Error de Acceso: Entregas";
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
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="servicios.php">
              <h2 class="text-white">Servicios</h2>
            </a>
          </li>
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="comandas.php">
              <h2 class="text-white">Comandas</h2>
            </a>
          </li>
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
  <div class="alert alert-success" role="alert">
    <strong>Listo para entrega!</strong> Por favor has clic en entregado cuando corresponda.
</div>
    <form>
          <!-- Coloco datos ocultos-->                    
          <div class="form-group">
            <table class="table table-bordered table-dark">
              <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Mesa</th>
                    <th>Cantidad</th>
                    <th>Comentario</th>
                </tr>
              </thead>
              <tbody>

              <?php  

                  // Obtiene los Productos a Entregar del usuario
                  $registros = fnGetProductosAEntregar($conexion,$codigo);
               
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
                      echo "<tr> \n";

                      // Coloca los datos
                      echo "<td>";
                      echo "<a class='btn btn-success' href='php/productoEntregado.php?servicio=$servicio&comanda=$comanda&producto=$producto'>";
                      echo "Entregado";
                      echo "</td>\n";
                      echo "<td>".$fila['nombre']."</td>\n";
                      echo "<td>".$fila['mesa']."</td>\n";   
                      echo "<td>".$fila['cantidad'];
                      echo "<td>$comentario</td>\n";
                      echo "</td>\n";

                      // Cierra el Renglón
                      echo "</tr>";                    
                  }
              ?>
              </tbody>
            </table>  
          </div>
        <a class="btn btn-warning" href="entregas.php" role="button">Actualizar</a>
      </form>
  </div>

    
</body>
</html>