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

if (isset($_GET['codigo']))
  $codigoActualizar = $_GET['codigo'];
else
  $codigoActualizar = "";

if (isset($_GET['nombre']))
  $nombreActualizar = $_GET['nombre']; 
else
  $nombreActualizar = ""; 

if (isset($_GET['precio']))
  $precioActualizar = $_GET['precio'];
else
  $precioActualizar = "";

if (isset($_GET['clase']))
  $claseActualizar = $_GET['clase']; 
else
  $claseActualizar =""; 
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
         Agrega un producto
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
          <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="php/salida.php">
            <h2 class="text-white">Salir</h2>
          </a>
        </li>
      </ul>
    </div>
  </nav>
<br>

<div class="container">
  <?php    
  echo "<form action='php/producto$operacion.php' 
  class='was-validated' method='POST'>"
  ?>      
  <div class="form-group">
    <?php
    if ($operacion != "Alta")
    {
               // Crea el input oculto para cambios y bajas
     echo "<input type='hidden' value = '$codigoActualizar' name ='codigoOculto'/>";
   }
   ?>

   <label for="codigo" class="text-white">Codigo:</label>
   <input type="text" class="form-control" id="codigo" maxlength=4 
   placeholder="Capture el Codigo" 
   name="codigoABC" required                
   <?php
     echo "value='$codigoActualizar' ";
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
   <div class="invalid-feedback text-white">Por favor captura el codigo para el producto.</div>
 </div>

 <div class="form-group">
  <label for="clave" class="text-white">Nombre:</label>
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
    elseif ($operacion =="Cambios")
    {
        // Coloca el Foco cuando son Cambios
        echo "autofocus "; 
    }   
  ?>
 required>
 <div class="valid-feedback">Valido.</div>
 <div class="invalid-feedback text-white">Por favor capture el Nombre.</div>
</div>

<div class="form-group">
  <label for="precio" class="text-white">Precio:</label>
  <input type="number" class="form-control" id="precio" maxlength=10 
  min = 1 step =".01"
  placeholder="Capture el Precio" name="precioABC" 
  <?php
     echo "value='$precioActualizar' ";
     // Verifica que operación es
     if ($operacion=="Baja")
     {
        // Coloca atributo de deshabilitado
        echo "disabled ";
     }   
  ?>
  required>
  <div class="valid-feedback">Valido.</div>
  <div class="invalid-feedback text-white">Por favor capture el Precio.</div>
</div>

<div class="form-group">
  <label for="clase" class="text-white">Seleccione la Clase:</label>
  <select class="form-control" id="clase" 
  <?php
  if ($operacion=="Baja")
    echo "disabled "
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
<button type="submit" class="btn btn-danger">Aceptar</button>
</form>      
</div>
<br>
</body>
</html>