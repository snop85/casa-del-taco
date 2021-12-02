<?php  
// -----------------------------------------------------
// conexion.php
// crea conexion al servidor
// -----------------------------------------------------

// Variables de Acceso
$servidor  = "localhost";
$usuario   = "root";
$password  = "";
$basedatos = "bdcomandas21";

// Se crea la conexion
$conexion = new mysqli($servidor,$usuario,$password,$basedatos);

// Verifica si hubo error
if ($conexion->connect_errno)
{
  	// Despliega mensaje de Error
   	die ("Error en Conexión :<br>".$conexion->connect_error);
}

// Verifica conexion a BD
if (!$conexion->select_db($basedatos))
   	die ("Error en Selección de Base de Datos :<br>".$conexion->error);

?>

