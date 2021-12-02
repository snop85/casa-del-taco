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

     // Obtengo la operacion y los datos del usario a actualizar
     $operacion = $_GET['operacion'];
     
     if (isset($_GET['numero']))
        $numeroActualizar = $_GET['numero'];
     else
        $numeroActualizar = "";

     if (isset($_GET['clase']))
        $claseActualizar = $_GET['clase']; 
     else
        $claseActualizar ="";  


     if (isset($_GET['descripcion']))
        $descripcionActualizar = $_GET['descripcion'];
     else
        $descripcionActualizar = "";

     
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
    <a class="navbar-brand" href="#">Comandas.Comentarios.<?php
         echo $operacion;
       ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuarios.php">
            Usuarios
          </a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="mesas.php">
            Mesas
          </a>
        </li>                
        <li class="nav-item">
          <a class="nav-link" href="productos.php">
            Productos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="php/salida.php">Salida</a>
        </li>    
      </ul>
    </div>  
  </nav>
  <br>

  <div class="container">
    <?php    
    echo "<form action='php/comentario$operacion.php' 
          class='was-validated' method='POST'>"
    ?>      
      <div class="form-group">
        <?php
            if ($operacion != "Alta")
            {
               // Crea el input oculto para cambios y bajas
               echo "<input type='hidden' value = '$numeroActualizar' name ='numeroOculto'/>";
            }
        ?>
        
        <label for="numero">Número:</label>
        <input type="number" class="form-control" id="numero" maxlength=2
               placeholder="Capture el Número" 
               min = 1 max = 99
               name="numeroABC" required                
               <?php
                  echo "value='$numeroActualizar' ";
                  // Verifica que operación es
                  if ($operacion=="Baja" || $operacion=="Cambios")
                  {
                     // Coloca atributo de deshabilitado
                     echo "disabled ";
                  }   
                  else
                  {
                     echo "autofocus";   
                  }
               ?>
        >       
        <div class="valid-feedback">Valido.</div>
        <div class="invalid-feedback">Por favor captura el Número.</div>
      </div>

      <div class="form-group">
        <label for="tipo">Seleccione la Clase:</label>
        <select class="form-control" id="tipo" 
                <?php
                   if ($operacion=="Baja")
                      echo "disabled ";
                   else
                   {
                      echo "autofocus ";
                   } 
                ?>    
                name="claseABC">          
                <?php
                  
                  // Obtiene las Clases
                  $clases = fnGetDatos($conexion,"clases");
                 
                  // para saber si es la primera
                  $boolPrimera = True;

                  // Ciclo para procesar cada clase
                  while ($fila = $clases->fetch_assoc()) 
                  {
                    // Lee la clase
                    $claseLeida = $fila['nombre'];

                    // Verifica si es alta
                    if ($operacion=="Alta")
                    {
                       // Verifica si es la primera                    
                      if ($boolPrimera)
                      {
                         echo "<option selected value=$claseLeida>$claseLeida</option>";
                         $boolPrimera= False;
                      }
                      else
                      {
                         echo "<option value=$claseLeida>$claseLeida</option>";
                      }
                    }
                    else
                    {
                      if ($claseActualizar==$claseLeida)
                        echo "<option selected value=$claseLeida>$claseLeida</option>";
                    else  
                        echo "<option value=$claseLeida>$claseLeida</option>";
                    }                      
                  }

                ?>          
        </select>
      </div>
      
      <div class="form-group">
        <label for="descripcion">Descripcion:</label>
        <input type="text" class="form-control" id="descripcion" 
               maxlength=10 
               placeholder="Capture la Descripción" name="descripcionABC" 
               <?php
                  echo "value='$descripcionActualizar' ";
                  // Verifica que operación es
                  if ($operacion=="Baja")
                  {
                     // Coloca atributo de deshabilitado
                     echo "disabled ";
                  }   
               ?>
               required>
        <div class="valid-feedback">Valido.</div>
        <div class="invalid-feedback">Por favor capture el Nombre.</div>
      </div>

      
      <button type="submit" class="btn btn-danger">Aceptar</button>
    </form>      
  </div>
  <br>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
  <a class="navbar-brand" href="#"> <img src="img/casa del taco logo blanco.png" alt="Logo" style="width:100px;"> </a>
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
  </nav>
</body>
</html>