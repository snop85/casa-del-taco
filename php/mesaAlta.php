<?php  
// -----------------------------------------------------
// mesaAlta.php
// Alta de una Mesa
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroABC']) &&
    isset($_POST['nombreABC']))
{
	// Obtiene los datos
	$numero = $_POST['numeroABC'];
	$nombre = $_POST['nombreABC'];

	// Prepara el Query para la Inserción
	$query  = " INSERT INTO mesas ";
	$query .= " (numero, nombre)";
	$query .= " VALUES ";
	$query .= " ('$numero','$nombre')";


	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Alta de Mesa";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "mesas.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		// Variables para el error
        $titulo      = "Exito Alta Mesa";
        $descripcion = "Se ha realizado con exito el Alta de: $numero";
        $enlace      = "mesas.php";

        // Lanzando Aplicación por Tipo
        header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Mesa:<br>Faltaron datos");	
}

