<?php  
// -----------------------------------------------------
// claseAlta.php
// Alta de Clases
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroABC']) &&
    isset($_POST['nombreABC']) &&
    isset($_POST['tipoABC']))
{
	// Obtiene los datos
	$numero = $_POST['numeroABC'];
	$nombre = $_POST['nombreABC'];
	$tipo   = $_POST['tipoABC'];

	// Prepara el Query para la Inserción
	$query  = " INSERT INTO clases ";
	$query .= " (numero, nombre, tipo)";
	$query .= " VALUES ";
	$query .= " ('$numero','$nombre.','$tipo')";

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Variables para el Error
	    $titulo      = "Error en Alta de Clase";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "clases.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   	    	    
	    // Variables para el error
        $titulo      = "Exito Alta Clase";
        $descripcion = "Se ha realizado con exito el Alta de: $numero";
        $enlace      = "clases.php";

        // Lanzando Aplicación por Tipo
        header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Clase:<br>Faltaron datos");	
}

?>