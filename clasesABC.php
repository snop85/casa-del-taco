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

     if (isset($_GET['nombre']))
        $nombreActualizar = $_GET['nombre'];
     else
        $nombreActualizar = "";

     if (isset($_GET['tipo']))
        $tipoActualizar = $_GET['tipo']; 
     else
        $tipoActualizar =""; 
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
  <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />
</head>
<body>

  <nav class="navbar navbar-light">
  <a class="navbar-brand" href="#">
    <img src="img/logo.png" alt="Logo" style="width:100px;">
  </a>
    <a class="navbar-brand" href="#">Comandas.Clases.<?php
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
          <a class="nav-link" href="mesas.php">
            Mesas
          </a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="comentarios.php">
            Comentarios
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
    echo "<form action='php/clase$operacion.php' 
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
                     echo "disabled> ";
                  }   
                  else
                  {
                     echo "autofocus>";   
                  }
               ?>
               
        <div class="valid-feedback">Valido.</div>
        <div class="invalid-feedback">Por favor captura el Número.</div>
      </div>
      
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" class="form-control" id="nombre" maxlength=10 
               placeholder="Capture el Nombre" name="nombreABC" 
               <?php
                  echo "value='$nombreActualizar' ";
                  // Verifica que operación es
                  if ($operacion=="Baja")
                  {
                     // Coloca atributo de deshabilitado
                     echo "disabled ";
                  }   
                  elseif ($operacion=="Cambios")
                  {
                     // Coloca el Foco
                     echo "autofocus ";
                  }
               ?>
               required>
        <div class="valid-feedback">Valido.</div>
        <div class="invalid-feedback">Por favor capture el Nombre.</div>
      </div>

      <div class="form-group">
        <label for="tipo">Seleccione el Tipo:</label>
        <select class="form-control" id="tipo" 
                <?php
                   if ($operacion=="Baja")
                      echo "disabled "
                ?>    
                name="tipoABC">          
          <?php
            if ($tipoActualizar=="atencion")
               echo "<option selected value=atencion>atencion</option>";
            else 
               echo "<option value=atencion>atencion</option>";
            if ($tipoActualizar=="barra") 
               echo "<option selected value=barra>barra</option>";
            else 
               echo "<option value=barra>barra</option>";
            if ($tipoActualizar=="cocina")  
               echo "<option selected value=cocina>cocina</option>";
            else 
               echo "<option value=cocina>cocina</option>";
            if ($tipoActualizar=="control")   
               echo "<option selected value=control>control</option>";
            else 
               echo "<option value=control>control</option>";
          ?>
          
        </select>
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